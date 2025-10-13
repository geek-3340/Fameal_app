import calendarResponsive from "./partials/calendarResponsive";
import calendarActiveButton from "./partials/calendarActiveButton";
import modalLinkSvg from "../svg/modalLinkSvg";
export default function fullCalendar() {
    document.addEventListener("DOMContentLoaded", function () {
        const calendarEl = document.getElementById("calendar");
        const initialView = calendarEl.dataset.initialView || "dayGridMonth";
        const monthUrl = calendarEl.dataset.monthUrl;
        const weekUrl = calendarEl.dataset.weekUrl;
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
                right: "monthButton,weekButton",
            },
            customButtons: {
                monthButton: {
                    click: function () {
                        window.location.href = monthUrl;
                    },
                },
                weekButton: {
                    click: function () {
                        window.location.href = weekUrl;
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

        calendarActiveButton(monthUrl, weekUrl);
        calendarResponsive();
    });
}
