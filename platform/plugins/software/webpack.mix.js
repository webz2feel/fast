let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/software';
const resourcePath = './platform/plugins/software';

mix
    .js(resourcePath + '/resources/assets/js/software.js', publicPath + '/js')
    .copy(publicPath + '/js/software.js', resourcePath + '/public/js');
