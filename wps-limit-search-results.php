<?php
/**
 * Plugin Name: WPS Limit Search Results
 * Plugin URI: https://github.com/geotsiokos/wps-product-search-field-exclude-attributes
 * Description: Limit the number of search results when using the Product Search Field by <a href="https://woo.com/products/woocommerce-product-search/">WooCommerce Product Search</a>
 * Version: 1.0.0
 * Author: gtsiokos
 * Author URI: http://www.netpad.gr
 * Donate-Link: http://www.netpad.gr
 * License: GPLv3
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class WPS_Limit_Search_Results {

	public static $results_limit = 500;

	public static function init() {
		add_filter( 'woocommerce_product_search_engine_stage_parameters', array( __CLASS__, 'woocommerce_product_search_engine_stage_parameters' ), 10, 2 );
	}

	public static function woocommerce_product_search_engine_stage_parameters( $args, $engine_stage ) {
		if ( !is_ajax() ) {
			if (
				isset( $_REQUEST ) &&
				isset( $_REQUEST['ixwps'] ) &&
				$_REQUEST['ixwps']
			) {
				error_log( 'search term' );
				error_log( $_REQUEST['s'] );
				$stage_id = $engine_stage->get_stage_id();
				if ( $stage_id == 'pagination' ) {
					if ( is_array( $args ) ) {
						if ( isset( $args['limit'] ) ) {
							$args['limit'] = self::$results_limit;
						}
						if ( isset( $args['offset'] ) ) {
							$args['offset'] = 0;
						}
					}
				}
			}
		}

		return $args;
	}

} WPS_Limit_Search_Results::init();