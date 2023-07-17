<?php 
/** Remove Content Tabbing Strat */
add_action('init', 'wsppcp_remove_content_single_product_page', 2  );
function wsppcp_remove_content_single_product_page(){
	
	$wsppcp_get_wc_single_opt=get_option('wsppcp_hide_single_page_conetnt_hook');
	$wsppcp_wc_hooks=json_decode($wsppcp_get_wc_single_opt);
	if(!empty($wsppcp_wc_hooks)){		
		foreach($wsppcp_wc_hooks as $wsppcp_wc_key => $wsppcp_wc_hook)
		{
			if($wsppcp_wc_hook  == "woocommerce_template_single_title"){
				remove_action( 'woocommerce_single_product_summary', $wsppcp_wc_hook, 5 );
			}
			if($wsppcp_wc_hook  == "woocommerce_show_product_sale_flash"){
				remove_action( 'woocommerce_before_single_product_summary', $wsppcp_wc_hook , 10);
			}
			if($wsppcp_wc_hook  == "woocommerce_template_single_price"){
				remove_action( 'woocommerce_single_product_summary', $wsppcp_wc_hook , 10);
			}
			if($wsppcp_wc_hook  == "woocommerce_template_single_rating"){
				remove_action( 'woocommerce_single_product_summary', $wsppcp_wc_hook , 10);
			}
			if($wsppcp_wc_hook  == "woocommerce_template_single_excerpt"){
				remove_action( 'woocommerce_single_product_summary', $wsppcp_wc_hook , 20);
			}
			if($wsppcp_wc_hook  == "woocommerce_template_single_meta"){
				remove_action( 'woocommerce_single_product_summary',$wsppcp_wc_hook , 40);
			}
			if($wsppcp_wc_hook  == "woocommerce_template_single_add_to_cart"){
				remove_action( 'woocommerce_single_product_summary',$wsppcp_wc_hook , 30);
			}
			if($wsppcp_wc_hook  == "woocommerce_show_product_thumbnails"){
				remove_action( 'woocommerce_product_thumbnails',$wsppcp_wc_hook , 20);
			}
			if($wsppcp_wc_hook  == "woocommerce_output_related_products"){
				remove_action( 'woocommerce_after_single_product_summary',$wsppcp_wc_hook , 20);
			}
			if($wsppcp_wc_hook  == "wsppcp_woocommerce_product_description_tab"){
				function wsppcp_woocommerce_product_description_tabs( $tabs ) {
					unset( $tabs['description'] );
					return $tabs;
				}
				add_filter( 'woocommerce_product_tabs', 'wsppcp_woocommerce_product_description_tabs', 98 );
			}
			if($wsppcp_wc_hook  == "wsppcp_woocommerce_product_review_tab"){
				function wsppcp_woocommerce_product_review_tabs( $tabs ) {
					unset( $tabs['reviews'] );
					return $tabs;
				}
				add_filter( 'woocommerce_product_tabs', 'wsppcp_woocommerce_product_review_tabs', 98 );
			}
			
			if($wsppcp_wc_hook  == "wsppcp_woocommerce_product_additional_information_tab"){
				add_filter( 'woocommerce_product_tabs', 'wsppcp_woocommerce_product_additional_info_tabs', 98 );
				function wsppcp_woocommerce_product_additional_info_tabs( $tabs ) {
					unset( $tabs['additional_information'] );
					return $tabs;
				}
				
			}
			if($wsppcp_wc_hook  == "wsppcp_woocommerce_product_all_tab"){
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs',10);
			}
			
		}
	}
}
/** Remove Content Tabbing Strat */
?>