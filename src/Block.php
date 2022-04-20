<?php
declare(strict_types=1);

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

class Block {
	public function init() {
		\add_action( 'init', array( $this, 'register_block' ) );
	}

	public function register_block() {
		\register_block_type_from_metadata(
			plugin_dir_path( \RIBARICH_DDLB_FILE ),
			array(
				'render_callback' => array( $this, 'render' ),
			)
		);
	}

	public function render( $attributes = array(), $content = '' ) {
		if ( ! \is_admin() ) {
			\wp_enqueue_script( 'ddlb-frontend' );
		}
		return add_attributes_to_block( $attributes, $content );
	}

	/**
	 * Returns all files and directories from $args['directory'], which must be
	 * within wp-content, in the form of a Ribarich\DDLB\Directory which
	 * contains Directory and File objects.
	 *
	 * @throws \Exception
	 * @return Directory
	 */
	public function get_files( $args ) {
		if ( ! $this->is_within_wp_content_dir( $args['directory'] ) ) {
			throw new \Exception( 'Root directory must be within wp-content.' );
		}

		$files = \list_files( $args['directory'] );

		if ( $files === false ) {
			throw new \Exception( 'Failed listing files.' );
		}

		$dirmap = array( '.' => new Directory( array( 'path' => $args['directory'] ) ) );

		foreach ( $files as $file ) {
			$relpath = './' . \ltrim( \dirname( $file ), $args['directory'] );

			if ( empty( $dirmap[ $relpath ] ) ) {
				$dirmap[ $relpath ] = new Directory(
					array(
						'path' => dirname( $file ),
					)
				);
			}

			$content_dir = \ABSPATH . 'wp-content';

			$obj = new File(
				array(
					'path' => $file,
					'url'  => \content_url( \ltrim( $file, $content_dir ) ),
				)
			);

			$dirmap[ $relpath ]->add_child( $obj, \basename( $file ) );
		}

		return $dirmap['.'];
	}

	public function is_within_wp_content_dir( string $path ) {
		return strpos( $path, \WP_CONTENT_DIR ) === 0;
	}

}
