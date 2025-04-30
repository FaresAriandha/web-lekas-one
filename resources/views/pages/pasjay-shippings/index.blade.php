@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded-2xl p-6 relative" id="container-table">
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
            <h2 class="text-xl font-semibold mb-10">Daftar Riwayat Pengiriman Pasar Jaya</h2>
            <div class="flex flex-col sm:flex-row items-start flex-wrap justify-between w-full ">
                <form class="flex flex-col sm:flex-row items-start sm:items-center flex-wrap" method="get"
                    action="{{ route('admin.pasjay-shippings.index') }}">
                    {{-- Dropdown Status --}}
                    <div
                        class="dropdown-input relative w-48 mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <select
                            class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border cursor-pointer"
                            name="shipment_location">
                            <option value="" selected>Pilih Kota</option>
                            @foreach ($prices as $price)
                                <option value="{{ $price->spl_name }}"
                                    {{ isset($shipment_location) && $shipment_location == $price->spl_name ? 'selected' : '' }}>
                                    {{ $price->spl_name }}
                                </option>
                            @endforeach
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

                    <input type="number" placeholder="Ritase"
                        class="block w-32 border-0 ring-1 ring-black rounded-lg px-4 py-2 focus:ring-2 focus:outline-none focus:ring-[#344357] mb-[10px] sm:mb-0 sm:mr-[10px]"
                        name="shipment_ritase" value="{{ isset($shipment_ritase) ? $shipment_ritase : '' }}"
                        autocomplete="off" min="0">


                    {{-- Date Picker --}}
                    <div class="relative max-w-sm mb-[10px] sm:mb-0 sm:mr-[10px]">
                        <input id="datepicker-autohide" datepicker datepicker-autohide datepicker-format="yyyy-mm-dd"
                            type="text"
                            class="border-0 ring-1 ring-black rounded-lg px-4 py-2 focus:ring-2 focus:outline-none focus:[#344357] block w-48 ps-10 p-2.5 peer"
                            placeholder="Pilih tanggal" name="shipment_date" autocomplete="off"
                            value="{{ isset($shipment_date) ? $shipment_date : '' }}">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 text-black peer-focus:text-[#344357]">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                    </div>


                    <input type="text" placeholder="Search..."
                        class="block border-0 ring-1 ring-black rounded-lg px-4 py-2 focus:ring-2 focus:outline-none focus:ring-[#344357] mb-[10px] sm:mb-0 sm:mr-[10px]"
                        name="keyword" value="{{ isset($keyword) ? $keyword : '' }}" autocomplete="off">


                    <button
                        class="flex items-center sm:mt-0 bg-[#344357] px-3 py-2 rounded-md text-white font-semibold shadow-md cursor-pointer  active:translate-y-[3px]">
                        <svg class="w-[20px] h-[20px] text-white mr-[5px]" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-search">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        Cari
                    </button>
                </form>
                <a href="{{ route('admin.pasjay-shippings.create') }}"
                    class="flex items-center mt-5 sm:mt-0 bg-[#344357] px-3 py-2 rounded-md text-white font-semibold shadow-md cursor-pointer  active:translate-y-[3px] self-end">
                    Tambah
                    <svg class="w-[20px] h-[20px] text-white ml-[5px]" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                </a>
            </div>
        </div>



        <div class="relative overflow-x-scroll no-scrollbar shadow-md rounded-lg">
            <table class="w-full h-fit text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-[16px] capitalize bg-[#344357] text-white text-nowrap">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Destinasi Pengiriman
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Ritase
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Roundtrip
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Nama Kurir
                        </th>
                        <th scope="col" class="px-6 py-3  text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="text-[15px] h-fit text-black">
                    @if (count($pasjay_locations) > 0)
                        @foreach ($pasjay_locations as $index => $psj_loc)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-100">
                                <th scope="row" class="px-6 py-4 font-medium text-center">
                                    {{ $pasjay_locations->firstItem() + $index }}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ $psj_loc->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold">{{ $psj_loc->location->shploc_name }}</span> <br>
                                    ({{ $psj_loc->location->price->spl_name }})
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $psj_loc->rit }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($psj_loc->roundtrip != null)
                                        <span class="p-2 rounded-lg bg-green-700 text-white font-semibold">
                                            Ya
                                        </span>
                                    @else
                                        <span class="p-2 rounded-lg bg-red-500 text-white font-semibold">
                                            Tidak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $psj_loc->courier->courier_name }}
                                </td>
                                <td class="px-6 py-4 relative text-center">
                                    <button
                                        class="menu-btn text-white  cursor-pointer font-semibold bg-[#344357] px-3 p-2 rounded-md">
                                        &#x22EE;
                                    </button>
                                    <div
                                        class="menu-popup fixed right-[110px] sm:right-32 hidden mt-2 w-32 bg-white shadow-lg rounded-md z-50 p-2 text-nowrap">
                                        <a href="{{ route('admin.pasjay-shippings.show', $psj_loc->shpsj_ID) }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Lihat
                                            Detail</a>
                                        <a href="{{ route('admin.pasjay-shippings.edit', $psj_loc->shpsj_ID) }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Edit
                                            Data</a>
                                        <button type="button"
                                            data-url="/admin/pasjay-shippings/{{ $psj_loc->shpsj_ID }}"
                                            class="{{ Auth::user()->user_role !== 'kurir' ? '' : 'hidden' }} btn-hapus block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md cursor-pointer">Hapus
                                            Data</button>
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
        @if (count($pasjay_locations) > 0)
            <div class="justify-between items-center mt-6 flex">
                <div>
                    <h1 class="text-xs sm:text-base w-[120px] sm:w-full">
                        Showing {{ $pasjay_locations->firstItem() }} to {{ $pasjay_locations->lastItem() }} of
                        {{ $pasjay_locations->total() }}
                        entries
                    </h1>
                </div>
                <div class="space-x-2">
                    @if ($pasjay_locations->currentPage() > 1)
                        <a href="{{ $pasjay_locations->previousPageUrl() }}"
                            class="px-4 py-2 ring-1 ring-black rounded-lg hover:bg-gray-100 cursor-pointer">
                            &larr; <span class="hidden sm:inline-block">Previous</span>
                        </a>
                    @endif

                    @if ($pasjay_locations->hasMorePages())
                        <a href="{{ $pasjay_locations->nextPageUrl() }}"
                            class="px-4 py-2 ring-1 ring-black rounded-lg hover:bg-gray-100 cursor-pointer">
                            <span class="hidden sm:inline-block">Next</span> &rarr;
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection


@section('modal-delete')
    {{-- Modal Delete Button --}}
    <div id="delete-modal"
        class="w-screen h-full hidden fixed top-0 right-0 left-0 bg-black/50 justify-center items-center z-30 duration-300">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] sm:w-full max-w-md relative">
            <div class="text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-[#344357]" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="text-lg font-semibold text-[#344357]">Konfirmasi Hapus</h3>
                <p class="text-[#344357] mt-2">Apakah Anda yakin ingin menghapus data ini?</p>

                <!-- Form untuk submit DELETE request -->
                <form id="delete-form" method="POST" class="mt-5">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-4">
                        <button type="submit"
                            class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 cursor-pointer">
                            Ya, Hapus
                        </button>
                        <button type="button" id="btnCloseModal"
                            class="px-5 py-2 bg-[#344357] text-white rounded-lg hover:bg-[#2c3849] cursor-pointer">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
