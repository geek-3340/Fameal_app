import axios from "axios";

export default function () {
    const $form = document.getElementById("dish-and-baby-food-form");

    if (!$form) return;

    $form.addEventListener("submit", async (e) => {
        e.preventDefault(); // ← ページリロード防止

        const formData = new FormData(e.target);

        try {
            const response = await axios.post(
                $form.action, // Blade側の action="{{ route('menus.dishes.store') }}" をそのまま使える
                formData,
                {
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        "Content-Type": "multipart/form-data",
                    },
                }
            );

            // ✅ 成功したらカスタムイベントを発火
            window.dispatchEvent(
                new CustomEvent("menu-updated", {
                    detail: {
                        newCalendarDish:response.data.calendar,
                        newModalDish: response.data.modal, // サーバーが返した新規データ
                    },
                })
            );

            // フォームをリセット
            $form.reset();

            console.log("送信成功:", response.data);
            // ここでモーダルを閉じたり、画面を更新したりする処理を追加
        } catch (error) {
            console.error("送信エラー:", error.response?.data || error);
        }
    });
}
