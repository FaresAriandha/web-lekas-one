<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Tentukan folder penyimpanan
    static private $imgFolder = 'couriers/images';
    static private $docFolder = 'couriers/docs';


    public function index(Request $request)
    {
        $data = ["title" => "Kelola Kurir", "header_title" => "Kelola Kurir"];
        $data["couriers"] = Courier::select('courier_ID', 'courier_name', 'created_at', 'courier_no_rekening', 'courier_nama_rekening')->orderBy('created_at', 'desc')->paginate(10);
        if ($request->input("keyword")) {
            $keyword = $request->input("keyword");
            # code...
            $data["couriers"] = Courier::select('courier_ID', 'courier_name', 'created_at', 'courier_no_rekening', 'courier_nama_rekening')
                ->where('courier_name', 'like', "%{$keyword}%")
                ->orWhere('courier_NIK', 'like', "%{$keyword}%")
                ->orWhere('courier_nama_rekening', 'like', "%{$keyword}%")
                ->orWhere('courier_no_rekening', 'like', "%{$keyword}%")
                ->orderBy('created_at', 'desc')
                ->paginate(10)->appends(['keyword' => $keyword]);;
            $data['keyword'] = $keyword;
        }
        // dd($data['couriers']);

        return view('pages.couriers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ["title" => "Tambah Kurir", "header_title" => "Tambah Data Kurir"];
        return view('pages.couriers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Inputs
        $validatedData = static::validasiInput($request);

        try {
            // Input File
            $courier_files = static::uploadFile($request, $validatedData);
            $validatedData["courier_img"] = $courier_files[0];
            $validatedData["courier_docs"] = $courier_files[1];

            Courier::create($validatedData);

            Session::flash('success', 'Data kurir berhasil ditambahkan!');
            return redirect()->route('admin.couriers.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal menyimpan data kurir');
            return redirect()->route('admin.couriers.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier)
    {

        $data = ["title" => "Detail Kurir", "header_title" => "Detail Data Kurir"];
        $data["courier"] = $courier;
        return view('pages.couriers.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courier $courier)
    {
        //
        $data = ["title" => "Edit Kurir", "header_title" => "Edit Data Kurir"];
        $data["courier"] = $courier;
        $data["courier_birthdate"] = Carbon::parse($courier->courier_birthdate)->format('m/d/Y');
        return view('pages.couriers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courier $courier)
    {
        // Validate Inputs
        $validatedData = static::validasiInput($request, $courier);

        try {
            // Input File
            if (isset($validatedData['courier_img']) || isset($validatedData['courier_docs'])) {
                $courier_files = static::uploadFile($request, $validatedData, $courier);
                $validatedData["courier_img"] = $courier_files[0];
                $validatedData["courier_docs"] = $courier_files[1];
            }

            // Update data courier ke dalam database
            $courier->update($validatedData);
            $user = User::where('courier_ID', $courier->courier_ID)->first();
            $user->update([
                'user_name' => $courier->courier_name,
                'user_img' => $courier->courier_img
            ]);

            Session::flash('success', 'Data kurir berhasil diperbarui');
            return redirect()->route('admin.couriers.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal memperbarui data kurir');
            return redirect()->route('admin.couriers.edit', $courier->courier_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        // dd($courier);
        try {
            // Hapus file dari storage jika ada
            // if ($courier->courier_img && Storage::disk('public')->exists($courier->courier_img)) {
            //     Storage::disk('public')->delete($courier->courier_img);
            // }

            // if ($courier->courier_docs && Storage::disk('public')->exists($courier->courier_docs)) {
            //     Storage::disk('public')->delete($courier->courier_docs);
            // }

            // Hapus data dari database
            $courier->delete();

            Session::flash('success', 'Data kurir berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus data kurir: ' . $e->getMessage());
        }

        // Redirect kembali ke daftar kurir
        return redirect()->route('admin.couriers.index');
    }

    static  private function validasiInput(Request $request, $courier = [])
    {
        $messages = [
            'courier_name.required'        => 'Nama kurir wajib diisi.',
            'courier_name.max'             => 'Nama kurir tidak boleh lebih dari :max karakter.',
            'courier_name.regex'           => 'Nama kurir tidak boleh mengandung angka.',

            'courier_NIK.required'         => 'NIK wajib diisi.',
            'courier_NIK.digits'           => 'NIK harus tepat :digits digit.',
            'courier_NIK.numeric'          => 'NIK hanya boleh berisi angka.',
            'courier_NIK.unique'           => 'NIK sudah terdaftar, gunakan NIK yang lain.',

            'courier_birthplace.required'  => 'Tempat lahir wajib diisi.',
            'courier_birthplace.max'       => 'Tempat lahir tidak boleh lebih dari :max karakter.',
            'courier_birthplace.regex'     => 'Tempat lahir tidak boleh mengandung angka.',

            'courier_birthdate.required'   => 'Tanggal lahir wajib diisi.',
            'courier_birthdate.date'       => 'Tanggal lahir harus dalam format yang valid.',

            'courier_telp.required'         => 'No. Telp wajib diisi.',
            'courier_telp.digits_between'   => 'No. Telp min 10 dan maks 14 digit',
            'courier_telp.numeric'          => 'No. Telp hanya boleh berisi angka.',

            'courier_telp_darurat.required'         => 'No. Telp wajib diisi.',
            'courier_telp_darurat.digits_between'   => 'No. Telp min 10 dan maks 14 digit',
            'courier_telp_darurat.numeric'          => 'No. Telp hanya boleh berisi angka.',

            'courier_gender.required'     => 'Jenis kelamin wajib diisi.',
            'courier_gender.in'     => 'Jenis kelamin harus laki-laki atau perempuan',

            'courier_address.required'     => 'Alamat wajib diisi.',
            'courier_address.max'          => 'Alamat tidak boleh lebih dari :max karakter.',

            'courier_nama_rekening.required'   => 'Nama rekening wajib diisi.',
            'courier_nama_rekening.max'        => 'Nama rekening tidak boleh lebih dari :max karakter.',
            'courier_nama_rekening.regex'      => 'Nama rekening tidak boleh mengandung angka.',

            'courier_no_rekening.required' => 'Nomor rekening wajib diisi.',
            'courier_no_rekening.digits'   => 'Nomor rekening harus :digits digit.',
            'courier_no_rekening.numeric'  => 'Nomor rekening hanya boleh berisi angka.',

            'courier_img.required'         => 'Foto kurir wajib diunggah.',
            'courier_img.mimes'            => 'Foto kurir harus berformat JPG, JPEG, atau PNG.',
            'courier_img.max'              => 'Ukuran foto kurir tidak boleh lebih dari 2MB.',

            'courier_docs.required'        => 'Dokumen kurir wajib diunggah.',
            'courier_docs.mimes'           => 'Dokumen kurir harus berformat PDF.',
            'courier_docs.max'             => 'Ukuran dokumen kurir tidak boleh lebih dari 2MB.',
        ];

        $validationFormat = [
            'courier_name'        => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'courier_NIK'         => 'required|digits:16|numeric|unique:couriers,courier_NIK',
            'courier_birthplace'  => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'courier_birthdate'   => 'required|date',
            'courier_telp'        => 'required|digits_between:10,14|numeric',
            'courier_telp_darurat' => 'required|digits_between:10,14|numeric',
            'courier_gender'     => 'required|in:male,female',
            'courier_address'     => 'required|string|max:255',
            'courier_nama_rekening' => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'courier_no_rekening' => 'required|digits:10|numeric',
            'courier_img'         => 'required|mimes:jpg,jpeg,png|max:2048', // Max 2MB sebelum dikompresi
            'courier_docs'        => 'required|mimes:pdf|max:2048', // Max 2MB sebelum dikompresi
        ];

        if ($request->isMethod('PUT')) {
            $validationFormat['courier_img'] = 'mimes:jpg,jpeg,png|max:2048';
            $validationFormat['courier_docs'] = 'mimes:pdf|max:2048';
            if ($courier['courier_NIK'] == $request->input('courier_NIK')) {
                $validationFormat['courier_NIK'] = 'required|digits:16|numeric';
            }
            // dd($validationFormat);
        }


        $validatedData = $request->validate($validationFormat, $messages);
        // dd($validatedData);

        return $validatedData;
    }

    static private function uploadFile(Request $request, $data, $courier = [])
    {
        $timestamp = now()->timestamp;
        $imgFileName = "";
        $docFileName = "";
        $imgPath = "";
        $docPath = "";

        if (!empty($courier)) {
            $imgPath = $courier["courier_img"];
            $docPath = $courier["courier_docs"];
        }


        if (isset($data["courier_img"])) {
            $imgFileName = "{$timestamp}." . $data["courier_img"]->getClientOriginalExtension();
            $existingImages = Storage::disk('public')->files(static::$imgFolder);
            if ($request->isMethod('PUT')) {
                foreach ($existingImages as $file) {
                    if (str_starts_with(basename($file), basename($courier['courier_img']))) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $imgPath = $data["courier_img"]->storeAs(static::$imgFolder, $imgFileName, 'public');
        }
        if (isset($data["courier_docs"])) {
            $docFileName = "{$timestamp}." . $data["courier_docs"]->getClientOriginalExtension();
            $existingDocs = Storage::disk('public')->files(static::$docFolder);
            if ($request->isMethod('PUT')) {
                foreach ($existingDocs as $file) {
                    if (str_starts_with(basename($file), basename($courier['courier_docs']))) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $docPath = $data["courier_docs"]->storeAs(static::$docFolder, $docFileName, 'public');
        }


        return [$imgPath, $docPath];
    }

    // static private function renamingFile($data, $courier = [])
    // {
    //     $existingImages = Storage::disk('public')->files(static::$imgFolder);
    //     $existingDocs = Storage::disk('public')->files(static::$docFolder);
    //     $imgPath = $courier["courier_img"];
    //     $docPath = $courier["courier_docs"];

    //     if ($data['courier_NIK'] != $courier['courier_NIK']) {
    //         foreach ($existingImages as $file) {
    //             if (str_starts_with(basename($file), "{$courier['courier_NIK']}_")) {
    //                 $newFileName = str_replace("{$courier['courier_NIK']}_", "{$data['courier_NIK']}_", basename($file));
    //                 $newPath = static::$imgFolder . '/' . $newFileName;
    //                 // Rename file
    //                 Storage::disk('public')->move($file, $newPath);
    //                 $imgPath = $newPath;
    //             }
    //         }

    //         foreach ($existingDocs as $file) {
    //             if (str_starts_with(basename($file), "{$courier['courier_NIK']}_")) {
    //                 $newFileName = str_replace("{$courier['courier_NIK']}_", "{$data['courier_NIK']}_", basename($file));
    //                 $newPath = static::$docFolder . '/' . $newFileName;

    //                 // Rename file
    //                 Storage::disk('public')->move($file, $newPath);

    //                 $docPath = $newPath;
    //             }
    //         }
    //     }

    //     return [$imgPath, $docPath];
    // }
}
