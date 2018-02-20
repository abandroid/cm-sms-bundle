let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('../src/Resources/public/build/')
    .setPublicPath('/bundles/endroidcmsms/build')
    .setManifestKeyPrefix('/build')
    .cleanupOutputBeforeBuild()
    .createSharedEntry('base', './js/base.js')
    .addEntry('dashboard', './js/dashboard.js')
    .autoProvidejQuery()
    .enableVueLoader()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();
