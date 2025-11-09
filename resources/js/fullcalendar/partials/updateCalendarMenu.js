export default (calendar) => {
    window.calendar = calendar;
    window.addEventListener("menu-updated", (e) => {
        if (!window.calendar) return;
        document.querySelectorAll(".fc-event").forEach((dish) => dish.remove());
        // 該当日のイベントを削除
        window.calendar.removeAllEvents();
        const newEvents = e.detail.newCalendarDish;
        newEvents.forEach((dish) => {
            window.calendar.addEvent({
                id: dish.id,
                title: dish.title,
                start: dish.start,
                backgroundColor: dish.backgroundColor,
                displayOrder: dish.displayOrder,
                extendedProps: { category: dish.category },
            });
        });
        const selectedDate = e.detail.selectedDate;
        // FullCalendar の日付セルを全て取得
        const dayCells = window.calendar.el.querySelectorAll(
            ".fc-daygrid-day[data-date]"
        );

        // 指定日のセルを探す
        const targetCell = Array.from(dayCells).find(
            (cell) => cell.dataset.date === selectedDate
        );

        // targetCell 内から .lunch クラスを持つ要素を取得
        const breakFirstEL = targetCell.querySelector(".break-first");
        const lunchEL = targetCell.querySelector(".lunch");
        const dinnerEL = targetCell.querySelector(".dinner");

        const eventsByDate = window.calendar
            .getEvents()
            .filter(
                (event) =>
                    new Date(event.start.getTime() + 9 * 60 * 60 * 1000)
                        .toISOString()
                        .split("T")[0] === selectedDate
            );

        const meals = [
            { category: "朝食", el: breakFirstEL },
            { category: "昼食", el: lunchEL },
            { category: "夕食", el: dinnerEL },
        ];

        meals.forEach(({ category, el }) => {
            if (
                !eventsByDate.some(
                    (event) => event.extendedProps.category === category
                )
            ) {
                el.classList.add("hidden");
            } else {
                el.classList.remove("hidden");
            }
        });
    });
};
