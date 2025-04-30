<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ["title" => "Kelola Tarif", "header_title" => "Kelola Tarif Pengiriman"];
        // Query awal tanpa filter
        $query = Price::select('spl_ID', 'spl_name', 'spl_type', 'spl_baseprice', 'spl_baseprice_client', 'spl_multidrop', 'spl_multidrop_client', 'spl_roundtrip', 'spl_roundtrip_client')->orderBy('created_at', 'desc');
        if ($request->filled("keyword")) {
            $keyword = $request->input("keyword");

            $query->where(function ($q) use ($keyword) {
                $q->where('spl_name', 'like', "%{$keyword}%");
            });

            $data['keyword'] = $keyword;
        }

        // Ambil data dengan pagination
        $data["prices"] = $query->paginate(5)->appends(['keyword' => $request->input("keyword")]);
        return view('pages.pricings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ["title" => "Tambah Tarif", "header_title" => "Tambah Tarif Pengiriman"];
        return view('pages.pricings.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Inputs
        $validatedData = static::validasiInput($request);

        try {

            Price::create($validatedData);

            Session::flash('success', 'Data tarif berhasil ditambahkan!');
            return redirect()->route('admin.prices.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal menyimpan data tarif');
            return redirect()->route('admin.prices.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price)
    {
        $data = ["title" => "Edit Tarif", "header_title" => "Edit Tarif Pengiriman"];
        $data["price"] = $price;
        return view('pages.pricings.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Price $price)
    {
        $validatedData = static::validasiInput($request, $price);

        try {

            // Update data courier ke dalam database
            $price->update($validatedData);

            Session::flash('success', 'Data tarif berhasil diperbarui');
            return redirect()->route('admin.prices.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal memperbarui data tarif');
            return redirect()->route('admin.prices.edit', $price->spl_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price)
    {
        try {

            // Hapus data dari database
            $price->delete();

            Session::flash('success', 'Data tarif berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus data tarif: ' . $e->getMessage());
        }

        // Redirect kembali ke daftar kurir
        return redirect()->route('admin.prices.index');
    }


    static  private function validasiInput(Request $request, $price = [])
    {
        $messages = [
            'spl_name.required'     => 'Nama tarif wajib diisi.',
            'spl_name.max'          => 'Nama tarif maksimal :max karakter.',
            'spl_name.unique'       => 'Nama tarif sudah digunakan.',
            'spl_name.regex'        => 'Nama tarif hanya boleh mengandung huruf, angka, spasi, dan tanda hubung.',

            'spl_type.required'     => 'Jenis tarif wajib dipilih.',
            'spl_type.in'           => 'Jenis tarif harus berdasarkan opsi yang ada.',

            'spl_baseprice.required'        => 'Tarif dasar internal wajib diisi.',
            'spl_baseprice.integer'         => 'Tarif dasar internal harus berupa angka.',
            'spl_baseprice.min'             => 'Tarif dasar internal tidak boleh negatif.',

            'spl_baseprice_client.required' => 'Tarif dasar klien wajib diisi.',
            'spl_baseprice_client.integer'  => 'Tarif dasar klien harus berupa angka.',
            'spl_baseprice_client.min'      => 'Tarif dasar klien tidak boleh negatif.',

            'spl_multidrop.required'        => 'Tarif multidrop internal wajib diisi.',
            'spl_multidrop.integer'         => 'Tarif multidrop internal harus berupa angka.',
            'spl_multidrop.min'             => 'Tarif multidrop internal tidak boleh negatif.',

            'spl_multidrop_client.required' => 'Tarif multidrop klien wajib diisi.',
            'spl_multidrop_client.integer'  => 'Tarif multidrop klien harus berupa angka.',
            'spl_multidrop_client.min'      => 'Tarif multidrop klien tidak boleh negatif.',

            'spl_roundtrip.required'        => 'Tarif roundtrip internal wajib diisi.',
            'spl_roundtrip.integer'         => 'Tarif roundtrip internal harus berupa angka.',
            'spl_roundtrip.min'             => 'Tarif roundtrip internal tidak boleh negatif.',

            'spl_roundtrip_client.required' => 'Tarif roundtrip klien wajib diisi.',
            'spl_roundtrip_client.integer'  => 'Tarif roundtrip klien harus berupa angka.',
            'spl_roundtrip_client.min'      => 'Tarif roundtrip klien tidak boleh negatif.',
        ];


        $validationFormat = [
            'spl_name'               => 'required|string|max:100|unique:shipment_price_lists,spl_name|regex:/^[a-zA-Z0-9\s\-]+$/',
            'spl_type'               => 'required|in:pasjay,paxel',
            'spl_baseprice'          => 'required|integer|min:0',
            'spl_baseprice_client'   => 'required|integer|min:0',
            'spl_multidrop'          => 'required|integer|min:0',
            'spl_multidrop_client'   => 'required|integer|min:0',
            'spl_roundtrip'          => 'required|integer|min:0',
            'spl_roundtrip_client'   => 'required|integer|min:0',
        ];



        if ($request->isMethod('PUT')) {
            if ($request->input('spl_name') == $price['spl_name']) {
                $validationFormat['spl_name'] = 'required|string|max:100|regex:/^[a-zA-Z0-9\s\-]+$/';
            }
        }

        $validatedData = $request->validate($validationFormat, $messages);

        return $validatedData;
    }
}
