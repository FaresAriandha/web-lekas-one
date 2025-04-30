@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded-2xl p-6" id="container-table">
        <div class="w-full flex justify-between items-start mb-4 flex-col sm:flex-col">
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="courier_name" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Lengkap (Sesuai KTP)</label>
                    <div class="relative">
                        <input type="text" id="courier_name" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            placeholder="John Doe" name="courier_name" autocomplete="off" disabled
                            value="{{ $courier->courier_name }}">
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_NIK" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">NIK
                        (Sesuai
                        KTP)</label>
                    <div class="relative">
                        <input type="number" id="courier_NIK" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            placeholder="3214567896783456" name="courier_NIK" autocomplete="off" disabled
                            value="{{ $courier->courier_NIK }}">
                    </div>
                </div>
            </div>

            {{-- Baris 2 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="courier_birthplace"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tempat Lahir (Sesuai
                        KTP)</label>
                    <div class="relative">
                        <input type="text" id="courier_birthplace" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            placeholder="Jakarta Selatan" name="courier_birthplace" autocomplete="off" disabled
                            value="{{ $courier->courier_birthplace }}">
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_birthdate"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tanggal Lahir
                        (Sesuai
                        KTP)</label>
                    <div class="relative">
                        <input id="courier_birthdate" type="text"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 ps-10 cursor-not-allowed"
                            placeholder="Pilih tanggal" name="courier_birthdate" disabled
                            value="{{ $courier->courier_birthdate->format('d-m-Y') }}">
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
                    <label for="courier_gender"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Jenis Kelamin (Sesuai
                        KTP)</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <input type="text" id="courier_gender" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            name="courier_gender" disabled
                            value="{{ $courier->courier_gender == 'male' ? 'Laki-laki' : 'Perempuan' }}">
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_address"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Alamat (Sesuai
                        KTP)</label>
                    <div class="relative">
                        <textarea type="text" id="courier_address" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 resize-y cursor-not-allowed"
                            placeholder="Jl. Lorem Ipsum No. 255" name="courier_address" disabled>{{ $courier->courier_address }}</textarea>
                    </div>
                </div>
            </div>


            {{-- Baris 4 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="courier_nama_rekening"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama Rekening</label>
                    <div class="relative">
                        <input type="text" id="courier_nama_rekening" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            placeholder="John Doe" name="courier_nama_rekening" disabled
                            value="{{ $courier->courier_nama_rekening }}">
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_no_rekening"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nomor Rekening
                        (BCA)</label>
                    <div class="relative">
                        <input type="number" id="courier_no_rekening" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            placeholder="3214567896" name="courier_no_rekening" disabled
                            value="{{ $courier->courier_no_rekening }}">
                    </div>
                </div>
            </div>

            {{-- Baris 5 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="courier_telp"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">No.
                        Telp/HP</label>
                    <div class="relative">
                        <input type="number" id="courier_telp" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            placeholder="08923892382" name="courier_telp" disabled value="{{ $courier->courier_telp }}">
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_telp_darurat"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">No. Telp/HP
                        (Darurat)</label>
                    <div class="relative">
                        <input type="number" id="courier_telp_darurat" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-base font-semibold rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            placeholder="089729389238" name="courier_telp_darurat" disabled
                            value="{{ $courier->courier_telp_darurat }}">
                    </div>
                </div>
            </div>

            {{-- Baris 6 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white"
                        for="courier_img">Foto</label>
                    <img id="img-preview"
                        class="ring-1 ring-[#344357] w-[200px] h-[200px] bg-gray-200 my-5 rounded-lg object-cover "
                        src="{{ asset('storage/' . $courier->courier_img) }}">
                </div>
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white"
                        for="courier_docs">Dokumen Pribadi<br>(berisi scan KTP, SIM, Akta Lahir, Ijazah, dan SKCK dalam 1
                        PDF)</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] focus:outline-none block w-full px-2 box-border text-base font-semibold cursor-not-allowed"
                            aria-describedby="courier_docs_help" id="courier_docs" type="text" name="courier_docs"
                            accept="application/pdf" value="{{ basename($courier->courier_docs) }}">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $courier->courier_docs) }}', '_blank')">
                            Lihat PDF
                        </button>
                    </div>
                    @error('courier_docs')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.couriers.index') }}
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
    </div>
@endsection
