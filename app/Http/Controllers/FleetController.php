<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fleet;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FleetController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    static private $imgFolder = 'fleets/images';
    static private $docFolder = 'fleets/docs';
    public function index(Request $request)
    {
        $data = ["title" => "Kelola Armada", "header_title" => "Kelola Armada"];

        $selectedStatus = $request->input('fleet_status');

        // Query awal tanpa filter
        $query = Fleet::with('courier:courier_ID,courier_name') // Eager loading untuk courier
            ->select('fleet_ID', 'fleet_nopol', 'fleet_type', 'fleet_status', 'courier_ID');


        // Filter status jika ada
        if (!empty($selectedStatus)) {
            $query->where('fleet_status', $selectedStatus);
            $data['fleet_status'] = $selectedStatus;
        }
        // Jika ada keyword pencarian
        if ($request->filled("keyword")) {
            $keyword = $request->input("keyword");

            $query->where(function ($q) use ($keyword) {
                $q->where('fleet_nopol', 'like', "%{$keyword}%")
                    ->orWhere('fleet_type', 'like', "%{$keyword}%")
                    ->orWhereHas('courier', function ($query) use ($keyword) {
                        $query->where('courier_name', 'like', "%{$keyword}%");
                    });
            });

            $data['keyword'] = $keyword;
        }

        // Ambil data dengan pagination
        $data["fleets"] = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->only('fleet_status', 'keyword'));

        return view('pages.fleets.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ["title" => "Tambah Armada", "header_title" => "Tambah Data Armada"];
        // Ambil semua courier yang tidak terhapus dan belum ada di tabel fleets
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            // ->whereNotIn('courier_ID', Fleet::whereNotNull('courier_ID')->pluck('courier_ID')->toArray()) // Ambil hanya yang sudah terisi
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();
        // dd($data["couriers"]);
        return view('pages.fleets.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = static::validasiInput($request);

        try {
            // Input File
            $fleet_files = static::uploadFile($request, $validatedData);
            $validatedData["fleet_img"] = $fleet_files[0];
            $validatedData["fleet_docs"] = $fleet_files[1];
            // dd($validatedData);

            Fleet::create($validatedData);

            Session::flash('success', 'Data armada berhasil ditambahkan!');
            return redirect()->route('admin.fleets.index');
        } catch (\Exception $e) {
            // Simpan pesan error ke session
            Log::error('Error saat menyimpan data:', ['error' => $e->getMessage()]);
            Session::flash('error', 'Gagal menyimpan data armada');
            return redirect()->route('admin.fleets.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Fleet $fleet)
    {
        //
        $data = ["title" => "Detail Armada", "header_title" => "Detail Data Armada"];
        $data["fleet"] = $fleet;
        return view('pages.fleets.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fleet $fleet)
    {
        $data = ["title" => "Edit Kurir", "header_title" => "Edit Data Kurir"];
        $data["fleet"] = $fleet;
        $data["fleet_KIR_date"] = Carbon::parse($fleet->fleet_KIR_date)->format('m/d/Y');
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete            
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();
        return view('pages.fleets.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fleet $fleet)
    {
        $validatedData = static::validasiInput($request, $fleet);

        try {
            // Input File
            if (isset($validatedData['fleet_img']) || isset($validatedData['fleet_docs'])) {
                $fleet_files = static::uploadFile($request, $validatedData, $fleet);
                $validatedData["fleet_img"] = $fleet_files[0];
                $validatedData["fleet_docs"] = $fleet_files[1];
            }

            // Update data fleet ke dalam database
            $fleet->update($validatedData);

            Session::flash('success', 'Data kurir berhasil diperbarui');
            return redirect()->route('admin.fleets.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal memperbarui data kurir');
            return redirect()->route('admin.fleets.edit', $fleet->fleet_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fleet $fleet)
    {
        //

        try {
            // Hapus file dari storage jika ada
            // if ($courier->courier_img && Storage::disk('public')->exists($courier->courier_img)) {
            //     Storage::disk('public')->delete($courier->courier_img);
            // }

            // if ($courier->courier_docs && Storage::disk('public')->exists($courier->courier_docs)) {
            //     Storage::disk('public')->delete($courier->courier_docs);
            // }

            // Hapus data dari database
            $fleet->delete();

            Session::flash('success', 'Data armada berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus data armada: ' . $e->getMessage());
        }

        // Redirect kembali ke daftar armada
        return redirect()->route('admin.fleets.index');
    }

    static  private function validasiInput(Request $request, $fleet = [])
    {
        $messages = [
            'fleet_nopol.required'  => 'Nopol armada wajib diisi.',
            'fleet_nopol.regex'     => 'Nopol armada harus mengikuti format yang ada di indonesia',
            'fleet_nopol.unique'    => 'Nopol armada sudah terdaftar, silahkan cek kembali pada armada',
            'fleet_nopol.max'       => 'Nopol armada tidak boleh lebih dari :max karakter.',
            'fleet_nopol.min'       => 'Nopol armada tidak boleh kurang dari :min karakter.',

            'courier_ID.unique'     => 'Nama kurir tersebut sudah menggunakan armada lain',
            'courier_ID.exists'     => 'Nama kurir tidak ditemukan',

            'fleet_type.required' => 'Tipe armada wajib diisi.',
            'fleet_type.in'       => 'Tipe armada tidak ditemukan',

            'fleet_merk.required'  => 'Merek armada wajib diisi.',
            'fleet_merk.max'       => 'Merek armada tidak boleh lebih dari :max karakter.',

            'fleet_status.required' => 'Status armada wajib diisi.',
            'fleet_status.in'       => 'Status armada tidak ditemukan',

            'fleet_KIR_date.required' => 'Tanggal uji kir armada terakhir wajib diisi.',
            'fleet_KIR_date.date'       => 'Tanggal uji kir armada terakhir harus dalam format yang valid.',

            'fleet_img.required'        => 'Dokumen foto armada wajib diunggah.',
            'fleet_img.mimes'           => 'Dokumen foto armada harus berformat PDF.',
            'fleet_img.max'             => 'Ukuran Dokumen foto armada tidak boleh lebih dari 2MB.',

            'fleet_docs.required'        => 'Dokumen armada wajib diunggah.',
            'fleet_docs.mimes'           => 'Dokumen armada harus berformat PDF.',
            'fleet_docs.max'             => 'Ukuran dokumen armada tidak boleh lebih dari 2MB.',
        ];

        $validationFormat = [
            'fleet_nopol'    => 'required|string|min:4|max:12|unique:fleets,fleet_nopol|regex:/^[A-Z]{1,2} \d{1,4} [A-Z]{0,3}$/',
            'courier_ID'     => 'unique:fleets,courier_ID',
            'fleet_type'     => 'required|in:Van,Pickup,CDE Box',
            'fleet_merk'     => 'required|string|max:100',
            'fleet_status'   => 'required|in:DIGUNAKAN,TERSEDIA,PERBAIKAN',
            'fleet_KIR_date' => 'required|date',
            'fleet_img'      => 'required|mimes:pdf|max:2048', // Max 2MB
            'fleet_docs'     => 'required|mimes:pdf|max:2048', // Max 2MB
        ];


        if ($request->isMethod('POST') && $request->input("courier_ID") != null) {
            $validationFormat['courier_ID'] = 'unique:fleets,courier_ID|exists:couriers,courier_ID';
        }


        if ($request->isMethod('PUT')) {
            $validationFormat['fleet_img'] = 'mimes:pdf|max:2048';
            $validationFormat['fleet_docs'] = 'mimes:pdf|max:2048';
            if ($fleet['fleet_nopol'] == $request->input('fleet_nopol')) {
                $validationFormat['fleet_nopol'] = 'required|string|min:4|max:12|regex:/^[A-Z]{1,2} \d{1,4} [A-Z]{0,3}$/';
            }
            if ($fleet['courier_ID'] == $request->input('courier_ID')) {
                $validationFormat['courier_ID'] = 'exists:couriers,courier_ID';
            } else {
                $validationFormat['courier_ID'] = 'unique:fleets,courier_ID|exists:couriers,courier_ID';
            }
        }

        if ($request->input("courier_ID") == null) {
            $validationFormat['courier_ID'] = '';
        }

        $validatedData = $request->validate($validationFormat, $messages);

        return $validatedData;
    }

    static private function uploadFile(Request $request, $data, $fleet = [])
    {
        $timestamp = now()->timestamp;
        $imgFileName = "";
        $docFileName = "";
        $imgPath = "";
        $docPath = "";

        if (!empty($fleet)) {
            $imgPath = $fleet["fleet_img"];
            $docPath = $fleet["fleet_docs"];
        }


        if (isset($data["fleet_img"])) {
            $imgFileName = "{$timestamp}." . $data["fleet_img"]->getClientOriginalExtension();
            $existingImages = Storage::disk('public')->files(static::$imgFolder);
            if ($request->isMethod('PUT')) {
                foreach ($existingImages as $file) {
                    if (str_starts_with(basename($file), basename($fleet['fleet_img']))) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $imgPath = $data["fleet_img"]->storeAs(static::$imgFolder, $imgFileName, 'public');
        }
        if (isset($data["fleet_docs"])) {
            $docFileName = "{$timestamp}." . $data["fleet_docs"]->getClientOriginalExtension();
            $existingDocs = Storage::disk('public')->files(static::$docFolder);
            if ($request->isMethod('PUT')) {
                foreach ($existingDocs as $file) {
                    if (str_starts_with(basename($file), basename($fleet['fleet_docs']))) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $docPath = $data["fleet_docs"]->storeAs(static::$docFolder, $docFileName, 'public');
        }


        return [$imgPath, $docPath];
    }
}
