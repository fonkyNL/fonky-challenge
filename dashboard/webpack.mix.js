const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .extract(['bootstrap'])
    .styles([
        'resources/css/app.css',
    ], 'public/css/app.css')
    .version();