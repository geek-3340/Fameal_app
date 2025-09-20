export default function fullCalendar() {
    document.addEventListener("DOMContentLoaded", function () {
        const calendarEl = document.getElementById("calendar");
        const initialView = calendarEl.dataset.initialView || "dayGridMonth";
        const monthUrl = calendarEl.dataset.monthUrl;
        const weekUrl = calendarEl.dataset.weekUrl;
        const events = JSON.parse(calendarEl.dataset.menusEvent || "[]");

        const calendar = new FullCalendar.Calendar(calendarEl, {
            // plugins: [dayGridPlugin], ←CDNで読み込む場合は不要
            initialView: initialView,
            locale: "ja",
            events: events,
            dayCellContent: function (arg) {
                return { html: arg.date.getDate() }; // 日付から「日」を消す
            },
            dayCellDidMount: function (arg) {
                const link = document.createElement("a");
                link.text = "link";
                link.href = `#`;
                link.classList.add(
                    "text-text",
                    "decoration-none",
                    "pt-1",
                    "px-2"
                );
                link.innerHTML = `
                    <svg
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="#9f9f9f"
                        stroke="#9f9f9f"
                        class="w-6 h-6"
                    >
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g
                            id="SVGRepo_tracerCarrier"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        ></g>
                        <g id="SVGRepo_iconCarrier">
                            {" "}
                            <title></title>{" "}
                            <g id="Complete">
                                {" "}
                                <g id="edit">
                                    {" "}
                                    <g>
                                        {" "}
                                        <path
                                            d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8"
                                            fill="none"
                                            stroke="#9f9f9f"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        ></path>{" "}
                                        <polygon
                                            fill="none"
                                            points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8"
                                            stroke="#9f9f9f"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        ></polygon>{" "}
                                    </g>{" "}
                                </g>{" "}
                            </g>{" "}
                        </g>
                    </svg>
                `;

                // クリックイベントでAlpine.jsのカスタムイベントを発火
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    // JSTで日付を取得
                    const jstDate = formatDateJST(arg.date);
                    window.dispatchEvent(
                        new CustomEvent("open-modal", {
                            detail: {
                                date: jstDate,
                            },
                        })
                    );
                });
                // ファイルの先頭や関数外に追加
                function formatDateJST(date) {
                    const jst = new Date(date.getTime() + 9 * 60 * 60 * 1000);
                    return jst.toISOString().slice(0, 10);
                }

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
