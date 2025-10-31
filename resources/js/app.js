import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./fullcalendar/fullcalendar";
import updateActiveNavButton from "./modules/updateActiveNavButton";
import axiosToggleCheckedShoppingListItems from "./modules/axiosToggleCheckedShoppingListItems";
import axiosOnClickDishEditLinks from "./modules/axiosOnClickDishEditLinks";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

updateActiveNavButton();

axiosToggleCheckedShoppingListItems();

axiosOnClickDishEditLinks();
