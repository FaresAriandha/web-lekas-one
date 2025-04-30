<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dashboard;
use App\Models\PaxelBill;
use App\Models\ClientBill;
use Illuminate\Http\Request;
use App\Models\PasarJayaBill;
use App\Models\PaxelShipment;
use App\Models\PasarJayaShipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_shipping(Request $request)
    {
        $data = [
            "title" => "Dashboard Pengiriman",
            "header_title" => "Dashboard",
        ];

        $data["startDate"] =  $request->input('start_date') ?? Carbon::now()->startOfMonth();
        $data["endDate"] = $request->input('end_date') ?? Carbon::now()->endOfMonth();



        if (strtotime($data["endDate"]) < strtotime($data["startDate"])) {
            Session::flash('warning',  "Tanggal akhir tidak boleh lebih kecil dari tanggal awal");
            return redirect()->route('admin.shippings.index');
        }

        $data["proyek"] = $request->input('proyek', 'paxel');

        if ($data["proyek"] == "pasjay") {
            $mapping = [
                'Jakarta Utara'  => 'JAKUT',
                'Jakarta Barat'  => 'JAKBAR',
                'Jakarta Selatan' => 'JAKSEL',
                'Jakarta Timur'  => 'JAKTIM',
                'Jakarta Pusat'  => 'JAKPUS',
            ];


            $query = PasarJayaBill::whereBetween('created_at', [
                Carbon::parse($data["startDate"])->startOfDay(),
                Carbon::parse($data["endDate"])->endOfDay()
            ]);

            $total_location = $query->sum("total_location");

            $total_multidrop = $total_location - $query->count("total_location");

            $total_roundtrip = (clone $query)
                ->where('roundtrip', true)
                ->count();

            $queryLokasi = PasarJayaShipment::whereBetween('created_at', [
                Carbon::parse($data["startDate"])->startOfDay(),
                Carbon::parse($data["endDate"])->endOfDay()
            ]);

            $data['total_location'] = $total_location;
            $data['total_multidrop'] = $total_multidrop;
            $data['total_roundtrip'] = $total_roundtrip;
            $data['client_bills'] = ClientBill::where('cb_type', 'pasjay')->whereBetween('created_at', [
                Carbon::parse($data["startDate"])->startOfDay(),
                Carbon::parse($data["endDate"])->endOfDay()
            ])->sum('total_bill_client');
            $data['paid_bills'] = ClientBill::where('cb_type', 'pasjay')->whereBetween('created_at', [
                Carbon::parse($data["startDate"])->startOfDay(),
                Carbon::parse($data["endDate"])->endOfDay()
            ])->sum('total_paid_client');

            $countLocations = PasarJayaShipment::select(
                DB::raw('shipment_price_lists.spl_name as city_name'),
                DB::raw('COUNT(*) as total')
            )
                ->join('shipment_pasjay_locations', 'shipments_pasjay.shploc_id', '=', 'shipment_pasjay_locations.shploc_ID')
                ->join('shipment_price_lists', 'shipment_pasjay_locations.spl_ID', '=', 'shipment_price_lists.spl_ID')
                ->whereBetween('shipments_pasjay.created_at', [
                    Carbon::parse($data["startDate"])->startOfDay(),
                    Carbon::parse($data["endDate"])->endOfDay()
                ])
                ->groupBy('city_name')
                ->pluck('total', 'city_name')
                ->toArray();
            $data["dataCharts"] = [];
            foreach ($countLocations as $cityName => $total) {
                if (isset($mapping[$cityName])) {
                    $data["dataCharts"][$mapping[$cityName]] = $total;
                }
            }
            // dd($data);
            // $data["dataCharts"] 
        } else {
            $query = PaxelShipment::whereBetween('created_at', [
                Carbon::parse($data["startDate"])->startOfDay(),
                Carbon::parse($data["endDate"])->endOfDay()
            ]);

            $totalAwb = $query->count();

            $totalAwbFinished = (clone $query)
                ->where('awb_status', '!=', 'Dibatalkan')
                ->count();

            $totalAwbCancelled = (clone $query)
                ->where('awb_status', 'Dibatalkan')
                ->count();

            $totalAwbHalimHub = (clone $query)
                ->where('awb_hub', 'HALIM')
                ->count();

            $totalAwbMangduHub = (clone $query)
                ->where('awb_hub', 'MANGGA DUA')
                ->count();

            $data['total_awb'] = $totalAwb;
            $data['total_awb_finished'] = $totalAwbFinished;
            $data['total_awb_canceled'] = $totalAwbCancelled;
            $data['client_bills'] = ClientBill::where('cb_type', 'paxel')->whereBetween('created_at', [
                Carbon::parse($data["startDate"])->startOfDay(),
                Carbon::parse($data["endDate"])->endOfDay()
            ])->sum('total_bill_client');
            $data['paid_bills'] = ClientBill::where('cb_type', 'paxel')->whereBetween('created_at', [
                Carbon::parse($data["startDate"])->startOfDay(),
                Carbon::parse($data["endDate"])->endOfDay()
            ])->sum('total_paid_client');

            $data["dataCharts"] = [
                "Halim HUB" => $totalAwbHalimHub,
                "Mangga Dua HUB" => $totalAwbMangduHub,
            ];
        }

        // dd($data);

        return view('pages.dashboard', $data);
    }

    public function index_courier(Request $request)
    {
        $data = [
            "title" => "Dashboard Kurir",
            "header_title" => "Dashboard",
        ];


        // Query dari tabel paxel_bills
        $paxelData = DB::table('paxel_bills')
            ->select(
                'courier_ID',
                DB::raw('SUM(awb_total) as total_awb_paxel'),
                DB::raw('SUM(CAST(total_bill_client AS SIGNED) - CAST(paid_to_courier AS SIGNED)) as total_setoran_paxel')
            )
            ->whereNull("deleted_at")
            ->groupBy('courier_ID');

        // Query dari tabel pasjay_bills
        $pasjayData = DB::table('pasjay_bills')
            ->select(
                'courier_ID',
                DB::raw('SUM(total_location) as total_lokasi_pasjay'),
                DB::raw('SUM(CAST(total_charge AS SIGNED) - CAST(paid_to_courier AS SIGNED)) as total_setoran_pasjay')
            )
            ->whereNull("deleted_at")
            ->groupBy('courier_ID');

        // Gabungkan hasilnya
        $result = DB::table(DB::raw("({$paxelData->toSql()}) as paxel"))
            ->mergeBindings($paxelData)
            ->leftJoinSub($pasjayData, 'pasjay', 'paxel.courier_ID', '=', 'pasjay.courier_ID')
            ->leftJoin('couriers', 'paxel.courier_ID', '=', 'couriers.courier_ID')
            ->select(
                'couriers.courier_name',
                DB::raw('COALESCE(total_awb_paxel, 0) as total_awb'),
                DB::raw('COALESCE(total_lokasi_pasjay, 0) as total_lokasi'),
                DB::raw('(COALESCE(total_setoran_paxel, 0) + COALESCE(total_setoran_pasjay, 0)) as total_setoran')
            )
            ->orderByDesc('total_setoran')
            ->paginate(10);


        // dd($result);


        $data["startDate"] =  $request->input('start_date') ?? Carbon::now()->startOfMonth();
        $data["endDate"] = $request->input('end_date') ?? Carbon::now()->endOfMonth();
        $data["proyek"] = $request->input('proyek');
        $data["courier_performs"] = $result;

        return view('pages.dashboard', $data);
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
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
