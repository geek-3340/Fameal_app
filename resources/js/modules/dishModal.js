import axios from "axios";

export default function dishModal() {
    const dishModalLinks = document.querySelectorAll(".open-dish-modal");
    dishModalLinks.forEach((link) => {
        link.addEventListener("click", async (e) => {
            e.preventDefault();
            const dishId = link.dataset.dishId;
            try {
                const response = await axios.get(`/dishes/${dishId}`);
                console.log(response);
                console.log(response.data);
                window.dispatchEvent(
                    new CustomEvent("open-dish-modal", {
                        detail: response.data,
                    })
                );
            } catch (error) {
                console.error("データ取得エラー：", error);
            }
        });
    });
}
