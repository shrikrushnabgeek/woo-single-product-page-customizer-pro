<?php

/*

Plugin Name: Woocommerce Single Product Page Customizer Pro

Description: By using this smart plugin, allows you to add text or HTML in wooocommerce Single product page , no need to edit theme and woocommerce plugin!

Author: Geek Code Lab

Version: 1.3

WC tested up to: 6.3.1

Author URI: https://geekcodelab.com/

Text Domain : woo-single-product-page-customizer-pro


*/

if( !defined( 'ABSPATH' ) ) exit;

define("wsppcp_BUILD", '1.1');

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
);


/** Admin Menu Start */
add_action('admin_menu', 'wsppcp_admin_menu_single_product_page_customizer' );
function wsppcp_admin_menu_single_product_page_customizer(){
	add_submenu_page( 'woocommerce','Single Product Page Customizer pro', 'Single Product Page Customizer pro', 'manage_options', 'wsppcp-woocommerce-single-product-page-customizer', 'wsppcp_single_product_page_setting');
}
function wsppcp_single_product_page_setting(){
	if(!current_user_can('manage_options') ){
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	include( plugin_dir_path( __FILE__ ) . 'admin/options.php' );
}
require_once(plugin_dir_path( __FILE__ ) . 'admin/product-meta.php' );
require_once(plugin_dir_path( __FILE__ ) . 'admin/wsppcp-categories-meta.php' );

require_once(plugin_dir_path( __FILE__ ) . 'front/index.php' );
require_once(plugin_dir_path( __FILE__ ) . 'front/single-category-meta.php' );
require_once(plugin_dir_path( __FILE__ ) . 'front/remove-content-tab.php' );
require_once(plugin_dir_path( __FILE__ ) . 'front/label-setting.php' );

/** Admin Menu End */


/**Avtivation Hook Start */
register_activation_hook( __FILE__, 'wsppcp_plugin_active_single_product_page_customizert' );
function wsppcp_plugin_active_single_product_page_customizert(){
	$error='required <b>woocommerce</b> plugin.';
	if ( !class_exists( 'WooCommerce' ) ) {
	   die('Plugin NOT activated: ' . $error);
	}
	if (is_plugin_active( 'woo-single-product-page-customizer/woocommerce-single-product-page-customizer.php' ) ) {		
		deactivate_plugins('woo-single-product-page-customizer/woocommerce-single-product-page-customizer.php');
   	} 

	$free_options		= get_option('wsppc_hook');
	if(isset($free_options) && !empty($free_options)){
		update_option('wsppcp_hook',$free_options);
	}
}
/**Avtivation Hook End */


/** Add settings And Support link Start */
$plugin = plugin_basename(__FILE__);
add_filter( "plugin_action_links_$plugin", 'wsppcp_add_plugin_settings_link');
function wsppcp_add_plugin_settings_link( $links ) {
	$support_link = '<a href="https://geekcodelab.com/contact/"  target="_blank" >' . __( 'Support', 'woocommerce-single-product-page-customizer' ) . '</a>'; 
	array_unshift( $links, $support_link );

	$settings_link = '<a href="'. admin_url() .'admin.php?page=wsppcp-woocommerce-single-product-page-customizer">' . __( 'Settings', 'wsppcp-woocommerce-single-product-page-customizer' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}
/** Add settings And Support link End */

/** Admin Site Add Css And Script Start */
add_action( 'admin_footer', 'wsppcp_enqueue_styles_scripts' );
function wsppcp_enqueue_styles_scripts(){

    if( is_admin() ) {

        $css= plugins_url() . '/'.  basename(dirname(__FILE__)) . "/admin/assets/css/wsppcp_style.css";               
        wp_enqueue_style( 'main-wsppcp-woocommerce-single-page-css', $css, '', wsppcp_BUILD );

		$js= plugins_url() . '/'.  basename(dirname(__FILE__)) . "/admin/assets/js/wsppcp_script.js";       
		wp_enqueue_script( 'wsppcp-custom', $js, array(), wsppcp_BUILD, true );
		wp_localize_script( 'wsppcp-custom', 'custom_call', [ 'ajaxurl' => admin_url('admin-ajax.php') ] );
    }

}
/** Admin Site Add Scriot End */


/** Admin Panel Edit Hook Form Start */

add_action('wp_ajax_wsppcp_get_edit_form','wsppcp_edit_form');
add_action( 'wp_ajax_nopriv_wsppcp_get_edit_form', 'wsppcp_edit_form' );
function wsppcp_edit_form(){
	
	$hook		=  "";
	$hook_value	=  "";
	$all_hook	=  "";

	if($_POST['form_action']=='add_form'){
		check_ajax_referer( 'wsppcp_ajax_add_nonce', 'security' );
	}
	if($_POST['form_action']=='edit_form'){
		check_ajax_referer( 'wsppcp_ajax_edit_nonce', 'security' );
	}
	
	if(isset($_POST['hook_name']) && !empty($_POST['hook_name'])){
		$hook		= sanitize_text_field($_POST['hook_name']);
		$hook_value = wsppcp_get_hook_value($hook);
	}

	$all_hook = wsppcp_get_hook();
	
	?>
	<form method="post" class="wsppcp_form">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<?php 
					if(empty($hook)) { ?>
						<th scope="row">
							<span><strong>Select Position</strong></span>
							<span>
								<select id="" name="hook">
									<?php 
									global $hook_list; 
									$i=1;							

									if(isset($hook_list) && !empty($hook_list)){

										foreach($hook_list as $hooks){

											$disable_key	= "";										
											if(isset($all_hook[$hooks])) $disable_key = 'disabled="disabled"';	 
												?>
											
												<option <?php echo $disable_key ?> value="<?php echo $hooks ?>"><?php echo  $i.". ".str_replace("_"," ",$hooks); ?></option>
		
												<?php 
												$i++;
										}  
									}
									?>
								</select>
								<p class="description">Refere bellow position map.</p>
							</span>
						</th>
						<?php 
					} else { ?>
						<input type="hidden" name="hook" value="<?php echo $hook; ?>">
						<input type="hidden" name="edit_form" value="1">
						<?php 
					} ?>
				</tr>			
				<tr valign="top">				
					<td>
						<textarea name="content" id="content_<?php echo $hook;?>" rows="12" class="wsppcp_content wp-editor"> <?php  echo wp_unslash($hook_value); ?></textarea>
						<p class="description">This content will be show on single product page as per choosen position.</p>
					</td>				
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="single_page_wpnonce" value="<?php echo $nonce= wp_create_nonce('wsppcp_single_page_wpnonce'); ?>">
		<input type="submit" class="button button-primary " name="update_option" value="Update">			
	</form>
	<?php
	die;
}
/** Admin Panel Edit Hook Form End */


/** Admin Panel Remove Hook Form Start */
add_action("wp_ajax_wsppcp_remove_global_hook", "wsppcp_removed_hook");
function wsppcp_removed_hook(){	
	check_ajax_referer( 'wsppcp_ajax_remove_nonce', 'security' );
	$hook	= '';
	if(isset($_POST['hook_name'])){
		$hook = sanitize_text_field($_POST['hook_name']);
	}
	if(isset($hook) && !empty($hook)){

		$wsppcp_hook = wsppcp_get_hook();
		unset($wsppcp_hook[$hook]);
		update_option('wsppcp_hook',$wsppcp_hook);
		echo true;
	}else{
		echo false;
	}
	die;
}
/** Admin Panel Remove Hook Form End */


/** Single Product Page Hook Add Ajax Strat */

add_action('wp_ajax_wsppcp_single_product_add_form','wsppcp_single_product_add_form');
add_action( 'wp_ajax_nopriv_wsppcp_single_product_add_form', 'wsppcp_single_product_add_form' );

function wsppcp_single_product_add_form(){
	$hook		= "";
	$hook_value	= "";
	$all_hook	= "";
	$product_id = "";
	$current_page 		= "";

	if(isset($_POST['product_id']))				$product_id = $_POST['product_id'];
	if(isset($_REQUEST['current_page']))		$current_page = $_REQUEST['current_page'];
	if($_POST['form_action']=='add_form')		check_ajax_referer( 'wsppcp_ajax_add_nonce', 'security' );
	if($_POST['form_action']=='edit_form')		check_ajax_referer( 'wsppcp_ajax_edit_nonce', 'security' );	

		
	if(isset($_POST['hook_name']) && !empty($_POST['hook_name']) )		 $hook					= sanitize_text_field($_POST['hook_name']);	


	if(isset($current_page) && !empty($current_page) && $current_page == "term"){

		$prodcut_position_hook 	= get_term_meta($product_id, 'wsppcp_product_categories_position', true);

		if(isset($prodcut_position_hook) && !empty($prodcut_position_hook)) $hook_value 			= $prodcut_position_hook[$hook];
	
		$all_hook	= get_term_meta($product_id, 'wsppcp_product_categories_position', true);

	}else{

		$prodcut_position_hook 	= get_post_meta($product_id, 'wsppcp_single_product_position', true);
		if(isset($prodcut_position_hook) && !empty($prodcut_position_hook)) $hook_value 			= $prodcut_position_hook[$hook];
	
		$all_hook	= get_post_meta($product_id, 'wsppcp_single_product_position', true);
	}
	
	?>
	<section method="post" class="wsppcp_form">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<?php 
					if(empty($hook)) { ?>
						<th scope="row">
							<span><strong>Select Position</strong></span>
							<span>
								<select name="hook">
									<?php 
									global $hook_list; 
									$i	= 1;							

									if(isset($hook_list) && !empty($hook_list)){
										foreach($hook_list as $hooks){
											$disable_key="";
											
											if(isset($all_hook[$hooks])) $disable_key = 'disabled="disabled"'; 	  ?>										
												
												<option <?php echo $disable_key; ?> value="<?php echo $hooks ?>"><?php echo  $i.". ".str_replace("_"," ",$hooks); ?></option>
	
												<?php 
											$i++;
										} 
									}
									?>
								</select>
								<p class="description">Refere bellow position map.</p>
							</span>
						</th>
						<?php 
					} else {  ?>
						<input type="hidden" name="hook" value="<?php echo $hook; ?>">
						<input type="hidden" name="edit_form" value="1">
						<?php
					} ?>
				</tr>			
				<tr valign="top">				
					<td>
						<textarea name="wsppcp_product_content" id="content_<?php echo $hook;?>" rows="12" class="wsppcp_content wp-editor"> <?php  echo wp_unslash($hook_value); ?></textarea>
						<p class="description">This content will be show on single product page as per choosen position.</p>
					</td>				
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="single_page_wpnonce" value="<?php echo $nonce= wp_create_nonce('wsppcp_single_page_wpnonce'); ?>">
		<input type="submit" class="button button-primary " name="update_option" value="Update">			
	</section>
	<?php
	die;
}
/** Single Product Page Hook Add Ajax End */


/**  Single Product Page Remove Hook Form Start */
add_action("wp_ajax_wsppcp_remove_single_product_hook", "wsppcp_remove_single_product_hook");
function wsppcp_remove_single_product_hook()
{	
	check_ajax_referer( 'wsppcp_ajax_remove_nonce', 'security' );
	$hook		=	'';
	$product_id = $_POST['product_id'];
	$current_page	= "";

	if(isset($_POST['product_id']) ) 	$product_id	= $_POST['product_id'];
	if(isset($_REQUEST['current_page']))				$current_page = $_REQUEST['current_page'];
	if(isset($_POST['hook_name']) ) 	$hook		= sanitize_text_field($_POST['hook_name']);


	if(isset($product_id) && !empty($product_id)){
		$single_page_hook_list = array();	
		echo $current_page;
		if(isset($current_page) && !empty($current_page) && $current_page == "term"){

			$single_page_hook_list = get_term_meta($product_id, 'wsppcp_product_categories_position', true);   
			print_r($single_page_hook_list);    
			unset($single_page_hook_list[$hook]);
			update_term_meta($product_id, 'wsppcp_product_categories_position', $single_page_hook_list);
	
		}else{
			
			$single_page_hook_list = get_post_meta($product_id, 'wsppcp_single_product_position', true);        
			unset($single_page_hook_list[$hook]);
			update_post_meta($product_id, 'wsppcp_single_product_position', $single_page_hook_list);
		}
		echo $product_id;
		echo true;
	}else{
		echo false;
	}
	die;
}
/**  Single Product Page  Remove Hook Form End */







?>