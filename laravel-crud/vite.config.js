import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/style.css', // Jouw game CSS
                'resources/js/game.js'     // Jouw game JS
            ],
            refresh: true,
        }),
    ],
});