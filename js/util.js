import apiFetch from '@wordpress/api-fetch';
import File from './components/file';
import Directory from './components/directory';

/**
 * If onError is provided, in case of fetch error, whatever onError
 * returns will be what this function returns.
 */
export async function getFiles( path, onError = null, onSuccess = null ) {
	const params = new URLSearchParams( [ [ 'directory', path ] ] );
	try {
		const data = await apiFetch( {
			path: `/ribarich/v1/ddlb?${ params.toString() }`,
		} );

		if ( ! data.files ) {
			return {};
		}

		onSuccess();

		return data.files;
	} catch ( e ) {
		if ( onError ) {
			return await onError( e );
		} else {
			throw e;
		}
	}
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
export function getFileComponents( files, inEditor = false ) {
	if ( ! files || ! files.children ) {
		return <p>No files.</p>;
	}

	return Object.values( files.children ).map( ( file ) => {
		if ( file.type === 'file' ) {
			return (
				<File
					inEditor={ inEditor }
					key={ file.name }
					name={ file.name }
					url={ file.url }
				/>
			);
		} else {
			return (
				<Directory
					inEditor={ inEditor }
					key={ file.name }
					dir={ file }
				/>
			);
		}
	} );
}
