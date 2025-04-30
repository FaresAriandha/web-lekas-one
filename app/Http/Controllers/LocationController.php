<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ["title" => "Kelola Lokasi", "header_title" => "Kelola Lokasi Pengiriman Pasar Jaya"];

        // Query awal tanpa filter
        // $query = Location::select('shploc_ID', 'shploc_name', 'shploc_city', 'shploc_url_maps')->orderBy('created_at', 'desc');
        // if ($request->filled("keyword")) {
        //     $keyword = $request->input("keyword");

        //     $query->where(function ($q) use ($keyword) {
        //         $q->where('shploc_name', 'like', "%{$keyword}%")
        //             ->orWhere('shploc_city', 'like', "%{$keyword}%");
        //     });

        //     $data['keyword'] = $keyword;
        // }


        // Ambil data dengan pagination
        // $data["locations"] = $query->paginate(10)->appends(['keyword' => $request->input("keyword")]);

        $keyword = $request->input('keyword');



        // Query CourierAssign
        $query = Location::with([
            'price:spl_ID,spl_name',
        ]);


        // Filter keyword jika ada
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('price', function ($qc) use ($keyword) {
                    $qc->where('spl_name', 'like', "%{$keyword}%");
                })->orWhere('shploc_name', 'like', "%{$keyword}%");
            });

            $data['keyword'] = $keyword;
            // dd($data);
        }



        // Pagination dan passing data
        $data['locations'] = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->only('keyword'));



        // dd($data['']);
        return view('pages.locations.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = ["title" => "Tambah Lokasi", "header_title" => "Tambah Lokasi Gerai"];
        $data["prices"] = Price::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->where("spl_type", "pasjay")
            ->select('spl_ID', 'spl_name') // Pilih hanya field yang diperlukan
            ->get();

        // dd($data['prices']);
        return view('pages.locations.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Inputs
        $validatedData = static::validasiInput($request);

        try {

            Location::create($validatedData);

            Session::flash('success', 'Data gerai berhasil ditambahkan!');
            return redirect()->route('admin.locations.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal menyimpan data gerai');
            return redirect()->route('admin.locations.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        $data = ["title" => "Detail Lokasi", "header_title" => "Detail Data Lokasi Gerai"];
        $data["location"] = $location;
        return view('pages.locations.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        $data = ["title" => "Edit Lokasi", "header_title" => "Edit Data Lokasi Gerai"];
        $data["location"] = $location;
        $data["prices"] = Price::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->where("spl_type", "pasjay")
            ->select('spl_ID', 'spl_name') // Pilih hanya field yang diperlukan
            ->get();
        return view('pages.locations.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validatedData = static::validasiInput($request, $location);

        try {

            // Update data courier ke dalam database
            $location->update($validatedData);

            Session::flash('success', 'Data gerai berhasil diperbarui');
            return redirect()->route('admin.locations.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal memperbarui data gerai');
            return redirect()->route('admin.locations.edit', $location->shiploc_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        try {

            // Hapus data dari database
            $location->delete();

            Session::flash('success', 'Data gerai berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus data gerai: ' . $e->getMessage());
        }

        // Redirect kembali ke daftar kurir
        return redirect()->route('admin.locations.index');
    }

    static  private function validasiInput(Request $request, $location = [])
    {
        $messages = [
            'shploc_name.required'  => 'Nama gerai wajib diisi.',
            'shploc_name.regex'     => 'Nama gerai tidak boleh mengandung angka.',
            'shploc_name.unique'    => 'Nama gerai sudah terdaftar, silahkan masukkan nama gerai lain.',
            'shploc_name.max'       => 'Nama gerai tidak boleh lebih dari :max karakter.',

            'shploc_address.required'  => 'Alamat lokasi gerai wajib diisi.',

            'spl_ID.required' => 'Kota lokasi gerai harus dipilih.',
            'spl_ID.exists' => 'Kota lokasi gerai tidak ditemukan di sistem.',
            'spl_ID.ulid' => 'Format ID Kota lokasi gerai tidak valid.',

            'shploc_url_maps.required'  => 'Alamat URL lokasi gerai wajib diisi.',
            'shploc_url_maps.url'  => 'Alamat URL lokasi harus dalam format URL',

        ];

        $validationFormat = [
            'shploc_name'      => 'required|string|max:100|unique:shipment_pasjay_locations,shploc_name|regex:/^[a-zA-Z\s]+$/',
            'shploc_address'   => 'required|string',
            'spl_ID'        => 'required|exists:shipment_price_lists,spl_ID|ulid',
            'shploc_url_maps'  => 'required|url',
        ];


        if ($request->isMethod('PUT')) {
            if ($request->input('shploc_name') == $location['shploc_name']) {
                $validationFormat['shploc_name'] = 'required|string|max:100|regex:/^[a-zA-Z\s]+$/';
            }
        }

        $validatedData = $request->validate($validationFormat, $messages);

        return $validatedData;
    }
}
