export default function () {
    if (window.matchMedia("(max-width: 767px)").matches) {
        return "dishesButton,babyFoodsButton,monthButton,weekButton";
    } else if (window.matchMedia("(min-width:768px)").matches) {
        return "dishesButton,monthButton,babyFoodsButton,weekButton";
    }
}
