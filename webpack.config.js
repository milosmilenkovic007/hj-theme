const path = require('path');

module.exports = {
	entry: './assets/js/main.js',
	output: {
		filename: 'main.js',
		path: path.resolve(__dirname, 'assets/js'),
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env']
					}
				}
			},
			{
				test: /\.scss$/,
				use: [
					'style-loader',
					'css-loader',
					'sass-loader'
				]
			}
		]
	},
	devtool: 'source-map',
	mode: 'development'
};
