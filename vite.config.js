import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/fullcalendar.css",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
    base: "https://fameal-app.fly.dev/", // 本番のHTTPS URLを指定
});
