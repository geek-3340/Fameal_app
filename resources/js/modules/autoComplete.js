import axios from "axios";

export default function () {
    window.addEventListener("DOMContentLoaded", () => {
        initAutoComplete();
    });
}

function initAutoComplete() {
    const input = document.getElementById("dish_name");
    console.log("input:", input);
    input.addEventListener("input", async (e) => {
        const keyword = e.target.value;
        try {
            const response = await axios.get("/search/recipes", {
                params: { keyword: keyword },
            });
            console.log(response.data);
        } catch (error) {
            console.error("データ取得エラー：", error);
        }
    });
}
