var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    .addEntry('js/docs', './assets/js/docs.js')
    .addEntry('js/mail', './assets/js/mail.js')

    .addStyleEntry('css/docs', './assets/css/docs.scss')
    .addStyleEntry('css/mail', './assets/css/mail.scss')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    .enableSassLoader()

    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
