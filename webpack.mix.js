const mix = require('laravel-mix');
require('laravel-mix-polyfill');

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
    .sass('resources/css/app.scss', 'dist/css')
;

if (mix.inProduction()) {
    // Minify and use polyfills in production
    mix.version();
    mix.sourceMaps();
    mix.polyfill({
        enabled: true,
        useBuiltIns: 'usage',
        targets: {firefox: '50', ie: 11}
    });
}
