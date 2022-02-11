<?php
declare(strict_types=1);

namespace Ribarich\DDLB\REST;

defined( 'ABSPATH' ) || exit;

use Ribarich\DDLB\Block;

class Block_Controller extends \WP_REST_Controller {
	const NAMESPACE = 'ddlb'

	public function init() {
		\add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function __construct( Block $block ) {
		$this->block = $block;
	}

	public function register_routes() {
		\register_rest_route(
			// TODO: /some/path,
			array(
				// TODO: Fix this array
				array(
					'methods' => \WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_files' ),
					'permission_callback' => array( $this, 'can_user_get_files' )
				)
			)
		);
	}

	public function can_user_get_files( $request ) {
		if ( ! \current_user_can( 'edit_posts' ) ) {
			return false;
		}

		return true;
	}

	public function get_files( $request ) {
		// TODO
		$files = $this->block->get_files( array( 'directory' => '/' ) );
		return \rest_ensure_response( $files );
	}

}
