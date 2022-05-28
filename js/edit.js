import { useState } from '@wordpress/element';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl } from '@wordpress/components';

import Ddlb from './block';

export default function Edit( { attributes, setAttributes } ) {
	return (
		<>
			<InspectorControls>
				<PanelBody title="Settings">
					<TextControl
						label={ __( 'Path to directory', 'ddlb' ) }
						value={ attributes.directory || '' }
						onChange={ ( value ) =>
							setAttributes( { directory: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps( { className: 'ddlb-root' } ) }>
				<Ddlb directory={ attributes.directory } />
			</div>
		</>
	);
}
