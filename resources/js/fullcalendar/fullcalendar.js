import updateResponsiveMonthCalendar from "./partials/updateResponsiveMonthCalendar";
import updateActiveCustomButton from "./partials/updateActiveCustomButton";
import createCustomButtons from "./partials/createCustomButtons";
import createDayCellHeaderContent from "./partials/createDayCellHeaderContent";
import createCategoryBlocksInMenu from "./partials/createCategoryBlocksInMenu";
import onClickMenuEditLink from "./partials/onClickMenuEditLink";
import toggleCategoryBlocksVisibility from "./partials/toggleCategoryBlocksVisibility";
import updateCalendarMenu from "./partials/updateCalendarMenu";
import setCustomButtons from "./partials/setCustomButtons";

export default function fullCalendar() {
    document.addEventListener("DOMContentLoaded", function () {
        const $calendarEl = document.getElementById("calendar");
        if (!$calendarEl) return;
        const initialCalendar =
            $calendarEl.dataset.initialView || "dayGridMonth";
        const menusForCalendarEvents = JSON.parse(
            $calendarEl.dataset.menusForCalendarEvents || "[]"
        );
        const currentUrl =
            window.location.origin +
            window.location.pathname +
            window.location.search;
        const DISHES_MONTH_URL = $calendarEl.dataset.dishesMonthUrl;
        const DISHES_WEEK_URL = $calendarEl.dataset.dishesWeekUrl;
        const BABY_FOODS_MONTH_URL = $calendarEl.dataset.babyfoodsMonthUrl;
        const BABY_FOODS_WEEK_URL = $calendarEl.dataset.babyfoodsWeekUrl;

        // FullCalendarの初期化
        const calendar = new FullCalendar.Calendar($calendarEl, {
            initialView: initialCalendar,
            locale: "ja",
            headerToolbar: {
                left: "prev,title,next",
                right: setCustomButtons(),
            },
            height: "auto",
            events: menusForCalendarEvents,
            eventOrder: "dishDisplayOrder",
            customButtons: createCustomButtons(
                currentUrl,
                DISHES_MONTH_URL,
                DISHES_WEEK_URL,
                BABY_FOODS_MONTH_URL,
                BABY_FOODS_WEEK_URL
            ),
            dayCellContent: createDayCellHeaderContent,
            eventContent(arg) {
                const $dish = document.createElement("div");
                $dish.textContent = arg.event.title;
                return { domNodes: [$dish] };
            },
            dayCellDidMount(arg) {
                createCategoryBlocksInMenu(arg, initialCalendar);
                onClickMenuEditLink(arg);
            },
            eventDidMount(arg) {
                toggleCategoryBlocksVisibility(arg);
            },
        });

        // fullCalendarの描画
        calendar.render();

        // fullCalendarのリサイズ対応
        let resizeTimer;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                calendar.render();
            }, 200);
        });

        // 献立の追加・編集・削除に伴うカレンダー描画更新処理
        updateCalendarMenu(calendar);

        // カスタムボタンのアクティブ状態更新処理
        updateActiveCustomButton(
            DISHES_MONTH_URL,
            DISHES_WEEK_URL,
            BABY_FOODS_MONTH_URL,
            BABY_FOODS_WEEK_URL
        );

        // 月間カレンダー日付セルのレスポンシブ対応処理
        updateResponsiveMonthCalendar(
            currentUrl,
            DISHES_MONTH_URL,
            BABY_FOODS_MONTH_URL
        );
    });
}
