import axios from "axios";

export default function () {
    const checkBoxes = document.querySelectorAll('input[type="checkbox"]');
    checkBoxes.forEach((checkBox) => {
        checkBox.addEventListener("change", async (e) => {
            const target = e.target;
            const listItemId = target.dataset.id;
            const isChecked = target.checked;
            const textEl = target.closest("li")?.querySelector("p");
            const listItem = textEl.parentElement;
            const listContainer = listItem.parentElement;
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
                if (isChecked) {
                    textEl.classList.add("line-through", "text-gray-400");
                    listContainer.appendChild(listItem);
                } else {
                    textEl.classList.remove("line-through", "text-gray-400");
                    listContainer.prepend(listItem);
                }
                console.log("Success");
            } catch (err) {
                console.error("error:" + err);
                target.checked = !isChecked;
                const prevChecked = textEl.dataset.checked === "true";
                if (prevChecked) {
                    textEl.classList.add("line-through", "text-gray-400");
                } else {
                    textEl.classList.remove("line-through", "text-gray-400");
                }
            }
        });
    });
}
