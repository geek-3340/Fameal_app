import axios from "axios";

export default async function (arg) {
    const jstDate = jst(arg.date);
    const formattedDate = dateFormat(arg.date);
    const date = jstDate;
    try {
        const response = await axios.get(`/menus/${date}`);
        window.dispatchEvent(
            new CustomEvent("open-menu-edit-modal", {
                detail: {
                    dishesByDate: response.data.dishesByDate,
                    babyFoodsByDate: response.data.babyFoodsByDate,
                    date: jstDate,
                    formattedDate,
                },
            })
        );
    } catch (error) {
        console.error("データ取得エラー：", error);
    }
}

function dateFormat(date) {
    return date.toLocaleDateString("ja-JP", {
        weekday: "short",
        month: "short",
        day: "numeric",
    });
}
function jst(date) {
    return new Date(date.getTime() + 9 * 60 * 60 * 1000)
        .toISOString()
        .split("T")[0];
}
