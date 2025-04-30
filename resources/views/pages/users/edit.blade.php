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
            action="{{ route('admin.users.update', $user->user_ID) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Baris 1 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 {{ $user->user_role == 'kurir' ? 'hidden' : '' }}">
                <div class="w-full ">
                    <label for="user_name" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Pengguna</label>
                    <div class="relative">
                        <input type="text" id="user_name" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="John Doe" name="user_name" autocomplete="off" data-char-count maxlength="100"
                            value="{{ old('user_name', $user->user_name) }}">
                        @error('user_name')
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
                    <label for="user_role" class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Peran
                        Pengguna</label>
                    <div
                        class="dropdown-input relative w-full ring-1 ring-black overflow-hidden rounded-lg focus-within:ring-2 focus-within:ring-[#344357]">
                        <select
                            class="appearance-none w-full bg-white border-0 px-4 py-2 focus:ring-2 outline-none focus:ring-[#344357] overflow-hidden text-ellipsis pr-8 box-border"
                            name="user_role">
                            <option value="" selected disabled>Pilih Peran</option>
                            </option>
                            <option value="admin" {{ old('user_role', $user->user_role) == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="korlap" {{ old('user_role', $user->user_role) == 'korlap' ? 'selected' : '' }}>
                                Korlap
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
                    @error('user_role')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 {{ $user->user_role == 'kurir' ? '' : 'hidden' }}">
                <div class="w-full ">
                    <label for="user_name_courier"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Nama
                        Pengguna</label>
                    <div class="relative">
                        <input type="text" id="user_name_courier" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5 cursor-not-allowed"
                            placeholder="John Doe" name="user_name_courier" autocomplete="off" data-char-count
                            maxlength="100" value="{{ $user->user_role == 'kurir' ? $user->courier->courier_name : '' }}"
                            disabled>
                    </div>
                </div>
                <div class="w-full">
                    <label for="username_courier"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Username</label>
                    <div class="relative">
                        <input type="text" id="username_courier" aria-describedby="helper-text-explanation"
                            class="{{ $user->user_role == 'kurir' ? '' : 'hidden' }} border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="Johndoe321" name="username_courier" autocomplete="off" data-char-count
                            maxlength="100" value="{{ old('username_courier', $user->username) }}">
                        @error('username_courier')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 100
                        </span>
                    </div>
                </div>
            </div>

            {{-- Baris 2 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-x-[40px] sm:space-y-0 mt-8">

                <div class="w-full {{ $user->user_role == 'kurir' ? 'hidden' : '' }}">
                    <label for="username"
                        class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white">Username</label>
                    <div class="relative">
                        <input type="text" id="username" aria-describedby="helper-text-explanation"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="Johndoe321" name="username" autocomplete="off" data-char-count maxlength="100"
                            value="{{ old('username', $user->username) }}">
                        @error('username')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 100
                        </span>
                    </div>
                </div>


                <div class="{{ $user->user_role == 'kurir' ? 'w-[48.5%]' : 'w-full' }}">
                    <label for="password" class="block mb-2 w-fit text-sm font-medium text-[#344357] ">Kata Sandi Baru
                        Pengguna</label>
                    <div class="relative">
                        <!-- Input Password -->
                        <input type="password" id="password"
                            class="border-0 ring-1 ring-[#344357] text-[#344357] text-sm rounded-lg focus:ring-2 focus:outline-none block w-full p-2.5"
                            placeholder="Masukkan kata sandi" autocomplete="off" name="password" data-char-count
                            maxlength="100">

                        <!-- Icon Mata (Kanan) -->
                        <button type="button"
                            class="absolute inset-y-0 right-3 flex items-center cursor-pointer btn-password">
                            <svg class="w-[21px] h-[21px] text-[#344357] hidden" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24" id="eyeOpen">
                                <path class="" stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg class="w-[21px] h-[21px] text-[#344357]" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24" id="eyeClose">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                        <span class="charCount absolute -top-7 right-2 text-sm text-gray-500">
                            0 / 100
                        </span>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Baris 3 --}}
            <div
                class="w-full flex flex-col sm:flex-row justify-between items-start space-y-8 sm:space-y-0 mt-8 {{ $user->user_role == 'kurir' ? 'hidden' : '' }}">
                <div class="w-full box-border">
                    <label class="block w-fit mb-2 text-sm font-medium text-[#344357] dark:text-white" for="user_img">Foto
                        Pengguna</label>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden">
                        <input
                            class="border-0  text-[#344357] text-sm  focus:outline-none block w-full px-2 box-border upload-pdf cursor-not-allowed"
                            aria-describedby="user_img_preview_help" id="user_img_preview" type="text"
                            name="user_img_preview" accept="image/jpg, image/jpeg, image/png"
                            value="{{ basename($user->user_img) }}" disabled>
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer active:scale-105"
                            onclick="window.open('{{ asset('storage/' . $user->user_img) }}', '_blank')">
                            Lihat Foto
                        </button>
                    </div>
                    <div class="relative ring-1 ring-[#344357] rounded-lg focus:ring-2 overflow-hidden mt-5">
                        <input
                            class="border-0  text-[#344357] text-sm  focus:outline-none block w-full px-2 box-border upload-pdf"
                            aria-describedby="user_img_help" id="user_img" type="file" name="user_img"
                            accept="image/jpg, image/jpeg, image/png">
                        <button type="button"
                            class="absolute top-0 right-0 bg-yellow-300 text-black px-2 h-full cursor-pointer hidden active:scale-105"
                            id="showPDF">
                            Lihat Foto
                        </button>
                    </div>
                    @error('user_img')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris Tombol --}}

            <div class="w-full flex justify-between flex-col sm:flex-row mt-14">
                <a href={{ route('admin.users.index') }}
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
