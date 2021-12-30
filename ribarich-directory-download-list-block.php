<?php
/**
 * Plugin Name: Ribarich Directory Download List Block
 * Description: Block that displays all files from a server directory in a hierarchical way and makes them available for downloading.
 * Requires at least: 5.8
 * Requires PHP: 7.3
 * Version: 1.0.0
 * Author: Bruno Ribarich
 * Author URI: https://ribarich.me/
 * Text Domain: ribarich-ddlb
 */

if ( defined( 'RIBARICH_DDLB_FILE' ) ) {
	// Maybe somehow it's possible that in PHP unit tests the plugin becomes
	// activated by default, so we wouldn't want to load it twice
	return;
} else {
	define( 'RIBARICH_DDLB_FILE', __FILE__ );
}

require 'vendor/autoload.php';

new \Ribarich\DDLB\DDLB();
