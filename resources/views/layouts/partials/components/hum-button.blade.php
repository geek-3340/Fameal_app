<button type="button" @click="openNavMenu = !openNavMenu"
    class="absolute z-50 top-0 left-0 md:hidden">
    <div class="relative w-20 h-20 bg-main max-md:w-16 max-md:h-16">
        <span class="absolute block top-1/2 left-1/2 w-10 h-1 rounded-lg bg-white transition duration-300 max-md:w-8"
            :class="openNavMenu ? '-translate-x-1/2 -translate-y-0 rotate-45' : '-translate-x-1/2 -translate-y-3 rotate-0 max-md:-translate-y-2 '">
        </span>
        <span class="absolute block top-1/2 left-1/2 w-10 h-1 rounded-lg bg-white transition duration-300 max-md:w-8"
            :class="openNavMenu ? 'opacity-0' : 'opacity-100 -translate-x-1/2'">
        </span>
        <span class="absolute block top-1/2 left-1/2 w-10 h-1 rounded-lg bg-white transition duration-300 max-md:w-8"
            :class="openNavMenu ? '-translate-x-1/2 -translate-y-0 -rotate-45' : '-translate-x-1/2 translate-y-3 rotate-0 max-md:translate-y-2 '">
        </span>
    </div>
</button>
