<button type="button" @click="openLeft = !openLeft"
    class="absolute top-0 left-0 flex flex-col justify-center items-center w-20 h-20 bg-main z-50 md:hidden">
    <div class="relative w-20 h-20">
        <span class="absolute top-1/2 left-1/2 block w-10 h-1 rounded-lg bg-white transform transition duration-300"
            :class="openLeft ? '-translate-x-1/2 -translate-y-0 rotate-45' : '-translate-x-1/2 -translate-y-3 rotate-0'">
        </span>
        <span class="absolute top-1/2 left-1/2 block w-10 h-1 rounded-lg bg-white transform transition duration-300"
            :class="openLeft ? 'opacity-0' : 'opacity-100 -translate-x-1/2'">
        </span>
        <span class="absolute top-1/2 left-1/2 block w-10 h-1 rounded-lg bg-white transform transition duration-300"
            :class="openLeft ? '-translate-x-1/2 -translate-y-0 -rotate-45' : '-translate-x-1/2 translate-y-3 rotate-0'">
        </span>
    </div>
</button>
