import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/filament/admin/theme.css",
            ],
            refresh: true,
            phpBinary: "C:/laragon/bin/php/php-8.3.30-Win32-vs16-x64/php.exe",
        }),
    ],
});
