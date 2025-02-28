import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/home.css",
                "resources/css/show.css",
                "resources/css/testimonial-login.css",
                "resources/css/testimonial-register.css",
                "resources/css/testimonial.css",
                "resources/css/testimonial-show.css",
            ],
            refresh: true,
        }),
    ],
});
