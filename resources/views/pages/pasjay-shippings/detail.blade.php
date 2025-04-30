@extends('layouts.app')
@section('content')
    <div class="bg-white shadow rounded-2xl p-6 flex flex-col mt-[20px]" id="container-table">

        <div class="w-full flex justify-between items-start mb-4 flex-col sm:flex-col">
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="courier_ID" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Kurir</label>
                    <div class="relative">
                        <input type="text" id="courier_ID" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $psj_location->courier->courier_name }}" disabled>
                    </div>
                </div>
                <div class="w-full">
                    <label for="rit"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Ritase</label>
                    <div class="relative">
                        <input type="text" id="rit" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $psj_location->rit }}" disabled>
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
                    <div class="relative">
                        <input type="text" id="shploc_ID" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $psj_location->location->shploc_name . ' (' . $psj_location->location->price->spl_name . ')' }}"
                            disabled>
                    </div>
                </div>
            </div>

            {{-- Baris 3 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 {{ $psj_location->roundtrip != null ? 'sm:space-x-[40px]' : '' }} sm:space-y-0 mt-8">
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white" for="image">Foto
                        Surat Jalan</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] focus:outline-none block w-full px-2 box-border text-base font-semibold"
                            aria-describedby="image_help" id="image_preview" type="text"
                            value="{{ basename($psj_location->image) }}" disabled>
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $psj_location->image) }}', '_blank')">
                            Lihat Foto
                        </button>
                    </div>
                </div>
                <div class="w-full box-border {{ $psj_location->roundtrip != null ? '' : 'hidden' }}">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white" for="roundtrip">Foto
                        Surat Jalan Roundtrip</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] focus:outline-none block w-full px-2 box-border text-base font-semibold"
                            aria-describedby="roundtrip_help" id="roundtrip_preview" type="text"
                            value="{{ basename($psj_location->roundtrip) }}" disabled>
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $psj_location->roundtrip) }}', '_blank')">
                            Lihat Foto
                        </button>
                    </div>
                </div>
            </div>

            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.pasjay-shippings.index') }}
                    class="self-center flex items-center justify-center space-x-2.5 w-full sm:w-36 bg-orange-400 py-3 rounded-lg text-white font-bold cursor-pointer hover:bg-orange-500 active:scale-95 duration-150"
                    name="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-arrow-left">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M16 12H8" />
                        <path d="m12 8-4 4 4 4" />
                    </svg>
                    <span>
                        KEMBALI
                    </span>
                </a>
            </div>

            </form>
        </div>
    @endsection
