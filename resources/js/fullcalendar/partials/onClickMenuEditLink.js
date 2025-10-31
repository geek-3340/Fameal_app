export default function onClickMenuEditLink(arg) {
    const $menuEditLink = arg.el.querySelector(".menu-edit-link");
    if ($menuEditLink) {
        $menuEditLink.addEventListener("click", (e) => {
            e.preventDefault();
            const jstDate = jst(arg.date);
            const formattedDate = dateFormat(arg.date);
            window.dispatchEvent(
                new CustomEvent("open-menu-edit-modal", {
                    detail: { date: jstDate, formattedDate },
                })
            );
        });
    }
}

function dateFormat(date) {
    return date.toLocaleDateString("ja-JP", {
        weekday: "short",
        month: "short",
        day: "numeric",
    });
}
function jst(date) {
    return new Date(date.getTime() + 9 * 60 * 60 * 1000)
        .toISOString()
        .split("T")[0];
}