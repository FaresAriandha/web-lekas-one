import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // server: {
    //     host: "192.168.1.48", // <- agar bisa diakses dari jaringan lain
    //     port: 5173, // <- default port vite
    //     strictPort: true,
    // },
});
