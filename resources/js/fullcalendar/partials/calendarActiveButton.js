import monthMenuSvg from "../../svg/monthMenuSvg";
import weekMenuSvg from "../../svg/weekMenuSvg";
export default function calendarActiveButton(dishesMonthUrl, dishesWeekUrl) {
    const currentUrl = window.location.pathname + window.location.search;
    const dishesMonthBtn = document.querySelector(".fc-dishesMonthButton-button");
    const dishesWeekBtn = document.querySelector(".fc-dishesWeekButton-button");

    if (
        currentUrl ===
        new URL(dishesMonthUrl, window.location.origin).pathname +
            new URL(dishesMonthUrl, window.location.origin).search
    ) {
        dishesMonthBtn.innerHTML = monthMenuSvg(true);
        dishesMonthBtn.classList.add("active");
    } else {
        dishesMonthBtn.innerHTML = monthMenuSvg(false);
        dishesMonthBtn.classList.remove("active");
    }
    if (
        currentUrl ===
        new URL(dishesWeekUrl, window.location.origin).pathname +
            new URL(dishesWeekUrl, window.location.origin).search
    ) {
        dishesWeekBtn.innerHTML = weekMenuSvg(true);
        dishesWeekBtn.classList.add("active");
    } else {
        dishesWeekBtn.innerHTML = weekMenuSvg(false);
        dishesWeekBtn.classList.remove("active");
    }
}
