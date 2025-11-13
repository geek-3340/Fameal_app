import "./bootstrap";
import Alpine from "alpinejs";
import fullCalendar from "./fullcalendar/fullcalendar";
import updateActiveNavButton from "./modules/updateActiveNavButton";
import toggleCheckedShoppingListItems from "./modules/toggleCheckedShoppingListItems";
import onClickDishEditLinks from "./modules/onClickDishEditLinks";
import submitMenusDishesStoreForm from "./modules/submitMenusDishesStoreForm";
import submitMenusDishesDeleteForm from "./modules/submitMenusDishesDeleteForm";
import setShoppingListFormContents from "./modules/setShoppingListFormContents";
import submitIngredientsStoreForm from "./modules/submitIngredientsStoreForm";
import submitIngredientsDeleteForm from "./modules/submitIngredientsDeleteForm";

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// FullCalendar
fullCalendar();

updateActiveNavButton();

submitMenusDishesStoreForm();

submitMenusDishesDeleteForm();

onClickDishEditLinks();

submitIngredientsStoreForm();

submitIngredientsDeleteForm();

setShoppingListFormContents();

toggleCheckedShoppingListItems();
