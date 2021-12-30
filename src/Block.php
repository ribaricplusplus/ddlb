<?php

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

class Block {

	public function __construct() {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	public function register_block() {
		register_block_type_from_metadata(
			plugin_dir_path( RIBARICH_DDLB_FILE ),
			array(
				'render_callback' => array( $this, 'render' )
			)
		);
	}

	public function render( $attributes = array(), $content = '' ) {
		if ( ! is_admin() ) {
			wp_enqueue_script( 'ddlb-frontend' );
		}
		return add_attributes_to_block( $attributes, $content );
	}

}
