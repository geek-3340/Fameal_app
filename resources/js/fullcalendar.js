import modalLinkSvg from "./modalLinkSvg";
export default function fullCalendar() {
    document.addEventListener("DOMContentLoaded", function () {
        const calendarEl = document.getElementById("calendar");
        window.dishesByDate = JSON.parse(calendarEl.dataset.menusByDate || "{}");
        // URLを切り替えるためにbladeからrouteをdata属性で受け取る
        const initialView = calendarEl.dataset.initialView || "dayGridMonth";
        const monthUrl = calendarEl.dataset.monthUrl;
        const weekUrl = calendarEl.dataset.weekUrl;

        // 自作献立イベント（menus_dishesテーブルのデータ）をdata属性で受け取る
        const events = JSON.parse(calendarEl.dataset.menusEvent || "[]");

        const calendar = new FullCalendar.Calendar(calendarEl, {
            // plugins: [dayGridPlugin], ←CDNで読み込む場合は不要
            initialView: initialView,
            locale: "ja",
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
            // buttonText: {
            //     month: "月表示",
            //     week: "週表示",
            // },
            events: events,
            dayCellContent: function (arg) {
                if (arg.view.type === "dayGridMonth") {
                    return { html: arg.date.getDate() }; // dayGridMonthでは日付のみ
                } else if (arg.view.type === "dayGridWeek") {
                    const options = {
                        weekday: "short",
                        month: "short",
                        day: "numeric",
                    }; // 曜日 + m月d日
                    const formattedDate = arg.date.toLocaleDateString(
                        "ja-JP",
                        options
                    );
                    return { html: formattedDate };
                }
            },
            dayCellDidMount: function (arg) {
                const link = document.createElement("a");
                link.text = "";
                link.href = `#`;
                link.classList.add(
                    "text-text",
                    "decoration-none",
                    "pt-1",
                    "px-2"
                );
                link.innerHTML = modalLinkSvg();
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const jstDate = formatDateJST(arg.date);
                    const options = {
                        weekday: "short",
                        month: "short",
                        day: "numeric",
                    }; // 曜日 + m月d日
                    const formattedDate = arg.date.toLocaleDateString(
                        "ja-JP",
                        options
                    );
                    window.dispatchEvent(
                        new CustomEvent("open-modal", {
                            detail: {
                                date: jstDate,
                                formattedDate: formattedDate,
                            },
                        })
                    );
                });
                arg.el.querySelector(".fc-daygrid-day-top").appendChild(link);
            },
        });

        calendar.render();

        // JSTに変換してYYYY-MM-DD形式で返す関数
        // カスタムモーダルの日付ずれ対策
        function formatDateJST(date) {
            const jst = new Date(date.getTime() + 9 * 60 * 60 * 1000);
            return jst.toISOString().slice(0, 10);
        }
        // カスタムボタンのactive状態を切り替え
        const setActiveButton = () => {
            const currentUrl =
                window.location.pathname + window.location.search;
            const monthBtn = document.querySelector(".fc-monthButton-button");
            const weekBtn = document.querySelector(".fc-weekButton-button");
            if (
                monthBtn &&
                monthUrl &&
                currentUrl ===
                    new URL(monthUrl, window.location.origin).pathname +
                        new URL(monthUrl, window.location.origin).search
            ) {
                monthBtn.classList.add("active");
            }
            if (
                weekBtn &&
                weekUrl &&
                currentUrl ===
                    new URL(weekUrl, window.location.origin).pathname +
                        new URL(weekUrl, window.location.origin).search
            ) {
                weekBtn.classList.add("active");
            }
        };
        setActiveButton();
    });
}
