<?php
/*
Plugin Name: Woocommerce Single Product Page Customizer Pro
Description: By using this smart plugin, allows you to add text or HTML in wooocommerce Single product page , no need to edit theme and woocommerce plugin!
Author: Geek Code Lab
Plugin URI:  https://geekcodelab.com/wordpress-plugins/woocommerce-single-product-page-customizer-pro/
Version: 2.1.1
WC tested up to: 8.9.0
Author URI: https://geekcodelab.com/
Text Domain : woo-single-product-page-customizer-pro
Requires Plugins:  woocommerce
*/
if( !defined( 'ABSPATH' ) ) exit;

define("WSPPCP_BUILD", '2.1.1');

require_once( plugin_dir_path (__FILE__) .'functions.php' );

/** All Hook List Array */
$hook_list=array(
	'woocommerce_before_single_product',
	'woocommerce_before_single_product_summary',
	'woocommerce_single_product_summary',
	'woocommerce_after_product_title',
	'woocommerce_after_product_price',
	'woocommerce_before_add_to_cart_form',
	'woocommerce_before_variations_form',
	'woocommerce_before_single_variation',
	'woocommerce_single_variation',
	'woocommerce_before_add_to_cart_button',
	'woocommerce_after_add_to_cart_button',
	'woocommerce_after_single_variation',
	'woocommerce_after_variations_form',
	'woocommerce_after_add_to_cart_form',
	'woocommerce_product_meta_start',
	'woocommerce_product_meta_end',
	'woocommerce_share',
	'woocommerce_product_thumbnails',
	'woocommerce_after_single_product_summary',
	'woocommerce_after_single_product',
	'woocommerce_after_product_thumbnails'
);


/** Admin Menu Start */
add_action('admin_menu', 'wsppcp_admin_menu_single_product_page_customizer' );
function wsppcp_admin_menu_single_product_page_customizer(){
	add_submenu_page( 'woocommerce','Single Product Page Customizer pro', 'Single Product Page Customizer pro', 'manage_options', 'wsppcp-woocommerce-single-product-page-customizer', 'wsppcp_single_product_page_setting');
}
function wsppcp_single_product_page_setting(){
	include( plugin_dir_path( __FILE__ ) . 'admin/options.php' );
}
require_once(plugin_dir_path( __FILE__ ) . 'admin/product-meta.php' );
require_once(plugin_dir_path( __FILE__ ) . 'admin/wsppcp-categories-meta.php' );
require_once(plugin_dir_path( __FILE__ ) . 'admin/wsppcp-tag-meta.php' );
require_once(plugin_dir_path( __FILE__ ) . 'admin/wsppcp-admin-ajax.php' );
require_once(plugin_dir_path( __FILE__ ) . 'front/index.php' );
require_once(plugin_dir_path( __FILE__ ) . 'front/product-display-meta.php' );
require_once(plugin_dir_path( __FILE__ ) . 'front/remove-content-tab.php' );
require_once(plugin_dir_path( __FILE__ ) . 'front/label-setting.php' );

/**Avtivation Hook Start */
register_activation_hook( __FILE__, 'wsppcp_plugin_active_single_product_page_customizert' );
function wsppcp_plugin_active_single_product_page_customizert(){
	if (is_plugin_active( 'woo-single-product-page-customizer/woocommerce-single-product-page-customizer.php' ) ) {		
		deactivate_plugins('woo-single-product-page-customizer/woocommerce-single-product-page-customizer.php');
   	} 
	$pro_options = get_option('wsppcp_hook');
	$free_options = get_option('wsppc_hook');
	if(!$pro_options) {
		if(isset($free_options) && !empty($free_options)){
			update_option('wsppcp_hook',$free_options);
		}
	}

	$wsppcp_hook_exclude = get_option('wsppcp_hook_exclude');
	if(isset($wsppcp_hook_exclude) && !empty($wsppcp_hook_exclude)){
		update_option('wsppcp_hook_exclude',$wsppcp_hook_exclude);
	}
}

/** Add settings And Support link Start */
$plugin = plugin_basename(__FILE__);
add_filter( "plugin_action_links_$plugin", 'wsppcp_add_plugin_settings_link');
function wsppcp_add_plugin_settings_link( $links ) {
	$support_link = '<a href="https://geekcodelab.com/contact/"  target="_blank" >' . __( 'Support', 'woo-single-product-page-customizer-pro' ) . '</a>'; 
	array_unshift( $links, $support_link );

	$settings_link = '<a href="'. admin_url() .'admin.php?page=wsppcp-woocommerce-single-product-page-customizer">' . __( 'Settings', 'woo-single-product-page-customizer-pro' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}

/** Admin side Add Css And Script Start */
function wsppcp_enqueue_styles_scripts(){
    if( is_admin() ) {
        $css= plugins_url() . '/'.  basename(dirname(__FILE__)) . "/admin/assets/css/wsppcp_style.css";     
		wp_enqueue_style( 'wsppcp-select2-css', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/admin/assets/css/select2.min.css", '', WSPPCP_BUILD );
        wp_enqueue_style( 'main-wsppcp-woocommerce-single-page-css', $css, array('wsppcp-select2-css'), WSPPCP_BUILD );

		$js= plugins_url() . '/'.  basename(dirname(__FILE__)) . "/admin/assets/js/wsppcp_script.js";       
		wp_enqueue_script( 'wsppcp-select2-js', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/admin/assets/js/select2.min.js", array(), WSPPCP_BUILD, true );
		wp_enqueue_script( 'wsppcp-custom', $js, array('jquery', 'wsppcp-select2-js'), WSPPCP_BUILD, true );
		wp_localize_script( 'wsppcp-custom', 'custom_call', [ 'ajaxurl' => admin_url('admin-ajax.php') ] );
    }
}
add_action( 'admin_footer', 'wsppcp_enqueue_styles_scripts' );

/**
 * Added HPOS support for woocommerce
 */
add_action( 'before_woocommerce_init', 'wsppcp_before_woocommerce_init' );
function wsppcp_before_woocommerce_init() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
}