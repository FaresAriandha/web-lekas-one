@extends('layouts.app')
@section('content')
    {{-- Tab Element --}}
    <ul class="text-sm font-medium text-center overflow-hidden rounded-lg shadow-md flex ">
        <li class="w-full focus-within:z-10">
            <a href="{{ route('admin.paxel-shippings.create', ['mode_insert' => 'single']) }}"
                class="inline-block w-full p-4 {{ $mode_insert == 'single' ? 'text-white bg-[#344357]' : 'text-[#344357]' }} focus:outline-none"
                aria-current="page">Single Insert</a>
        </li>
        <li class="w-full focus-within:z-10">
            <a href="{{ route('admin.paxel-shippings.create', ['mode_insert' => 'multiple']) }}"
                class="inline-block w-full p-4 {{ $mode_insert == 'multiple' ? 'text-white bg-[#344357]' : 'text-[#344357]' }} focus:outline-none"
                aria-current="page">Multiple Insert</a>
        </li>
    </ul>

    <div class="bg-white shadow rounded-2xl p-6 flex flex-col mt-[20px]" id="container-table">
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

        <form class="w-full flex justify-between items-start mb-4 flex-col sm:flex-col"
            action="{{ route('admin.paxel-shippings.store', ['mode_insert' => $mode_insert]) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full box-border {{ $mode_insert == 'single' ? 'hidden' : '' }}">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white" for="awb_excel">File
                        AWB (excel/csv)</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] text-sm  focus:outline-none block w-full px-2 box-border upload-excel"
                            aria-describedby="awb_excel_help" id="awb_excel" type="file" name="awb_excel"
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full hidden cursor-pointer active:scale-105"
                            id="downloadExcel">
                            Download
                        </button>
                    </div>
                    @error('awb_excel')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="w-full {{ $mode_insert == 'multiple' ? 'hidden' : '' }}">
                    <label for="awb_number"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nomor AWB</label>
                    <div class="relative">
                        <input type="text" id="awb_number" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="EM.87UTMWUR7G-20250325-1-S4WUBV" name="awb_number" autocomplete="off"
                            data-char-count maxlength="255" value="{{ old('awb_number') }}">
                        @error('awb_number')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 255
                        </span>
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_ID" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Kurir</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <select
                            class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border"
                            name="courier_ID">
                            <option value="" selected disabled>Pilih Kurir</option>
                            </option>
                            @foreach ($couriers as $courier)
                                <option value="{{ $courier->courier_ID }}"
                                    {{ old('courier_ID') == $courier->courier_ID ? 'selected' : '' }}>
                                    {{ $courier->courier_name }}
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
                    @error('courier_ID')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris 2 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="awb_slot" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Slot
                        Pengiriman</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <select
                            class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border"
                            name="awb_slot">
                            <option value="" disabled selected>Pilih Slot</option>
                            <option value="Pagi" {{ old('awb_slot') == 'Pagi' ? 'selected' : '' }}>
                                Pagi
                            </option>
                            <option value="Siang" {{ old('awb_slot') == 'Siang' ? 'selected' : '' }}>
                                Siang
                            </option>
                        </select>

                        <!-- Custom Chevron Icon -->
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[#344357] transition-transform duration-200 bg-white">
                            <svg class="w-5 h-5 transition-transform duration-200" id="icon-dropdown" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('awb_slot')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="w-full">
                    <label for="awb_hub" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Hub
                        Pengiriman</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <select
                            class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border"
                            name="awb_hub">
                            <option value="" disabled selected>Pilih Hub</option>
                            <option value="HALIM" {{ old('awb_hub') == 'HALIM' ? 'selected' : '' }}>
                                Halim
                            </option>
                            <option value="MANGGA DUA" {{ old('awb_hub') == 'MANGGA DUA' ? 'selected' : '' }}>
                                Mangga Dua
                            </option>
                        </select>

                        <!-- Custom Chevron Icon -->
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[#344357] transition-transform duration-200 bg-white">
                            <svg class="w-5 h-5 transition-transform duration-200" id="icon-dropdown" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('awb_hub')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris 3 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="created_at"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tanggal
                        Pengiriman</label>
                    <div class="relative">
                        <input id="created_at" datepicker datepicker-autohide datepicker-format="yyyy-mm-dd"
                            type="text"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 ps-10"
                            placeholder="Pilih tanggal" name="created_at" value="{{ old('created_at', '') }}"
                            autocomplete="off">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 text-[#344357]">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                    </div>
                    @error('created_at')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.paxel-shippings.index') }}
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
                <button type="submit"
                    class="self-center mt-4 sm:mt-0 flex items-center justify-center space-x-2.5 w-full sm:w-36 bg-green-600 py-3 rounded-lg text-white font-bold cursor-pointer hover:bg-green-700 active:scale-95 duration-150"
                    name="btn-submit">
                    <span>
                        SIMPAN
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-save">
                        <path
                            d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                    </svg>
                </button>
            </div>

        </form>
    </div>
@endsection
