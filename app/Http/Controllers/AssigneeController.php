<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fleet;
use App\Models\Courier;
use App\Models\Assignee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AssigneeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ["title" => "Kelola Penugasan", "header_title" => "Kelola Penugasan Kurir"];
        $selectedDate = $request->input('assignee_date');
        $selectedStatus = $request->input('assignee_status');
        $keyword = $request->input('keyword');



        // Query CourierAssign
        $query = Assignee::with([
            'courier:courier_ID,courier_name',
            'courier.fleet:fleet_nopol,courier_ID'
        ]);


        // jika ada request tanggal
        if (!empty($selectedDate)) {
            $query->whereDate('cas_pickup_time', $selectedDate);
            $data['assignee_date'] = $selectedDate;
        }

        // Filter status jika ada
        if (!empty($selectedStatus)) {
            $query->where('cas_status', $selectedStatus);
            $data['assignee_status'] = $selectedStatus;
        }

        // Filter keyword jika ada
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('courier', function ($qc) use ($keyword) {
                    $qc->where('courier_name', 'like', "%{$keyword}%");
                })->orWhereHas('courier.fleet', function ($qf) use ($keyword) {
                    $qf->where('fleet_nopol', 'like', "%{$keyword}%");
                })->orWhere('cas_type', 'like', "%{$keyword}%");
            });

            $data['keyword'] = $keyword;
            // dd($data);
        }



        // Pagination dan passing data
        $data['assignees'] = $query->orderBy('cas_pickup_time', 'desc')
            ->paginate(2)
            ->appends($request->only('assignee_date', 'assignee_status', 'keyword'));
        // dd($data['assignees']);
        return view('pages.assigns.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ["title" => "Tambah Penugasan", "header_title" => "Tambah Data Penugasan"];
        // Ambil semua courier yang tidak terhapus dan belum ada di tabel fleets
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->whereIn('courier_ID', Fleet::whereNotNull('courier_ID')->pluck('courier_ID')->toArray()) // Ambil hanya yang sudah terisi
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();
        // dd($data["couriers"][0]->fleet->fleet_nopol);
        return view('pages.assigns.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Inputs
        $validatedData = static::validasiInput($request);

        try {
            // dd($validatedData);
            Assignee::create($validatedData);

            Session::flash('success', 'Data penugasan berhasil ditambahkan!');
            return redirect()->route('admin.assignees.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal menyimpan data penugasan');
            return redirect()->route('admin.assignees.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignee $assignee)
    {
        $data = ["title" => "Detail Penugasan", "header_title" => "Detail Data Penugasan"];
        $data["assignee"] = $assignee;
        return view('pages.assigns.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignee $assignee)
    {
        $data = ["title" => "Edit Penugasan", "header_title" => "Edit Data Penugasan"];
        $data["assignee"] = $assignee;
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->whereIn('courier_ID', Fleet::whereNotNull('courier_ID')->pluck('courier_ID')->toArray()) // Ambil hanya yang sudah terisi
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();
        return view('pages.assigns.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignee $assignee)
    {
        $validatedData = static::validasiInput($request, $assignee);

        try {

            // Update data courier ke dalam database
            if ($validatedData['cas_status'] == "Siap Pickup") {
                $validatedData['cas_arrived_time'] = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
            } else if ($validatedData['cas_status'] == "Dalam Tugas") {
                $validatedData['cas_start_time'] = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
            } else if ($validatedData['cas_status'] == "Selesai") {
                $validatedData['cas_finish_time'] = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
            }

            $assignee->update($validatedData);

            Session::flash('success', 'Data penugasan berhasil diperbarui');
            return redirect()->route('admin.assignees.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal memperbarui data penugasan');
            return redirect()->route('admin.assignees.index', $assignee->cas_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignee $assignee)
    {
        try {

            // Hapus data dari database
            $assignee->delete();

            Session::flash('success', 'Data penugasan berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus data penugasan: ' . $e->getMessage());
        }

        // Redirect kembali ke daftar kurir
        return redirect()->route('admin.assignees.index');
    }

    static  private function validasiInput(Request $request, $courier = [])
    {
        $messages = [
            'courier_ID.required' => 'Kurir harus dipilih.',
            'courier_ID.exists' => 'Kurir tidak ditemukan di sistem.',
            'courier_ID.ulid' => 'Format ID kurir tidak valid.',

            'cas_type.required' => 'Tipe penugasan wajib dipilih.',
            'cas_type.in' => 'Tipe penugasan hanya boleh "Pasar Jaya" atau "Paxel".',

            'cas_pickup_time.required' => 'Waktu pickup harus diisi.',
            'cas_pickup_time.date_format' => 'Format waktu pickup tidak valid. Gunakan format: 2020-04-20 08:00:00',
        ];

        $validationFormat = [
            'courier_ID'        => 'required|exists:couriers,courier_ID|ulid',
            'cas_type'         => 'required|in:pasjay,paxel',
            'cas_pickup_time'  => 'required|date_format:Y-m-d H:i:s',
        ];

        if ($request->isMethod('PUT')) {
            $validationFormat['cas_status'] = 'required|in:Ditugaskan,Siap Pickup,Dalam Tugas,Selesai';
        }


        $validatedData = $request->validate($validationFormat, $messages);
        // dd($validatedData);

        return $validatedData;
    }
}
