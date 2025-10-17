import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./fullcalendar/fullcalendar";
import activeButton from "./modules/activeButton";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

// ナビメニューのアクティブスタイル設定
activeButton();
