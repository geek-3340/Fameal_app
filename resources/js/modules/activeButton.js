export default function activeButton() {
    window.addEventListener("DOMContentLoaded", function () {
        const currentUrl = window.location.pathname + window.location.search;
        const menuLinks = document.querySelectorAll("#js-left-menu a");
        const menuBtn = menuLinks[0];
        const dishBtn = menuLinks[1];
        if (currentUrl === "/menus/month" || currentUrl === "/menus/week") {
            menuBtn.classList.remove("text-main");
            menuBtn.classList.add("text-white", "bg-main", "rounded-lg");
            dishBtn.classList.remove("text-white", "bg-main", "rounded-lg");
            dishBtn.classList.add("text-main");
        } else if (currentUrl === "/dishes") {
            dishBtn.classList.remove("text-main");
            dishBtn.classList.add("text-white", "bg-main", "rounded-lg");
            menuBtn.classList.remove("text-white", "bg-main", "rounded-lg");
            menuBtn.classList.add("text-main");
        }
    });
}
