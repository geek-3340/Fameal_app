export const customButtons = ({
    currentUrl,
    babyfoodsMonthUrl,
    babyfoodsWeekUrl,
    dishesMonthUrl,
    dishesWeekUrl,
}) => {
    return {
        dishesButton: {
            click: function () {
                if (currentUrl === babyfoodsMonthUrl) {
                    window.location.href = dishesMonthUrl;
                } else if (currentUrl === babyfoodsWeekUrl) {
                    window.location.href = dishesWeekUrl;
                }
            },
        },
        babyfoodsButton: {
            click: function () {
                if (currentUrl === dishesMonthUrl) {
                    window.location.href = babyfoodsMonthUrl;
                } else if (currentUrl === dishesWeekUrl) {
                    window.location.href = babyfoodsWeekUrl;
                }
            },
        },
        monthButton: {
            click: function () {
                if (currentUrl === dishesWeekUrl) {
                    window.location.href = dishesMonthUrl;
                } else if (currentUrl === babyfoodsWeekUrl) {
                    window.location.href = babyfoodsMonthUrl;
                }
            },
        },
        weekButton: {
            click: function () {
                if (currentUrl === dishesMonthUrl) {
                    window.location.href = dishesWeekUrl;
                } else if (currentUrl === babyfoodsMonthUrl) {
                    window.location.href = babyfoodsWeekUrl;
                }
            },
        },
    };
}

export const dayCellHeaderContents = () => {

}

export const menusEditModalLinkClickHandler = () => {

}

export const eventContentsInDomNodes = () => {

}

export const menusCategoryBlockContents = () => {

}

export const menusCategoryBlockDisplayControll = () => {

}

