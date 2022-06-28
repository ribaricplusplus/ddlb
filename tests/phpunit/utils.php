<?php
declare(strict_types=1);

namespace Ribarich\DDLB\Test;

/**
 * @param array $params Request params.
 * @return \WP_REST_Response
 */
function dispatch_request( $params = array() ) {
	$request = new \WP_REST_Request( 'GET', '/ribarich/v1/ddlb' );

	foreach ( $params as $param => $value ) {
		$request->set_param( $param, $value );
	}

	return \rest_get_server()->dispatch( $request );
}

function create_test_files() {
	global $wp_filesystem;

	$test_dir = \WP_CONTENT_DIR . '/ribarich-ddlb-test';

	if ( $wp_filesystem->exists( $test_dir ) ) {
		$wp_filesystem->delete( $test_dir, true );
	}

	// Directory structure:
	// | -- wp-content/ribarich-ddlb-test/
	// | -- file.txt
	// | -- subdirectory/
	// | ---- another.txt
	// | ---- thing.pdf
	// | ---- subsubdir/
	// | ------ file.txt

	\wp_mkdir_p( $test_dir );
	\file_put_contents( $test_dir . '/file.txt', 'Hello world' );
	\wp_mkdir_p( $test_dir . '/subdirectory' );
	\wp_mkdir_p( $test_dir . '/subdirectory/subsubdir' );
	\file_put_contents( $test_dir . '/subdirectory/another.txt', 'Hello world 2' );
	\file_put_contents( $test_dir . '/subdirectory/thing.pdf', 'Hello world 3' );
	\file_put_contents( $test_dir . '/subdirectory/subsubdir/file.txt', 'Hello world' );

	return array(
		'test_dir' => $test_dir,
	);
}

function remove_test_files( $test_dir ) {
	global $wp_filesystem;

	$wp_filesystem->delete( $test_dir, true );
}
