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
            action="{{ route('admin.couriers.store') }}" method="post" enctype="multipart/form-data">
            {{-- <h2 class="text-lg sm:text-xl font-semibold mb-10 self-center sm:self-start">Form Tambah Data</h2> --}}
            @csrf
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0">
                <div class="w-full">
                    <label for="courier_name"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Lengkap (Sesuai KTP)</label>
                    <div class="relative">
                        <input type="text" id="courier_name" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="John Doe" name="courier_name" autocomplete="off" data-char-count maxlength="100"
                            value="{{ old('courier_name') }}">
                        @error('courier_name')
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
                    <label for="courier_NIK" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">NIK
                        (Sesuai
                        KTP)</label>
                    <div class="relative">
                        <input type="number" id="courier_NIK" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="3214567896783456" name="courier_NIK" autocomplete="off" data-char-count
                            max="9999999999999999" value="{{ old('courier_NIK') }}">
                        @error('courier_NIK')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 16
                        </span>
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
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="Jakarta Selatan" name="courier_birthplace" autocomplete="off" data-char-count
                            maxlength="100" value="{{ old('courier_birthplace') }}">
                        @error('courier_birthplace')
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
                    <label for="courier_birthdate"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Tanggal Lahir
                        (Sesuai
                        KTP)</label>
                    <div class="relative">
                        <input id="courier_birthdate" datepicker datepicker-autohide type="text"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 ps-10"
                            placeholder="Pilih tanggal" name="courier_birthdate" value="{{ old('courier_birthdate', '') }}"
                            autocomplete="off">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 text-[#344357]">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                    </div>
                    @error('courier_birthdate')
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
                    <label for="courier_gender"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Jenis Kelamin (Sesuai
                        KTP)</label>
                    <div
                        class="dropdown-input relative w-full mb-[10px] sm:mb-0 sm:mr-[10px] ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <select
                            class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border"
                            name="courier_gender">
                            <option value="" disabled selected>Pilih Jenis</option>
                            <option value="male" {{ old('courier_gender') == 'male' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="female" {{ old('courier_gender') == 'female' ? 'selected' : '' }}>Perempuan
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
                    @error('courier_gender')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="w-full">
                    <label for="courier_address"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Alamat (Sesuai
                        KTP)</label>
                    <div class="relative">
                        <textarea type="text" id="courier_address" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 resize-y"
                            placeholder="Jl. Lorem Ipsum No. 255" name="courier_address" autocomplete="off" data-char-count maxlength="255">{{ old('courier_address') }}</textarea>
                        @error('courier_address')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 255
                        </span>
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
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="John Doe" name="courier_nama_rekening" autocomplete="off" data-char-count
                            maxlength="100" value="{{ old('courier_nama_rekening') }}">
                        @error('courier_nama_rekening')
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
                    <label for="courier_no_rekening"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nomor Rekening
                        (BCA)</label>
                    <div class="relative">
                        <input type="number" id="courier_no_rekening" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="3214567896" name="courier_no_rekening" autocomplete="off" data-char-count
                            max="9999999999" value="{{ old('courier_no_rekening') }}">
                        @error('courier_no_rekening')
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

            {{-- Baris 5 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full">
                    <label for="courier_telp"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">No.
                        Telp/HP</label>
                    <div class="relative">
                        <input type="number" id="courier_telp" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="08923892382" name="courier_telp" autocomplete="off" data-char-count
                            max="99999999999999" value="{{ old('courier_telp') }}">
                        @error('courier_telp')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 14
                        </span>
                    </div>
                </div>
                <div class="w-full">
                    <label for="courier_telp_darurat"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">No. Telp/HP
                        (Darurat)</label>
                    <div class="relative">
                        <input type="number" id="courier_telp_darurat" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="089729389238" name="courier_telp_darurat" autocomplete="off" data-char-count
                            max="99999999999999" value="{{ old('courier_telp_darurat') }}">
                        @error('courier_telp_darurat')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 14
                        </span>
                    </div>
                </div>
            </div>

            {{-- Baris 6 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white"
                        for="courier_img">Foto<br>(dengan ekstensi .jpg/.jpeg/.png)</label>
                    <img id="img-preview"
                        class="ring-1 ring-[#344357] w-[200px] h-[200px] bg-gray-200 my-5 rounded-lg object-cover">
                    <input
                        class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full px-2 box-border"
                        aria-describedby="courier_img_help" id="courier_img" type="file" name="courier_img"
                        accept="image/jpg, image/jpeg, image/png">
                    @error('courier_img')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white"
                        for="courier_docs">Dokumen Pribadi<br>(Scan KTP, SIM, Akta Lahir, Ijazah, dan SKCK dalam 1
                        PDF)</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] text-sm  focus:outline-none block w-full px-2 box-border upload-pdf"
                            aria-describedby="courier_docs_help" id="courier_docs" type="file" name="courier_docs"
                            accept="application/pdf">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full hidden cursor-pointer active:scale-105"
                            id="showPDF">
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
