@extends('layouts.app')
@section('content')
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
            action="{{ route('admin.pasjay-shippings.update', $psj_location->shpsj_ID) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="courier_ID" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Kurir</label>
                    <div class="relative">
                        <input type="text" id="courier_ID" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $psj_location->courier->courier_name }}" readonly>
                    </div>
                </div>
                <div class="w-full">
                    <label for="rit"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Ritase</label>
                    <div class="relative">
                        <input type="text" id="rit" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $psj_location->rit }}" name="rit" readonly>
                    </div>
                </div>

            </div>

            {{-- Baris 2 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="created_at"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tanggal
                        Pengiriman</label>
                    <div class="relative">
                        <input type="text" id="created_at" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $psj_location->created_at->format('d-m-Y') }}" disabled>
                    </div>
                </div>
                <div class="w-full">
                    <label for="shploc_ID"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Destinasi
                        Pengiriman</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <select
                            class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border"
                            name="shploc_ID">
                            <option value="" disabled selected>Pilih Destinasi</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->shploc_ID }}"
                                    {{ old('shploc_ID', $psj_location->shploc_ID) == $location->shploc_ID ? 'selected' : '' }}>
                                    {{ $location->shploc_name . ' - (' . $location->price->spl_name . ')' }}
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
                    @error('shploc_ID')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris 3 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white" for="image">Foto
                        Surat Jalan</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] text-sm  focus:outline-none block w-full px-2 box-border upload-pdf cursor-not-allowed"
                            aria-describedby="image_preview_help" id="image_preview" type="text" name="image_preview"
                            accept="image/jpg, image/jpeg, image/png" value="{{ basename($psj_location->image) }}" disabled>
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $psj_location->image) }}', '_blank')">
                            Lihat Foto
                        </button>
                    </div>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden mt-5">
                        <input
                            class="border-0  text-[#344357] text-sm  focus:outline-none block w-full px-2 box-border upload-pdf"
                            aria-describedby="image_help" id="image" type="file" name="image"
                            accept="image/jpg, image/jpeg, image/png">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer hidden active:scale-105"
                            id="showPDF">
                            Lihat Foto
                        </button>
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white"
                        for="roundtrip">Foto Surat Jalan Roundtrip</label>
                    <div
                        class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden {{ $psj_location->roundtrip == null ? 'hidden' : '' }}">
                        <input
                            class="border-0  text-[#344357] text-sm  focus:outline-none block w-full px-2 box-border upload-pdf cursor-not-allowed"
                            aria-describedby="roundtrip_preview_help" id="roundtrip_preview" type="text"
                            name="roundtrip_preview" accept="image/jpg, image/jpeg, image/png"
                            value="{{ basename($psj_location->roundtrip) }}" disabled>
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $psj_location->roundtrip) }}', '_blank')">
                            Lihat Foto
                        </button>
                    </div>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden mt-5">
                        <input
                            class="border-0  text-[#344357] text-sm  focus:outline-none block w-full px-2 box-border upload-pdf"
                            aria-describedby="roundtrip_help" id="roundtrip" type="file" name="roundtrip"
                            accept="image/jpg, image/jpeg, image/png">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer hidden active:scale-105"
                            id="showPDF">
                            Lihat Foto
                        </button>
                    </div>
                    @error('roundtrip')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.pasjay-shippings.index') }}
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
                    class="self-center mt-4 sm:mt-0 flex items-center justify-center space-x-2.5 w-full sm:w-36 bg-blue-400 py-3 rounded-lg text-white font-bold cursor-pointer hover:bg-blue-500 active:scale-95 duration-150"
                    name="btn-submit">
                    <span>
                        PERBARUI
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
