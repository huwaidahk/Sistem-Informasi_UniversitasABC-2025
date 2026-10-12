const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file to CSS and bundling up the JavaScript files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    // Baris ini mengkompilasi file SASS/SCSS Anda (resources/sass/app.scss)
    // dan menempatkan hasilnya di public/css/app.css.
    .sass('resources/sass/app.scss', 'public/css')
    
    // Opsi ini mencegah masalah pada URL aset (misalnya font) di CSS
    // yang sering terjadi saat mengimpor library seperti Bootstrap.
    .options({
        processCssUrls: false, 
    })
    
    // Baris ini opsional, hanya jika Anda ingin mendapatkan notifikasi
    // saat kompilasi berhasil (berguna saat menggunakan npm run watch).
    .version(); 

// Jalankan 'npm run dev' atau 'npm run prod' untuk mengkompilasi aset.