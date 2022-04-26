const compiler = require('laravel-mix');

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

// Конфигурация "Webpack"
compiler
    .version()
    .options({

        // Отключение генерации файла "*.js.LICENSE.txt"
        terser: {
            extractComments: false,
        },

        // Перенос ресурсов из папки "node_modules"
        processCssUrls: true,
        fileLoaderDirs: {
            fonts: 'assets/fonts',
            images: 'assets/media'
        }
    });

// Компиляция ресурсов
compiler
    .js('resources/assets/scripts/app.js', 'public/assets/scripts')
    .sass('resources/assets/styles/app.scss', 'public/assets/styles')
    .copy('resources/assets/media', 'public/assets/media');
