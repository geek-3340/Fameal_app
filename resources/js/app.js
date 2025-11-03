import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./fullcalendar/fullcalendar";
import updateActiveNavButton from "./modules/updateActiveNavButton";
import toggleCheckedShoppingListItems from "./modules/toggleCheckedShoppingListItems";
import onClickDishEditLinks from "./modules/onClickDishEditLinks";
import submitDishAndBabyFoodForm from "./modules/submitDishAndBabyFoodForm";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

updateActiveNavButton();

submitDishAndBabyFoodForm();

onClickDishEditLinks();

toggleCheckedShoppingListItems();
