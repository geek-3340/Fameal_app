import updateResponsiveMonthCalendar from "./partials/updateResponsiveMonthCalendar";
import updateActiveCustomButton from "./partials/updateActiveCustomButton";
import createCustomButtons from "./partials/createCustomButtons";
import createDayCellHeaderContent from "./partials/createDayCellHeaderContent";
import createCategoryBlocksInMenu from "./partials/createCategoryBlocksInMenu";
import onClickMenuEditLink from "./partials/onClickMenuEditLink";
import toggleCategoryBlocksVisibility from "./partials/toggleCategoryBlocksVisibility";

export default function fullCalendar() {
    document.addEventListener("DOMContentLoaded", function () {
        const $calendarEl = document.getElementById("calendar");
        const initialCalendar =
            $calendarEl.dataset.initialView || "dayGridMonth";
        const menusForCalendarEvents = JSON.parse($calendarEl.dataset.menusForCalendarEvents || "[]");
        const currentUrl =
            window.location.origin +
            window.location.pathname +
            window.location.search;
        const DISHES_MONTH_URL = $calendarEl.dataset.dishesMonthUrl;
        const DISHES_WEEK_URL = $calendarEl.dataset.dishesWeekUrl;
        const BABY_FOODS_MONTH_URL = $calendarEl.dataset.babyfoodsMonthUrl;
        const BABY_FOODS_WEEK_URL = $calendarEl.dataset.babyfoodsWeekUrl;

        const calendar = new FullCalendar.Calendar($calendarEl, {
            initialView: initialCalendar,
            locale: "ja",
            headerToolbar: {
                left: "title,prev,next",
                right: "dishesButton,monthButton,babyFoodsButton,weekButton",
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

        calendar.render();


        window.calendar = calendar;
        window.addEventListener("menu-updated", (e) => {
            if (!window.calendar) return;
            document
                .querySelectorAll(".fc-event")
                .forEach((dish) => dish.remove());
            // 該当日のイベントを削除
            window.calendar.removeAllEvents();
            const newEvents = e.detail.newCalendarDish;
            newEvents.forEach((dish) => {
                window.calendar.addEvent({
                    id: dish.id,
                    title: dish.title,
                    start: dish.start,
                    backgroundColor: dish.backgroundColor,
                    displayOrder: dish.displayOrder,
                    extendedProps: { category: dish.category },
                });
            });
        });

        updateActiveCustomButton(
            DISHES_MONTH_URL,
            DISHES_WEEK_URL,
            BABY_FOODS_MONTH_URL,
            BABY_FOODS_WEEK_URL
        );
        updateResponsiveMonthCalendar(
            currentUrl,
            DISHES_MONTH_URL,
            BABY_FOODS_MONTH_URL
        );
    });
}
