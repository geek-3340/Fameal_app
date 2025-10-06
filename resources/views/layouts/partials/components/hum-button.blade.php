<button type="button" @click="openNavMenu = !openNavMenu"
    class="absolute z-50 top-0 left-0 md:hidden">
    <div class="relative w-20 h-20 bg-main">
        <span class="absolute block top-1/2 left-1/2 w-10 h-1 rounded-lg bg-white transition duration-300"
            :class="openNavMenu ? '-translate-x-1/2 -translate-y-0 rotate-45' : '-translate-x-1/2 -translate-y-3 rotate-0'">
        </span>
        <span class="absolute block top-1/2 left-1/2 w-10 h-1 rounded-lg bg-white transition duration-300"
            :class="openNavMenu ? 'opacity-0' : 'opacity-100 -translate-x-1/2'">
        </span>
        <span class="absolute block top-1/2 left-1/2 w-10 h-1 rounded-lg bg-white transition duration-300"
            :class="openNavMenu ? '-translate-x-1/2 -translate-y-0 -rotate-45' : '-translate-x-1/2 translate-y-3 rotate-0'">
        </span>
    </div>
</button>
