import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./modules/fullcalendar";
import activeButton from "./modules/activeButton";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

// 左メニューとカスタムボタンのアクティブリンク設定
activeButton();