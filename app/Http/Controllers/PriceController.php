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

            $price = Price::with('locations.pasarJayaShipments', 'locations.pasarJayaBills')->findOrFail($price->spl_ID);
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
            'spl_baseprice.integer'         => 'Tarif dasar internal harus berupa nominal.',
            'spl_baseprice.digits_between'             => 'Tarif dasar internal min 1 dan maks 10 digit',

            'spl_baseprice_client.required' => 'Tarif dasar klien wajib diisi.',
            'spl_baseprice_client.integer'  => 'Tarif dasar klien harus berupa nominal.',
            'spl_baseprice_client.digits_between'      => 'Tarif dasar klien min 1 dan maks 10 digit',

            'spl_multidrop.required'        => 'Tarif multidrop internal wajib diisi.',
            'spl_multidrop.integer'         => 'Tarif multidrop internal harus berupa nominal.',
            'spl_multidrop.digits_between'             => 'Tarif multidrop internal min 1 dan maks 10 digit',

            'spl_multidrop_client.required' => 'Tarif multidrop klien wajib diisi.',
            'spl_multidrop_client.integer'  => 'Tarif multidrop klien harus berupa nominal.',
            'spl_multidrop_client.digits_between'      => 'Tarif multidrop klien min 1 dan maks 10 digit',

            'spl_roundtrip.required'        => 'Tarif roundtrip internal wajib diisi.',
            'spl_roundtrip.integer'         => 'Tarif roundtrip internal harus berupa nominal.',
            'spl_roundtrip.digits_between'             => 'Tarif roundtrip internal min 1 dan maks 10 digit',

            'spl_roundtrip_client.required' => 'Tarif roundtrip klien wajib diisi.',
            'spl_roundtrip_client.integer'  => 'Tarif roundtrip klien harus berupa nominal.',
            'spl_roundtrip_client.digits_between'      => 'Tarif roundtrip klien min 1 dan maks 10 digit',
        ];


        $validationFormat = [
            'spl_name'               => 'required|string|max:100|unique:shipment_price_lists,spl_name|regex:/^[a-zA-Z0-9\s\-]+$/',
            'spl_type'               => 'required|in:pasjay,paxel',
            'spl_baseprice'          => 'required|integer|digits_between:1,10',
            'spl_baseprice_client'   => 'required|integer|digits_between:1,10',
            'spl_multidrop'          => 'required|integer|digits_between:1,10',
            'spl_multidrop_client'   => 'required|integer|digits_between:1,10',
            'spl_roundtrip'          => 'required|integer|digits_between:1,10',
            'spl_roundtrip_client'   => 'required|integer|digits_between:1,10',
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
