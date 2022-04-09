<?php
declare(strict_types=1);

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

class Directory {

	public $path;

	public $children = array();

	/**
	 * @param array $args {
	 *     @type string $path Absolute path.
	 * }
	 */
	public function __construct( $args ) {
		$this->path = $args['path'];
	}

	public function add_child( $child, $name ) {
		$this->children[ $name ] = $child;
	}

}
