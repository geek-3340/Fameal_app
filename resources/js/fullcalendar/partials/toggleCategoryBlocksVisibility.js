export default function toggleCategoryBlocksVisibility(arg) {
    const menuCategory = arg.event.extendedProps.category;
    const $dayEl = arg.el.closest(".fc-daygrid-day");
    const $menuCategoryBlock = $dayEl.querySelector(".menu-category-block");
    if (!$menuCategoryBlock) return;
    const menuCategoryMap = {
        朝食: ".break-first",
        昼食: ".lunch",
        夕食: ".dinner",
    };
    const setClassName = menuCategoryMap[menuCategory];
    if (!setClassName) return;
    // 全category対応のborderを描画するためにforEachで回す
    const $menuBlock = $menuCategoryBlock.querySelectorAll(setClassName);
    $menuBlock.forEach((mb) => {
        const $dishBlock = mb.querySelector("div");
        mb.classList.remove("hidden");
        if ($dishBlock) $dishBlock.appendChild(arg.el);
    });
}