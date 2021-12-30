const { activatePlugin } = require( '@wordpress/e2e-test-utils' );

const slug = 'ribarich-directory-download-list-block';

beforeAll( async () => {
	await activatePlugin( slug );
} );
