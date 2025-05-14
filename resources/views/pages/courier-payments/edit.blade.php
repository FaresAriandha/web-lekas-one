@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded-2xl p-6 flex flex-col mt-[20px] relative" id="container-table">
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
                class="hidden items-center self-end w-full max-w-xs p-4 mb-4 text-[#344357] bg-red-100 rounded-lg shadow-sm opacity-0 duration-300"
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
            <h2 class="text-xl font-semibold mb-10">Tanggal Pengiriman : {{ $shipment_date->translatedFormat('d F Y') }}
            </h2>
        </div>


        @if (count($courier_payments) > 0)
            @foreach ($courier_payments as $index => $courier_pay)
                <div class="relative overflow-x-scroll no-scrollbar shadow-md rounded-lg mb-[20px]">
                    <form class="w-full flex justify-between items-start flex-col sm:flex-col"
                        action="{{ route('admin.courier-payments.update', ['date' => $shipment_date->format('Y-m-d'), 'courier_ID' => $courier_pay->courier_ID]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="display_data" value="{{ $display_data }}">
                        <table class="w-full h-fit text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-[15px] capitalize bg-[#344357] text-white text-nowrap text-center">
                                <tr>
                                    <th scope="col" class="px-6 py-2">
                                        No.
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        Nama Kurir
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        {{ $display_data == 'pasjay' ? 'Total Lokasi' : 'Total AWB Pagi' }}
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        {{ $display_data == 'pasjay' ? 'Total Ritase' : 'Subtotal AWB Pagi' }}
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        {{ $display_data == 'pasjay' ? 'Total Roundtrip' : 'Total AWB Siang' }}
                                    </th>
                                    <th scope="col" class="px-6 py-2">
                                        {{ $display_data == 'pasjay' ? 'Lokasi Baseprice' : 'Subtotal AWB Siang' }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-[15px] h-fit text-black">
                                <div>
                                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 text-center">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-center outline-1 outline-[#344357]">
                                            {{ $index + 1 }}
                                        </th>
                                        <td class="px-6 py-4 outline-1 outline-[#344357]">
                                            {{ $courier_pay->courier_name }}
                                        </td>
                                        <td class="px-6 py-4 outline-1 outline-[#344357]">
                                            {{ $display_data == 'pasjay' ? $courier_pay->total_location : $courier_pay->awb_total_pagi }}
                                        </td>
                                        <td class="px-6 py-4 outline-1 outline-[#344357]">
                                            {{ $display_data == 'pasjay' ? $courier_pay->total_rit : 'Rp. ' . number_format($courier_pay->total_bill_client_pagi, 0, '.', ',') }}
                                        </td>
                                        <td class="px-6 py-4 outline-1 outline-[#344357]">
                                            {{ $display_data == 'pasjay' ? $courier_pay->total_roundtrip : $courier_pay->awb_total_siang }}
                                        </td>
                                        <td class="px-6 py-4 text-wrap w-[150px] outline-1 outline-[#344357]">
                                            {{ $display_data == 'pasjay' ? $courier_pay->location_baseprice : 'Rp. ' . number_format($courier_pay->total_bill_client_siang, 0, '.', ',') }}
                                        </td>
                                    </tr>

                                    <div>
                                        <tr class="text-[15px] capitalize bg-[#344357] text-white text-nowrap text-center">
                                            <th scope="col" class="px-6 py-2">
                                                Nama Rekening
                                            </th>
                                            <th scope="col" class="px-6 py-2" colspan="2">
                                                Total Tagihan
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Setoran
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Total Dibayarkan
                                            </th>
                                            <th scope="col" class="px-6 py-2">
                                                Aksi
                                            </th>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="px-6 py-4 outline-1 outline-[#344357]">
                                                {{ $courier_pay->courier_nama_rekening }}
                                            </td>
                                            <td class="px-6 py-4 outline-1 outline-[#344357]" colspan="2">
                                                Rp.
                                                {{ number_format($display_data == 'pasjay' ? $courier_pay->total_charge : $courier_pay->sum_total_bill_client, 0, '.', ',') }}
                                            </td>
                                            @php

                                                $total_charge =
                                                    $display_data == 'pasjay'
                                                        ? $courier_pay->total_charge
                                                        : $courier_pay->sum_total_bill_client;
                                                $setoran = $total_charge - $courier_pay->paid_to_courier;
                                            @endphp
                                            <td
                                                class="px-6 py-4 outline-1 outline-[#344357] {{ $setoran < 200000 ? 'text-red-400' : '' }}">
                                                Rp. {{ number_format($setoran, 0, '.', ',') }}
                                            </td>
                                            <td class="px-6 py-4 outline-1 outline-[#344357] w-[200px]">
                                                <input type="number" id="paid_to_courier"
                                                    aria-describedby="helper-text-explanation"
                                                    class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2"
                                                    placeholder="0" name="paid_to_courier"
                                                    value="{{ old('paid_to_courier', $courier_pay->paid_to_courier) }}">
                                            </td>
                                            <td
                                                class="flex justify-center items-center h-full outline-1 outline-[#344357]">
                                                <button type="submit"
                                                    class="self-center my-2 flex items-center justify-center space-x-2.5 w-fit px-4 bg-blue-400 py-2 rounded-lg text-white font-bold cursor-pointer hover:bg-blue-500 active:scale-95 duration-150"
                                                    name="btn-submit">
                                                    <span>
                                                        PERBARUI
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    </div>
                                </div>
                            </tbody>
                        </table>
                    </form>
                </div>
            @endforeach
        @endif

        <div class="w-full flex justify-between flex-col sm:flex-row mt-10">
            <a href={{ route('admin.courier-payments.index') }}
                class="self-center flex items-center justify-center space-x-2.5 w-full sm:w-36 bg-orange-400 py-3 rounded-lg text-white font-bold cursor-pointer hover:bg-orange-500 active:scale-95 duration-150"
                name="btn-submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-circle-arrow-left">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M16 12H8" />
                    <path d="m12 8-4 4 4 4" />
                </svg>
                <span>
                    KEMBALI
                </span>
            </a>
        </div>
    </div>
@endsection
