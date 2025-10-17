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
            events: events,
            height: "auto",
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
                            new CustomEvent("open-modal", {
                                detail: { date: jstDate, formattedDate },
                            })
                        );
                    });
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
