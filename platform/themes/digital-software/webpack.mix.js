let mix = require('laravel-mix');

const resourcePath = 'platform/themes/digital-software';
const publicPath = 'public/themes/digital-software';

mix
    .sass(resourcePath + '/assets/sass/style.scss', publicPath + '/css')
    .copy(publicPath + '/css/style.css', resourcePath + '/public/css')
    .js(resourcePath + '/assets/js/app.js', publicPath + '/js')
    .copy(publicPath + '/js/app.js', resourcePath + '/public/js')
    .js(resourcePath + '/assets/js/components.js', publicPath + '/js')
    .copy(publicPath + '/js/components.js', resourcePath + '/public/js');
