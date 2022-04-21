<?php
declare(strict_types=1);

namespace Ribarich\DDLB\Test;

use Ribarich\DDLB\Block;
use Ribarich\DDLB\Directory;

class Block_Test extends \WP_UnitTestCase {

	public static $sut;

	public static $test_dir;

	public static function set_up_before_class() {
		parent::set_up_before_class();

		global $wp_filesystem;

		self::$sut = new Block();

		self::$test_dir = \WP_CONTENT_DIR . '/ribarich-ddlb-test';

		if ( $wp_filesystem->exists( self::$test_dir ) ) {
			$wp_filesystem->delete( self::$test_dir, true );
		}

		// Directory structure:
		// | -- wp-content/ribarich-ddlb-test/
		//     | -- file.txt
		//     | -- subdirectory/
		//         | -- another.txt
		//         | -- thing.pdf

		\wp_mkdir_p( self::$test_dir );
		\file_put_contents( self::$test_dir . '/file.txt', 'Hello world' );
		\wp_mkdir_p( self::$test_dir . '/subdirectory' );
		\file_put_contents( self::$test_dir . '/subdirectory/another.txt', 'Hello world 2' );
		\file_put_contents( self::$test_dir . '/subdirectory/thing.pdf', 'Hello world 3' );
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
				'directory' => self::$test_dir
			)
		);

		$this->assertEquals( 2, count( $dir->children ) );
		$this->assertInstanceOf( Directory::class, $dir->children[ 'subdirectory' ] );

		$file = $dir->children[ 'file.txt' ];
		$this->assertEquals( 'http://localhost:8889/wp-content/ribarich-ddlb-test/file.txt', $file->url );

		$subdir = $dir->children[ 'subdirectory' ];
		$this->assertNotEmpty( $subdir->children[ 'thing.pdf' ] );
	}

	public function is_within_wp_content_dir_data_provider() {
		return array(
			array(
				'/var/www/html/wp-content/file.txt',
				true
			)
		);
	}

}
