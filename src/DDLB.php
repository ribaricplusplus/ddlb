<?php

namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

/**
 * Directory Download List Block main plugin file.
 */
class DDLB {

	public function __construct() {
		$this->load();
		new Scripts_Loader();
		new Block();
	}

	public function load() {
		require 'functions.php';
	}

}
