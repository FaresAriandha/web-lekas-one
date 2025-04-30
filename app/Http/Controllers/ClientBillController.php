<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ClientBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $displayData = $request->input('display_data', 'paxel');
        $selectedDate = $request->input('bills_date');
        $data = ["title" => "Tagihan Klien", "header_title" => "Kelola Riwayat Tagihan Klien", "display_data" => $displayData];

        $query = ClientBill::where("cb_type", $displayData);

        if (!empty($selectedDate)) {
            $query->whereDate('created_at', $selectedDate);
            $data['bills_date'] = $selectedDate;
        }

        $data['client_bills'] = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->only(['bills_date, display_data']));
        return view('pages.client-bills.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientBill $clientBill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientBill $clientBill)
    {
        $data = ["title" => "Edit Tagihan Klien", "header_title" => $clientBill->cb_type == "pasjay" ? "Edit Tagihan Klien Pasar Jaya" : "Edit Tagihan Klien Paxel"];

        $data['client_bill'] = $clientBill;

        return view('pages.client-bills.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientBill $clientBill)
    {
        try {
            $clientBill->update([
                'total_paid_client' => $request->input("total_paid_client"),
                'keterangan' => $request->input("keterangan")
            ]);

            Session::flash('success', 'Data tagihan berhasil diperbarui');
            return redirect()->route('admin.client-bills.edit', $clientBill->cb_ID);
        } catch (\Throwable $th) {
            Session::flash('error', 'Gagal memperbarui data tagihan');
            return redirect()->route('admin.courier-payments.edit', $clientBill->cb_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientBill $clientBill)
    {
        //
    }
}
