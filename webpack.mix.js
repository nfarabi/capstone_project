const mix = require('laravel-mix');
let productionSourceMaps = false;

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

    // JAVASCRIPT
mix.js('resources/js/admin.js', 'public/js')
    .js('resources/js/app.js', 'public/js')

    // SCSS
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')

    // CSS
    .postCss('resources/css/shop.css', 'public/css', [])

    // COPY FILE
    .copy('node_modules/codemirror/lib/codemirror.js', 'public/js/vendor/codemirror')
    .copy('node_modules/codemirror/mode/xml/xml.js', 'public/js/vendor/codemirror/mode/xml')
    .copy('node_modules/codemirror/mode/css/css.js', 'public/js/vendor/codemirror/mode/css')
    .copy('node_modules/codemirror/mode/javascript/javascript.js', 'public/js/vendor/codemirror/mode/javascript')
    .copy('node_modules/codemirror/addon/display/autorefresh.js', 'public/js/vendor/codemirror/addon/display')
    .copy('node_modules/codemirror/addon/scroll/simplescrollbars.js', 'public/js/vendor/codemirror/addon/scroll')
    .copy('node_modules/codemirror/lib/codemirror.css', 'public/css/vendor/codemirror')
    .copy('node_modules/codemirror/theme/monokai.css', 'public/css/vendor/codemirror/theme')
    .copy('node_modules/codemirror/addon/scroll/simplescrollbars.css', 'public/css/vendor/codemirror/addon/scroll')
    .copy('node_modules/icheck-bootstrap/icheck-bootstrap.min.css', 'public/css/plugins/icheck-bootstrap')

    // COPY DIRECTORY
    .copyDirectory('resources/images', 'public/images')

    // CONFIGURATION CHANGES
    .sourceMaps(productionSourceMaps, 'source-map')
    .disableNotifications();
