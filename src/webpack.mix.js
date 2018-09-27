const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

// это уменьшит избыточность использования ЦП и памяти с помощью команд npm run watch и npm run watch-poll докеров.
mix.webpackConfig({
    watchOptions: {
        ignored: /node_modules/
    }
});

mix.options({ processCssUrls: false });