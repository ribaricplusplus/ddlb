<?php
declare(strict_types=1);

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

/**
 * Directory Download List Block main plugin file.
 */
class DDLB {

	public $block = null;

	public function __construct() {
		$this->load();
		new Scripts_Loader();
		$this->block = new Block();
		$this->block->init();

		$this->init_rest_api();
	}

	public function init_rest_api() {
		$block_controller = new REST\Block_Controller( $this->block );
		$block_controller->init();
	}

	public function load() {
		require 'functions.php';
	}

}
