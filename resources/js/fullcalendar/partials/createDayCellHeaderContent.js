import modalLinkSvg from "../../svg/modalLinkSvg";

export default function (arg) {
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

function dateFormat(date) {
    return date.toLocaleDateString("ja-JP", {
        weekday: "short",
        month: "short",
        day: "numeric",
    });
}