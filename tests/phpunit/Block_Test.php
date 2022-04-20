<?php
declare(strict_types=1);

namespace Ribarich\DDLB\Test;

use Ribarich\DDLB\Block;

class Block_Test extends \WP_UnitTestCase {

	public static $sut;

	public static function set_up_before_class() {
		parent::set_up_before_class();
		self::$sut = new Block();
	}

	/**
	 * @dataProvider is_within_wp_content_dir_data_provider
	 */
	public function test_is_within_wp_content_dir( $dir, $is_within ) {
		$this->assertEquals( self::$sut->is_within_wp_content_dir( $dir ), $is_within );
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
