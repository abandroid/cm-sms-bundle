let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('src/Resources/public/build/')
    .setPublicPath('/bundles/endroidcmsms/build')
    .setManifestKeyPrefix('/build')
    .cleanupOutputBeforeBuild()
    .createSharedEntry('base', './src/Resources/public/src/js/base.js')
    .addEntry('dashboard', './src/Resources/public/src/js/dashboard.js')
    .autoProvidejQuery()
    .enableReactPreset()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();