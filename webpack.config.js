var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/docs', './assets/js/docs.js')
    .addEntry('js/mail', './assets/js/mail.js')

    .addStyleEntry('css/app', './assets/css/app.scss')
    .addStyleEntry('css/docs', './assets/css/docs.scss')
    .addStyleEntry('css/mail', './assets/css/mail.scss')

    // .enableSingleRuntimeChunk()
    .disableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())

    .enableSassLoader(function(options) {
      options.includePaths = [
        __dirname + '/node_modules/frameworkstylepackage/dist'
      ];
    })

    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
