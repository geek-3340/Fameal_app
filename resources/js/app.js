import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./fullcalendar/fullcalendar";
import activeButton from "./modules/activeButton";
import checkBoxToggle from "./modules/checkBoxToggle";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

// ナビメニューのアクティブスタイル設定
activeButton();

// チェックボックスの状態を切り替え
checkBoxToggle();
