import calendarResponsive from "./partials/calendarResponsive";
import calendarActiveButton from "./partials/calendarActiveButton";
import modalLinkSvg from "../svg/modalLinkSvg";
export default function fullCalendar() {
    document.addEventListener("DOMContentLoaded", function () {
        const calendarEl = document.getElementById("calendar");
        const initialView = calendarEl.dataset.initialView || "dayGridMonth";
        const currentUrl =
            window.location.origin +
            window.location.pathname +
            window.location.search;
        const dishesMonthUrl = calendarEl.dataset.dishesMonthUrl;
        const dishesWeekUrl = calendarEl.dataset.dishesWeekUrl;
        const babyfoodsMonthUrl = calendarEl.dataset.babyfoodsMonthUrl;
        const babyfoodsWeekUrl = calendarEl.dataset.babyfoodsWeekUrl;
        const events = JSON.parse(calendarEl.dataset.menusEvent || "[]");
        window.dishesByDate = JSON.parse(
            calendarEl.dataset.menusByDate || "{}"
        );
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

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: initialView,
            locale: "ja",
            headerToolbar: {
                left: "title,prev,next",
                right: "dishesButton,monthButton,babyfoodsButton,weekButton",
            },
            height: "auto",
            events: events,
            eventOrder: "order",
            customButtons: {
                dishesButton: {
                    click: function () {
                        if (currentUrl === babyfoodsMonthUrl) {
                            window.location.href = dishesMonthUrl;
                        } else if (currentUrl === babyfoodsWeekUrl) {
                            window.location.href = dishesWeekUrl;
                        }
                    },
                },
                babyfoodsButton: {
                    click: function () {
                        if (currentUrl === dishesMonthUrl) {
                            window.location.href = babyfoodsMonthUrl;
                        } else if (currentUrl === dishesWeekUrl) {
                            window.location.href = babyfoodsWeekUrl;
                        }
                    },
                },
                monthButton: {
                    click: function () {
                        if (currentUrl === dishesWeekUrl) {
                            window.location.href = dishesMonthUrl;
                        } else if (currentUrl === babyfoodsWeekUrl) {
                            window.location.href = babyfoodsMonthUrl;
                        }
                    },
                },
                weekButton: {
                    click: function () {
                        if (currentUrl === dishesMonthUrl) {
                            window.location.href = dishesWeekUrl;
                        } else if (currentUrl === babyfoodsMonthUrl) {
                            window.location.href = babyfoodsWeekUrl;
                        }
                    },
                },
            },
            eventContent(arg) {
                const event = document.createElement("div");
                event.textContent = arg.event.title;
                event.classList.add("menu-event");
                return { domNodes: [event] };
            },
            eventDidMount(arg) {
                const category = arg.event.extendedProps.category;
                const dayEl = arg.el.closest(".fc-daygrid-day");
                const menuCategoryBlocks = dayEl.querySelector(
                    ".menu-category-blocks"
                );
                if (!menuCategoryBlocks) return;

                // category名とクラス名を対応付けるマップ
                const categoryMap = {
                    朝食: ".break-first",
                    昼食: ".lunch",
                    夕食: ".dinner",
                };

                // 対応するクラスを取得
                const targetSelector = categoryMap[category];
                if (!targetSelector) return; // 対応しないcategoryならスキップ

                const target =
                    menuCategoryBlocks.querySelectorAll(targetSelector);
                target.forEach((t) => {
                    const menusBlock = t.querySelector("div");
                    t.classList.remove("hidden");
                    // const categoryHeadline = t.previousElementSibling;
                    // if (categoryHeadline) {
                    //     categoryHeadline.classList.remove("hidden");
                    // }
                    if (menusBlock) menusBlock.appendChild(arg.el);
                });
            },

            dayCellContent(arg) {
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
            },
            dayCellDidMount(arg) {
                const link = arg.el.querySelector(".open-modal-link");
                if (link) {
                    link.addEventListener("click", (e) => {
                        e.preventDefault();
                        const jstDate = jst(arg.date);
                        const formattedDate = dateFormat(arg.date);
                        window.dispatchEvent(
                            new CustomEvent("open-day-modal", {
                                detail: { date: jstDate, formattedDate },
                            })
                        );
                    });
                }

                const eventsContainer = arg.el.querySelector(
                    ".fc-daygrid-day-events"
                );
                if (
                    eventsContainer &&
                    !eventsContainer.querySelector(".menu-category-blocks")
                ) {
                    const menuCategoryBlocks = document.createElement("div");
                    menuCategoryBlocks.classList.add("menu-category-blocks");
                    if (initialView === "dayGridMonth") {
                        menuCategoryBlocks.innerHTML = `
                        
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
                        menuCategoryBlocks.innerHTML = `
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
                    eventsContainer.appendChild(menuCategoryBlocks);
                }
            },
        });

        calendar.render();

        calendarActiveButton(
            dishesMonthUrl,
            dishesWeekUrl,
            babyfoodsMonthUrl,
            babyfoodsWeekUrl
        );
        calendarResponsive(dishesMonthUrl, babyfoodsMonthUrl);
    });
}
