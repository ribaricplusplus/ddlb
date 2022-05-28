<?php
declare(strict_types=1);

namespace Ribarich\DDLB\Test;

use Ribarich\DDLB\Block;
use Ribarich\DDLB\Directory;

class Block_Test extends \WP_UnitTestCase {

	public static $sut;

	public static $test_dir;

	public static function wpSetUpBeforeClass( \WP_UnitTest_Factory $factory ) {
		self::$sut = new Block();

		$files_data = create_test_files();

		self::$test_dir = $files_data['test_dir'];
	}

	public static function wpTearDownAfterClass() {
		remove_test_files( self::$test_dir );
	}

	public static function tear_down_after_class() {
		parent::tear_down_after_class();

		global $wp_filesystem;

		$wp_filesystem->delete( self::$test_dir, true );
	}

	/**
	 * @dataProvider is_within_wp_content_dir_data_provider
	 */
	public function test_is_within_wp_content_dir( $dir, $is_within ) {
		$this->assertEquals( self::$sut->is_within_wp_content_dir( $dir ), $is_within );
	}

	public function test_get_files() {
		$dir = self::$sut->get_files(
			array(
				'directory' => self::$test_dir,
			)
		);

		$this->assertEquals( 2, count( $dir->children ) );
		$this->assertInstanceOf( Directory::class, $dir->children['subdirectory'] );

		$file = $dir->children['file.txt'];
		$this->assertEquals( 'http://localhost:8889/wp-content/ribarich-ddlb-test/file.txt', $file->url );

		$subdir = $dir->children['subdirectory'];
		$this->assertNotEmpty( $subdir->children['thing.pdf'] );
	}

	public function test_restricted_directory_not_allowed() {
		$dir        = \WP_CONTENT_DIR . '/plugins';
		$is_allowed = self::$sut->validate_directory( $dir );
		$this->assertFalse( $is_allowed );
	}

	public function is_within_wp_content_dir_data_provider() {
		return array(
			array(
				'/var/www/html/wp-content/file.txt',
				true,
			),
			array(
				'/var/www',
				false,
			),
		);
	}

}
