const { activatePlugin } = require( '@wordpress/e2e-test-utils' );
const { dirname, basename } = require( 'path' );

const slug = basename( dirname( __dirname ) );

beforeAll( async () => {
	await activatePlugin( slug );
} );
