const path = require('path')
module.exports = {
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'vue'),
            '#': path.resolve(__dirname, 'admin'),
            'stream': "stream-browserify",
        },
        fallback: {"path": require.resolve("path-browserify")}
    },
    // 设置代理
    devServer: {
        proxy: {
            '/api': {
                target: 'http://192.168.2.82:3000/api',
                changeOrigin: true,
                pathRewrite: {
                    '^/api': ''
                }
            }
        }
    }
}
