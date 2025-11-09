import axios from "axios";

export default function () {
    // 削除ボタンはAlpineによって生成されるため、動的に要素を取得する
    window.addEventListener("submit", async (e) => {
        const form = e.target.closest(".dish-and-baby-food-delete-form");
        if (!form) return;

        e.preventDefault(); // ← ページリロード防止

        try {
            const response = await axios.post(
                form.action, // Blade側の action="{{ route('menus.dishes.store') }}" をそのまま使える
                {
                    _method: "DELETE",
                }
            );

            // ✅ 成功したらカスタムイベントを発火
            window.dispatchEvent(
                new CustomEvent("menu-updated", {
                    detail: {
                        newCalendarDish: response.data.calendar,
                        newModalDish: response.data.modal, // サーバーが返した新規データ
                        selectedDate: response.data.date,
                    },
                })
            );

            // フォームをリセット
            form.reset();

            console.log("送信成功:", response.data);
            // ここでモーダルを閉じたり、画面を更新したりする処理を追加
        } catch (error) {
            console.error("送信エラー:", error.response?.data || error);
        }
    });
}
