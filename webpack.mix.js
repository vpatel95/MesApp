let mix = require('laravel-mix');
let webpack = require('webpack');
const dotenv = require('dotenv');

dotenv.config();

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .webpackConfig({
      plugins: [
         new webpack.DefinePlugin({
            "process.env": {
               PUSHER_APP_KEY: JSON.stringify(process.env.PUSHER_APP_KEY),
               PUSHER_APP_CLUSTER: JSON.stringify(process.env.PUSHER_APP_CLUSTER)
            }
         })
      ]
   });
