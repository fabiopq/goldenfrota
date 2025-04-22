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


/* Images folder */
mix.copyDirectory('resources/images', 'public/images');

/* Bootstrap toogle */
mix.copy('node_modules/bootstrap-toggle/css/bootstrap-toggle.css', 'public/css/bootstrap-toggle.css');


mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/bs4navbar.js', 'public/js')
   .js('resources/js/entradaestoque.js', 'public/js')
   .js('resources/js/entradatanque.js', 'public/js')
   .js('resources/js/saidaestoque.js', 'public/js')
   .js('resources/js/inventarioestoque.js', 'public/js')
   .js('resources/js/estoqueproduto.js', 'public/js')
   .js('resources/js/osservico.js', 'public/js')
   .js('resources/js/os.js', 'public/js')
   .js('resources/js/dashboard.js', 'public/js')
   .js('resources/js/precocliente.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/report.scss', 'public/css')
   .sass('resources/sass/login.scss', 'public/css')
   .version();
  