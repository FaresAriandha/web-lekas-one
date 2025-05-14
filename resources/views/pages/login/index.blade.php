<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/img/logo-lekas.png">
    <title>{{ $title }}</title>

    {{-- @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/flowbite.min.js') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/flowbite.min.js'])


</head>

<body>

    <div class="w-screen h-screen flex justify-center items-center overflow-hidden bg-[#52C3BE]">
        <img src="/img/bg-login.jpg" alt="" class="w-screen h-screen fixed object-cover z-5 opacity-95">
        <div class="w-screen h-screen z-10 bg-black/50 flex justify-center items-center">
            <div class="w-[90%] max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                <form action="{{ route('login.auth') }}" method="POST">
                    @csrf
                    <div class="w-full flex justify-center ">
                        <img src="/img/logo-lekas.png" alt="" class="w-[50px] h-[50px]">
                    </div>
                    <h5 class="text-xl font-medium text-[#344357] text-center mt-2">Lekas One Platform</h5>
                    <div class="mt-5">
                        <label for="username"
                            class="block mb-2 w-fit text-sm font-medium text-[#344357] ">Username</label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center px-3 text-sm  bg-gray-200 border border-e-0 border-gray-300 rounded-s-md outline-none">
                                <svg class="w-[18px] h-[18px] text-[#344357]" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round">
                                    <circle cx="12" cy="8" r="5" />
                                    <path d="M20 21a8 8 0 0 0-16 0" />
                                </svg>
                            </span>
                            <input type="text" id="username"
                                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-[#344357] focus:ring-[#344357] block flex-1 min-w-0 w-full text-sm p-2.5 "
                                placeholder="Username Anda" autocomplete="off" name="username"
                                value="{{ old('username') }}">
                        </div>
                        @error('username')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="mt-5">
                        <label for="password"
                            class="block mb-2 w-fit text-sm font-medium text-[#344357]">Password</label>
                        <div class="flex relative">
                            <!-- Icon Lock (Kiri) -->
                            <span
                                class="inline-flex items-center px-3 text-sm  bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                <svg class="w-[17px] h-[17px] text-[#344357]" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>

                            <!-- Input Password -->
                            <input type="password" id="password"
                                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-[#344357]  focus:ring-[#344357] block flex-1 min-w-0 w-full text-sm p-2.5 pr-10"
                                placeholder="Password Anda" autocomplete="off" name="password">

                            <!-- Icon Mata (Kanan) -->
                            <button type="button"
                                class="absolute inset-y-0 right-3 flex items-center cursor-pointer btn-password">
                                <svg class="w-[21px] h-[21px] text-[#344357] hidden" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" id="eyeOpen">
                                    <path class="" stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg class="w-[21px] h-[21px] text-[#344357]" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" id="eyeClose">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>

                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full mt-8 text-white bg-[#344357] hover:bg-black active:scale-[0.98] focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer">Login</button>
                </form>
            </div>
        </div>
    </div>


    @if (session('warning'))
        <div id="warning-modal"
            class="w-screen h-full flex fixed top-0 right-0 left-0 bg-black/50 justify-center items-center z-30 duration-300">
            <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] sm:w-full max-w-md relative">
                <div class="text-center">
                    <div class="mx-auto w-fit h-fit p-3 bg-red-100 rounded-full overflow-hidden mb-2">
                        <svg class="w-[60px] h-[60px] text-red-500 " xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-[#344357]">Kesalahan</h3>
                    <p class="text-[#344357] mt-2">{{ session('warning', 'Peringatan') }}</p>


                    <div class="flex justify-center mt-5">
                        <button type="button" id="btnCloseWarning"
                            class="px-5 py-2 bg-[#344357] text-white rounded-lg hover:bg-[#2c3849] cursor-pointer">
                            Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('logout_success'))
        <div id="warning-modal"
            class="w-screen h-full flex fixed top-0 right-0 left-0 bg-black/50 justify-center items-center z-30 duration-300">
            <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] sm:w-full max-w-md relative">
                <div class="text-center">
                    <div class="mx-auto w-fit h-fit p-3 bg-green-100 rounded-full overflow-hidden mb-2">
                        {{-- <img src="/img/success.gif" alt="" class="w-[100px] h-[100px]"> --}}
                        <svg class="w-[60px] h-[60px] text-green-600 bg-green-300 rounded-full"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-[#344357]">Sukses</h3>
                    <p class="text-[#344357] mt-2">{{ session('logout_success', 'Berhasil') }}</p>


                    <div class="flex justify-center mt-5">
                        <button type="button" id="btnCloseWarning"
                            class="px-5 py-2 bg-[#344357] text-white rounded-lg hover:bg-[#2c3849] cursor-pointer">
                            Mengerti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif


</body>

</html>
