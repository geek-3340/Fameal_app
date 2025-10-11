import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./modules/fullcalendar";
import activeButton from "./modules/activeButton";
import monthOrWeek from "./modules/monthOrWeek";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

// ナビメニューのアクティブスタイル設定
activeButton();

// 月表示・週表示ボタンのアクティブスタイル設定
monthOrWeek();


