import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/quill-editor.css",
                "resources/js/app.js",
                "resources/js/quill-editor.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        https: true,
        host: "0.0.0.0",
        port: 5173,
        hmr: {
            host: "large-candies-wonder.loca.lt",  // Replace with your current Vite tunnel URL (e.g., https://93c84f84e5c9.ngrok-free.app)
        },
        allowedHosts: [".ngrok-free.app", ".ngrok.io"],  // Allow ngrok domains
    },
});
