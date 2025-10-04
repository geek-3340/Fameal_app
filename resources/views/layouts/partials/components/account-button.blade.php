<button x-show="!openRight" type="button" @click="openRight = true"
    class="absolute top-0 right-0 mr-5 flex flex-col justify-center items-center w-20 h-20  z-50">
    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffb700" viewBox="0 0 24 24" stroke="#ffb700" class=" w-14 h-14">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
            <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z">
            </path>
        </g>
    </svg>
</button>
<button x-show="openRight" type="button" @click="openRight = false"
    class="absolute top-0 right-0 mr-5 flex flex-col justify-center items-center w-20 h-20  z-50" style="display: none">
    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffff" viewBox="0 0 24 24" stroke="#ffff" class="w-14 h-14">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
            <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z">
            </path>
        </g>
    </svg>
</button>
