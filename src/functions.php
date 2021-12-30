<?php
namespace Ribarich\DDLB;

defined( 'ABSPATH' ) || exit;

// Copied from WooCommerce Blocks. See https://developer.woocommerce.com/2021/11/15/how-does-woocommerce-blocks-render-interactive-blocks-in-the-frontend/
function add_attributes_to_block( $attributes = [], $content = '' ) {
    $escaped_data_attributes = [];

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
