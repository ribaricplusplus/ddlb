<?php
declare(strict_types=1);

namespace Ribarich\DDLB\REST;

defined( 'ABSPATH' ) || exit;

use Ribarich\DDLB\Block;
use Ribarich\DDLB\Exceptions\Validation_Exception;

class Block_Controller extends \WP_REST_Controller {

	const NAMESPACE = 'ribarich/v1';

	const REST_BASE = 'ddlb';

	public function init() {
		\add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function __construct( Block $block ) {
		$this->block = $block;
	}

	public function register_routes() {
		\register_rest_route(
			self::NAMESPACE,
			'/' . self::REST_BASE,
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_files' ),
					'permission_callback' => array( $this, 'can_user_get_files' ),
					'args'                => $this->get_files_arguments(),
				),
			)
		);
	}

	public function get_files_arguments() {
		return array(
			'directory' => array(
				'type'              => 'string',
				'required'          => true,
				'sanitize_callback' => '\\Ribarich\\DDLB\\get_path_relative_to_wp_content',
				'validate_callback' => 'rest_validate_request_arg',
			),
		);
	}

	public function can_user_get_files( $request ) {
		if ( ! \current_user_can( 'edit_posts' ) ) {
			return false;
		}

		return true;
	}

	public function get_files( $request ) {
		try {
			$files = $this->block->get_files( array( 'directory' => $request['directory'] ) );
			// Convert to array
			$files = json_decode( wp_json_encode( $files ), null, 512, \JSON_OBJECT_AS_ARRAY );
			$data  = array( 'files' => $files );
			return \rest_ensure_response( $data );
		} catch ( Validation_Exception $e ) {
			return new \WP_Error(
				'ddlb_directory_validation_error',
				$e->getMessage(),
				array( 'status' => 400 )
			);
		} catch ( \Exception $e ) {
			return new \WP_Error(
				'ddlb_rest_error',
				'An error occurred.',
				array( 'status' => 500 )
			);
		}
	}

}
