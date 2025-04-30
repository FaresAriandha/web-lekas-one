<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PaxelBill;
use Illuminate\Http\Request;
use App\Models\PasarJayaBill;
use Illuminate\Support\Facades\Session;

class CourierPaymentController extends Controller
{
    public function index(Request $request)
    {
        $displayData = $request->input('display_data', 'paxel');
        $selectedDate = $request->input('payment_date');
        $data = ["title" => "Pencairan Kurir", "header_title" => "Kelola Riwayat Pencairan Kurir", "display_data" => $displayData];
        if ($displayData === 'pasjay') {
            $query = PasarJayaBill::selectRaw('DATE(created_at) as created_at, SUM(total_charge) as total_charge_sum, SUM(paid_to_courier) as total_paid_sum')
                ->groupByRaw('DATE(created_at)');
        } else {
            $query = PaxelBill::selectRaw('DATE(created_at) as created_at, SUM(total_bill_client) as total_charge_sum, SUM(paid_to_courier) as total_paid_sum')
                ->groupByRaw('DATE(created_at)');
        }

        if (!empty($selectedDate)) {
            $query->whereDate('created_at', $selectedDate);
            $data['payment_date'] = $selectedDate;
        }

        $data['courier_payments'] = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->only(['payment_date, display_data']));
        return view('pages.courier-payments.index', $data);
    }

    public function edit($display_data, $date)
    {
        // dd($date . " " . $display_data);
        $data = ["title" => "Edit Pencairan Kurir", "header_title" => "Edit Pencairan Kurir Paxel", "shipment_date" => Carbon::parse($date), "display_data" => $display_data];
        if ($display_data === 'pasjay') {
            $mapping = [
                'Jakarta Utara'  => 'JAKUT',
                'Jakarta Barat'  => 'JAKBAR',
                'Jakarta Selatan' => 'JAKSEL',
                'Jakarta Timur'  => 'JAKTIM',
                'Jakarta Pusat'  => 'JAKPUS',
            ];

            $data['header_title'] = "Edit Pencairan Kurir Pasar Jaya";
            $pasjay_payments = PasarJayaBill::selectRaw('pasjay_bills.courier_ID, couriers.courier_name as courier_name, couriers.courier_nama_rekening as courier_nama_rekening, SUM(total_location) as total_location, COUNT(rit) as total_rit, SUM(CASE WHEN roundtrip = true THEN roundtrip ELSE 0 END) as total_roundtrip, SUM(total_charge) as total_charge, SUM(paid_to_courier) as paid_to_courier')
                ->join('couriers', 'couriers.courier_ID', '=', 'pasjay_bills.courier_ID')
                ->whereDate('pasjay_bills.created_at', Carbon::parse($date)->toDateString())
                ->groupBy('pasjay_bills.courier_ID', 'couriers.courier_name')
                ->get();


            foreach ($pasjay_payments as $payment) {
                // dd($payment->courier_ID);
                $courier_baseprice_locations = [];
                $location_baseprices = PasarJayaBill::with([
                    'location:shploc_ID,shploc_name,spl_ID',
                    'location.price:spl_ID,spl_name'
                ])->where("courier_ID", $payment->courier_ID)->whereDate('created_at', Carbon::parse($date)->toDateString())->get();

                // dd($location_baseprices);
                foreach ($location_baseprices as $loc_baseprice) {
                    $courier_baseprice_locations[] = $loc_baseprice->location->price->spl_name;
                }
                $converted = array_map(function ($loc) use ($mapping) {
                    return $mapping[$loc] ?? $loc; // fallback ke aslinya jika tidak ditemukan
                }, $courier_baseprice_locations);

                $payment['location_baseprice'] = implode(', ', $converted);
                // unset($courier_baseprice_locations);
            }

            $data['courier_payments'] = $pasjay_payments;
        } else {
            $paxel_payments = PaxelBill::selectRaw('paxel_bills.courier_ID, couriers.courier_name as courier_name, couriers.courier_nama_rekening as courier_nama_rekening, SUM(CASE WHEN awb_slot = "Pagi" THEN awb_total ELSE 0 END) as awb_total_pagi, SUM(CASE WHEN awb_slot = "Pagi" THEN total_bill_client ELSE 0 END) as total_bill_client_pagi, SUM(CASE WHEN awb_slot = "Siang" THEN awb_total ELSE 0 END) as awb_total_siang, SUM(CASE WHEN awb_slot = "Siang" THEN total_bill_client ELSE 0 END) as total_bill_client_siang, SUM(total_bill_client) as sum_total_bill_client, SUM(paid_to_courier) as paid_to_courier')
                ->join('couriers', 'couriers.courier_ID', '=', 'paxel_bills.courier_ID')
                ->whereDate('paxel_bills.created_at', Carbon::parse($date)->toDateString())
                ->groupBy('paxel_bills.courier_ID', 'couriers.courier_name')
                ->get();

            $data['courier_payments'] = $paxel_payments;
        }
        // dd($data);
        return view('pages.courier-payments.edit', $data);
    }

    public function update($date, $courier_ID, Request $request)
    {

        // dd($date . " " . $courier_ID . " " . $request->input("paid_to_courier"));
        try {
            if ($request->input("display_data") == "pasjay") {
                $pasjayBill = PasarJayaBill::where('courier_ID', $courier_ID)
                    ->whereDate('created_at', Carbon::parse($date)->toDateString())
                    ->first();

                if ($pasjayBill) {
                    $pasjayBill->paid_to_courier = $request->input("paid_to_courier");
                    $pasjayBill->save();
                }
            } else {
                $paxelBill = PaxelBill::where('courier_ID', $courier_ID)
                    ->whereDate('created_at', Carbon::parse($date)->toDateString())
                    ->first();

                if ($paxelBill) {
                    $paxelBill->paid_to_courier = $request->input("paid_to_courier");
                    $paxelBill->save();
                }
            }

            Session::flash('success', 'Data pencairan berhasil diperbarui');
            return redirect()->route('admin.courier-payments.edit', ['date' => $date, 'display_data' => $request->input("display_data")]);
        } catch (\Throwable $th) {
            Session::flash('error', 'Gagal memperbarui data pencairan');
            return redirect()->route('admin.courier-payments.edit', ['date' => $date, 'display_data' => $request->input("display_data")])->withInput();
        }
    }
}
