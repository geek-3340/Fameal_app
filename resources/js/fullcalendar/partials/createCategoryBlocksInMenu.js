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
            <div class="flex">
                                <div class="break-first pl-4 pr-4 border-l border-dashed border-gray-300 hidden">
                                    <h2 class="text-center font-semibold text-sm mt-2 mx-2">朝食</h2>
                                    <div class="p-1"></div>
                                </div>
                                <div class="lunch pl-4 pr-4 border-l border-dashed border-gray-300 hidden">
                                    <h2 class="text-center font-semibold text-sm mt-2 mx-2">昼食</h2>
                                    <div class="p-1"></div>
                                </div>
                                <div class="dinner pl-4 pr-4 border-l border-dashed border-gray-300 hidden">
                                    <h2 class="text-center font-semibold text-sm mt-2 mx-2">夕食</h2>
                                    <div class="p-1"></div>
                                </div>
                                <div class="break-first lunch dinner border-r border-dashed border-gray-300 hidden"></div>
                            </div>
                            `;
        }
        $eventsContainer.appendChild($menuCategoryBlock);
    }
}

function dateFormat(date) {
    return date.toLocaleDateString("ja-JP", {
        weekday: "short",
        month: "short",
        day: "numeric",
    });
}
function jst(date) {
    return new Date(date.getTime() + 9 * 60 * 60 * 1000)
        .toISOString()
        .split("T")[0];
}