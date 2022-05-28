<?php
declare(strict_types=1);

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

class File {

	public $path;

	public $url;

	public $type = 'file';

	public $name = '';

	/**
	 * @param array $args {
	 *     @type string $path Absolute path.
	 *     @type string $url URL.
	 * }
	 */
	public function __construct( $args ) {
		$this->path = $args['path'] ?? '';
		$this->url  = $args['url'] ?? '';
	}

}
