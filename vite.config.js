import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/chatpage.css",
                "resources/css/home.css",
                "resources/css/loginpage.css",
                "resources/css/postcreate.css",
                "resources/css/public-chat.css",
                "resources/css/signupPage.css",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
