export default function activeButton() {
    window.addEventListener("DOMContentLoaded", function () {
        const currentPage = window.location.pathname.split("/")[1];
        const menuLinks = document.querySelectorAll("#js-left-menu a");
        const menuBtn = menuLinks[0];
        const dishesBtn = menuLinks[1];
        const babyfoodsBtn = menuLinks[2];
        const shoppingListBtn = menuLinks[3];
        if (currentPage === "menus") {
            menuBtn.classList.remove("text-main");
            menuBtn.classList.add("text-white", "bg-main", "rounded-lg");
        } else if (currentUrl === "/dishes") {
            dishesBtn.classList.remove("text-main");
            dishesBtn.classList.add("text-white", "bg-main", "rounded-lg");
        } else if (currentUrl === "/babyfoods") {
            babyfoodsBtn.classList.remove("text-main");
            babyfoodsBtn.classList.add("text-white", "bg-main", "rounded-lg");
        } else if (currentUrl === "/shopping-list") {
            shoppingListBtn.classList.remove("text-main");
            shoppingListBtn.classList.add(
                "text-white",
                "bg-main",
                "rounded-lg"
            );
        }
    });
}
