<a class="w-full flex justify-start items-center group font-semibold px-4 py-2 rounded-md gap-[10px] {{ !request()->is('dashboard') ? 'hover:bg-[#52C3BE] hover:shadow-xl hover:text-black' : 'bg-[#52C3BE] shadow-xl text-black' }}"
    href="@yield('menu')">
    <svg class="w-6 h-6  {{ !request()->is('dashboard') ? 'text-white group-hover:text-black' : 'text-black' }}"
        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
        viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5v14m8-7h-2m0 0h-2m2 0v2m0-2v-2M3 11h6m-6 4h6m11 4H4c-.55228 0-1-.4477-1-1V6c0-.55228.44772-1 1-1h16c.5523 0 1 .44772 1 1v12c0 .5523-.4477 1-1 1Z" />
    </svg>
    Dashboard
</a>
