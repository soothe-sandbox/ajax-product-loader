<?
/**
 * Plugin Name:       Ajax Product Loader
 * Plugin URI:        https://github.com/soothe-sandbox/ajax-product-loader
 * Description:       Plugin for Wordpress Storefront theme, for ajax product loading.
 * Version:           0.1
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Soothe
 * Author URI:        https://github.com/soothe-sandbox
 * License:           MIT License
 * License URI:       https://github.com/soothe-sandbox/ajax-product-loader/blob/master/LICENSE
 * Text Domain:       soothe-ajax-product-loader
 * Domain Path:       /languages
 */

// Debug
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/*
 * Include Admin Page script
 */
include plugin_dir_path(__FILE__) . 'admin/page-admin.php';

/*
 * Include Front assets
 */
include plugin_dir_path(__FILE__) . 'front/include-assets.php';

/*
 * Include Core
 */
include plugin_dir_path(__FILE__) . 'core.php';

/*
 * Include Requests
 */
include plugin_dir_path(__FILE__) . 'back/requests.php';

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'salp_products_per_page', 20 );
function salp_products_per_page( $cols ) {
  $cols = get_option('salp_product_amount');
  return $cols;
}