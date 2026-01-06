import axios from "axios";

export default function () {
    function initAutocomplete(
        targetInputId, // 入力欄のID
        targetListId,  // 候補リストを表示するulのID
        apiUrl,        // 叩くAPIのURL
        minLength = 1  // 検索を開始する最小文字数
    ) {
        const inputElement = document.getElementById(targetInputId);
        const listElement = document.getElementById(targetListId);
        if (!inputElement || !listElement) return; // 要素がなければ終了

        let debounceTimer;

        // 入力イベント
        inputElement.addEventListener("input", (e) => {
            const keyword = e.target.value;

            listElement.classList.add("hidden");

            // 文字数チェック
            if (keyword.length < minLength) {
                return;
            }

            // デバウンス処理（入力が止まってから300ms後に通信）
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchSuggestions(keyword);
            }, 300);
        });

        // API通信と描画
        async function fetchSuggestions(keyword) {
            try {
                const response = await axios.get(apiUrl, {
                    params: { keyword: keyword },
                });

                const results = response.data;
                renderList(results);
                console.log("検索結果:", results);
            } catch (error) {
                console.error("検索エラー:", error);
            }
        }

        // リストの描画
        function renderList(items) {
            if (items.length === 0) {
                listElement.classList.add("hidden");
                return;
            }
            listElement.innerHTML = ""; // 既存のリストをクリア
            items.forEach((item) => {
                const li = document.createElement("li");
                li.textContent = item.name;
                li.classList.add("pl-4","cursor-pointer", "hover:bg-gray-200");

                // クリック時の動作：入力欄に値をセットしてリストを消す
                li.addEventListener("click", () => {
                    inputElement.value = item.name;
                    listElement.innerHTML = "";
                    listElement.classList.add("hidden");
                });
                listElement.appendChild(li);
            });

            listElement.classList.remove("hidden");
        }

        // 外部クリックでリストを閉じる
        document.addEventListener("click", (e) => {
            if (
                !inputElement.contains(e.target) &&
                !listElement.contains(e.target)
            ) {
                listElement.classList.add("hidden");
            }
        });
    }
    // --- 実行 ---


    // 1. 料理名 (3文字以上で発火)
    initAutocomplete("dish_name", "recipes-suggest-list", "/search/recipes", 3);
    initAutocomplete("babyfood_name", "babyfoods-suggest-list", "/search/babyfoods", 1);
    initAutocomplete("dish_name_edit", "recipes-edit_suggest-list", "/search/recipes", 3);
    initAutocomplete("ingredients_name", "ingredients-suggest-list", "/search/ingredients", 1);
}
