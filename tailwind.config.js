import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    safelist: [
        "text-main",
        "text-customRed",
        "text-customGreen",
        "hover:text-main",
        "hover:text-customRed",
        "hover:text-customGreen",
        "hover:text-gray-400",
        "border-main",
        "border-customRed",
        "border-customGreen",
        "border-gray-400",
        "peer-checked:bg-main",
        "peer-checked:bg-customRed",
        "peer-checked:bg-customGreen",
        "peer-checked:bg-gray-400",
        "max-md:w-1/3",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Noto Sans JP", ...defaultTheme.fontFamily.sans],
                monoton: ["Monoton", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                main: "#ffb700",
                sub: "#ffcf55",
                accent: "#00e65c",
                button: {
                    primary: "#ffb700",
                    primaryhover: "#ffa000",
                    secondary: "#00e65c",
                    secondaryhover: "#00c74a",
                    danger: "#e54c4c",
                    dangerhover: "#d43c3c",
                },
                customRed: "#ff7d55",
                customGreen: "#91ff00",
                text: "#3d3d3d",
                graytext: "#9f9f9f",
                link: "#0022ff",
            },
            boxShadow: {
                custom: "0 0 4px 2px rgba(0,0,0,0.15)",
            },
        },
    },

    plugins: [forms],
};
