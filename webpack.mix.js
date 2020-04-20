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
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/fonts', 'public/fonts');

 mix.browserSync({
   proxy: 'http://dev-teajudo.me/',
   port: '3001'
 });

let src_path = 'resources/js/';

mix.webpackConfig({
  resolve: {
    alias: {
      '@src': path.resolve(__dirname, src_path),
      '@store': path.resolve(__dirname, src_path + 'store/'),
      '@views': path.resolve(__dirname, src_path + 'views/'),
      '@components': path.resolve(__dirname, src_path + 'components/'),
      '@modules': path.resolve(__dirname, src_path + 'modules/'),
    }
  },
  node: {
     fs: "empty"
  }
});
