import monthMenuSvg from "./svg/monthMenuSvg";
import weekMenuSvg from "./svg/weekMenuSvg";
export default function monthOrWeek() {
    window.addEventListener("DOMContentLoaded", function () {
        const currentUrl = window.location.pathname + window.location.search;
        const monthUrl = document.getElementById("calendar").dataset.monthUrl;
        const weekUrl = document.getElementById("calendar").dataset.weekUrl;
        const monthBtn = document.querySelector(".fc-monthButton-button");
        const weekBtn = document.querySelector(".fc-weekButton-button");

        if (
            monthBtn &&
            monthUrl &&
            currentUrl ===
                new URL(monthUrl, window.location.origin).pathname +
                    new URL(monthUrl, window.location.origin).search
        ) {
            monthBtn.innerHTML = monthMenuSvg(true);
            monthBtn.classList.add("active");
        } else {
            monthBtn.innerHTML = monthMenuSvg(false);
            monthBtn.classList.remove("active");
        }
        if (
            weekBtn &&
            weekUrl &&
            currentUrl ===
                new URL(weekUrl, window.location.origin).pathname +
                    new URL(weekUrl, window.location.origin).search
        ) {
            weekBtn.innerHTML = weekMenuSvg(true);
            weekBtn.classList.add("active");
        } else {
            weekBtn.innerHTML = weekMenuSvg(false);
            weekBtn.classList.remove("active");
        }
    });
}
