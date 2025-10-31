export default function (active) {
    if (active) {
        return `
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#ffffff" class="w-6 h-6">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 8h5m0 4h-5m5 4h-5m-5 4h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2zM8 8h.001M8 12h.001M8 16h.001">
                    </path>
                </g>
            </svg>
            <p>週表示</p>
        `;
    } else {
        return `
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" class="w-6 h-6">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path stroke="#ffb700" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 8h5m0 4h-5m5 4h-5m-5 4h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2zM8 8h.001M8 12h.001M8 16h.001">
                    </path>
                </g>
            </svg>
            <p>週表示</p>
        `;
    }
}
