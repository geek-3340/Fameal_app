import axios from "axios";

export default function () {
    const checkBoxes = document.querySelectorAll('input[type="checkbox"]');
    checkBoxes.forEach((checkBox) => {
        checkBox.addEventListener("change", async (e) => {
            const listItemId = e.target.dataset.id;
            const isChecked = e.target.checked;

            try {
                await axios.post(
                    `/shopping-list/${listItemId}/check-toggle`,
                    {
                        is_checked: isChecked,
                    },
                    {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                    }
                );
                console.log("Success");
            } catch (err) {
                console.error("error:" + err);
                e.target.checked = !isChecked; // 元の状態に戻す
            }
        });
    });
}
