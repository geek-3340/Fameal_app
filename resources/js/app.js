import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// FullCalendar
document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");
    const calendar = new FullCalendar.Calendar(calendarEl, {
        // plugins: [dayGridPlugin], ←CDNで読み込む場合は不要
        initialView: "dayGridMonth",
        locale: "ja",
        dayCellContent: function (arg) {
            return { html: arg.date.getDate() }; // 日付から「日」を消す
        },
        buttonText: {
            month: "月表示",
            week: "週表示",
        },
        headerToolbar: {
            left: "title,prev,next",
            right: "dayGridMonth,dayGridWeek", // 月・週切り替えボタン
        },
    });

    calendar.render();
});
