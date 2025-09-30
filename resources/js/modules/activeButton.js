export default function activeButton() {
    window.addEventListener("DOMContentLoaded", function () {
        // 左メニューのアクティブリンク設定
        const currentUrl = window.location.pathname + window.location.search;
        const menuLinks = document.querySelectorAll("#js-left-menu a");
        const menuBtn = menuLinks[0];
        const dishBtn = menuLinks[1];
        if (currentUrl === "/menus/month" || currentUrl === "/menus/week") {
            menuBtn.classList.remove("text-main");
            menuBtn.classList.add("text-subtext", "bg-main", "rounded-lg");
            dishBtn.classList.remove("text-subtext", "bg-main", "rounded-lg");
            dishBtn.classList.add("text-main");
        } else if (currentUrl === "/dishes") {
            dishBtn.classList.remove("text-main");
            dishBtn.classList.add("text-subtext", "bg-main", "rounded-lg");
            menuBtn.classList.remove("text-subtext", "bg-main", "rounded-lg");
            menuBtn.classList.add("text-main");
        }

        // カスタムボタンのactive状態を切り替え
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
            monthBtn.classList.add("active");
        }
        if (
            weekBtn &&
            weekUrl &&
            currentUrl ===
                new URL(weekUrl, window.location.origin).pathname +
                    new URL(weekUrl, window.location.origin).search
        ) {
            weekBtn.classList.add("active");
        }
    });
}
