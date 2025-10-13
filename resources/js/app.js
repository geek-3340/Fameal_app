import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./modules/fullcalendar";
import activeButton from "./modules/activeButton";
import monthOrWeek from "./modules/calendarActiveButton";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

// ナビメニューのアクティブスタイル設定
activeButton();


