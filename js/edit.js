import { useState, useCallback } from '@wordpress/element';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl } from '@wordpress/components';
import { store as noticesStore } from '@wordpress/notices';
import { useDispatch } from '@wordpress/data';

import Ddlb from './block';

export default function Edit( { attributes, setAttributes } ) {
	const { createNotice, removeNotice } = useDispatch( noticesStore );
	const handleError = useCallback( ( err ) => {
		const noticeOptions = { isDismissible: true, id: 'ddlb_error' };
		if ( err.code === 'ddlb_directory_validation_error' ) {
			createNotice(
				'error',
				'DDLB error: ' + err.message,
				noticeOptions
			);
		} else {
			createNotice(
				'error',
				'DDLB error: ' +
					__(
						'Failed to fetch files from the given directory.',
						'ribarich-ddlb'
					),
				noticeOptions
			);
		}
		return {};
	}, [] );

	const handleSuccess = useCallback( () => {
		removeNotice( 'ddlb_error' );
	}, [] );

	return (
		<>
			<InspectorControls>
				<PanelBody title="Settings">
					<TextControl
						label={ __( 'Path to directory', 'ribarich-ddlb' ) }
						value={ attributes.directory || '' }
						help={ __(
							'You must input a path relative to the "wp-content" directory. For example, if the dir is /var/www/html/wp-content/downloads, you must input "downloads".',
							'ribarich-ddlb'
						) }
						onChange={ ( value ) =>
							setAttributes( { directory: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { className: 'ddlb-root' } ) }>
				<Ddlb
					directory={ attributes.directory }
					onError={ handleError }
					onSuccess={ handleSuccess }
					inEditor
				/>
			</div>
		</>
	);
}
