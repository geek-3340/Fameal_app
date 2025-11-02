export default function (currentUrl, dishesMonthUrl, babyFoodsMonthUrl) {

    if (currentUrl === dishesMonthUrl || currentUrl === babyFoodsMonthUrl) {
        updateLayoutMonthCalendar();

        window.addEventListener("resize", () => {
            setTimeout(() => {
                updateLayoutMonthCalendar();
            }, 200);
        });

        // calendar内の要素の追加・削除を監視し処理を実行する
        // MutationObserverを設定
        const observer = new MutationObserver(() => {
            updateLayoutMonthCalendar();
        });
        // 監視対象のノードとオプションを指定
        const $calendarRoot = document.querySelector(".fc-view-harness");
        if ($calendarRoot) {
            observer.observe($calendarRoot, {
                childList: true, // 子ノードの追加や削除を監視
                subtree: true, // 子孫ノードも監視
            });
        }
    }

    function updateLayoutMonthCalendar() {

        const $dayCellHeader = document.querySelector(".fc-daygrid-day-top");
        const dayCellHeaderWidth = $dayCellHeader.clientWidth;
        const dayCellHeaderHeight = $dayCellHeader.clientHeight;
        const dayCellBodyMinHeight = dayCellHeaderWidth - dayCellHeaderHeight;

        const $dayCellBodies = document.querySelectorAll(".fc-daygrid-day-events");
        $dayCellBodies.forEach((dayCellBody) => {
            dayCellBody.style.setProperty(
                "min-height",
                `${dayCellBodyMinHeight}px`,
                "important"
            );
        });

        const calendarHeaderHeight =
        document.querySelector(".fc-col-header").clientHeight;
        const calendarBodyHeight =
        document.querySelector(".fc-daygrid-body").clientHeight;
        const calendarHeight = calendarHeaderHeight + calendarBodyHeight;

        const $calendarCanvas = document.querySelector(".fc-view-harness");
        $calendarCanvas.style.setProperty(
            "height",
            `${calendarHeight}px`,
            "important"
        );

    }
}
