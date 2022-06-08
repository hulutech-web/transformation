const mix = require("laravel-mix");
const BundleAnalyzerPlugin =
    require("webpack-bundle-analyzer").BundleAnalyzerPlugin;
/**
 * 前端编译
 */
// mix.js('vue/app.js', 'public/dist')
//     .vue()
//     .postCss('vue/css/app.css', 'public/dist', [require('postcss-import'), require('autoprefixer')])
//     .webpackConfig(require('./webpack.config'))
//     .extract(['vue', 'vuex', 'lodash', 'vue-router',  'dayjs'])
/*
 * 后端编译
 */
mix.js("admin/main.js", "public/admin/dist")
    .vue()
    .postCss("admin/css/main.css", "public/admin/dist", [
        require("postcss-import"),
        require("autoprefixer"),
    ])
    .webpackConfig(require("./webpack.config"))
    // .webpackConfig({
    //     plugins: [new BundleAnalyzerPlugin()]
    // })
    .extract([
        "vuex",
        "docx-preview",
        "echarts",
        "nprogress",
        "lodash",
        'three',
        'vanta',
        "vue-router",
        "moment",
        "mammoth",
        "echarts",
        "v-charts",
        "vue-esign",
        "vue-cropper",
        "vue",
    ]);

// mix.browserSync({
//     proxy: 'laravel.test',
//     files: 'admin/**'
// })
