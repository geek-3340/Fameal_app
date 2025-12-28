export default function () {
    let currentDate = new Date();

    function formatJapaneseDate(date) {
        const y = date.getFullYear();
        const m = date.getMonth() + 1;
        const d = date.getDate();
        return `${y}年${m}月${d}日`;
    }

    function updateWeek() {
        const start = new Date(currentDate);
        start.setDate(start.getDate() - start.getDay()); // 日曜日
        const end = new Date(start);
        end.setDate(start.getDate() + 6);
        const startInput = document.getElementById("start");
        const endInput = document.getElementById("end");
        const weekDisplay = document.getElementById("weekDisplay");

        if (!startInput || !endInput || !weekDisplay) return;
        
        startInput.value = start.toISOString().split("T")[0];
        endInput.value = end.toISOString().split("T")[0];
        weekDisplay.textContent = `${formatJapaneseDate(
            start
        )}〜${formatJapaneseDate(end)}`;
    }

    document.getElementById("prevWeek")?.addEventListener("click", () => {
        currentDate.setDate(currentDate.getDate() - 7);
        updateWeek();
    });

    document.getElementById("nextWeek")?.addEventListener("click", () => {
        currentDate.setDate(currentDate.getDate() + 7);
        updateWeek();
    });

    updateWeek();
}
