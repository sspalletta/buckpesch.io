// Initialize dependencies
const path  = require('path');
const merge = require('webpack-merge');
const argv  = require('minimist')(process.argv.slice(2));

// Initialize variables
const isProduction = !!((argv.env && argv.env.production) || argv.p || process.env.NODE_ENV === 'production');
const userConfig   = isProduction ? require('../config') : require('../config.json');
const rootPath     = (userConfig.paths && userConfig.paths.root)
    ? userConfig.paths.root
    : process.cwd();

// Merge and initialize config
const config = merge({
    paths  : {
        root  : rootPath,
        assets: path.resolve(rootPath, 'source', 'css'),
        js    : path.resolve(rootPath, 'source', 'js'),
        dist  : path.resolve(rootPath, 'public', 'dist')
    },
    enabled: {
        sourceMaps: !isProduction,
        optimize  : isProduction,
        watcher   : !!argv.watch,
        watch     : !!argv.w
    },
    watch  : []
}, userConfig);

// Export settings
module.exports = merge(config, {
    env     : Object.assign({production: isProduction, development: !isProduction, nodeEnv: process.env.NODE_ENV},
        argv.env),
    //publicPath: `${config.publicPath}/${path.basename(config.paths.dist)}/`,
    manifest: {}
});