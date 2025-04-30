@extends('layouts.app')

@section('content')
    <ul class="text-sm font-medium text-center overflow-hidden rounded-lg shadow-md flex ">
        <li class="w-full focus-within:z-10">
            <a href="{{ route('admin.client-bills.index', ['display_data' => 'paxel']) }}"
                class="inline-block w-full p-4 {{ $display_data == 'paxel' ? 'text-white bg-[#344357]' : 'text-[#344357]' }} focus:outline-none"
                aria-current="page">Proyek Paxel</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a href="{{ route('admin.client-bills.index', ['display_data' => 'pasjay']) }}"
                class="inline-block w-full p-4 {{ $display_data == 'pasjay' ? 'text-white bg-[#344357]' : 'text-[#344357]' }} focus:outline-none"
                aria-current="page">Proyek Pasar Jaya</a>
        </li>
    </ul>

    <div class="bg-white shadow rounded-2xl p-6 mt-[20px] relative" id="container-table">
        @if (session('success'))
            <div id="toast-success"
                class="hidden items-center sm:absolute sm:top-[10px] sm:right-[10px] w-full max-w-xs p-4 mb-4 text-[#344357] bg-green-100 rounded-lg shadow-sm opacity-0 duration-300"
                role="alert">
                <div class="inline-flex items-center justify-center w-8 h-8 text-green-500 bg-green-200 rounded-lg">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                </div>
                <div class="ms-3 text-sm font-semibold">{{ session('success', 'Berhasil') }}</div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-[#344357] text-white rounded-lg p-1.5  inline-flex items-center justify-center h-8 w-8 cursor-pointer"
                    data-dismiss-target="#toast-success" aria-label="Close">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="toast-danger"
                class="hidden items-center sm:absolute sm:top-[10px] sm:right-[10px] w-full max-w-xs p-4 mb-4 text-[#344357] bg-red-100 rounded-lg shadow-sm opacity-0 duration-300"
                role="alert">
                <div class="inline-flex items-center justify-center w-8 h-8 text-red-500 bg-red-200 rounded-lg">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                    </svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ms-3 text-sm font-semibold">{{ session('error', 'Gagal') }}</div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-[#344357] text-white rounded-lg p-1.5  inline-flex items-center justify-center h-8 w-8 cursor-pointer"
                    data-dismiss-target="#toast-danger" aria-label="Close">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif


        <div class="flex justify-between items-start sm:items-start mb-4 flex-col sm:flex-col">
            <h2 class="text-xl font-semibold mb-10">Daftar Riwayat Tagihan Klien</h2>
            <div class="flex flex-col sm:flex-row items-start flex-wrap justify-between w-full ">
                <form class="flex flex-col sm:flex-row items-start sm:items-center flex-wrap" method="get"
                    action="{{ route('admin.client-bills.index') }}">
                    <input type="hidden" name="display_data" value="{{ $display_data }}">
                    {{-- Date Picker --}}
                    <div class="relative max-w-sm mb-[10px] sm:mb-0 sm:mr-[10px]">
                        <input id="datepicker-autohide" datepicker datepicker-autohide datepicker-format="yyyy-mm-dd"
                            type="text"
                            class="border-0 ring-1 ring-black rounded-lg px-4 py-2 focus:ring-2 focus:outline-none focus:[#344357] block w-48 ps-10 p-2.5 peer"
                            placeholder="Pilih tanggal" name="bills_date" autocomplete="off"
                            value="{{ isset($bills_date) ? $bills_date : '' }}">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 text-black peer-focus:text-[#344357]">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
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
                        Cari
                    </button>
                </form>
            </div>
        </div>



        <div class="relative overflow-x-scroll no-scrollbar shadow-md rounded-lg">
            <table class="w-full h-fit text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-[16px] capitalize bg-[#344357] text-white text-nowrap text-center">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Tagihan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Dibayarkan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Selisih Penagihan
                        </th>
                        <th scope="col" class="px-6 py-3  text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="text-[15px] h-fit text-black text-center">
                    @if (count($client_bills) > 0)
                        @foreach ($client_bills as $index => $client_bill)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-100">
                                <th scope="row" class="px-6 py-4 font-medium ">
                                    {{ $client_bills->firstItem() + $index }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $client_bill->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 w-[200px]">
                                    Rp. {{ number_format($client_bill->total_bill_client, 0, '.', ',') }}
                                </td>
                                <td class="px-6 py-4">
                                    Rp. {{ number_format($client_bill->total_paid_client, 0, '.', ',') }}
                                </td>
                                <td
                                    class="px-6 py-4 {{ $client_bill->total_paid_client - $client_bill->total_bill_client < 0 ? 'text-red-400' : '' }}">
                                    Rp.
                                    {{ number_format($client_bill->total_paid_client - $client_bill->total_bill_client, 0, '.', ',') }}
                                </td>
                                <td class="px-6 py-4 relative text-center">
                                    <button
                                        class="menu-btn text-white  cursor-pointer font-semibold bg-[#344357] px-3 p-2 rounded-md">
                                        &#x22EE;
                                    </button>
                                    <div
                                        class="menu-popup fixed right-[110px] sm:right-32 hidden mt-2 w-32 bg-white shadow-lg rounded-md z-50 p-2 text-nowrap">
                                        <a href="{{ route('admin.client-bills.edit', $client_bill->cb_ID) }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Edit
                                            Data</a>
                                    </div>
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
        @if (count($client_bills) > 0)
            <div class="justify-between items-center mt-6 flex">
                <div>
                    <h1 class="text-xs sm:text-base">
                        Showing {{ $client_bills->firstItem() }} to {{ $client_bills->lastItem() }} of
                        {{ $client_bills->total() }}
                        entries
                    </h1>
                </div>
                <div class="space-x-1">
                    @if ($client_bills->currentPage() > 1)
                        <a href="{{ $client_bills->previousPageUrl() }}"
                            class="px-4 py-2 ring-1 ring-black rounded-lg hover:bg-gray-100 cursor-pointer">
                            &larr; <span class="hidden sm:inline-block">Previous</span>
                        </a>
                    @endif

                    @if ($client_bills->hasMorePages())
                        <a href="{{ $client_bills->nextPageUrl() }}"
                            class="px-4 py-2 ring-1 ring-black rounded-lg hover:bg-gray-100 cursor-pointer">
                            <span class="hidden sm:inline-block">Next</span> &rarr;
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
