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
}
