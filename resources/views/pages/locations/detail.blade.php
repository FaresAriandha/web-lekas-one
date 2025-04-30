@extends('layouts.app')
@section('content')
    <div class="bg-white shadow rounded-2xl p-6" id="container-table">
        <div class="w-full flex justify-between items-start mb-4 flex-col sm:flex-col">
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="shploc_name" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Gerai</label>
                    <div class="relative">
                        <input type="text" id="shploc_name" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            placeholder="Jakmart Rusun Pesakih" name="shploc_name" value="{{ $location->shploc_name }}"
                            disabled>
                    </div>
                </div>
                <div class="w-full">
                    <label for="shploc_address"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Alamat Lengkap
                        Gerai</label>
                    <div class="relative">
                        <textarea type="text" id="shploc_address" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 resize-y font-semibold cursor-not-allowed"
                            placeholder="Jl. Lorem Ipsum No. 255" name="shploc_address" disabled>{{ $location->shploc_address }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Baris 2 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="spl_name" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Kota
                        Lokasi
                        Gerai</label>
                    <div class="relative">
                        <input type="text" id="spl_name" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            placeholder="Jakmart Rusun Pesakih" name="spl_name" value="{{ $location->price->spl_name }}"
                            disabled>
                    </div>
                </div>
                <div class="w-full">
                    <label for="shploc_url_maps"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">URL Google Maps</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] focus:outline-none block w-full px-2 box-border text-base font-semibold cursor-not-allowed"
                            aria-describedby="shploc_url_maps_help" id="shploc_url_maps" type="text"
                            name="shploc_url_maps" value="{{ $location->shploc_url_maps }}">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ $location->shploc_url_maps }}', '_blank')">
                            Buka GMaps
                        </button>
                    </div>
                </div>
            </div>



            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.locations.index') }}
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

        </div>
    </div>
@endsection
