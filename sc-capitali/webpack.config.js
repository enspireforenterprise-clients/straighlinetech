
const path        = require( 'path' );
const outputPath  = path.resolve( __dirname, 'dist/js' );
require("@babel/polyfill");
const entryPoints = { 
	'scripts': path.resolve( __dirname, 'source/scripts/app.js' )
};

const devConstructConfig = function ( entryPoints, outputPath )  {

	const config = {
		entry: entryPoints,
		output: {
			filename: '[name].js',
			path: outputPath
		},
		module: {
			rules: [
				{
					test: /\.js$/,
					use: {
						loader: 'babel-loader'
					},
					exclude: /node_modules/
				}
			]
		},
		plugins: [],
		devtool: 'eval-source-map',
		externals: {
			jquery: 'jQuery',
			fs: 'fs',
		},
		optimization: {
			minimize: false,
		}
	};

	return config;

};

const prodConstructConfig = function ( entryPoints, outputPath )  {

	const config = {
		entry: entryPoints,
		output: {
			filename: '[name].js',
			path: outputPath
		},
		module: {
			rules: [
				{
					test: /\.js$/,
					use: {
						loader: 'babel-loader',
					},
					exclude: /node_modules/
				}
			]
		},
		plugins: [],
		externals: {
			jquery: 'jQuery',
			fs: 'fs',
		},
	};

	return config;

};

module.exports = {
	devConstructor: devConstructConfig,
	prodConstructor: prodConstructConfig,
	entry: entryPoints,
	output: outputPath
};
