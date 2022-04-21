<?php
declare(strict_types=1);
namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

// Copied from WooCommerce Blocks. See https://developer.woocommerce.com/2021/11/15/how-does-woocommerce-blocks-render-interactive-blocks-in-the-frontend/
function add_attributes_to_block( $attributes = array(), $content = '' ) {
	$escaped_data_attributes = array();

	foreach ( $attributes as $key => $value ) {
		if ( is_bool( $value ) ) {
			$value = $value ? 'true' : 'false';
		}
		if ( ! is_scalar( $value ) ) {
			$value = wp_json_encode( $value );
		}
		$escaped_data_attributes[] = 'data-' . esc_attr( strtolower( preg_replace( '/(?<!\ )[A-Z]/', '-$0', $key ) ) ) . '="' . esc_attr( $value ) . '"';
	}

	return preg_replace( '/^<div /', '<div ' . implode( ' ', $escaped_data_attributes ) . ' ', trim( $content ) );
}

/**
 * @param string $haystack Haystack.
 * @param string $needle String to remove from start of haystack.
 */
function remove_string( $haystack, $needle ) {
	$haystack_starts_with_needle = strpos( $haystack, $needle ) === 0;

	if ( ! $haystack_starts_with_needle ) {
		return $haystack;
	}

	$index_of_last_character = strlen( $needle ) - 1;

	return substr( $haystack, $index_of_last_character + 1 );
}
