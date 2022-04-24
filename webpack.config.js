const baseConfig = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = {
	...baseConfig,
	entry: {
		frontend: './js/frontend.js',
		register: './js/register.js',
	},
};
