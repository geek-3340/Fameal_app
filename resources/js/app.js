import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./fullcalendar/fullcalendar";
import activeButton from "./modules/activeButton";
import checkBoxToggle from "./modules/checkBoxToggle";
import dishModal from "./modules/dishModal";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

// ナビメニューのアクティブスタイル設定
activeButton();

// チェックボックスの状態を切り替え
checkBoxToggle();

// 料理編集モーダル処理
dishModal();
