import { useEffect, useCallback, useState } from '@wordpress/element';
import { useDebounce } from '@wordpress/compose';

import { getFiles, getFileComponents } from './util';
import File from './components/file';

const DELAY = 500;

export default function Ddlb( { directory } ) {
	const [ files, setFiles ] = useState( {} );

	const fetchFiles = useCallback( async () => {
		if ( ! directory ) {
			setFiles( {} );
			return;
		}

		const files = await getFiles( directory );
		setFiles( files );
	}, [ directory ] );

	const debouncedFetchFiles = useDebounce( fetchFiles, DELAY );

	useEffect( () => {
		debouncedFetchFiles();
	}, [ directory ] );

	const FilesList = getFileComponents( files );

	return <div className="ddlb-container">{ FilesList }</div>;
}
