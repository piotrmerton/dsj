/* https://webpack.js.org/configuration/ */
const path = require('path');

/*
 *	additional, standard plugins:
 *
 *	For extracting CSS out of JS: 
 *	https://github.com/webpack-contrib/mini-css-extract-plugin
 */
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

/*
 *	For optmizing CSS:
 *	https://github.com/NMFR/optimize-css-assets-webpack-plugin
 */
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

const config = {
    entry: {
        'global.bundle' : './js/global.js',	
    },
    output: {
        path: path.resolve(__dirname, '../public/js'),
        filename: '[name].js'
    },
    module: {
        rules: [
            { 
                test: /\.(js|jsx)$/,
                //exclude: /(node_modules)/,
                exclude: [
                    path.resolve(__dirname, 'node_modules'), 
                    path.resolve(__dirname, 'webpack')
                ],            
                use: [
                    {
                        // https://github.com/babel/babel-loader
                        loader: "babel-loader",	                    
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                ] 
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options : {
                            publicPath: '../public/',
                            sourceMap : true,
                        }						
                    },
                    {
                        loader: 'css-loader',
                        options : {
                            url : false,
                            sourceMap : true,							
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options : {
                            sourceMap : true,
                        }
                    },
                ],
            },							
        ]
    },

    devtool: "source-map", //development only?
    resolve: {
        extensions: ['*', '.js', '.jsx']
    },  
    plugins: [

        new MiniCssExtractPlugin({
            // Options similar to the same options in webpackOptions.output
            // both options are optional
            filename: "../css/[name].css",
            chunkFilename: "../css/[name].css"
        }),
        new OptimizeCSSAssetsPlugin({
            cssProcessorOptions: {
                map: {
                    inline: false,
                    annotation: true,
                }
            }
        }),
    ]
};

module.exports = config;
