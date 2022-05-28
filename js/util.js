import apiFetch from '@wordpress/api-fetch';
import File from './components/file';
import Directory from './components/directory';

export async function getFiles( path ) {
	const params = new URLSearchParams( [ [ 'directory', path ] ] );
	const data = await apiFetch( {
		path: `/ribarich/v1/ddlb?${ params.toString() }`,
	} );
	if ( ! data.files ) {
		return {};
	}
	return data.files;
}

/**
 * Files look like:
 * {
 *     path: string,
 *     type: 'directory' | 'file'
 *     children: {
 *         "file.txt": {
 *              name: string,
 *              ...
 *          }
 *     }
 * }
 */
export function getFileComponents( files ) {
	if ( ! files || ! files.children ) {
		return <p>No files.</p>;
	}

	return Object.values( files.children ).map( ( file ) => {
		if ( file.type === 'file' ) {
			return (
				<File key={ file.name } name={ file.name } url={ file.url } />
			);
		} else {
			return <Directory key={ file.name } dir={ file } />;
		}
	} );
}
