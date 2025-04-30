@extends('layouts.app')
@section('content')
    <div class="bg-white shadow rounded-2xl p-6 flex flex-col" id="container-table">

        <div class="w-full flex justify-between items-start mb-4 flex-col sm:flex-col">
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="courier_ID" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Kurir</label>
                    <input type="text" id="courier_ID" aria-describedby="helper-text-explanation"
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                        placeholder="Jakmart Rusun Pesakih" name="courier_ID" value="{{ $assignee->courier->courier_name }}"
                        disabled>
                </div>
                <div class="w-full">
                    <label for="fleet_nopol"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nopol Armada</label>
                    <input type="text" id="fleet_nopol" aria-describedby="helper-text-explanation"
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                        placeholder="Jakmart Rusun Pesakih" name="fleet_nopol"
                        value="{{ $assignee->courier->fleet->fleet_nopol }}" disabled>
                </div>

            </div>

            {{-- Baris 2 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start sm:space-x-[40px] space-y-8 sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="cas_type" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tipe
                        Penugasan</label>
                    <input type="text" id="cas_type" aria-describedby="helper-text-explanation"
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                        name="courier_ID" value="{{ $assignee->cas_type == 'pasjay' ? 'Pasar Jaya' : 'Paxel' }}" disabled>
                </div>
                <div class="w-full">
                    <label for="cas_status"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Status Penugasan</label>
                    <input type="text" id="cas_status" aria-describedby="helper-text-explanation"
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                        name="cas_status" value="{{ $assignee->cas_status }}" disabled>
                </div>
            </div>


            {{-- Baris 3 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="cas_pickup_time"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Jadwal Muat</label>
                    <input type="text" id="cas_pickup_time" aria-describedby="helper-text-explanation"
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                        name="cas_pickup_time" value="{{ $assignee->cas_pickup_time->format('d M Y, H:i') }} WIB" disabled>
                </div>
                <div class="w-full">
                    <label for="cas_arrived_time"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Waktu Tiba</label>
                    <input type="text" id="cas_arrived_time" aria-describedby="helper-text-explanation"
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                        name="cas_arrived_time"
                        value="{{ $assignee->cas_arrived_time ? $assignee->cas_arrived_time->format('d M Y, H:i') . ' WIB' : '-' }}"
                        disabled>

                    @if ($assignee->cas_arrived_time > $assignee->cas_pickup_time && $assignee->cas_arrived_time != null)
                        <p class="mt-2 text-sm text-red-600">
                            Terlambat
                            {{ $assignee->cas_pickup_time->diff($assignee->cas_arrived_time)->format('%h jam %i menit') }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Baris 4 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="cas_start_time"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Waktu Mulai
                        Tugas</label>
                    <input type="text" id="cas_start_time" aria-describedby="helper-text-explanation"
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                        name="cas_start_time"
                        value="{{ $assignee->cas_start_time ? $assignee->cas_start_time->format('d M Y, H:i') . ' WIB' : '-' }}"
                        disabled>

                    @if ($assignee->cas_start_time > $assignee->cas_arrived_time && $assignee->cas_start_time != null)
                        <p class="mt-2 text-sm text-red-600">
                            Lebih
                            {{ $assignee->cas_start_time->diff($assignee->cas_arrived_time)->format('%h jam %i menit %s detik') }}
                            dari waktu tiba
                        </p>
                    @endif
                </div>
                <div class="w-full">
                    <label for="cas_finish_time"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Waktu Selesai
                        Tugas</label>
                    <input type="text" id="cas_finish_time" aria-describedby="helper-text-explanation"
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 font-semibold cursor-not-allowed"
                        name="cas_finish_time"
                        value="{{ $assignee->cas_finish_time ? $assignee->cas_finish_time->format('d M Y, H:i') . ' WIB' : '-' }}"
                        disabled>

                    @if ($assignee->cas_finish_time != null)
                        <p class="mt-2 text-sm text-black">
                            Selesai dalam waktu
                            {{ $assignee->cas_start_time->diff($assignee->cas_finish_time)->format('%h jam %i menit %s detik') }}
                        </p>
                    @endif

                </div>
            </div>


            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.assignees.index') }}
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
    @endsection
