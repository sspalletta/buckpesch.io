const webpack           = require('webpack');
const path              = require('path');
const config            = require('./config');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    entry  : './source/js/app.js',
    output : {
        path    : config.paths.dist,
        filename: 'bundle.js'
    },
    //watch: true, //live-reloading
    //devtool: 'source-map'
    module : {
        rules: [
            {
                test   : /\.scss$/,
                include: config.paths.assets,
                use    : ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use     : [
                        'css-loader',
                        'resolve-url-loader',
                        'sass-loader?sourceMap'
                    ]
                })
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin('style.css'),
        new webpack.ProvidePlugin({
            $              : 'jquery',
            jQuery         : 'jquery',
            'window.jQuery': 'jquery',
            Popper         : ['popper.js', 'default'],
            // In case you imported plugins individually, you must also require them here:
            //Util           : "exports-loader?Tooltip!bootstrap/js/dist/util",
            //Tooltip        : "exports-loader?Tooltip!bootstrap/js/dist/tooltip",
        })
    ]
};