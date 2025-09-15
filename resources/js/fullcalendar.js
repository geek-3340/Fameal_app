export default function fullCalendar() {
    document.addEventListener("DOMContentLoaded", function () {
        const calendarEl = document.getElementById("calendar");
        const initialView = calendarEl.dataset.initialView || "dayGridMonth";
        const monthUrl = calendarEl.dataset.monthUrl;
        const weekUrl = calendarEl.dataset.weekUrl;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            // plugins: [dayGridPlugin], ←CDNで読み込む場合は不要
            initialView: initialView,
            locale: "ja",
            dayCellContent: function (arg) {
                return { html: arg.date.getDate() }; // 日付から「日」を消す
            },
            dayCellDidMount: function (arg) {
                const svg=document.createElement("svg");
                const g=document.createElement("g");
                const g2=document.createElement("g");
                const g3=document.createElement("g");
                const path=document.createElement("path");

                svg.setAttribute("xmlns","http://www.w3.org/2000/svg");
                svg.setAttribute("fill","#3d3d3d");
                svg.setAttribute("viewBox","0 0 24 24");
                svg.setAttribute("stroke","#3d3d3d");
                svg.classList.add("w-5","h-5");
                g.setAttribute("id","SVGRepo_bgCarrier");
                g.setAttribute("stroke-width","0");
                g2.setAttribute("id","SVGRepo_tracerCarrier");
                g2.setAttribute("stroke-linecap","round");
                g2.setAttribute("stroke-linejoin","round");
                g3.setAttribute("id","SVGRepo_iconCarrier");
                path.setAttribute("stroke","#3d3d3d");
                path.setAttribute("stroke-width","2");
                path.setAttribute("stroke-linecap","round");
                path.setAttribute("stroke-linejoin","round");
                path.setAttribute("d","M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575");

                svg.appendChild(g);
                svg.appendChild(g2);
                svg.appendChild(g3);
                g3.appendChild(path);
                
                const link = document.createElement("a");
                link.href = `#`;
                link.classList.add(
                    "text-text",
                    "decoration-none",
                );

                link.appendChild(svg);
                arg.el.querySelector(".fc-daygrid-day-top").appendChild(link);
            },
            // buttonText: {
            //     month: "月表示",
            //     week: "週表示",
            // },
            headerToolbar: {
                left: "title,prev,next",
                right: "monthButton,weekButton", // 月・週切り替えボタン
            },
            customButtons: {
                monthButton: {
                    text: "月表示",
                    click: function () {
                        window.location.href = monthUrl;
                    },
                },
                weekButton: {
                    text: "週表示",
                    click: function () {
                        window.location.href = weekUrl;
                    },
                },
            },
        });

        calendar.render();
    });
}
