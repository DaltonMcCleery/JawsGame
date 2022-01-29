const mix = require('laravel-mix');

// All output files/directories will be placed in the `/public` directory
mix.setPublicPath('public');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'dist/js')
    .postCss('resources/css/app.css', 'dis/css', [
        require("tailwindcss"),
    ]);

if (mix.inProduction()) {
    // Minify and use polyfills in production
    mix.version();
    mix.sourceMaps();
}
