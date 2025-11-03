import axios from "axios";

export default function () {

    const $shoppingListsCheckbox = document.querySelectorAll('input[type="checkbox"]');

    $shoppingListsCheckbox.forEach(($checkbox) => {

        $checkbox.addEventListener("change", async (e) => {

            const target = e.target;
            const shoppingListId = target.dataset.id;
            const isChecked = target.checked;
            const $soppingListText = target.closest("li")?.querySelector("p");
            const $shoppingListItem = $soppingListText.parentElement;
            const $shoppingListsContainer = $shoppingListItem.parentElement;

            try {

                await axios.post(
                    `/shopping-list/${shoppingListId}/check-toggle`,
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
                    $soppingListText.classList.add("line-through", "text-gray-400");
                    $shoppingListsContainer.appendChild($shoppingListItem);
                } else {
                    $soppingListText.classList.remove("line-through", "text-gray-400");
                    $shoppingListsContainer.prepend($shoppingListItem);
                }

                console.log("Success");

            } catch (err) {

                console.error("error:" + err);

                target.checked = !isChecked;

                const prevChecked = $soppingListText.dataset.checked === "true";

                if (prevChecked) {
                    $soppingListText.classList.add("line-through", "text-gray-400");
                } else {
                    $soppingListText.classList.remove("line-through", "text-gray-400");
                }
                
            }
        });
    });
}
