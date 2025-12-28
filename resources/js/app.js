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
import autoComplete from "./modules/autoComplete";

window.Alpine = Alpine;
Alpine.start();

// 以下、モジュールの並び順で実行がされないことがある
// 原因を調査中のため、一旦ここにまとめる

// 特定のページでのみ動作するモジュールもあり
// そういったモジュールは他のページが読み込まれた際にスルーされるように
// しなくてはならないかもしれないので注意

fullCalendar();

updateActiveNavButton();

submitMenusDishesStoreForm();

submitMenusDishesDeleteForm();

autoComplete();

onClickDishEditLinks();

submitIngredientsStoreForm();

submitIngredientsDeleteForm();

setShoppingListFormContents();

toggleCheckedShoppingListItems();
