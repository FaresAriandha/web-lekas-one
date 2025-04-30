@extends('layouts.app')

@section('content')
    {{-- Tab Element --}}
    <ul class="text-sm font-medium text-center overflow-hidden rounded-lg shadow-md flex ">
        <li class="w-full focus-within:z-10">
            <a href="/admin/dashboard/shippings"
                class="inline-block w-full p-4 {{ $title == 'Dashboard Pengiriman' ? 'text-white bg-[#344357]' : 'text-[#344357]' }} focus:outline-none"
                aria-current="page">Pengiriman</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a href="/admin/dashboard/couriers"
                class="inline-block w-full p-4 {{ $title == 'Dashboard Kurir' ? 'text-white bg-[#344357]' : 'text-[#344357]' }} focus:outline-none"
                aria-current="page">Kinerja Kurir</a>
        </li>
    </ul>


    {{-- Datepicker & Dropdown --}}

    <div class="flex justify-between items-start sm:items-start my-[40px] flex-col sm:flex-col">
        <div class="flex flex-col sm:flex-row items-end sm:items-center justify-end w-full ">
            <form
                action="{{ $title == 'Dashboard Pengiriman' ? '/admin/dashboard/shippings' : '/admin/dashboard/couriers' }}"
                method="get" class="flex flex-col sm:flex-row items-end sm:items-center flex-wrap ">

                {{-- Date Picker --}}
                <div class="flex flex-col sm:flex-row justify-between items-center  mb-[10px] sm:mb-0">
                    {{-- start --}}
                    <div class="relative sm:max-w-sm mb-[10px] sm:mb-0 sm:mr-[10px]">
                        <input id="datepicker-autohide-1" datepicker datepicker-autohide type="text"
                            datepicker-format="yyyy-mm-dd"
                            class="border-0 ring-1 ring-black rounded-lg px-4 py-2 focus:ring-2 focus:outline-none focus:ring-[#344357] block w-48 ps-10 p-2.5 peer"
                            placeholder="Pilih tanggal" name="start_date" autocomplete="off"
                            value="{{ old('start_date', $startDate) }}">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 text-black peer-focus:text-[#344357]">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                    </div>

                    {{-- end --}}
                    <span>to</span>

                    <div class="relative max-w-sm mt-[10px] sm:mt-0 sm:mx-[10px]">
                        <input id="datepicker-autohide-2" datepicker datepicker-autohide type="text"
                            datepicker-format="yyyy-mm-dd"
                            class="border-0 ring-1 ring-black rounded-lg px-4 py-2 focus:ring-2 focus:outline-none focus:ring-[#344357] block w-48 ps-10 p-2.5 peer"
                            placeholder="Pilih tanggal" name="end_date" autocomplete="off"
                            value="{{ old('end_date', $endDate) }}">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 text-black peer-focus:text-[#344357]">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                    </div>

                </div>



                {{-- Dropdown Status --}}
                <div
                    class="dropdown-input relative w-32 my-[15px] sm:my-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357] {{ $title == 'Dashboard Kurir' ? 'hidden' : '' }}">
                    <select
                        class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border cursor-pointer"
                        name="proyek">
                        <option value="paxel" {{ old('proyek') == 'paxel' || $proyek == 'paxel' ? 'selected' : '' }}>Paxel
                        </option>
                        <option value="pasjay" {{ old('proyek') == 'pasjay' || $proyek == 'pasjay' ? 'selected' : '' }}>
                            Pasar Jaya</option>
                    </select>

                    <!-- Custom Chevron Icon -->
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[#344357] transition-transform duration-200 bg-white">
                        <svg class="w-5 h-5 transition-transform duration-200" id="icon-dropdown" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <button
                    class="flex items-center sm:mt-0 bg-[#344357] px-3 py-2 rounded-md text-white font-semibold shadow-md cursor-pointer  active:translate-y-[3px]">
                    <svg class="w-[20px] h-[20px] text-white mr-[5px]" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    Filter
                </button>
            </form>

        </div>
    </div>

    {{-- Dashboard Pengiriman --}}
    @if ($title == 'Dashboard Pengiriman')
        <div>
            <div
                class="w-full flex flex-col sm:flex-row justify-start space-x-[20px] space-y-[20px] sm:space-y-0 mb-[20px]">
                <div
                    class="w-[100%] sm:w-[250px] p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 text-center">
                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 ">
                        {{ $proyek == 'pasjay' && $title == 'Dashboard Pengiriman' ? 'Total Lokasi Kirim' : 'Total AWB' }}
                    </h5>
                    <p class="text-gray-700 font-semibold mt-[16px]">
                        {{ $proyek == 'pasjay' ? number_format($total_location, 0, '.', ',') : number_format($total_awb, 0, '.', ',') }}
                    </p>
                </div>
                <div
                    class="w-[100%] sm:w-[250px] p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 text-center">
                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 ">
                        {!! $proyek == 'pasjay' ? 'Total <i>Multi Drop</i>' : 'Total AWB (Terkirim)' !!}</h5>
                    <p class="text-gray-700 font-semibold mt-[16px]">
                        {{ $proyek == 'pasjay' ? number_format($total_multidrop, 0, '.', ',') : number_format($total_awb_finished, 0, '.', ',') }}
                    </p>
                </div>
                <div
                    class="w-[100%] sm:w-[250px] p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 text-center">
                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 ">
                        {!! $proyek == 'pasjay' ? 'Total <i>Round Trip</i>' : 'Total AWB (Gagal Kirim)' !!}</h5>
                    <p class="text-gray-700 font-semibold mt-[16px]">
                        {{ $proyek == 'pasjay' ? number_format($total_roundtrip, 0, '.', ',') : number_format($total_awb_canceled, 0, '.', ',') }}
                    </p>
                </div>
            </div>
            <div
                class="w-full flex flex-col sm:flex-row justify-start space-x-[20px] space-y-[20px] sm:space-y-0 mb-[20px]">
                <div
                    class="w-[100%] sm:w-[250px] p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 text-center">
                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 ">Total Tagihan Klien</h5>
                    <p class="text-gray-700 font-semibold mt-[16px]">Rp {{ number_format($client_bills, 0, '.', ',') }}</p>
                </div>
                <div
                    class="w-[100%] sm:w-[250px] p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 text-center">
                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 ">Tagihan Dibayarkan</h5>
                    <p class="text-gray-700 font-semibold mt-[16px]">Rp {{ number_format($paid_bills, 0, '.', ',') }}</p>
                </div>
                <div
                    class="w-[100%] sm:w-[250px] p-6 {{ $paid_bills - $client_bills < 0 ? 'bg-red-200 text-white ' : 'bg-white hover:bg-gray-100' }}  border border-gray-200 rounded-lg shadow-sm  text-center">
                    <h5 class="mb-2 text-lg font-bold tracking-tight  text-gray-900 ">Selisih Tagihan</h5>
                    <p class="text-gray-700 font-semibold mt-[16px]">Rp
                        {{ number_format($paid_bills - $client_bills, 0, '.', ',') }}</p>
                </div>
            </div>


            {{-- Charts --}}
            @if ($client_bills > 0)
                <div class="w-full sm:w-[70%] h-[350px] bg-white rounded-lg p-6 text-black mt-10">
                    <canvas id="paxelCanvas" class="cursor-pointer"></canvas>
                    <canvas id="pasjayCanvas" class="hidden"></canvas>
                </div>
            @endif
        </div>
    @else
        <div class="bg-white shadow rounded-2xl p-6 relative" id="container-table">

            <div class="relative overflow-x-scroll no-scrollbar shadow-md rounded-lg">
                <table class="w-full h-fit text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-[16px] capitalize bg-[#344357] text-white text-center">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Kurir
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total AWB (Paxel)
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Lokasi (Pasar Jaya)
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Setoran
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-[15px] h-fit text-black text-center">
                        @if (count($courier_performs) > 0)
                            @foreach ($courier_performs as $index => $courier)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-100">
                                    <th scope="row" class="px-6 py-4 font-medium text-center">
                                        {{ $courier_performs->firstItem() + $index }}
                                    </th>
                                    <td class="px-6 py-4 text-center">
                                        {{ $courier->courier_name }}
                                    </td>
                                    <td class="px-6 py-4 w-[200px]">
                                        {{ number_format($courier->total_awb, 0, '.', ',') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ number_format($courier->total_lokasi, 0, '.', ',') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        Rp {{ number_format($courier->total_setoran, 0, '.', ',') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center">
                                    Tidak ada baris yang dapat ditampilkan
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (count($courier_performs) > 0)
                <div class="justify-between items-center mt-6 flex">
                    <div>
                        <h1 class="text-xs sm:text-base">
                            Showing {{ $courier_performs->firstItem() }} to {{ $courier_performs->lastItem() }} of
                            {{ $courier_performs->total() }}
                            entries
                        </h1>
                    </div>
                    <div class="space-x-1">
                        @if ($courier_performs->currentPage() > 1)
                            <a href="{{ $courier_performs->previousPageUrl() }}"
                                class="px-4 py-2 ring-1 ring-black rounded-lg hover:bg-gray-100 cursor-pointer">
                                &larr; <span class="hidden sm:inline-block">Previous</span>
                            </a>
                        @endif

                        @if ($courier_performs->hasMorePages())
                            <a href="{{ $courier_performs->nextPageUrl() }}"
                                class="px-4 py-2 ring-1 ring-black rounded-lg hover:bg-gray-100 cursor-pointer">
                                <span class="hidden sm:inline-block">Next</span> &rarr;
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif






    @isset($dataCharts)
        <script>
            const paxelCanvas = document.getElementById('paxelCanvas');
            const dataKeyCharts = @json(array_keys($dataCharts));
            const dataValueCharts = @json(array_values($dataCharts));
            const tipeProyek = @json($proyek);

            const paxelChart = new Chart(paxelCanvas, {
                type: 'bar',
                data: {
                    labels: dataKeyCharts,
                    datasets: [{
                        data: dataValueCharts,
                        backgroundColor: '#52C3BE',
                    }]
                },
                options: {
                    responsive: true, // Aktifkan responsivitas
                    maintainAspectRatio: false, // Biarkan chart menyesuaikan ukuran container
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    return tooltipItems[0].label; // Tetap menampilkan nama lokasi
                                },
                                label: function(tooltipItem) {
                                    let tooltipText =
                                        `Total Drop di ${tooltipItem . label} : ${tooltipItem . raw}`

                                    if (tipeProyek != 'pasjay') {
                                        tooltipText =
                                            `Total AWB asal ${tooltipItem . label} : ${tooltipItem . raw}`
                                    }
                                    return tooltipText;
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: tipeProyek != "pasjay" ? "Paxel HUB" :
                                "Lokasi Drop Barang", // Ganti dengan label yang sesuai
                                font: {
                                    family: 'sans-serif',
                                    size: 14,
                                    weight: 'bold'
                                },
                                color: '#344357', // Ubah warna teks label sumbu Y
                                padding: {
                                    top: 25
                                },
                            },
                            ticks: {
                                font: {
                                    size: 11,
                                    family: 'sans-serif'
                                },
                                color: '#344357', // Ubah warna angka di sumbu Y
                                maxRotation: 45, // Hindari rotasi otomatis
                                minRotation: 0
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: tipeProyek != "pasjay" ? "Total AWB" :
                                "Total Lokasi Drop", // Ganti dengan label yang sesuai
                                font: {
                                    size: 14, // Ubah ukuran font label sumbu Y
                                    weight: 'bold',
                                    family: 'sans-serif'
                                },
                                padding: {
                                    bottom: 15
                                },
                                color: '#344357', // Ubah warna teks label sumbu Y
                            },
                            ticks: {
                                font: {
                                    size: 11,
                                    family: 'sans-serif'
                                },
                                color: '#344357' // Ubah warna angka di sumbu Y
                            },
                            grid: {
                                display: false // Menghilangkan garis grid pada sumbu Y (horizontal)
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endisset
@endsection
@section('modal-delete')
    @if (session('warning'))
        <div id="warning-modal"
            class="w-screen h-full flex fixed top-0 right-0 left-0 bg-black/50 justify-center items-center z-30 duration-300">
            <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] sm:w-full max-w-md relative">
                <div class="text-center">
                    <svg class="mx-auto mb-4 w-12 h-12 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-[#344357]">Peringatan</h3>
                    <p class="text-[#344357] mt-2">{{ session('warning', 'Peringatan') }}</p>


                    <div class="flex justify-center mt-5">
                        <button type="button" id="btnCloseWarning"
                            class="px-5 py-2 bg-[#344357] text-white rounded-lg hover:bg-[#2c3849] cursor-pointer">
                            Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
