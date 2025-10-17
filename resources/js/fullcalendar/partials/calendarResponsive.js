export default function calendarResponsive(dishesMonthUrl, babyfoodsMonthUrl) {
    function responsiveLayout() {
        const base = document.querySelector(".fc-view-harness");
        const headerHeight =
            document.querySelector(".fc-col-header").clientHeight;
        const bodyHeight =
            document.querySelector(".fc-daygrid-body").clientHeight;
        const calendarHeight = headerHeight + bodyHeight;
        base.style.setProperty(
            "min-height",
            `${calendarHeight}px`,
            "important"
        );

        const topSpace = document.querySelector(".fc-daygrid-day-top");
        const topSpaceWidth = topSpace.clientWidth;
        const topSpaceHeight = topSpace.clientHeight;
        const eventSpaceMinHeight = topSpaceWidth - topSpaceHeight - 10;
        const eventSpaces = document.querySelectorAll(".fc-daygrid-day-events");
        eventSpaces.forEach((eventSpace) => {
            eventSpace.style.setProperty(
                "min-height",
                `${eventSpaceMinHeight}px`,
                "important"
            );
        });
    }

    const currentUrl =
        window.location.origin +
        window.location.pathname +
        window.location.search;
    if (currentUrl === dishesMonthUrl || currentUrl === babyfoodsMonthUrl) {
        responsiveLayout();
        
        window.addEventListener("resize", () => {
            setTimeout(() => {
                responsiveLayout();
            }, 200);
        });
                
        // MutationObserverを設定
        const observer = new MutationObserver(() => {
            responsiveLayout();
        });
        // 監視対象のノードとオプションを指定
        const calendarRoot = document.querySelector(".fc-daygrid");
        if (calendarRoot) {
            observer.observe(calendarRoot, {
                childList: true, // 子ノードの追加や削除を監視
                subtree: true, // 子孫ノードも監視
            });
        }
    }
}
