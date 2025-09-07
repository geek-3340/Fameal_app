import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Noto Sans JP", ...defaultTheme.fontFamily.sans],
                monoton: ["Monoton", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                main: "#f89900",
                bg: "#ffffff",
                filter: "#ffc870",
                text: "#3d3d3d",
                subtext: "#ffffff",
                graytext: "#9f9f9f",
                link: "#0022ff",
            },
            boxShadow: {
                custom: "0 0 8px 2px rgba(0,0,0,0.15)",
            },
        },
    },

    plugins: [forms],
};
