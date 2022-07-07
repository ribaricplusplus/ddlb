<?php
declare(strict_types=1);

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

class Directory {

	public $path;

	public $children = array();

	public $type = 'directory';

	public $name = '';

	public $depth = null;

	/**
	 * @param array $args {
	 *     @type string $path Absolute path.
	 *     @type int $depth Optional. Depth.
	 * }
	 */
	public function __construct( $args ) {
		$this->path = $args['path'];
	}

	public function add_child( $child, $name ) {
		$this->children[ $name ] = $child;
		$child->name             = $name;
	}

	public function set_depth( int $depth ) {
		$this->depth = $depth;

		foreach ( $this->children as $child ) {
			if ( \is_a( $child, self::class ) ) {
				$child->set_depth( $this->depth + 1 );
			}
		}
	}

}
