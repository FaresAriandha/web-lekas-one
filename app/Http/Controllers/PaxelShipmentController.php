<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fleet;
use App\Models\Price;
use App\Models\Courier;
use App\Models\PaxelBill;
use App\Models\ClientBill;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaxelShipment;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PaxelShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    static private $imgFolder = 'paxel/pod_awb';

    public function index(Request $request)
    {
        $data = ["title" => "Proyek Paxel", "header_title" => "Kelola Riwayat Pengiriman Paxel"];
        $selectedDate = $request->input('shipment_date');
        $selectedStatus = $request->input('shipment_status');
        $selectedSlot = $request->input('shipment_slot');
        $keyword = $request->input('keyword');



        // Query CourierAssign
        $query = PaxelShipment::with([
            'courier:courier_ID,courier_name',
            // 'courier.fleet:fleet_nopol,courier_ID'
        ]);

        if (Auth::user()->user_role === 'kurir') {
            $courier_ID = Auth::user()->courier->courier_ID;
            $query->where('courier_ID', $courier_ID);
        }


        // jika ada request tanggal
        if (!empty($selectedDate)) {
            $query->whereDate('created_at', $selectedDate);
            $data['shipment_date'] = $selectedDate;
        }

        // Filter status jika ada
        if (!empty($selectedStatus)) {
            $query->where('awb_status', $selectedStatus);
            $data['shipment_status'] = $selectedStatus;
        }

        // Filter slot jika ada
        if (!empty($selectedSlot)) {
            $query->where('awb_slot', $selectedSlot);
            $data['shipment_slot'] = $selectedSlot;
        }

        // Filter keyword jika ada
        if (!empty($keyword)) {
            if (Auth::user()->user_role === 'kurir') {
                $query->where('awb_number', 'like', "%{$keyword}%")->orWhere('awb_hub', 'like', "%{$keyword}%");
            } else {
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('courier', function ($qc) use ($keyword) {
                        $qc->where('courier_name', 'like', "%{$keyword}%");
                    });
                })->orWhere('awb_number', 'like', "%{$keyword}%")->orWhere('awb_hub', 'like', "%{$keyword}%");
            }


            $data['keyword'] = $keyword;
            // dd($data);
        }



        // Pagination dan passing data
        $data['awb_paxels'] = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->only('shipment_date', 'shipment_status', 'shipment_slot', 'keyword'));
        // dd($data['assignees']);
        return view('pages.paxel-shippings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = ["title" => "Tambah AWB Paxel", "header_title" => "Tambah Data AWB Paxel", "mode_insert" => "single"];
        if (!empty($request->get("mode_insert"))) {
            $data["mode_insert"] = $request->get("mode_insert");
        }
        // Ambil semua courier yang tidak terhapus dan belum ada di tabel fleets
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->whereIn('courier_ID', Fleet::whereNotNull('courier_ID')->pluck('courier_ID')->toArray()) // Ambil hanya yang sudah terisi
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();
        // dd($data["couriers"][0]->fleet->fleet_nopol);
        return view('pages.paxel-shippings.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Inputs
        $validatedData = static::validasiInput($request);
        $createdAt = Carbon::parse($request->created_at)->setTimeFrom(Carbon::now());
        $validatedData['created_at'] = $createdAt;
        // dd("test");
        $baseprice_paxel = Price::select("spl_baseprice_client")->where("spl_name", "AWB")->where("spl_type", "paxel")->first();

        if (!$baseprice_paxel) {
            Session::flash('error',  "Data Harga AWB Paxel tidak ditemukan");
            return redirect()->route('admin.paxel-shippings.create')->withInput();
        }
        // dd($baseprice_paxel);


        try {
            // Input File
            if ($request->get("mode_insert") == "multiple") {
                $totalAWB = static::multipleInsert($request, $validatedData);
                static::insertToPaxelBill($validatedData, $baseprice_paxel->spl_baseprice_client);
                static::insertOrUpdateClientBill($validatedData);
                Session::flash('success', "$totalAWB data AWB berhasil ditambahkan!");
                return redirect()->route('admin.paxel-shippings.index');
            } else if ($request->get("mode_insert") == "single") {
                PaxelShipment::create($validatedData);
                static::insertToPaxelBill($validatedData, $baseprice_paxel->spl_baseprice_client);
                static::insertOrUpdateClientBill($validatedData);
                Session::flash('success', 'Data AWB berhasil ditambahkan!');
                return redirect()->route('admin.paxel-shippings.index');
            } else {
                return redirect()->route('admin.paxel-shippings.index');
            }
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal menyimpan data AWB');
            return redirect()->route('admin.paxel-shippings.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaxelShipment $paxelShipment)
    {
        $data = ["title" => "Detail AWB", "header_title" => "Detail Data AWB"];
        $data["awb_paxel"] = $paxelShipment;
        return view('pages.paxel-shippings.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaxelShipment $paxelShipment)
    {
        $data = ["title" => "Edit AWB", "header_title" => "Edit Data AWB"];
        $data["awb_paxel"] = $paxelShipment;
        // Ambil semua courier yang tidak terhapus dan belum ada di tabel fleets
        $data["couriers"] = Courier::whereNull('deleted_at') // Hanya yang tidak di-soft delete
            ->whereIn('courier_ID', PaxelShipment::pluck('courier_ID')->unique()) // Ambil courier_ID dari tabel paxel-shippings
            ->select('courier_ID', 'courier_name') // Hanya field yang diperlukan
            ->get();

        // dd($data['couriers']);
        return view('pages.paxel-shippings.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaxelShipment $paxelShipment)
    {
        $validatedData = static::validasiInput($request, $paxelShipment);

        $baseprice_paxel = Price::select("spl_baseprice_client")->where("spl_name", "AWB")->where("spl_type", "paxel")->first();

        if (!$baseprice_paxel) {
            Session::flash('error',  "Data Harga AWB Paxel tidak ditemukan");
            return redirect()->route('admin.paxel-shippings.edit', $paxelShipment->shpxl_ID)->withInput();
        }



        try {
            // Update data courier ke dalam database

            if ($validatedData['awb_status'] != $paxelShipment->awb_status) {

                $paxelBill = PaxelBill::where('courier_ID', $paxelShipment->courier_ID)
                    ->where('awb_slot', $paxelShipment->awb_slot)
                    ->whereDate('created_at', Carbon::parse($paxelShipment->created_at)->toDateString())
                    ->first();

                if ($validatedData['awb_status'] == "Dibatalkan" && $paxelShipment->awb_status != "Dibatalkan") {
                    $awb_total = $paxelBill->awb_total - 1;
                    $total_bill_client = $awb_total > 0 && $awb_total <= 10 ? 200000 : $awb_total * $baseprice_paxel->spl_baseprice_client;

                    $paxelBill->update([
                        'awb_total' => $awb_total,
                        'total_bill_client' => $total_bill_client,
                    ]);
                    static::insertOrUpdateClientBill($paxelShipment);
                } else if ($validatedData['awb_status'] != "Dibatalkan" && $paxelShipment->awb_status == "Dibatalkan") {
                    $awb_total = $paxelBill->awb_total + 1;
                    $total_bill_client = $awb_total > 0 && $awb_total <= 10 ? 200000 : $awb_total * $baseprice_paxel->spl_baseprice_client;

                    $paxelBill->update([
                        'awb_total' => $awb_total,
                        'total_bill_client' => $total_bill_client,
                    ]);
                    static::insertOrUpdateClientBill($paxelShipment);
                }
            }

            if (isset($validatedData['awb_pod'])) {
                $validatedData['awb_pod'] = static::uploadFile($validatedData, $paxelShipment);
            }

            $paxelShipment->update($validatedData);


            Session::flash('success', 'Data AWB berhasil diperbarui');
            return redirect()->route('admin.paxel-shippings.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal memperbarui data AWB');
            return redirect()->route('admin.paxel-shippings.edit', $paxelShipment->shpxl_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaxelShipment $paxelShipment)
    {
        $baseprice_paxel = Price::select("spl_baseprice_client")->where("spl_name", "AWB")->where("spl_type", "paxel")->first();

        if (!$baseprice_paxel) {
            Session::flash('error',  "Data Harga AWB Paxel tidak ditemukan");
            return redirect()->route('admin.paxel-shippings.index')->withInput();
        }


        try {
            $paxelBill = PaxelBill::where('courier_ID', $paxelShipment->courier_ID)
                ->where('awb_slot', $paxelShipment->awb_slot)
                ->whereDate('created_at', Carbon::parse($paxelShipment->created_at)->toDateString())
                ->first();

            $awb_total = $paxelBill->awb_total - 1;
            $total_bill_client = $awb_total > 0 && $awb_total <= 10 ? 200000 : $awb_total * $baseprice_paxel->spl_baseprice_client;

            if ($awb_total == 0) {
                $paxelBill->delete();
            } else {
                $paxelBill->update([
                    'awb_total' => $awb_total,
                    'total_bill_client' => $total_bill_client,
                ]);
            }

            static::insertOrUpdateClientBill($paxelShipment);

            // Hapus data dari database
            $paxelShipment->delete();

            Session::flash('success', 'Data AWB berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus data AWB: ' . $e->getMessage());
        }

        // Redirect kembali ke daftar kurir
        return redirect()->route('admin.paxel-shippings.index');
    }


    static  private function validasiInput(Request $request, $awb_paxel = [])
    {
        $messages = [
            'courier_ID.required' => 'Kurir wajib dipilih.',
            'courier_ID.exists' => 'Kurir yang dipilih tidak ditemukan.',

            'awb_number.required' => 'Nomor AWB wajib diisi.',
            'awb_number.string' => 'Nomor AWB harus berupa teks.',
            'awb_number.unique' => 'Nomor AWB sudah digunakan.',

            'awb_slot.required' => 'Slot pengiriman wajib dipilih.',
            'awb_slot.in' => 'Slot pengiriman harus berupa Pagi atau Siang.',

            'awb_status.required' => 'Status AWB wajib dipilih.',
            'awb_status.in' => 'Status AWB tidak valid.',

            'awb_hub.required' => 'Hub pengiriman wajib dipilih.',
            'awb_hub.in' => 'Hub pengiriman harus berupa HALIM atau MANGGA DUA.',

            'awb_pod.required' => 'POD AWB wajib diunggah.',
            'awb_pod.mimes'    => 'POD AWB harus berformat JPG, JPEG, atau PNG.',
            'awb_pod.max'      => 'Ukuran POD AWB tidak boleh lebih dari 2MB.',

            'awb_excel.required' => 'File AWB wajib diunggah.',
            'awb_excel.file' => 'File AWB harus berupa file yang valid.',
            'awb_excel.mimes' => 'File AWB harus berformat .xlsx atau .xls',

            'created_at.required' => 'Tanggal pengiriman wajib diisi.',
            'created_at.date'       => 'Tanggal pengiriman harus dalam format yang valid.',
        ];

        $validationFormat = [
            'courier_ID' => 'required|exists:couriers,courier_ID',
            'awb_number' => 'required|string|unique:shipments_paxel,awb_number',
            'awb_slot' => 'required|in:Pagi,Siang',
            // 'awb_status' => 'required|in:Siap Antar,Selesai,Dikembalikan,Dibatalkan',
            'awb_hub' => 'required|in:HALIM,MANGGA DUA',
            'created_at' => 'required|date',
            // 'awb_pod' => 'required|mimes:jpg,jpeg,png|max:2048', // Max 2MB sebelum dikompresi
        ];

        // dd($request->get("mode_insert"));
        if ($request->get("mode_insert") == "multiple") {
            $validationFormat['awb_number'] = '';
            $validationFormat['awb_excel'] = 'required|file|mimes:xlsx,xls';
        }

        if ($request->isMethod('PUT')) {
            $validationFormat['courier_ID'] = '';
            $validationFormat['awb_slot'] = '';
            $validationFormat['awb_hub'] = '';
            $validationFormat['created_at'] = '';
            $validationFormat['awb_status'] = 'required|in:Siap Antar,Selesai,Dikembalikan,Dibatalkan';
            $validationFormat['awb_pod'] = 'required|mimes:jpg,jpeg,png|max:2048';
            if ($awb_paxel['awb_pod'] != null) {
                $validationFormat['awb_pod'] = 'mimes:jpg,jpeg,png|max:2048';
            }
            if ($awb_paxel['awb_number'] == $request->input('awb_number')) {
                $validationFormat['awb_number'] = 'required|string';
            }

            // dd($validationFormat);
        }


        $validatedData = $request->validate($validationFormat, $messages);
        // dd($validatedData);

        return $validatedData;
    }

    static private function uploadFile($data, $awb_paxel = [])
    {
        $timestamp = now()->timestamp;
        $imgFileName = "";
        $imgPath = "";

        // if (!empty($awb_paxel)) {
        //     $imgPath = $awb_paxel["awb_pod"];
        // }


        if (isset($data["awb_pod"])) {
            $imgFileName = "{$timestamp}." . $data["awb_pod"]->getClientOriginalExtension();
            $existingImages = Storage::disk('public')->files(static::$imgFolder);
            if ($awb_paxel['awb_pod']) {
                foreach ($existingImages as $file) {
                    if (str_starts_with(basename($file), basename($awb_paxel['awb_pod']))) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $imgPath = $data["awb_pod"]->storeAs(static::$imgFolder, $imgFileName, 'public');
        }


        return $imgPath;
    }

    static private function multipleInsert(Request $request, $awb_paxels = [])
    {
        // Ambil koleksi dari file excel
        $collection = Excel::toCollection(null, $request->file('awb_excel'))[0];
        // dd($collection);

        $duplikat_awbs = [];
        $insert_data = [];

        foreach ($collection as $index => $row) {
            // Lewati baris kosong atau header
            // if ($index === 0 || empty($row['Shipment code'] ?? $row[0])) continue;
            if ($index === 0) {
                foreach ($row as $key => $value) {
                    if (preg_match('/shipment\s*code/i', $value)) {
                        $awb_column_index = $key;
                        break;
                    }
                }
                continue; // Lewati baris header
            }

            // $awb_number = $row['Shipment code'] ?? $row[0];

            if ($awb_column_index === null || empty($row[$awb_column_index])) {
                continue;
            }

            $awb_number = trim($row[$awb_column_index]);

            // Cek duplikat di database
            if (PaxelShipment::where('awb_number', $awb_number)->exists()) {
                $duplikat_awbs[] = $awb_number;
                continue;
            }

            $insert_data[] = [
                'courier_ID' => $awb_paxels['courier_ID'],
                'awb_number' => $awb_number,
                'awb_slot' => $awb_paxels['awb_slot'],
                'awb_hub' => $awb_paxels['awb_hub'],
                'created_at' => $awb_paxels['created_at'],
            ];
        }

        // Jika ada duplikat, hentikan proses dan tampilkan pesan
        if (count($duplikat_awbs)) {
            return back()
                ->withInput()
                ->withErrors([
                    'awb_excel' => 'Proses dihentikan. Ditemukan nomor AWB duplikat: ' . implode(', ', $duplikat_awbs),
                ]);
        }

        $now = Carbon::now();

        foreach ($insert_data as &$data) {
            $data['shpxl_ID'] = strtolower((string) Str::ulid());
            $data['updated_at'] = $now;
        }
        unset($data);
        // dd(count($insert_data));
        // Masukkan data
        PaxelShipment::insert($insert_data);
        return count($insert_data);
    }

    static private function insertToPaxelBill($awb_paxels = [], $baseprice_paxel)
    {
        // Hitung total awb setelah insert
        $awb_total = PaxelShipment::where('courier_ID', $awb_paxels['courier_ID'])
            ->where('awb_slot', $awb_paxels['awb_slot'])
            ->whereDate('created_at', Carbon::parse($awb_paxels['created_at'])->toDateString())
            ->count();

        // Hitung total_bill_client
        $total_bill_client = $awb_total > 0 && $awb_total <= 10 ? 200000 : $awb_total * $baseprice_paxel;

        // Cek apakah data tagihan sudah ada
        $paxelBill = PaxelBill::where('courier_ID', $awb_paxels['courier_ID'])
            ->where('awb_slot', $awb_paxels['awb_slot'])
            ->whereDate('created_at', Carbon::parse($awb_paxels['created_at'])->toDateString())
            ->first();

        if (!$paxelBill) {
            // Jika belum ada, insert
            PaxelBill::create([
                'courier_ID' => $awb_paxels['courier_ID'],
                'awb_slot' => $awb_paxels['awb_slot'],
                'awb_total' => $awb_total,
                'total_bill_client' => $total_bill_client,
                'created_at' => $awb_paxels['created_at'], // agar tanggalnya sesuai dengan pengiriman
            ]);
        } else {
            // Jika sudah ada, update
            $paxelBill->update([
                'awb_total' => $awb_total,
                'total_bill_client' => $total_bill_client,
            ]);
        }
    }

    static private function insertOrUpdateClientBill($awb_paxel = [])
    {
        // Cek apakah data tagihan sudah ada
        $totalBill = PaxelBill::whereDate('created_at', Carbon::parse($awb_paxel['created_at'])->toDateString())
            ->sum('total_bill_client');

        $clientBill = ClientBill::where('cb_type', 'paxel')->whereDate('created_at', Carbon::parse($awb_paxel['created_at'])->toDateString())
            ->first();

        if (!$clientBill) {
            // Jika belum ada, insert
            ClientBill::create([
                'cb_type' => "paxel",
                'total_bill_client' => $totalBill,
                'created_at' => $awb_paxel['created_at'], // agar tanggalnya sesuai dengan pengiriman
            ]);
        } else {
            // Jika sudah ada, update
            $clientBill->update([
                'total_bill_client' => $totalBill,
            ]);
        }
    }
}
