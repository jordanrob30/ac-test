// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'


export default defineConfig({
    plugins: [
        vue([
            'resources'
        ]),
        laravel([
            'resources/scss/custom.scss',
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
});