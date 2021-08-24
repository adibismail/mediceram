const mix = require("laravel-mix");
const path = require("path");

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

mix
    .js("resources/js/app.js", "public/js")
    .js("resources/js/misc.js", "public/js")
    .js("resources/js/hoverable-collapse.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        //require("tailwindcss"),
        require("autoprefixer")
    ])
    .extract(['vue', 'vuetify'])
    .styles(["resources/css/style.css", "resources/css/custom.css", "resources/css/materialdesignicons.min.css"], "public/css/all.css")
    // .styles(["resources/css/custom.css", "resources/css/materialdesignicons.min.css"], "public/css/all.css")
    .sourceMaps()
    .webpackConfig({
        // output: { filename: "[name].[hash].bundle.js" },
        // output: { chunkFilename: "js/[name].js?id=[chunkhash]" },
        resolve: {
            alias: {
                //vue$: "vue/dist/vue.runtime.esm.js",
                "@": path.resolve("resources/js"),
            }
        }
    })
    .vue();

// require('laravel-mix-bundle-analyzer');

// if (mix.isWatching()) {
//     mix.bundleAnalyzer();
// }
