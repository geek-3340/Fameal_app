import axios from "axios";

export default function () {

    const $dishEditLinks = document.querySelectorAll(".open-dish-modal");

    $dishEditLinks.forEach(($dishEditLink) => {

        $dishEditLink.addEventListener("click", async (e) => {

            e.preventDefault();

            const dishId = $dishEditLink.dataset.dishId;

            try {

                const response = await axios.get(`/dishes/${dishId}`);

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
