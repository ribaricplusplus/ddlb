<?php
declare(strict_types=1);

namespace Ribarich\DDLB\Test;

class REST_API_Test extends \WP_Test_REST_TestCase {

	public static $user_id;

	public static $test_dir;

	public static function wpSetUpBeforeClass( \WP_UnitTest_Factory $factory ) {
		self::$user_id = $factory->user->create( array( 'role' => 'administrator' ) );

		$files_data = create_test_files();

		self::$test_dir = $files_data['test_dir'];
	}

	public static function wpTearDownAfterClass() {
		remove_test_files( self::$test_dir );
	}

	public function test_get_files_smoke_test() {
		\wp_set_current_user( self::$user_id );

		$response = dispatch_request( array( 'directory' => self::$test_dir ) );
		$this->assertNotEmpty( $response );
		$this->assertEquals( 200, $response->status );
	}

	public function test_depth() {
		\wp_set_current_user( self::$user_id );

		$response = dispatch_request( array( 'directory' => self::$test_dir ) );
		$data     = $response->get_data();

		$this->assertEquals( 0, $data['files']['depth'] );
		$this->assertEquals( 1, $data['files']['children']['subdirectory']['depth'] );

	}
}
