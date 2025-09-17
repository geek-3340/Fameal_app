export default function fullCalendar() {
    document.addEventListener("DOMContentLoaded", function () {
        const calendarEl = document.getElementById("calendar");
        const initialView = calendarEl.dataset.initialView || "dayGridMonth";
        const monthUrl = calendarEl.dataset.monthUrl;
        const weekUrl = calendarEl.dataset.weekUrl;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            // plugins: [dayGridPlugin], ←CDNで読み込む場合は不要
            initialView: initialView,
            locale: "ja",
            dayCellContent: function (arg) {
                return { html: arg.date.getDate() }; // 日付から「日」を消す
            },
            dayCellDidMount: function (arg) {
                const link = document.createElement("a");
                link.text="link"
                link.href = `#`;
                link.classList.add(
                    "text-text",
                    "decoration-none",
                    "pt-1",
                    "px-2",
                );

                arg.el.querySelector(".fc-daygrid-day-top").appendChild(link);
            },
            // buttonText: {
            //     month: "月表示",
            //     week: "週表示",
            // },
            headerToolbar: {
                left: "title,prev,next",
                right: "monthButton,weekButton", // 月・週切り替えボタン
            },
            customButtons: {
                monthButton: {
                    text: "月表示",
                    click: function () {
                        window.location.href = monthUrl;
                    },
                },
                weekButton: {
                    text: "週表示",
                    click: function () {
                        window.location.href = weekUrl;
                    },
                },
            },
        });

        calendar.render();
    });
}
