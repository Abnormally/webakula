const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js/lapp.js')
    .sass('resources/assets/sass/app.scss', 'public/css/lapp.css')
    .scripts([
        'public/js/lapp.js',
        'resources/assets/js/csrf_ajax.js',
        'resources/assets/js/laroute.js',
        'resources/assets/js/noty.min.js',
        'resources/assets/js/validator.min.js',
        'resources/assets/js/guestbook.js'
    ], 'public/js/app.js')
    .scripts([
        'resources/assets/js/admin/badges.js',
        'resources/assets/js/admin/posts_crud.js'
    ], 'public/js/admin.js')
    .styles([
        'public/css/lapp.css',
        'resources/assets/css/font-awesome.min.css',
        'resources/assets/css/noty.css',
        'resources/assets/css/dl_fix.css',
    ], 'public/css/app.css')
;
