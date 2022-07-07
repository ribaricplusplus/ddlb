import { useEffect, useCallback, useState, useMemo } from '@wordpress/element';
import { useDebounce } from '@wordpress/compose';

import { getFiles, getFileComponents } from './util';
import File from './components/file';

const DELAY = 500;

export default function Ddlb( { directory, onError, onSuccess, inEditor } ) {
	const [ files, setFiles ] = useState( {} );

	const fetchFiles = useCallback( async () => {
		if ( ! directory ) {
			setFiles( {} );
			return;
		}

		const files = await getFiles( directory, onError, onSuccess );
		setFiles( files );
	}, [ directory ] );

	const debouncedFetchFiles = useDebounce( fetchFiles, DELAY );

	useEffect( () => {
		debouncedFetchFiles();
	}, [ directory ] );

	const FilesList = useMemo(
		() => getFileComponents( files, inEditor ),
		[ files ]
	);

	return <div className="ddlb-container">{ FilesList }</div>;
}
