import monthMenuSvg from "../../svg/monthMenuSvg";
import weekMenuSvg from "../../svg/weekMenuSvg";
import dishesMenusSvg from "../../svg/dishesMenusSvg";
import babyFoodsMenusSvg from "../../svg/babyFoodsMenusSvg";
export default function (
    dishesMonthUrl,
    dishesWeekUrl,
    babyFoodsMonthUrl,
    babyFoodsWeekUrl
) {
    const currentUrl =
        window.location.origin +
        window.location.pathname +
        window.location.search;
    const $monthBtn = document.querySelector(".fc-monthButton-button");
    const $weekBtn = document.querySelector(".fc-weekButton-button");
    const $dishesBtn = document.querySelector(".fc-dishesButton-button");
    const $babyFoodsBtn = document.querySelector(".fc-babyFoodsButton-button");
    if (currentUrl === dishesMonthUrl || currentUrl === babyFoodsMonthUrl) {
        $monthBtn.innerHTML = monthMenuSvg(true);
        $monthBtn.classList.add("active");
    } else {
        $monthBtn.innerHTML = monthMenuSvg(false);
        $monthBtn.classList.remove("active");
    }
    if (currentUrl === dishesWeekUrl || currentUrl === babyFoodsWeekUrl) {
        $weekBtn.innerHTML = weekMenuSvg(true);
        $weekBtn.classList.add("active");
    } else {
        $weekBtn.innerHTML = weekMenuSvg(false);
        $weekBtn.classList.remove("active");
    }
    if (currentUrl === dishesMonthUrl || currentUrl === dishesWeekUrl) {
        $dishesBtn.innerHTML=dishesMenusSvg(true);
        $dishesBtn.classList.add("active");
    } else {
        $dishesBtn.innerHTML=dishesMenusSvg(false);
        $dishesBtn.classList.remove("active");
    }
    if (currentUrl === babyFoodsMonthUrl || currentUrl === babyFoodsWeekUrl) {
        $babyFoodsBtn.innerHTML=babyFoodsMenusSvg(true);
        $babyFoodsBtn.classList.add("active");
    } else {
        $babyFoodsBtn.innerHTML=babyFoodsMenusSvg(false);
        $babyFoodsBtn.classList.remove("active");
    }
}
