import modalLinkSvg from "../../svg/modalLinkSvg";

export default function (arg) {
    if (window.matchMedia("(max-width: 767px)").matches) {
        if (arg.view.type === "dayGridMonth") {
            return {
                html: arg.date.getDate(),
            };
        } else if (arg.view.type === "dayGridWeek") {
            const formattedDate = dateFormat(arg.date);
            return {
                html: formattedDate,
            };
        }
    } else if (window.matchMedia("(min-width: 768px)").matches) {
        if (arg.view.type === "dayGridMonth") {
            return {
                html: arg.date.getDate() + `${modalLinkSvg()}`,
            };
        } else if (arg.view.type === "dayGridWeek") {
            const formattedDate = dateFormat(arg.date);
            return {
                html: formattedDate + ` ${modalLinkSvg()}`,
            };
        }
    }
}

function dateFormat(date) {
    return date.toLocaleDateString("ja-JP", {
        weekday: "short",
        month: "short",
        day: "numeric",
    });
}
