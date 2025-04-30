@extends('layouts.app')
@section('content')
    <div class="bg-white shadow rounded-2xl p-6 flex flex-col" id="container-table">

        <div class="w-full flex justify-between items-start mb-4 flex-col sm:flex-col">
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="awb_number" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nomor
                        AWB</label>
                    <div class="relative">
                        <input type="text" id="awb_number" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $awb_paxel->awb_number }}" disabled>
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_ID" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Kurir</label>
                    <div class="relative">
                        <input type="text" id="courier_ID" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $awb_paxel->courier->courier_name }}" disabled>
                    </div>
                </div>
            </div>

            {{-- Baris 2 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="awb_slot" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Slot
                        Pengiriman</label>
                    <div class="relative">
                        <input type="text" id="awb_slot" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $awb_paxel->awb_slot }}" disabled>
                    </div>
                </div>
                <div class="w-full">
                    <label for="awb_hub" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Hub
                        Pengiriman</label>
                    <div class="relative">
                        <input type="text" id="awb_hub" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $awb_paxel->awb_hub == 'HALIM' ? 'Halim' : 'Mangga Dua' }}" disabled>
                    </div>
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
                        <input type="text" id="created_at" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $awb_paxel->created_at->format('d-m-Y') }}" disabled>
                    </div>
                </div>
                <div class="w-full">
                    <label for="awb_status"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Status
                        AWB</label>
                    <div class="relative">
                        <input type="text" id="awb_status" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                            value="{{ $awb_paxel->awb_status }}" disabled>
                    </div>
                </div>
            </div>

            {{-- Baris 4 --}}
            <div
                class="w-full {{ $awb_paxel->awb_pod != null ? '' : 'hidden' }} flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full sm:w-1/2 box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white" for="awb_pod">POD
                        AWB</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] focus:outline-none block w-full px-2 box-border text-base font-semibold"
                            aria-describedby="awb_pod_help" id="awb_pod_preview" type="text" name="awb_pod_preview"
                            accept="application/pdf" value="{{ basename($awb_paxel->awb_pod) }}" disabled>
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $awb_paxel->awb_pod) }}', '_blank')">
                            Lihat Foto
                        </button>
                    </div>
                </div>
            </div>


            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.paxel-shippings.index') }}
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
