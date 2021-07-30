/**
 * @type {import('@vue/cli-service').ProjectOptions}
 */
module.exports = {
    publicPath: process.env.NODE_ENV === "production" ? "/Muestra-TFG/" : "/",
    devServer: { // Environment configuration
        // host: '0.0.0.0',
        public: '192.168.121.25:8080',
        port: 8080,
        https: false,
        hotOnly: false,
        disableHostCheck: true,
        open: true // Configure to automatically start the browser

    },
};