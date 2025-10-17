import monthMenuSvg from "../../svg/monthMenuSvg";
import weekMenuSvg from "../../svg/weekMenuSvg";
import dishesMenusSvg from "../../svg/dishesMenusSvg";
import babyfoodsMenusSvg from "../../svg/babyfoodsMenusSvg";
export default function calendarActiveButton(
    dishesMonthUrl,
    dishesWeekUrl,
    babyfoodsMonthUrl,
    babyfoodsWeekUrl
) {
    const currentUrl =
        window.location.origin +
        window.location.pathname +
        window.location.search;
    const monthBtn = document.querySelector(".fc-monthButton-button");
    const weekBtn = document.querySelector(".fc-weekButton-button");
    const dishesBtn = document.querySelector(".fc-dishesButton-button");
    const babyfoodsBtn = document.querySelector(".fc-babyfoodsButton-button");
    if (currentUrl === dishesMonthUrl || currentUrl === babyfoodsMonthUrl) {
        monthBtn.innerHTML = monthMenuSvg(true);
        monthBtn.classList.add("active");
    } else {
        monthBtn.innerHTML = monthMenuSvg(false);
        monthBtn.classList.remove("active");
    }
    if (currentUrl === dishesWeekUrl || currentUrl === babyfoodsWeekUrl) {
        weekBtn.innerHTML = weekMenuSvg(true);
        weekBtn.classList.add("active");
    } else {
        weekBtn.innerHTML = weekMenuSvg(false);
        weekBtn.classList.remove("active");
    }
    if (currentUrl === dishesMonthUrl || currentUrl === dishesWeekUrl) {
        dishesBtn.innerHTML=dishesMenusSvg(true);
        dishesBtn.classList.add("active");
    } else {
        dishesBtn.innerHTML=dishesMenusSvg(false);
        dishesBtn.classList.remove("active");
    }
    if (currentUrl === babyfoodsMonthUrl || currentUrl === babyfoodsWeekUrl) {
        babyfoodsBtn.innerHTML=babyfoodsMenusSvg(true);
        babyfoodsBtn.classList.add("active");
    } else {
        babyfoodsBtn.innerHTML=babyfoodsMenusSvg(false);
        babyfoodsBtn.classList.remove("active");
    }
}
