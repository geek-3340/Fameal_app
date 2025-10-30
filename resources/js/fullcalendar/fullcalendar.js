import initResponsiveMonthCalendar from "./partials/initResponsiveMonthCalendar";
import updateActiveCustomButton from "./partials/updateActiveCustomButton";
import {
    customButtonsData,
    createDayCellHeaderContent,
    createDishNodes,
    createCategoryBlocksInMenu,
    setCategoryBlocksInMenu,
    onClickMenuEditLink,
} from "./partials/calendarInitConfigModules";

export default function fullCalendar() {

    document.addEventListener("DOMContentLoaded", function () {

        const $calendarEl = document.getElementById("calendar");
        const initialCalendar = $calendarEl.dataset.initialView || "dayGridMonth";
        const menus = JSON.parse($calendarEl.dataset.menusEvent || "[]");
        const currentUrl =
            window.location.origin +
            window.location.pathname +
            window.location.search;
        const DISHES_MONTH_URL = $calendarEl.dataset.dishesMonthUrl;
        const DISHES_WEEK_URL = $calendarEl.dataset.dishesWeekUrl;
        const BABY_FOODS_MONTH_URL = $calendarEl.dataset.babyfoodsMonthUrl;
        const BABY_FOODS_WEEK_URL = $calendarEl.dataset.babyfoodsWeekUrl;
        window.dishesByDate = JSON.parse(
            $calendarEl.dataset.menusByDate || "{}"
        );

        const calendar = new FullCalendar.Calendar($calendarEl, {
            initialView: initialCalendar,
            locale: "ja",
            headerToolbar: {
                left: "title,prev,next",
                right: "dishesButton,monthButton,babyfoodsButton,weekButton",
            },
            height: "auto",
            events: menus,
            eventOrder: "order",
            customButtons: customButtonsData(
                currentUrl,
                DISHES_MONTH_URL,
                DISHES_WEEK_URL,
                BABY_FOODS_MONTH_URL,
                BABY_FOODS_WEEK_URL
            ),
            dayCellContent: createDayCellHeaderContent,
            eventContent: createDishNodes,
            dayCellDidMount(arg) {
                createCategoryBlocksInMenu(arg, initialCalendar);
                onClickMenuEditLink(arg);
            },
            eventDidMount(arg) {
                setCategoryBlocksInMenu(arg);
            },
        });

        calendar.render();

        updateActiveCustomButton(
            DISHES_MONTH_URL,
            DISHES_WEEK_URL,
            BABY_FOODS_MONTH_URL,
            BABY_FOODS_WEEK_URL
        );
        initResponsiveMonthCalendar(currentUrl,DISHES_MONTH_URL, BABY_FOODS_MONTH_URL);
    });
}
