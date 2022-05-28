import { render } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Ddlb from './block';

domReady( () => {
	const root = document.querySelector( '.ddlb-root' );
	if ( root ) {
		const attributes = { ...root.dataset };
		render( <Ddlb { ...attributes } />, root );
	}
} );
