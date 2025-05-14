<aside
    class="h-screen w-64 text-white fixed z-30 -translate-x-64 opacity-0 sm:opacity-100 sm:translate-x-0 duration-300 bg-[#344357]"
    id="sidebar">
    {{-- Logo --}}
    <div
        class="w-full flex justify-start gap-[15px] items-center h-[60px] bg-[#344357] box-border px-[20px] sticky top-0 left-0">
        <img src="/img/logo-lekas.png" alt="" class="w-[40px] h-[40px]">
        <h1 class="text-[24px]  sm:text-[28px] font-bold">Lekas One</h1>
        <button
            class="w-[30px] h-[30px] bg-white absolute right-[15px] border-black border flex sm:hidden justify-center items-center rounded-md"
            id="btn-sidebar-close">
            <svg class="text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-x">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </button>
    </div>

    {{-- Menus --}}
    <div class="w-full h-full pb-[120px] overflow-y-auto no-scrollbar ">
        <div class="w-full h-fit my-[20px] px-4">
            <a class="{{ Auth::user()->user_role === 'admin' ? '' : 'hidden' }} w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md gap-[10px] {{ request()->is('admin/dashboard*') || request()->is('/') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                href="/admin/dashboard">
                <svg class="w-[20px] h-[20px] {{ request()->is('admin/dashboard*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                Dashboard
            </a>
            <a class="{{ Auth::user()->user_role !== 'kurir' ? '' : 'hidden' }} w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] my-[8px] {{ request()->is('admin/couriers*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                href="{{ route('admin.couriers.index') }}">
                <svg class="w-[20px] h-[20px] {{ request()->is('admin/couriers*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round">
                    <path d="M18 21a8 8 0 0 0-16 0" />
                    <circle cx="10" cy="8" r="5" />
                    <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                </svg>
                Kelola Kurir
            </a>
            <a class="{{ Auth::user()->user_role !== 'kurir' ? '' : 'hidden' }} w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md gap-[10px] my-[8px] {{ request()->is('admin/fleets*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                href="{{ route('admin.fleets.index') }}">
                <svg class="w-[20px] h-[20px] {{ request()->is('admin/fleets*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck">
                    <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                    <path d="M15 18H9" />
                    <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                    <circle cx="17" cy="18" r="2" />
                    <circle cx="7" cy="18" r="2" />
                </svg>
                Kelola Armada
            </a>
            <a class="w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] my-[8px] {{ request()->is('admin/locations*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                href="{{ route('admin.locations.index') }}">
                <svg class="w-[20px] h-[20px] {{ request()->is('admin/locations*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-locate-fixed">
                    <line x1="2" x2="5" y1="12" y2="12" />
                    <line x1="19" x2="22" y1="12" y2="12" />
                    <line x1="12" x2="12" y1="2" y2="5" />
                    <line x1="12" x2="12" y1="19" y2="22" />
                    <circle cx="12" cy="12" r="7" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Kelola Lokasi
            </a>
            <a class="{{ Auth::user()->user_role === 'admin' ? '' : 'hidden' }} w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] my-[8px] {{ request()->is('admin/prices*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                href="{{ route('admin.prices.index') }}">
                <svg class="w-[20px] h-[20px] {{ request()->is('admin/prices*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag">
                    <path
                        d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z" />
                    <circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
                </svg>
                Kelola Tarif
            </a>
            <a class="{{ Auth::user()->user_role === 'admin' ? '' : 'hidden' }} w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] my-[8px] {{ request()->is('admin/users*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                href="{{ route('admin.users.index') }}">
                <svg class="w-[20px] h-[20px] {{ request()->is('admin/users*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-user-round">
                    <circle cx="12" cy="8" r="5" />
                    <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
                Kelola Pengguna
            </a>
            <a class="w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] my-[8px] {{ request()->is('admin/assignees*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                href="{{ route('admin.assignees.index') }}">
                <svg class="w-[20px] h-[20px] {{ request()->is('admin/assignees*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-clipboard-list">
                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                    <path d="M12 11h4" />
                    <path d="M12 16h4" />
                    <path d="M8 11h.01" />
                    <path d="M8 16h.01" />
                </svg>
                Penugasan Kurir
            </a>
        </div>
        <hr class="text-white border">
        <div class="w-full h-fit my-[20px] px-4">
            <h1>Riwayat Pengiriman</h1>
            <div class="my-[20px]">
                <a class="w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] {{ request()->is('admin/paxel-shippings*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                    href="{{ route('admin.paxel-shippings.index') }}">
                    <svg class="w-[20px] h-[20px] {{ request()->is('admin/paxel-shippings*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-package">
                        <path
                            d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                        <path d="M12 22V12" />
                        <polyline points="3.29 7 12 12 20.71 7" />
                        <path d="m7.5 4.27 9 5.15" />
                    </svg>
                    Proyek Paxel
                </a>
                <a class="w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] my-[8px] {{ request()->is('admin/pasjay-shippings*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                    href="{{ route('admin.pasjay-shippings.index') }}">
                    <svg class="w-[20px] h-[20px] {{ request()->is('admin/pasjay-shippings*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-store">
                        <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                        <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                        <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4" />
                        <path d="M2 7h20" />
                        <path
                            d="M22 7v3a2 2 0 0 1-2 2a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12a2 2 0 0 1-2-2V7" />
                    </svg>
                    Proyek Pasar Jaya
                </a>
            </div>
        </div>
        <hr class="text-white border {{ Auth::user()->user_role === 'admin' ? '' : 'hidden' }}">
        <div class="w-full h-fit my-[20px] mb-[80px] px-4 {{ Auth::user()->user_role === 'admin' ? '' : 'hidden' }}">
            <h1>Transaksi</h1>
            <div class="my-[20px]">
                <a class="{{ Auth::user()->user_role === 'admin' ? '' : 'hidden' }} w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] {{ request()->is('admin/courier-payments*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                    href="/admin/courier-payments">
                    <svg class="w-[20px] h-[20px] {{ request()->is('admin/courier-payments*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-wallet">
                        <path
                            d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1" />
                        <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4" />
                    </svg>
                    Pencairan Kurir
                </a>
                <a class="{{ Auth::user()->user_role === 'admin' ? '' : 'hidden' }} w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md  gap-[10px] my-[8px] {{ request()->is('admin/client-bills*') ? 'bg-[#52C3BE] shadow-xl text-[#344357]' : 'hover:bg-[#52C3BE] active:bg-[#52C3BE] hover:shadow-xl hover:text-[#344357] active:text-[#344357] text-white' }}"
                    href="/admin/client-bills">
                    <svg class="w-[20px] h-[20px] {{ request()->is('admin/client-bills*') ? 'text-[#344357]' : 'text-white group-hover:text-[#344357] group-active:text-[#344357]' }}"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-banknote">
                        <rect width="20" height="12" x="2" y="6" rx="2" />
                        <circle cx="12" cy="12" r="2" />
                        <path d="M6 12h.01M18 12h.01" />
                    </svg>
                    Tagihan Klien
                </a>
            </div>
        </div>
    </div>

    <div class="w-64 h-[60px] flex justify-between items-center bg-[#2b3848] fixed bottom-0 left-0 text-white"
        id="profile">

        <a class="w-[70%] h-fit px-2 py-2 flex items-center  rounded-lg hover:bg-[#40536b] cursor-pointer active:bg-[#40536b] ms-3"
            href="{{ route('admin.users.edit', Auth::user()->user_ID) }}">
            <div class="w-[35px] h-[35px] rounded-full  overflow-hidden">
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . Auth::user()->user_img) }}">
            </div>
            <span class="ml-[10px] max-w-[120px] truncate block">{{ Auth::user()->user_name }}</span>
        </a>
        <div class="w-[20%] flex justify-center items-center">
            <a class="w-[30px] h-[30px] bg-white/80 hover:bg-white active:bg-white flex justify-center items-center rounded-md cursor-pointer me-5"
                href="{{ route('admin.logout') }}">
                <svg class="w-[20px] h-[20px] text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-log-out">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
            </a>
        </div>
    </div>


</aside>
