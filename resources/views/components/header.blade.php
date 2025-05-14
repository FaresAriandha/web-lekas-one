<header
    class="h-[60px] w-full bg-white box-border flex justify-between items-center sticky top-0 left-0 shadow-md shadow-gray-200 z-10">
    <div class="flex items-center">
        <button class="w-[60px] h-[60px]  flex justify-center items-center cursor-pointer sm:hidden"
            id="btn-sidebar-open">
            <svg class="w-[35px] h-[35px] text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-menu">
                <line x1="4" x2="20" y1="12" y2="12" />
                <line x1="4" x2="20" y1="6" y2="6" />
                <line x1="4" x2="20" y1="18" y2="18" />
            </svg>
        </button>
        <h1 class="sm:ml-[20px] text-[16px] sm:text-[24px] font-bold">{{ $header_title }}</h1>
    </div>
</header>
