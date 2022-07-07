<?php
declare(strict_types=1);

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

class Block {

	public $mimes = null;

	public $restricted_dirs = array();

	public function __construct() {
		$restricted_dirs = array(
			'.',
			'plugins',
			'themes',
		);

		$this->restricted_dirs = \array_map( fn( $val) => get_path_relative_to_wp_content( $val ), $restricted_dirs );
	}

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

	public function validate_directory( string $directory ): bool {
		if ( empty( $directory ) ) {
			return false;
		}

		if ( ! \file_exists( $directory ) ) {
			return false;
		}

		if ( ! $this->is_within_wp_content_dir( $directory ) ) {
			return false;
		}

		if ( \in_array( $directory, $this->restricted_dirs, true ) ) {
			return false;
		}

		return true;
	}

	public function get_allowed_mime_types() {
		if ( $this->mimes === null ) {
			$this->mimes = \get_allowed_mime_types();
		}

		return $this->mimes;
	}

	public function check_file( string $path ) {
		$mimes = $this->get_allowed_mime_types();
		$check = \wp_check_filetype_and_ext( $path, \basename( $path ), $mimes );
		return $check['ext'] !== false;
	}

	/**
	 * Returns all files and directories from $args['directory'], which must be
	 * within wp-content, in the form of a Ribarich\DDLB\Directory which
	 * contains Directory and File objects.
	 *
	 * @throws \Exception
	 * @return Directory
	 */
	public function get_files( array $args ) {
		if ( ! \function_exists( 'list_files' ) ) {
			require_once \ABSPATH . '/wp-admin/includes/file.php';
		}

		if ( ! $this->validate_directory( $args['directory'] ) ) {
			throw new \Exception( "Invalid directory {$args['directory']}" );
		}

		$files = \list_files( $args['directory'] );

		if ( $files === false ) {
			throw new \Exception( 'Failed listing files.' );
		}

		$files = \array_filter( $files, array( $this, 'check_file' ) );

		$dirmap = array( './' => new Directory( array( 'path' => $args['directory'] ) ) );

		foreach ( $files as $file ) {
			$relpath = './' . remove_string( \trailingslashit( \dirname( $file ) ), \trailingslashit( $args['directory'] ) );

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
					'url'  => \content_url( remove_string( $file, $content_dir ) ),
				)
			);

			$dirmap[ $relpath ]->add_child( $obj, \basename( $file ) );
		}

		foreach ( $dirmap as $path => $dir ) {
			$is_root_directory = $path === './';
			$parent_path       = dirname( $path ) . '/';

			if ( $is_root_directory ) {
				continue;
			}

			if ( empty( $dirmap[ $parent_path ] ) ) {
				throw new \Exception( 'Missing parent directory' );
			}

			$parent_dir = $dirmap[ $parent_path ];
			$parent_dir->add_child( $dir, basename( $dir->path ) );
		}

		$root_dir = $dirmap['./'];
		$root_dir->set_depth( 0 );

		return $root_dir;
	}

	public function is_within_wp_content_dir( string $path ) {
		return strpos( $path, \WP_CONTENT_DIR ) === 0;
	}

}
