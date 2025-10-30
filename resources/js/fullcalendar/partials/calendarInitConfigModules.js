import modalLinkSvg from "../../svg/modalLinkSvg";

export function customButtonsData(
    currentUrl,
    dishesMonthUrl,
    dishesWeekUrl,
    babyFoodsMonthUrl,
    babyFoodsWeekUrl
) {
    return {
        dishesButton: {
            click: function () {
                if (currentUrl === babyFoodsMonthUrl) {
                    window.location.href = dishesMonthUrl;
                } else if (currentUrl === babyFoodsWeekUrl) {
                    window.location.href = dishesWeekUrl;
                }
            },
        },
        babyFoodsButton: {
            click: function () {
                if (currentUrl === dishesMonthUrl) {
                    window.location.href = babyFoodsMonthUrl;
                } else if (currentUrl === dishesWeekUrl) {
                    window.location.href = babyFoodsWeekUrl;
                }
            },
        },
        monthButton: {
            click: function () {
                if (currentUrl === dishesWeekUrl) {
                    window.location.href = dishesMonthUrl;
                } else if (currentUrl === babyFoodsWeekUrl) {
                    window.location.href = babyFoodsMonthUrl;
                }
            },
        },
        weekButton: {
            click: function () {
                if (currentUrl === dishesMonthUrl) {
                    window.location.href = dishesWeekUrl;
                } else if (currentUrl === babyFoodsMonthUrl) {
                    window.location.href = babyFoodsWeekUrl;
                }
            },
        },
    };
}

export function createDayCellHeaderContent(arg) {
    if (arg.view.type === "dayGridMonth") {
        return {
            html: arg.date.getDate() + `${modalLinkSvg()}`,
        };
    } else if (arg.view.type === "dayGridWeek") {
        const formattedDate = dateFormat(arg.date);
        return {
            html: formattedDate + ` ${modalLinkSvg()}`,
        };
    }
}

export function createDishNodes(arg) {
    const $dish = document.createElement("div");
    $dish.textContent = arg.event.title;
    return { domNodes: [$dish] };
}

export function createCategoryBlocksInMenu(arg, initialView) {
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

export function onClickMenuEditLink(arg) {
    const $menuEditLink = arg.el.querySelector(".menu-edit-link");
    if ($menuEditLink) {
        $menuEditLink.addEventListener("click", (e) => {
            e.preventDefault();
            const jstDate = jst(arg.date);
            const formattedDate = dateFormat(arg.date);
            window.dispatchEvent(
                new CustomEvent("open-menu-edit-modal", {
                    detail: { date: jstDate, formattedDate },
                })
            );
        });
    }
}

export function setCategoryBlocksInMenu(arg) {
    const menuCategory = arg.event.extendedProps.category;
    const $dayEl = arg.el.closest(".fc-daygrid-day");
    const $menuCategoryBlock = $dayEl.querySelector(".menu-category-block");
    if (!$menuCategoryBlock) return;
    const menuCategoryMap = {
        朝食: ".break-first",
        昼食: ".lunch",
        夕食: ".dinner",
    };
    const setClassName = menuCategoryMap[menuCategory];
    if (!setClassName) return;
    // 全category対応のborderを描画するためにforEachで回す
    const $menuBlock = $menuCategoryBlock.querySelectorAll(setClassName);
    $menuBlock.forEach((mb) => {
        const $dishBlock = mb.querySelector("div");
        mb.classList.remove("hidden");
        if ($dishBlock) $dishBlock.appendChild(arg.el);
    });
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
