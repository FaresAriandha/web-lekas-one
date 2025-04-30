@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded-2xl p-6" id="container-table">
        <div class="w-full flex justify-between items-start mb-4 flex-col sm:flex-col">
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="fleet_nopol" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nopol
                        Armada</label>
                    <div class="relative">
                        <input type="text" id="fleet_nopol" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            placeholder="B 9772 UXX" name="fleet_nopol" autocomplete="off" disabled
                            value="{{ $fleet->fleet_nopol }}">
                    </div>
                </div>
                <div class="w-full">
                    <label for="fleet_type" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tipe
                        Armada</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <input type="text" id="fleet_type" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            placeholder="B 9772 UXX" name="fleet_type" autocomplete="off" disabled
                            value="{{ $fleet->fleet_type }}">
                    </div>
                </div>
            </div>

            {{-- Baris 2 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="fleet_merk"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Merek Armada</label>
                    <div class="relative">
                        <input type="text" id="fleet_merk" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            placeholder="Daihatsu Gran Max" name="fleet_merk" disabled value="{{ $fleet->fleet_merk }}">
                    </div>
                </div>
                <div class="w-full">
                    <label for="fleet_KIR_date"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tanggal Uji KIR
                        Terakhir</label>
                    <div class="relative">
                        <input id="fleet_KIR_date" type="text"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 ps-10 cursor-not-allowed"
                            placeholder="Pilih tanggal" name="fleet_KIR_date" disabled
                            value="{{ $fleet->fleet_KIR_date->format('d-m-Y') }}">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 text-[#344357]">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Baris 3 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="fleet_status"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Status Armada</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <input type="text" id="fleet_status" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            placeholder="B 9772 UXX" name="fleet_status" autocomplete="off" disabled
                            value="{{ $fleet->fleet_status }}">
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_ID" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Kurir</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <input type="text" id="courier_ID" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            placeholder="B 9772 UXX" name="courier_ID" autocomplete="off" disabled
                            value="{{ $fleet->courier_ID == null ? '-' : $fleet->courier->courier_name }}">
                    </div>
                </div>
            </div>


            {{-- Baris 4 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white" for="fleet_img">Foto
                        Armada<br>(Scan foto depan, belakang, kanan, kiri dan bersama kurir dalam 1
                        PDF)</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] focus:outline-none block w-full px-2 box-border text-base font-semibold cursor-not-allowed"
                            aria-describedby="fleet_img_help" id="fleet_img" type="text" name="fleet_img"
                            accept="application/pdf" value="{{ basename($fleet->fleet_img) }}">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $fleet->fleet_img) }}', '_blank')">
                            Lihat PDF
                        </button>
                    </div>
                </div>
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white"
                        for="fleet_docs">Dokumen Armada<br>(Scan foto STNK dan KIR dalam 1
                        PDF)</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] focus:outline-none block w-full px-2 box-border text-base font-semibold cursor-not-allowed"
                            aria-describedby="fleet_docs_help" id="fleet_docs" type="text" name="fleet_docs"
                            accept="application/pdf" value="{{ basename($fleet->fleet_docs) }}">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $fleet->fleet_docs) }}', '_blank')">
                            Lihat PDF
                        </button>
                    </div>
                </div>
            </div>


            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.fleets.index') }}
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

            </form>
        </div>
    @endsection
