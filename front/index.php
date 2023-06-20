<?php



/** Front Side Global Content Print Strat */
 
add_action( 'init', 'global_content_print_function' );
 
function global_content_print_function() {

	$wsppcp_hooks	=	wsppcp_get_hook();
	if(!empty($wsppcp_hooks)){
		foreach($wsppcp_hooks as $key => $wsppcp_hook){

			if($key == 'woocommerce_after_single_product_summary'){
				add_action( $key, 'wsppcp_single_product_product_summary_hook',8);

			}elseif($key == 'woocommerce_single_product_summary'){
				add_action( $key, 'wsppcp_single_product_page_hook',4);

			}elseif($key == 'woocommerce_after_product_title'){

				add_action( 'woocommerce_single_product_summary','woocommerce_after_product_title',5);

			}elseif($key == 'woocommerce_after_product_price'){

				add_action( 'woocommerce_single_product_summary' , 'woocommerce_after_product_price' ,10);

			}elseif($key == 'woocommerce_product_thumbnails'){

				add_action( 'woocommerce_after_single_product_summary','woocommerce_product_thumbnails',5);
				
			}else{

				add_action( $key, 'wsppcp_single_product_page_hook',10);
			}
	
		}
	}
}
function wsppcp_single_product_page_hook($arg) {
	$hook = current_filter();
	$wsppcp_hooks=wsppcp_get_hook(); 

	echo "<div class='wsppcp_div_block ".$hook." '>";
		echo wsppcp_output($wsppcp_hooks[$hook]);
		echo "</div>";
	
}

function wsppcp_single_product_product_summary_hook($arg) {
	$hook = current_filter();
	$wsppcp_hooks=wsppcp_get_hook(); 

	echo "<div class='wsppcp_div_block wsppcp_product_summary_text'>";
	echo wsppcp_output($wsppcp_hooks[$hook]);
	echo "</div>";
	
}

function woocommerce_after_product_title(){
	$wsppcp_hooks	=	wsppcp_get_hook(); 
				
	echo "<div class='wsppcp_div_block woocommerce_after_product_title'>";
	echo wsppcp_output($wsppcp_hooks['woocommerce_after_product_title']);
	echo "</div>";
}

function woocommerce_after_product_price(){
	$wsppcp_hooks	=	wsppcp_get_hook(); 
			
	echo "<div class='wsppcp_div_block woocommerce_after_product_price'>";
	echo wsppcp_output($wsppcp_hooks['woocommerce_after_product_price']);
	echo "</div>";
}

function woocommerce_product_thumbnails($arg) {

	$wsppcp_hooks=wsppcp_get_hook(); 

	echo "<div class='woocommerce_product_thumbnails'>";
	echo wsppcp_output($wsppcp_hooks['woocommerce_product_thumbnails']);
	echo "</div>";
	
}

/** Front Side Global Content Print End */



/** front side Css */
function wsppcp_front_site_css_add() {
    ?>
        <style>
             .wsppcp_div_block {
				display: inline-block;
				width: 100%;
				margin-top: 10px;
			}
			.wsppcp_div_block.wsppcp_product_summary_text {
				display: inline-block;
				width: 100%;
			}
			.wsppcp_div_block.wsppcp_category_pos20 {
				display: inline-block;
				width: 100%;
			}
			.product-type-simple .woocommerce_product_thumbnails{
				display: inline-block;
				width: 100%;
			}
			.product-type-variable .woocommerce_product_thumbnails{
				display: inline-block;
			}
        </style>
    <?php
}
add_action('wp_head', 'wsppcp_front_site_css_add');



