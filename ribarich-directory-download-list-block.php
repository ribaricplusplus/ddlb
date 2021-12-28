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

require 'vendor/autoload.php';

new \Ribarich\DDLB\DDLB();
