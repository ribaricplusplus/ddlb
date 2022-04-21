<?php

namespace Ribarich\DDLB\Test;

class Bootstrap {

	public function __construct() {
		$this->plugin_dir   = dirname( dirname( dirname( __FILE__ ) ) );
		$this->wp_tests_dir = $this->plugin_dir . '/vendor/wp-phpunit/wp-phpunit';

		define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $this->plugin_dir . '/vendor/yoast/phpunit-polyfills' );

		define( 'WP_PHPUNIT_TESTS', true );

		require_once $this->wp_tests_dir . '/includes/functions.php';

		require_once __DIR__ . '/utils.php';

		\tests_add_filter( 'muplugins_loaded', array( $this, 'load_plugin' ) );

		\tests_add_filter( 'init', array( $this, 'load_filesystem_abstraction' ) );

		require_once $this->wp_tests_dir . '/includes/bootstrap.php';
	}

	public function load_filesystem_abstraction() {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		\WP_Filesystem();
	}

	public function load_plugin() {
		require $this->plugin_dir . '/ribarich-directory-download-list-block.php';
	}

}

new Bootstrap();
