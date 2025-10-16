export default function calendarResponsive() {
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

    if (
        window.location.pathname ===
        ("/menus/dishes-month" || "/menus/babyfoods-month")
    ) {
        responsiveLayout();
        window.addEventListener("resize", () => {
            setTimeout(() => {
                responsiveLayout();
            }, 200);
        });
    }
}
