import { useEffect } from '@wordpress/element';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import apiFetch from '@wordpress/api-fetch';

export default function HelloWorld() {
	useEffect( () => {
		console.log( 'Hello! In effect now' );
		const params = new URLSearchParams( [
			[ 'directory', '/var/www/html/wp-content/test' ],
		] );
		apiFetch( { path: `/ribarich/v1/ddlb?${ params.toString() }` } )
			.then( ( data ) => {
				console.log( 'Data is data.', data );
			} )
			.catch( ( err ) => {
				console.log( 'An error occurred.', err );
			} );
	} );
	return (
		<div className="ddlb-container">
			<List>
				<ListItem>
					<ListItemText primary="Hello!" />
				</ListItem>
				<ListItem>
					<ListItemText primary="How you doing? And how is your son? And mom?" />
				</ListItem>
			</List>
		</div>
	);
}
