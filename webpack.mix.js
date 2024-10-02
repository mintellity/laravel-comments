const mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'dist/css')
    .setPublicPath('dist');
