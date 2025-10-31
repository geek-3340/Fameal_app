export default function createCustomButtons(
    currentUrl,
    dishesMonthUrl,
    dishesWeekUrl,
    babyFoodsMonthUrl,
    babyFoodsWeekUrl
) {
    return {
        dishesButton: {
            click: function () {
                if (currentUrl === babyFoodsMonthUrl) {
                    window.location.href = dishesMonthUrl;
                } else if (currentUrl === babyFoodsWeekUrl) {
                    window.location.href = dishesWeekUrl;
                }
            },
        },
        babyFoodsButton: {
            click: function () {
                if (currentUrl === dishesMonthUrl) {
                    window.location.href = babyFoodsMonthUrl;
                } else if (currentUrl === dishesWeekUrl) {
                    window.location.href = babyFoodsWeekUrl;
                }
            },
        },
        monthButton: {
            click: function () {
                if (currentUrl === dishesWeekUrl) {
                    window.location.href = dishesMonthUrl;
                } else if (currentUrl === babyFoodsWeekUrl) {
                    window.location.href = babyFoodsMonthUrl;
                }
            },
        },
        weekButton: {
            click: function () {
                if (currentUrl === dishesMonthUrl) {
                    window.location.href = dishesWeekUrl;
                } else if (currentUrl === babyFoodsMonthUrl) {
                    window.location.href = babyFoodsWeekUrl;
                }
            },
        },
    };
}