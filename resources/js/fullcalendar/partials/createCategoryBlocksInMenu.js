export default function (arg, initialView) {
    const $eventsContainer = arg.el.querySelector(".fc-daygrid-day-events");
    if (
        $eventsContainer &&
        !$eventsContainer.querySelector(".menu-category-block")
    ) {
        const $menuCategoryBlock = document.createElement("div");
        $menuCategoryBlock.classList.add("menu-category-block");
        if (initialView === "dayGridMonth") {
            $menuCategoryBlock.innerHTML = `
                            
                            <div class="break-first hidden">
                                <h2 class="font-semibold text-sm mt-2 mx-2 border-t border-dashed border-gray-300">朝食</h2>
                                <div></div>
                            </div>
                            <div class="lunch hidden">
                                <h2 class="font-semibold text-sm mt-2 mx-2 border-t border-dashed border-gray-300">昼食</h2>
                                <div></div>
                            </div>
                            <div class="dinner hidden">
                                <h2 class="font-semibold text-sm mt-2 mx-2 border-t border-dashed border-gray-300">夕食</h2>
                                <div></div>
                            </div>
                            <div class="mt-2 break-first lunch dinner hidden"></div>
                            `;
        } else {
            $menuCategoryBlock.innerHTML = `
            <div class="flex w-full">
                                <div class="break-first px-4 hidden max-md:p-0 max-md:w-1/3" style="border-left: 1px dashed #d1d5db;">
                                    <h2 class="text-center font-semibold text-sm mt-0">朝食</h2>
                                    <div></div>
                                </div>
                                <div class="lunch px-4 hidden max-md:p-0 max-md:w-1/3"  style="border-left: 1px dashed #d1d5db;">
                                    <h2 class="text-center font-semibold text-sm mt-0">昼食</h2>
                                    <div></div>
                                </div>
                                <div class="dinner px-4 hidden max-md:p-0 max-md:w-1/3" style="border-left: 1px dashed #d1d5db;">
                                    <h2 class="text-center font-semibold text-sm mt-0">夕食</h2>
                                    <div></div>
                                </div>
                                <div class="break-first lunch dinner hidden" style="border-right: 1px dashed #d1d5db;"></div>
                            </div>
                            `;
        }
        $eventsContainer.appendChild($menuCategoryBlock);
    }
}
