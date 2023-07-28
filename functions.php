<?php
if( !defined( 'ABSPATH' ) ) exit;
function wsppcp_selectively_enqueue_admin_script( $hook ) {
	wp_enqueue_editor();
	wp_enqueue_media ();
}
add_action( 'admin_enqueue_scripts', 'wsppcp_selectively_enqueue_admin_script' );

function wsppcp_get_hook(){
	return get_option('wsppcp_hook');
}

function wsppcp_get_hook_exclude(){
	return get_option('wsppcp_hook_exclude');
}

function wsppcp_single_page_label_option(){
	return get_option('wsppcp_sinagle_page_label_update_setting');
}
function  wsppcp_error_message($msg){
	echo '<div class="notice notice-success wsppcp-error-msg is-dismissible"><p> ' . $msg . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';	
	
}
function  wsppcp_success_message($msg){
	echo '<div class="notice notice-success wsppcp-success-msg is-dismissible"><p> ' . $msg . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text"> Dismiss this notice.</span></button></div>';
}

function wsppcp_get_hook_value($hook){
	$all_hook=wsppcp_get_hook();
	return $all_hook[$hook];
}

function wsppcp_output($meta){
	if ( empty( $meta ) ) {
		return;
	}
	if ( trim( $meta ) == '' ) {
		return;
	}
	return do_shortcode(html_entity_decode(wp_unslash( $meta )));
}