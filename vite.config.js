// vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Penting: Arahkan input ke file SASS Anda
            input: ['resources/sass/app.scss', 'resources/js/app.js'], 
            refresh: true,
        }),
        // Catatan: Jika Anda sebelumnya punya 'tailwindcss', pastikan baris itu dihapus
    ],
    // Konfigurasi tambahan untuk SCSS/Sass (opsional, tapi membantu)
    css: {
        preprocessorOptions: {
            scss: {
                // Di sini Anda bisa mengimpor file variabel kustom
                // Atau biarkan kosong jika Anda menaruh semua variabel di app.scss
            }
        }
    }
});