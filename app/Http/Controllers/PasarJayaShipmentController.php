<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fleet;
use App\Models\Price;
use App\Models\Courier;
use App\Models\Location;
use App\Models\ClientBill;
use Illuminate\Http\Request;
use App\Models\PasarJayaBill;
use App\Models\PasarJayaShipment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PasarJayaShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    static private $imgSuratJalan = 'pasjay/surat_jalan';
    static private $imgRoundTrip = 'pasjay/round_trip';

    public function index(Request $request)
    {
        $data = ["title" => "Proyek Pasar Jaya", "header_title" => "Kelola Riwayat Pengiriman Pasar Jaya"];
        $selectedDate = $request->input('shipment_date');
        $selectedRitase = $request->input('shipment_ritase');
        $selectedLocation = $request->input('shipment_location');
        $keyword = $request->input('keyword');



        // Query CourierAssign
        $query = PasarJayaShipment::with([
            'courier:courier_ID,courier_name',
            'location:shploc_ID,shploc_name,spl_ID',
            'location.price:spl_ID,spl_name'
        ]);


        // jika ada request tanggal
        if (!empty($selectedDate)) {
            $query->whereDate('created_at', $selectedDate);
            $data['shipment_date'] = $selectedDate;
        }

        // nilai rit jika ada
        if (!empty($selectedRitase)) {
            $query->where('rit', $selectedRitase);
            $data['shipment_ritase'] = $selectedRitase;
        }

        // Filter slot jika ada
        if (!empty($selectedLocation)) {
            $query->where(function ($q) use ($selectedLocation) {
                $q->whereHas('location.price', function ($qc) use ($selectedLocation) {
                    $qc->where('spl_name', $selectedLocation);
                });
            });
            $data['shipment_location'] = $selectedLocation;
        }

        // Filter keyword jika ada
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('courier', function ($qc) use ($keyword) {
                    $qc->where('courier_name', 'like', "%{$keyword}%");
                })->orWhereHas('location', function ($qf) use ($keyword) {
                    $qf->where('shploc_name', 'like', "%{$keyword}%");
                });
            });


            $data['keyword'] = $keyword;
            // dd($data);
        }



        // Pagination dan passing data
        $data['pasjay_locations'] = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->only('shipment_date', 'shipment_ritase', 'shipment_location', 'keyword'));

        $data["prices"] = Price::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->where("spl_type", "pasjay")
            ->select('spl_ID', 'spl_name') // Pilih hanya field yang diperlukan
            ->get();
        return view('pages.pasjay-shippings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ["title" => "Tambah Pengiriman", "header_title" => "Tambah Pengiriman Pasar Jaya", "mode_insert" => "single"];
        // Ambil semua courier yang tidak terhapus dan belum ada di tabel fleets
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->whereIn('courier_ID', Fleet::whereNotNull('courier_ID')->pluck('courier_ID')->toArray()) // Ambil hanya yang sudah terisi
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();

        $data["locations"] = Location::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->select('shploc_ID', 'shploc_name') // Pilih hanya field yang diperlukan
            ->get();
        // dd($data["couriers"][0]->fleet->fleet_nopol);
        return view('pages.pasjay-shippings.create', $data);
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

        $baseprice_location = Location::where("shploc_ID", $validatedData['shploc_ID'])->first();
        // dd($baseprice_location->price);
        if (!$baseprice_location->price) {
            Session::flash('error',  "Data Harga Proyek Pasar Jaya tidak ditemukan");
            return redirect()->route('admin.pasjay-shippings.create')->withInput();
        }



        try {
            // Input File
            $pasjayfiles = static::uploadFile($request, $validatedData);
            if ($pasjayfiles[1] == "") {
                $validatedData["image"] = $pasjayfiles[0];
            } else {
                $validatedData["image"] = $pasjayfiles[0];
                $validatedData["roundtrip"] = $pasjayfiles[1];
            }
            PasarJayaShipment::create($validatedData);
            static::insertToPasjayBill($validatedData);
            static::insertOrUpdateClientBill($validatedData);
            // dd("test");

            // PasarJayaShipment::create($validatedData);

            Session::flash('success', 'Data pengiriman berhasil ditambahkan!');
            return redirect()->route('admin.pasjay-shippings.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal menyimpan data AWB');
            return redirect()->route('admin.pasjay-shippings.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PasarJayaShipment $pasarJayaShipment)
    {
        $data = ["title" => "Detail Pengiriman", "header_title" => "Detail Pengiriman Pasar Jaya"];
        $data["psj_location"] = $pasarJayaShipment;
        return view('pages.pasjay-shippings.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PasarJayaShipment $pasarJayaShipment)
    {
        $data = ["title" => "Edit Pengiriman", "header_title" => "Edit Pengiriman Pasar Jaya"];
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->whereIn('courier_ID', Fleet::whereNotNull('courier_ID')->pluck('courier_ID')->toArray()) // Ambil hanya yang sudah terisi
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();

        $data["locations"] = Location::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->select('shploc_ID', 'shploc_name') // Pilih hanya field yang diperlukan
            ->get();
        $data["psj_location"] = $pasarJayaShipment;
        return view('pages.pasjay-shippings.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PasarJayaShipment $pasarJayaShipment)
    {
        // Validate Inputs
        $validatedData = static::validasiInput($request);
        $baseprice_location = Location::where("shploc_ID", $validatedData['shploc_ID'])->first();
        // dd($baseprice_location->price);
        if (!$baseprice_location->price) {
            Session::flash('error',  "Data Harga Proyek Pasar Jaya tidak ditemukan");
            return redirect()->route('admin.pasjay-shippings.edit', $pasarJayaShipment->shpsj_ID)->withInput();
        }

        $highestPriceLocationExisting = PasarJayaShipment::with('location.price')
            ->where('courier_ID', $pasarJayaShipment['courier_ID'])
            ->where('rit', $pasarJayaShipment['rit'])
            ->whereDate('created_at', Carbon::parse($pasarJayaShipment['created_at'])->toDateString())
            ->where('shpsj_ID', '!=', $pasarJayaShipment->shpsj_ID)
            ->get()
            ->sortByDesc(function ($item) {
                return $item->location->price->spl_baseprice_client ?? 0;
            })
            ->first();
        $highestPriceExisting = $highestPriceLocationExisting->location->price->spl_baseprice_client;
        // dd($highestPriceExisting);
        // dd("test");



        $pasjayBills = PasarJayaBill::where('courier_ID', $pasarJayaShipment['courier_ID'])
            ->where('rit', $pasarJayaShipment['rit'])
            ->whereDate('created_at', Carbon::parse($pasarJayaShipment['created_at'])->toDateString())
            ->first();



        try {
            // dd($validatedData);
            $total_multidrop = $pasjayBills->total_location - 1;
            $multidrop_price = $pasjayBills->location->price->spl_multidrop * $total_multidrop;
            $multidrop_price_client = $pasjayBills->location->price->spl_multidrop_client * $total_multidrop;
            // Cek apakah lokasi yang baru itu memiliki nilai baseprice lebih besar dibanding yang lama
            if ($pasjayBills->location->price->spl_baseprice_client < $baseprice_location->price->spl_baseprice_client) {
                $pasjayBills->shploc_ID = $validatedData["shploc_ID"];
                $multidrop_price = $baseprice_location->price->spl_multidrop * $total_multidrop;
                $multidrop_price_client = $baseprice_location->price->spl_multidrop_client * $total_multidrop;

                if ($pasjayBills->roundtrip || isset($validatedData['roundtrip'])) {
                    $pasjayBills->roundtrip = true;
                    $pasjayBills->total_charge = $baseprice_location->price->spl_baseprice + $baseprice_location->price->spl_roundtrip + $multidrop_price;

                    $pasjayBills->total_bill_client = $baseprice_location->price->spl_baseprice_client + $baseprice_location->price->spl_roundtrip_client + $multidrop_price_client;
                } else {

                    $pasjayBills->total_charge = $baseprice_location->price->spl_baseprice + $multidrop_price;

                    $pasjayBills->total_bill_client = $baseprice_location->price->spl_baseprice_client + $multidrop_price_client;
                }

                // Terakhir, simpan perubahannya ke DB
                $pasjayBills->save();
                static::insertOrUpdateClientBill($pasarJayaShipment);
            } else {
                if ($highestPriceExisting < $baseprice_location->price->spl_baseprice_client) {
                    $pasjayBills->shploc_ID = $validatedData["shploc_ID"];
                    $multidrop_price = $baseprice_location->price->spl_multidrop * $total_multidrop;
                    $multidrop_price_client = $baseprice_location->price->spl_multidrop_client * $total_multidrop;
                    if ($pasjayBills->roundtrip || isset($validatedData['roundtrip'])) {
                        $pasjayBills->roundtrip = true;
                        $pasjayBills->total_charge = $baseprice_location->price->spl_baseprice + $baseprice_location->price->spl_roundtrip + $multidrop_price;

                        $pasjayBills->total_bill_client = $baseprice_location->price->spl_baseprice_client + $baseprice_location->price->spl_roundtrip_client + $multidrop_price_client;
                    } else {

                        $pasjayBills->total_charge = $baseprice_location->price->spl_baseprice + $multidrop_price;

                        $pasjayBills->total_bill_client = $baseprice_location->price->spl_baseprice_client + $multidrop_price_client;
                    }
                } else {
                    $pasjayBills->shploc_ID = $highestPriceLocationExisting->shploc_ID;
                    $multidrop_price = $highestPriceLocationExisting->location->price->spl_multidrop * $total_multidrop;
                    $multidrop_price_client = $highestPriceLocationExisting->location->price->spl_multidrop_client * $total_multidrop;
                    if ($pasjayBills->roundtrip || isset($validatedData['roundtrip'])) {
                        $pasjayBills->roundtrip = true;
                        $pasjayBills->total_charge = $highestPriceLocationExisting->location->price->spl_baseprice + $highestPriceLocationExisting->location->price->spl_roundtrip + $multidrop_price;

                        $pasjayBills->total_bill_client = $highestPriceLocationExisting->location->price->spl_baseprice_client + $highestPriceLocationExisting->location->price->spl_roundtrip_client + $multidrop_price_client;
                    } else {

                        $pasjayBills->total_charge = $highestPriceLocationExisting->location->price->spl_baseprice + $multidrop_price;

                        $pasjayBills->total_bill_client = $highestPriceLocationExisting->location->price->spl_baseprice_client + $multidrop_price_client;
                    }
                }
                $pasjayBills->save();
                static::insertOrUpdateClientBill($pasarJayaShipment);
                // dd(isset($validatedData['image']));
            }



            // Input File


            // dd($highestPriceLocationExisting->shploc_ID . " === " . $validatedData['shploc_ID']);
            if (isset($validatedData['image']) || isset($validatedData['roundtrip'])) {
                $pasjayfiles = static::uploadFile($request, $validatedData, $pasarJayaShipment);
                if ($pasjayfiles[1] == "") {
                    $validatedData["image"] = $pasjayfiles[0];
                } else {
                    $validatedData["image"] = $pasjayfiles[0];
                    $validatedData["roundtrip"] = $pasjayfiles[1];
                }
            }

            // dd($baseprice_location->price->spl_baseprice_client);
            $pasarJayaShipment->update($validatedData);
            // dd("test");

            // PasarJayaShipment::create($validatedData);

            Session::flash('success', 'Data pengiriman berhasil diperbarui');
            return redirect()->route('admin.pasjay-shippings.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal memperbarui data pengiriman');
            return redirect()->route('admin.pasjay-shippings.edit', $pasarJayaShipment->shpsj_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PasarJayaShipment $pasarJayaShipment)
    {
        $highestPriceLocationExisting = PasarJayaShipment::with('location.price')
            ->where('courier_ID', $pasarJayaShipment['courier_ID'])
            ->where('rit', $pasarJayaShipment['rit'])
            ->whereDate('created_at', Carbon::parse($pasarJayaShipment['created_at'])->toDateString())
            ->where('shpsj_ID', '!=', $pasarJayaShipment->shpsj_ID)
            ->get()
            ->sortByDesc(function ($item) {
                return $item->location->price->spl_baseprice_client ?? 0;
            })->first();



        $isRoundtrip = PasarJayaShipment::with('location.price')
            ->where('courier_ID', $pasarJayaShipment['courier_ID'])
            ->where('rit', $pasarJayaShipment['rit'])
            ->whereDate('created_at', Carbon::parse($pasarJayaShipment['created_at'])->toDateString())
            ->where('shpsj_ID', '!=', $pasarJayaShipment->shpsj_ID)
            ->whereNotNull('roundtrip')
            ->first();

        // dd($isRoundtrip);

        $pasjayBills = PasarJayaBill::where('courier_ID', $pasarJayaShipment['courier_ID'])
            ->where('rit', $pasarJayaShipment['rit'])
            ->whereDate('created_at', Carbon::parse($pasarJayaShipment['created_at'])->toDateString())
            ->first();

        // dd($highestPriceLocationExisting);


        // if (!$highestPriceLocationExisting->location->price) {
        //     Session::flash('error',  "Data Harga Proyek Pasar Jaya tidak ditemukan");
        //     return redirect()->route('admin.pasjay-shippings.edit', $pasarJayaShipment->shpsj_ID)->withInput();
        // }

        // $highestPriceExisting = $highestPriceLocationExisting->location->price->spl_baseprice_client;

        try {
            if (!$highestPriceLocationExisting) {
                $pasjayBills->delete();
            } else {
                $total_multidrop = $pasjayBills->total_location - 2;
                $pasjayBills->total_location = $pasjayBills->total_location - 1;
                $pasjayBills->shploc_ID = $highestPriceLocationExisting->shploc_ID;
                $multidrop_price = $highestPriceLocationExisting->location->price->spl_multidrop * $total_multidrop;
                $multidrop_price_client = $highestPriceLocationExisting->location->price->spl_multidrop_client * $total_multidrop;
                if ($isRoundtrip) {
                    $pasjayBills->roundtrip = true;
                    $pasjayBills->total_charge = $highestPriceLocationExisting->location->price->spl_baseprice + $highestPriceLocationExisting->location->price->spl_roundtrip + $multidrop_price;

                    $pasjayBills->total_bill_client = $highestPriceLocationExisting->location->price->spl_baseprice_client + $highestPriceLocationExisting->location->price->spl_roundtrip_client + $multidrop_price_client;
                } else {
                    $pasjayBills->roundtrip = false;
                    $pasjayBills->total_charge = $highestPriceLocationExisting->location->price->spl_baseprice + $multidrop_price;

                    $pasjayBills->total_bill_client = $highestPriceLocationExisting->location->price->spl_baseprice_client + $multidrop_price_client;
                }
                $pasjayBills->save();
            }

            static::insertOrUpdateClientBill($pasarJayaShipment);
            // dd("coba cek di db");

            // Hapus data dari database
            $pasarJayaShipment->delete();

            Session::flash('success', 'Data pengiriman berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus data pengiriman: ' . $e->getMessage());
        }

        // Redirect kembali ke daftar kurir
        return redirect()->route('admin.pasjay-shippings.index');
    }

    static  private function validasiInput(Request $request)
    {
        $messages = [
            'courier_ID.required' => 'Kurir wajib dipilih.',
            'courier_ID.exists' => 'Kurir yang dipilih tidak ditemukan.',

            'shploc_ID.required' => 'Destinasi pengiriman wajib dipilih.',
            'shploc_ID.exists' => 'Destinasi pengiriman yang dipilih tidak ditemukan.',

            'rit.required' => 'Rit wajib diisi.',
            'rit.integer' => 'Rit harus berupa angka.',
            'rit.min' => 'Rit minimal harus 1.',

            'roundtrip.mimes'    => 'Foto surat jalan roundtrip harus berformat JPG, JPEG, atau PNG.',
            'roundtrip.max'      => 'Ukuran Foto surat jalan roundtrip tidak boleh lebih dari 2MB.',

            'image.required' => 'Foto surat jalan wajib diunggah.',
            'image.mimes'    => 'Foto surat jalan harus berformat JPG, JPEG, atau PNG.',
            'image.max'      => 'Ukuran Foto surat jalan tidak boleh lebih dari 2MB.',

            'created_at.required' => 'Tanggal pengiriman wajib diisi.',
            'created_at.date'       => 'Tanggal pengiriman harus dalam format yang valid.',
        ];

        $validationFormat = [
            'courier_ID' => 'required|exists:couriers,courier_ID',
            'shploc_ID' => 'required|exists:shipment_pasjay_locations,shploc_ID',
            'rit' => 'required|integer|min:1',
            'roundtrip' => 'mimes:jpg,jpeg,png|max:2048',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'created_at' => 'required|date',
        ];

        if ($request->isMethod("PUT")) {
            $validationFormat['courier_ID'] = "";
            $validationFormat['rit'] = "";
            $validationFormat['created_at'] = "";
            $validationFormat['image'] = "mimes:jpg,jpeg,png|max:2048";
        }



        $validatedData = $request->validate($validationFormat, $messages);
        // dd($validatedData);

        return $validatedData;
    }


    static private function uploadFile(Request $request, $data, $psj_locations = [])
    {
        $timestamp = now()->timestamp;
        $imgFileName = "";
        $imgPathSuratJalan = "";
        $imgPathRoundTrip = "";

        if (!empty($psj_locations)) {
            $imgPathSuratJalan = $psj_locations["image"];
            $imgPathRoundTrip = $psj_locations["roundtrip"];
        }


        if (isset($data["image"])) {
            $imgFileName = "{$timestamp}." . $data["image"]->getClientOriginalExtension();
            $existingImages = Storage::disk('public')->files(static::$imgSuratJalan);
            // dd($psj_locations['image']);
            if ($request->isMethod('PUT')) {
                foreach ($existingImages as $file) {
                    if (str_starts_with(basename($file), basename($psj_locations['image']))) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $imgPathSuratJalan = $data["image"]->storeAs(static::$imgSuratJalan, $imgFileName, 'public');
        }

        if (isset($data["roundtrip"])) {
            $imgFileName = "{$timestamp}." . $data["roundtrip"]->getClientOriginalExtension();
            $existingImages = Storage::disk('public')->files(static::$imgRoundTrip);
            if ($request->isMethod('PUT') && $psj_locations['roundtrip']) {
                foreach ($existingImages as $file) {
                    if (str_starts_with(basename($file), basename($psj_locations['roundtrip']))) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $imgPathRoundTrip = $data["roundtrip"]->storeAs(static::$imgRoundTrip, $imgFileName, 'public');
        }




        return [$imgPathSuratJalan, $imgPathRoundTrip];
    }


    static private function insertToPasjayBill($pasjay_locations = [])
    {

        // Hitung total location
        $locations = PasarJayaShipment::where('courier_ID', $pasjay_locations['courier_ID'])
            ->where('rit', $pasjay_locations['rit'])
            ->whereDate('created_at', Carbon::parse($pasjay_locations['created_at'])->toDateString())
            ->orderBy('created_at', 'desc')
            ->get();
        $total_location = count($locations);
        // dd($locations[0]->location->price->spl_baseprice);

        $pasjayBills = PasarJayaBill::where('courier_ID', $pasjay_locations['courier_ID'])
            ->where('rit', $pasjay_locations['rit'])
            ->whereDate('created_at', Carbon::parse($pasjay_locations['created_at'])->toDateString())
            ->first();


        // dd($pasjay_locations);
        if (!$pasjayBills) {
            $total_charge = isset($pasjay_locations['roundtrip']) ? $locations[0]->location->price->spl_baseprice + $locations[0]->location->price->spl_roundtrip : $locations[0]->location->price->spl_baseprice;

            $total_bill_client = isset($pasjay_locations['roundtrip']) ? $locations[0]->location->price->spl_baseprice_client + $locations[0]->location->price->spl_roundtrip_client : $locations[0]->location->price->spl_baseprice_client;
            // dd($total_charge);
            $roundtrip = isset($pasjay_locations['roundtrip']) != null ? true : false;

            PasarJayaBill::create(
                [
                    'courier_ID' => $pasjay_locations['courier_ID'],
                    'shploc_ID' => $pasjay_locations['shploc_ID'],
                    'rit' => $pasjay_locations['rit'],
                    'total_location' => $total_location,
                    'total_bill_client' => $total_bill_client,
                    'total_charge' => $total_charge,
                    'roundtrip' => $roundtrip,
                    'created_at' => $pasjay_locations['created_at'], // agar tanggalnya sesuai dengan pengiriman
                ]
            );
        } else {
            $total_multidrop = $total_location - 1;
            $multidrop_price = $pasjayBills->location->price->spl_multidrop * $total_multidrop;
            $multidrop_price_client = $pasjayBills->location->price->spl_multidrop_client * $total_multidrop;

            $pasjayBills->total_location = $total_location;
            // bandingkan harga baseprice dari $pasjay_locations dengan $pasjayBills
            if ($locations[0]->location->price->spl_baseprice_client > $pasjayBills->location->price->spl_baseprice_client) {

                $pasjayBills->shploc_ID = $locations[0]->shploc_ID;
                $multidrop_price = $locations[0]->location->price->spl_multidrop * $total_multidrop;
                $multidrop_price_client = $locations[0]->location->price->spl_multidrop_client * $total_multidrop;

                if ($pasjayBills->roundtrip || isset($locations[0]->roundtrip)) {
                    $pasjayBills->roundtrip = true;
                    $pasjayBills->total_charge = $locations[0]->location->price->spl_baseprice + $locations[0]->location->price->spl_roundtrip + $multidrop_price;

                    $pasjayBills->total_bill_client = $locations[0]->location->price->spl_baseprice_client + $locations[0]->location->price->spl_roundtrip_client + $multidrop_price_client;
                } else {

                    $pasjayBills->total_charge = $locations[0]->location->price->spl_baseprice + $multidrop_price;

                    $pasjayBills->total_bill_client = $locations[0]->location->price->spl_baseprice_client + $multidrop_price_client;
                }
            } else {

                if ($pasjayBills->roundtrip || isset($locations[0]->roundtrip)) {
                    $pasjayBills->roundtrip = true;
                    $pasjayBills->total_charge = $pasjayBills->location->price->spl_baseprice + $pasjayBills->location->price->spl_roundtrip + $multidrop_price;
                    $pasjayBills->total_bill_client = $pasjayBills->location->price->spl_baseprice_client + $pasjayBills->location->price->spl_roundtrip_client + $multidrop_price_client;
                } else {
                    $pasjayBills->total_charge = $pasjayBills->location->price->spl_baseprice + $multidrop_price;
                    $pasjayBills->total_bill_client = $pasjayBills->location->price->spl_baseprice_client + $multidrop_price_client;
                }
            }

            // Terakhir, simpan perubahannya ke DB
            $pasjayBills->save();
        }
    }

    static private function insertOrUpdateClientBill($psj_locations = [])
    {
        // Cek apakah data tagihan sudah ada
        $totalBill = PasarJayaBill::whereDate('created_at', Carbon::parse($psj_locations['created_at'])->toDateString())
            ->sum('total_bill_client');

        $clientBill = ClientBill::where("cb_type", "pasjay")->whereDate('created_at', Carbon::parse($psj_locations['created_at'])->toDateString())
            ->first();

        if (!$clientBill) {
            // Jika belum ada, insert
            ClientBill::create([
                'cb_type' => "pasjay",
                'total_bill_client' => $totalBill,
                'created_at' => $psj_locations['created_at'], // agar tanggalnya sesuai dengan pengiriman
            ]);
        } else {
            // Jika sudah ada, update
            $clientBill->update([
                'total_bill_client' => $totalBill,
            ]);
        }
    }
}
