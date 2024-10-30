<?php
/*
Plugin Name: Connect Products with Shopify
Description: You can connect Shopifiy to retrieve all the products in your store and automatically register them in a custom WordPress post.
Author: MAINICHI WEB
Author URI: https://mainichi-web.com/
Plugin URI: https://mainichi-web.com/how-to-connect-products-with-shopify/
Text Domain: mainichi-shopify-products-connect
Domain Path: /languages/
Requires at least: 5.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.1.6
*/

if(!defined('ABSPATH')) exit;

/* 翻訳 */
load_plugin_textdomain('mainichi-shopify-products-connect', false, dirname(plugin_basename(__FILE__)). '/languages');
/* テンプレート読み込み */
define( 'CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'functions/cps_create.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'functions/cps_connect.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'functions/cps_buy-button.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'functions/cps_products-list.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'functions/cps_translate.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'functions/cps_svg.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'functions/cps_other.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'css/style_shopify-font.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'css/style_shopify-buy-button.php' );
require_once( CONNECT_PRODUCTS_WITH_SHOPIFY__PLUGIN_DIR . 'css/style_shopify-inline.php' );

/* プラグイン一覧に設定リンク追加 */
function connect_products_with_shopify_plugin_action_links($links, $file) {
	static $this_plugin;
	if (!$this_plugin) {
		$this_plugin = plugin_basename(__FILE__);
	}
	if ($file == $this_plugin) {
		$cpsSettingsUrl = admin_url('admin.php?page=shopify_settings');
		$settings_link = sprintf(__('<a href="%s">Settings</a>', 'mainichi-shopify-products-connect'), esc_url($cpsSettingsUrl));
		array_unshift($links, $settings_link);
	}
	return $links;
}
add_filter('plugin_action_links', 'connect_products_with_shopify_plugin_action_links', 10, 2);
?>