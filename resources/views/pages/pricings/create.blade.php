@extends('layouts.app')
@section('content')
    <div class="bg-white shadow rounded-2xl p-6 flex flex-col" id="container-table">
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
            action="{{ route('admin.prices.store') }}" method="post">
            @csrf
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="spl_name" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Tarif</label>
                    <div class="relative">
                        <input type="text" id="spl_name" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="Jakarta Barat" name="spl_name" autocomplete="off" data-char-count maxlength="100"
                            value="{{ old('spl_name') }}">
                        @error('spl_name')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 100
                        </span>
                    </div>
                </div>
                <div class="w-full">
                    <label for="spl_type" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tipe
                        Tarif</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <select
                            class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border"
                            name="spl_type">
                            <option value="" disabled selected>Pilih Tipe</option>
                            <option value="pasjay" {{ old('spl_type') == 'pasjay' ? 'selected' : '' }}>
                                Pasar Jaya
                            </option>
                            <option value="paxel" {{ old('spl_type') == 'paxel' ? 'selected' : '' }}>
                                Paxel
                            </option>
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
                    @error('spl_type')
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
                    <label for="spl_baseprice"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tarif
                        Dasar</label>
                    <div class="relative">
                        <input type="number" id="spl_baseprice" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="100000" name="spl_baseprice" autocomplete="off" data-char-count maxlength="10"
                            value="{{ old('spl_baseprice') }}">
                        @error('spl_baseprice')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 10
                        </span>
                    </div>
                </div>
                <div class="w-full">
                    <label for="spl_baseprice_client"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tarif
                        Dasar (Klien)</label>
                    <div class="relative">
                        <input type="number" id="spl_baseprice_client" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="100000" name="spl_baseprice_client" autocomplete="off" data-char-count
                            maxlength="10" value="{{ old('spl_baseprice_client') }}">
                        @error('spl_baseprice_client')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 10
                        </span>
                    </div>
                </div>
            </div>


            {{-- Baris 3 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="spl_multidrop"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tarif
                        Multidrop</label>
                    <div class="relative">
                        <input type="number" id="spl_multidrop" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="100000" name="spl_multidrop" autocomplete="off" data-char-count maxlength="10"
                            value="{{ old('spl_multidrop') }}">
                        @error('spl_multidrop')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 10
                        </span>
                    </div>
                </div>
                <div class="w-full">
                    <label for="spl_multidrop_client"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tarif
                        Multidrop (Klien)</label>
                    <div class="relative">
                        <input type="number" id="spl_multidrop_client" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="100000" name="spl_multidrop_client" autocomplete="off" data-char-count
                            maxlength="10" value="{{ old('spl_multidrop_client') }}">
                        @error('spl_multidrop_client')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 10
                        </span>
                    </div>
                </div>
            </div>

            {{-- Baris 4 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="spl_roundtrip"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tarif
                        Roundtrip</label>
                    <div class="relative">
                        <input type="number" id="spl_roundtrip" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="100000" name="spl_roundtrip" autocomplete="off" data-char-count maxlength="10"
                            value="{{ old('spl_roundtrip') }}">
                        @error('spl_roundtrip')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 10
                        </span>
                    </div>
                </div>
                <div class="w-full">
                    <label for="spl_roundtrip_client"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tarif
                        Roundtrip (Klien)</label>
                    <div class="relative">
                        <input type="number" id="spl_roundtrip_client" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="100000" name="spl_roundtrip_client" autocomplete="off" data-char-count
                            maxlength="10" value="{{ old('spl_roundtrip_client') }}">
                        @error('spl_roundtrip_client')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 10
                        </span>
                    </div>
                </div>
            </div>

            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.prices.index') }}
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
