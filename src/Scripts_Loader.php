<?php

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

class Scripts_Loader {

	public function __construct() {
		add_action( 'wp_loaded', array( $this, 'register_scripts' ) );
	}

	public function register_scripts() {
		$scripts = array(
			'frontend',
			'register'
		);

		foreach( $scripts as $script ) {
			$data = $this->get_script_data($script);
			wp_register_script(
				"ddlb-$script",
				plugins_url( "build/$script.js", RIBARICH_DDLB_FILE ),
				$data['dependencies'],
				$data['version']
			);
		}
	}

	/**
	 * Get script data as produced by dependency extraction webpack plugin
	 *
	 * @param string $script_name Script name defined by a webpack entry point.
	 * @return array Script data (version, dependencies)
	 */
	protected function get_script_data( $script_name ) {
		$assets_path = plugin_dir_path( RIBARICH_DDLB_FILE ) . 'build/' . $script_name . '.asset.php';
		if ( file_exists( $assets_path ) ) {
			$data = require $assets_path;
			return $data;
		}
	}

}
