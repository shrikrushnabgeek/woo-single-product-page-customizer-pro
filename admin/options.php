<?php 
if( !defined( 'ABSPATH' ) ) exit;
$default_tab = null;
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
/** Genral Setting Option Start */
if(isset($_POST['update_option'])){
	$hook				= "";
	$edit_form			= "";
	$content			= "";
	$nonce				= "";
	$post_hook			= array();
	$post_hook_exclude	= array();
	$exclude_post		= array();		
	$exclude_category	= array();

	if(isset($_POST['hook']))						$hook				= sanitize_text_field($_POST['hook']);
	if(isset($_POST['edit_form']))					$edit_form			= sanitize_text_field($_POST['edit_form']);
	if(isset($_POST['content'])) 					$content			= htmlentities($_POST['content']);
	if(isset($_POST['wsppcp_exclude-post']))		$exclude_post		= $_POST['wsppcp_exclude-post'];
	if(isset($_POST['wsppcp_exclude-category']))	$exclude_category	= $_POST['wsppcp_exclude-category'];
	if(isset($_POST['single_page_wpnonce']))		$nonce				= $_POST['single_page_wpnonce'];
	
	if(isset($hook) && !empty($hook)) 				$post_hook[$hook]	= $content;
	if(isset($hook) && !empty($hook)){			
		$post_hook_exclude[$hook.'_exclude'] = array( 
			'exclude_post'		=> $exclude_post,
			'exclude_category'	=> $exclude_category
		);
	}

	if(wp_verify_nonce( $nonce, 'wsppcp_single_page_wpnonce' ))	{
		$wsppcp_hook			= wsppcp_get_hook();
		$wsppcp_hook_exclude	= wsppcp_get_hook_exclude();
		if($wsppcp_hook){	
		 	if (array_key_exists($hook,$wsppcp_hook) && $edit_form!=1){
				$errormsg	= wsppcp_error_message("This Position '$hook' already saved please update it.");
			} else {
				if($edit_form==1){
					$wsppcp_hook[$hook] = $content;
					update_option('wsppcp_hook',$wsppcp_hook);
					if(isset($wsppcp_hook_exclude) && !empty($wsppcp_hook_exclude)){	
						$wsppcp_hook_exclude[$hook.'_exclude'] = array(	
							'exclude_post'		=> $exclude_post,
							'exclude_category'	=> $exclude_category
						);
						update_option('wsppcp_hook_exclude',$wsppcp_hook_exclude);
					}else{
						update_option('wsppcp_hook_exclude', $post_hook_exclude);
					}
					$errormsg	= wsppcp_success_message("Settings Saved!");
				}else{
					$final_hook = array_merge($post_hook,$wsppcp_hook);
					update_option('wsppcp_hook',$final_hook);
					
					$final_hook_exclude = (isset($wsppcp_hook_exclude) && !empty($wsppcp_hook_exclude))? array_merge($post_hook_exclude, $wsppcp_hook_exclude) : $post_hook_exclude;
					update_option('wsppcp_hook_exclude', $final_hook_exclude);

					$errormsg	= wsppcp_success_message("Settings Saved!");
				}
			}
			
		}else{			
			update_option('wsppcp_hook',$post_hook);
			update_option('wsppcp_hook_exclude', $post_hook_exclude);
		}
	}	
}
$wsppcp_hooks=wsppcp_get_hook();
/** Genral Setting Option End */

/** Remove Content Option Start */
$wsppcp_hook_value=array(
	'Hide Flash Sale'				=>	'woocommerce_show_product_sale_flash',
	'Hide Product Title'			=>	'woocommerce_template_single_title',
	'Hide Product Price'			=>	'woocommerce_template_single_price',
	'Hide Product Rating'			=>	'woocommerce_template_single_rating',
	'Hide Short Description'		=>	'woocommerce_template_single_excerpt',
	'Hide Categories & SKU'			=>	'woocommerce_template_single_meta',
	'Hide Add to Cart'				=>	'woocommerce_template_single_add_to_cart',
	'Hide Thumbnail Product'		=>	'woocommerce_show_product_thumbnails',
	'Hide Related Product'			=>	'woocommerce_output_related_products',
	'Hide Description Tab'			=>	'wsppcp_woocommerce_product_description_tab',
	'Hide Review Tab'				=>	'wsppcp_woocommerce_product_review_tab',
	'Hide Additional Information'	=>	'wsppcp_woocommerce_product_additional_information_tab',
	'Hide All Product Tabs'			=>	'wsppcp_woocommerce_product_all_tab',
);

$wsppcp_wc_single_value = "";
$wsppcp_wc_single_page = "";
if(isset($_POST['wsppcp-remove-submit'])){
	if(isset($_POST['wsppcp_single_checkbox']) && !empty($_POST['wsppcp_single_checkbox'])){
		$wsppcp_wc_single_page	=	sanitize_text_field(json_encode($_POST['wsppcp_single_checkbox']));
	}

	$nonce=$_POST['wsppcp_wpnonce'];
	if(wp_verify_nonce( $nonce, 'wsppcp_nonce' ))
	{	
		update_option('wsppcp_hide_single_page_conetnt_hook', $wsppcp_wc_single_page);
		$successmsg= wsppcp_success_message('Settings Saved!');
	}
	else
	{
		$errormsg= wsppcp_error_message('An error has occurred.');
	}
}

$wsppcp_get_wc_single_opt	=	get_option('wsppcp_hide_single_page_conetnt_hook');
$wsppcp_wc_single_value		=	json_decode($wsppcp_get_wc_single_opt);
/** Remove Content Option End */

/** Label Setting Option Start */
if(isset($_POST['wsppcp_label_submit'])){
	$description_tab_title 			=	"";
	$additional_info_tab_title		=	"";
	$description_heading 			=	"";
	$additional_info_heading		=	"";
	$reviews_tabbing_title			=	"";
	$add_to_cart_text				=	"";
	$single_out_of_stock_text 		=	"";
	$single_backorder_text 			= 	"";
	$single_sale_flash_text			= 	"";
	$default_option_variations		= 	"";
	$related_product_title			= 	"";
	$related_product_per_page		= 	"";
	$related_product_column			= 	"";
	$label_options					= 	array();

	if(!empty($_POST['description_tab_title']) && isset($_POST['description_tab_title']))		$description_tab_title		= sanitize_text_field($_POST['description_tab_title']);
	if(!empty($_POST['additional_tab_title']) && isset($_POST['additional_tab_title']))			$additional_info_tab_title	= sanitize_text_field($_POST['additional_tab_title']);
	if(!empty($_POST['reviews_tab_title']) && isset($_POST['reviews_tab_title']))				$reviews_tabbing_title		= sanitize_text_field($_POST['reviews_tab_title']);
	if(!empty($_POST['description_con_title']) && isset($_POST['description_con_title']))		$description_heading		= sanitize_text_field($_POST['description_con_title']);
	if(!empty($_POST['additional_con_title']) && isset($_POST['additional_con_title']))			$additional_info_heading	= sanitize_text_field($_POST['additional_con_title']);
	if(!empty($_POST['cart_btn_text']) && isset($_POST['cart_btn_text']))						$add_to_cart_text			= sanitize_text_field($_POST['cart_btn_text']);
	if(!empty($_POST['related_pro_title']) && isset($_POST['related_pro_title']))				$related_product_title		= sanitize_text_field($_POST['related_pro_title']);

	if(isset($_POST['stock_out_description']))		$single_out_of_stock_text	= sanitize_text_field($_POST['stock_out_description']);
	if(isset($_POST['backorder_text']))				$single_backorder_text		= sanitize_text_field($_POST['backorder_text']);
	if(isset($_POST['sale_badge_text']))			$single_sale_flash_text		= sanitize_text_field($_POST['sale_badge_text']);
	if(isset($_POST['variable_default_option']))	$default_option_variations	= sanitize_text_field($_POST['variable_default_option']);
	if(isset($_POST['related_per_page']))			$related_product_per_page	= sanitize_text_field($_POST['related_per_page']);
	if(isset($_POST['related_pro_columns']))		$related_product_column		= sanitize_text_field($_POST['related_pro_columns']);

	if(!empty($description_tab_title))		$label_options['woocommerce_product_description_tab_title']				= $description_tab_title;
	if(!empty($additional_info_tab_title))	$label_options['woocommerce_product_additional_information_tab_title']	= $additional_info_tab_title;
	if(!empty($reviews_tabbing_title))		$label_options['woocommerce_product_reviews_tab_title']					= $reviews_tabbing_title;
	if(!empty($description_heading))		$label_options['woocommerce_product_description_heading']				= $description_heading;
	if(!empty($additional_info_heading))	$label_options['woocommerce_product_additional_information_heading']	= $additional_info_heading;
	if(!empty($add_to_cart_text))			$label_options['woocommerce_product_single_add_to_cart_text']			= $add_to_cart_text;
	if(!empty($related_product_title))		$label_options['woocommerce_product_related_products_heading']			= $related_product_title;
	if(!empty($single_out_of_stock_text))	$label_options['wsppcp_out_of_stock_text']								= $single_out_of_stock_text;
	if(!empty($single_backorder_text))		$label_options['wsppcp_backorder_text']									= $single_backorder_text;
	if(!empty($single_sale_flash_text))		$label_options['wsppcp_sale_flash_text']								= $single_sale_flash_text;
	if(!empty($default_option_variations))	$label_options['wsppcp_default_attribute_options']						= $default_option_variations;
	if(!empty($related_product_per_page))	$label_options['wsppcp_related_product_no']								= $related_product_per_page;
	if(!empty($related_product_column))		$label_options['wsppcp_related_product_column']							= $related_product_column;
	
	$label_nonce	= $_POST['wsppcp_label_wpnonce'];

	if (wp_verify_nonce($label_nonce, 'wsppcp_label_nonce')) {
		$res = update_option('wsppcp_sinagle_page_label_update_setting', $label_options);
		$successmsg = wsppcp_success_message('Settings Saved!');
	}
}

$description_tab_title 			=	"";
$additional_info_tab_title		=	"";
$description_heading 			=	"";
$additional_info_heading		=	"";
$reviews_tabbing_title			=	"";
$add_to_cart_text				=	"";
$single_out_of_stock_text 		=	"";
$single_backorder_text 			= 	"";
$single_sale_flash_text			= 	"";
$default_option_variations		= 	"";
$related_product_title			= 	"";
$related_product_per_page		= 	"";
$related_product_column			= 	"";
$label_options 					= 	wsppcp_single_page_label_option();


if(isset($label_options['woocommerce_product_description_tab_title']))				$description_tab_title		= $label_options['woocommerce_product_description_tab_title'];
if(isset($label_options['woocommerce_product_additional_information_tab_title']))	$additional_info_tab_title	= $label_options['woocommerce_product_additional_information_tab_title'];
if(isset($label_options['woocommerce_product_description_heading']))				$description_heading		= $label_options['woocommerce_product_description_heading'];
if(isset($label_options['woocommerce_product_additional_information_heading']))		$additional_info_heading	= $label_options['woocommerce_product_additional_information_heading'];
if(isset($label_options['woocommerce_product_reviews_tab_title']))					$reviews_tabbing_title		= $label_options['woocommerce_product_reviews_tab_title'];
if(isset($label_options['woocommerce_product_single_add_to_cart_text']))			$add_to_cart_text			= $label_options['woocommerce_product_single_add_to_cart_text'];
if(isset($label_options['woocommerce_product_related_products_heading']))			$related_product_title		= $label_options['woocommerce_product_related_products_heading'];
if(isset($label_options['wsppcp_out_of_stock_text']))								$single_out_of_stock_text	= $label_options['wsppcp_out_of_stock_text'];
if(isset($label_options['wsppcp_backorder_text']))									$single_backorder_text		= $label_options['wsppcp_backorder_text'];
if(isset($label_options['wsppcp_sale_flash_text']))									$single_sale_flash_text		= $label_options['wsppcp_sale_flash_text'];
if(isset($label_options['wsppcp_default_attribute_options']))						$default_option_variations	= $label_options['wsppcp_default_attribute_options'];
if(isset($label_options['wsppcp_related_product_no']))								$related_product_per_page	= $label_options['wsppcp_related_product_no'];
if(isset($label_options['wsppcp_related_product_column']))							$related_product_column		= $label_options['wsppcp_related_product_column'];
/** Label Setting Option End */	
?>
<div class="wrap wsppcp-main-box">
	<h1 class="wsppcp-h1-title"><?php _e('Woocommerce Single Product Page Customizer Pro','woo-single-product-page-customizer-pro') ?></h1>
	<?php 
	if(isset($successmsg)){
		echo $successmsg;
	}?>
	<nav class="nav-tab-wrapper">
		<a href="?page=wsppcp-woocommerce-single-product-page-customizer" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>"><?php _e('General Setting', 'woo-single-product-page-customizer-pro'); ?></a>
		<a href="?page=wsppcp-woocommerce-single-product-page-customizer&tab=remove-content" class="nav-tab <?php if ($tab === 'remove-content') : ?>nav-tab-active<?php endif; ?>"><?php _e('Remove Content', 'woo-single-product-page-customizer-pro'); ?></a>
		<a href="?page=wsppcp-woocommerce-single-product-page-customizer&tab=label-setting" class="nav-tab <?php if ($tab === "label-setting") : ?>nav-tab-active<?php endif; ?>"><?php _e('Labels Setting', 'woo-single-product-page-customizer-pro'); ?></a>
	</nav>

	<!-- General Setting Tabbing Html Start -->
	<div class="wsppcp-hidden <?php if ($tab == null) { 	_e('wsppcp-active-tab'); } ?>">
		<div class="wsppcp-page-title">
			<h2><?php _e('Woocommerce Single Product Page Customizer Pro','woo-single-product-page-customizer-pro'); ?> &raquo; <?php _e( 'Settings', 'woo-single-product-page-customizer-pro' ); ?></h2>	
			<?php 
			if(!empty($wsppcp_hooks)){ ?>
				<span class="wsppcp_ajax_loader edit_ajax_loader"></span>
				<input type="button" value="Remove All" id="wsppcp_clear_all" class="wsppcp-submit-button wsppcp-cancel-button">
				<?php 
			}?>
		</div>
		<div class='wsppcp_inner'>
			<?php
			if ( isset( $errormsg ) ) {?>
				<div class="error fade"><p><?php _e($errormsg); ?></p></div>
				<?php
			}
			?>
			<ul class="wsppcp_toggle wsppcp_tab wsppcp_hooks_list">
				<?php if(!empty($wsppcp_hooks)){ 
					$wsppcp_hooks = array_reverse($wsppcp_hooks);
					foreach($wsppcp_hooks as $key=>$wsppcp_hook) {?>
					<li>
						<span class="wsppcp_hook_name"><?php echo str_replace("_"," ",$key);?></span>
						<span class="wsppcp_hook_action">
						<span class="wsppcp_ajax_loader edit_ajax_loader"></span>
						<a class="wsppcp_edit_hook wsppcp_edit_global_hook" data-hook='<?php _e($key); ?>' href="javascript:void(0)"><?php _e('Edit','woo-single-product-page-customizer-pro'); ?></a>

						<a class="wsppcp_remove_hook wsppcp_remove_global_hook"  data-hook='<?php _e($key); ?>' href="javascript:void(0)"><?php _e('Remove','woo-single-product-page-customizer-pro'); ?></a>
						</span>
						<div class="wsppcphook_details" style="display:none"></div>
					</li>
				<?php } 
			}?></ul>
			<a class="wsppcp_add_form_link wsppcp_add_global_position" href="javascript:void(0);" ><?php _e('Add New Position','woo-single-product-page-customizer-pro'); ?></a>
			<span class="wsppcp_ajax_loader"></span>
			<div class="wsppcp_add_hook_form"></div>
		</div>
		<div class="wsppcp-single-page-position-box">
			<h2><?php _e('Woocommerce Single Product Page Position','woo-single-product-page-customizer-pro'); ?> <span class="wsppcp-position-map-accordion"><?php _e('Guide Map','woo-single-product-page-customizer-pro'); ?></span></h2>
			<img  class="wsppcp-woo-single-page-position-map-img" style="display:none;" src="<?php _e(plugins_url('../admin/assets/image/wsppcp-product-page-guide-map-new.jpg', __FILE__)); ?>" alt="Woocommerce Single page position map Image">	
			<?php 
				$ajax_add_nonce 	= wp_create_nonce( "wsppcp_ajax_add_nonce" ); 
				$ajax_edit_nonce 	= wp_create_nonce( "wsppcp_ajax_edit_nonce" );
				$ajax_remove_nonce 	= wp_create_nonce( "wsppcp_ajax_remove_nonce" );
				$admin_ajax_url 	= admin_url('admin-ajax.php');
			?>
			<input type="hidden" value="<?php _e($ajax_add_nonce); ?>" name="ajax_add_nonce" class="wsppcp_ajax_add_nonce">
			<input type="hidden" value="<?php _e($ajax_edit_nonce); ?>" name="ajax_edit_nonce" class="wsppcp_ajax_edit_nonce">
			<input type="hidden" value="<?php _e($ajax_remove_nonce); ?>" name="ajax_remove_nonce" class="wsppcp_ajax_remove_nonce">
		</div>
	</div>
	<!-- General Setting Tabbing Html End -->

	<!-- Remove Content Tabbing Html Start -->
	<form method="post" id="wsppcp_remove_content" class="wsppcp-hidden <?php if ($tab == "remove-content") { _e('wsppcp-active-tab'); } ?>">
		<h2><?php _e('Woocommerce Single Product Page Customizer Pro','woo-single-product-page-customizer-pro'); ?> &raquo; <?php _e( 'Remove Content', 'woo-single-product-page-customizer-pro' ); ?></h2>	
		<div class="wsppcp form-table wsppcp_table">
			<div class="wsppcp-list-box">
				<ul>
					<li>
						<div class="wsppcp-list">
							<label>Check All</label>
							<div><input name="wsppcp_single_page" type="checkbox" id="wsppcp_single_page" value=""></div>
						</div>
					</li>
					<?php foreach($wsppcp_hook_value as $wsppcp_title => $wsppcp_hook ){  ?>
						<li>
							<div class="wsppcp-list">
								<label><?php echo $wsppcp_title; ?></label>
								<div><input name="wsppcp_single_checkbox[]" type="checkbox" id="wsppcp_<?php echo $wsppcp_hook; ?>" value="<?php echo $wsppcp_hook ?>" <?php if(!empty($wsppcp_wc_single_value)){ if(in_array($wsppcp_hook,$wsppcp_wc_single_value)){ echo "checked";}}?> ></div>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<input type="hidden" name="wsppcp_wpnonce" value="<?php echo $nonce= wp_create_nonce('wsppcp_nonce'); ?>">				
		<input type="submit" value="Submit" class="wsppcp-submit-button" name="wsppcp-remove-submit">
	</form>
	<!-- Remove Content Tabbing Html End -->
	
	<!-- Label Setting Tabbing Html Start -->
	<form method="post" id="wsppcp_label_setting" class="wsppcp-hidden <?php if ($tab == "label-setting") { _e('wsppcp-active-tab'); } ?>">
		<h2><?php _e('Woocommerce Single Product Page Customizer Pro','woo-single-product-page-customizer-pro'); ?> &raquo; <?php _e( 'Label Setting', 'woo-single-product-page-customizer-pro' ); ?></h2>	
		<div class="wsppcp-label-box">
			<h3><?php _e('Tab Titles','woo-single-product-page-customizer-pro'); ?></h3>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Product Description','woo-single-product-page-customizer-pro'); ?> </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="description_tab_title"   <?php if(isset($description_tab_title)){ echo 'value="'.$description_tab_title.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes the Production Description tab title.','woo-single-product-page-customizer-pro'); ?></span>
				</div>
			</div>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Additional Information','woo-single-product-page-customizer-pro'); ?>  </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="additional_tab_title"  <?php if(isset($additional_info_tab_title)){ echo 'value="'.$additional_info_tab_title.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes the Additional Information tab title.','woo-single-product-page-customizer-pro'); ?></span>
				</div>
			</div>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Reviews','woo-single-product-page-customizer-pro'); ?></label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="reviews_tab_title"  <?php if(isset($reviews_tabbing_title)){ echo 'value="'.$reviews_tabbing_title.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes the Reviews tab title.','woo-single-product-page-customizer-pro'); ?></span>
					<p class="description"><b>Note:</b> &nbsp; Use <code>{count}</code> to insert reviews count, e.g., "Reviews ({count}) ".</p>
				</div>
			</div>
		</div>
		<div class="wsppcp-label-box">
			<h3><?php _e('Tab Content Headings','woo-single-product-page-customizer-pro'); ?></h3>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Product Description','woo-single-product-page-customizer-pro'); ?> </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="description_con_title"  <?php if(isset($description_heading)){ echo 'value="'.$description_heading.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes the Product Description tab heading.','woo-single-product-page-customizer-pro'); ?></span>
				</div>
			</div>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Additional Information','woo-single-product-page-customizer-pro'); ?>  </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="additional_con_title" <?php if(isset($additional_info_heading)){ echo 'value="'.$additional_info_heading.'"'; } ?>  >
					<span class="wsppcp-note"><?php _e('Changes the Additional Information tab heading.','woo-single-product-page-customizer-pro'); ?></span>
				</div>
			</div>
		</div>
		<div class="wsppcp-label-box">
			<h3><?php _e('Add to Cart Button Text','woo-single-product-page-customizer-pro'); ?></h3>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('All Product Types','woo-single-product-page-customizer-pro'); ?></label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="cart_btn_text"  <?php if(isset($add_to_cart_text)){ echo 'value="'.$add_to_cart_text.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes the Add to Cart button text on the single product page for all product type.','woo-single-product-page-customizer-pro'); ?></span>
				</div>
			</div>
		</div>
		<div class="wsppcp-label-box">
			<h3><?php _e('Out of Stock Text','woo-single-product-page-customizer-pro'); ?></h3>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Out of Stock Text','woo-single-product-page-customizer-pro'); ?></label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="stock_out_description" <?php if(isset($single_out_of_stock_text)){ echo 'value="'.$single_out_of_stock_text.'"'; } ?>  >
					<span class="wsppcp-note"><?php _e('Changes text for the out of stock on product pages. Default: "Out of stock"','woo-single-product-page-customizer-pro'); ?></span>
				</div>
			</div>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Backorder text','woo-single-product-page-customizer-pro'); ?> </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="backorder_text"  <?php if(isset($single_backorder_text)){ echo 'value="'.$single_backorder_text.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes text for the backorder on product pages. Default: "Available on backorder"','woo-single-product-page-customizer-pro'); ?></span>
				</div>
			</div>
		</div>
		<div class="wsppcp-label-box">
			<h3><?php _e('Sale Flash','woo-single-product-page-customizer-pro'); ?></h3>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Sale badge text ','woo-single-product-page-customizer-pro'); ?></label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="sale_badge_text"  <?php if(isset($single_sale_flash_text)){ echo 'value="'.$single_sale_flash_text.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes text for the sale flash on product pages. Default: "Sale!"','woo-single-product-page-customizer-pro'); ?></span>
					<p class="description"><?php _e('<b>Note:</b> &nbsp; Use <code>{percent}</code> to insert percent off, e.g., "{percent} off!"<br>Shows "up to n%" for grouped or variable products if multiple percentages are possible.','woo-single-product-page-customizer-pro'); ?></p>
				</div>
			</div>
		</div>

		<div class="wsppcp-label-box">
			<h3><?php _e('Variable Product','woo-single-product-page-customizer-pro'); ?></h3>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Default Option Text ','woo-single-product-page-customizer-pro'); ?> </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="variable_default_option"  <?php if(isset($default_option_variations)){ echo 'value="'.$default_option_variations.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes text for the all variations default option.','woo-single-product-page-customizer-pro'); ?> </span>
				</div>
			</div>
		</div>

		<div class="wsppcp-label-box">
			<h3><?php _e('Related products','woo-single-product-page-customizer-pro'); ?></h3>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Related Products Title','woo-single-product-page-customizer-pro'); ?> </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="text" name="related_pro_title"   <?php if(isset($related_product_title)){ echo 'value="'.$related_product_title.'"'; } ?> >	
					<span class="wsppcp-note"><?php _e('Changes the related product title.','woo-single-product-page-customizer-pro'); ?> </span>
				</div>
			</div>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Products displayed per page','woo-single-product-page-customizer-pro'); ?> </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="number" name="related_per_page" min="0" max="4"  <?php if(isset($related_product_per_page)){ echo 'value="'.$related_product_per_page.'"'; } ?>  >	
					<span class="wsppcp-note"><?php _e('Changes the number of products displayed per page, maximum show 4 products.','woo-single-product-page-customizer-pro'); ?>  </span>
				</div>
			</div>
			<div class="wsppcp-box-desc">
				<div class="wsppcp-label">
					<label><?php _e('Product columns displayed','woo-single-product-page-customizer-pro'); ?>  </label>		
				</div>
				<div class="wsppcp-label-content">
					<input type="number" name="related_pro_columns" min="1" <?php if(isset($related_product_column)){ echo 'value="'.$related_product_column.'"'; } ?>  >	
					<span class="wsppcp-note"><?php _e('Changes the number of columns displayed per page.','woo-single-product-page-customizer-pro'); ?>  </span>
				</div>
			</div>
		</div>

		<input type="hidden" name="wsppcp_label_wpnonce" value="<?php echo $nonce= wp_create_nonce('wsppcp_label_nonce'); ?>">				
		<input type="submit" value="Submit" class="wsppcp-submit-button" name="wsppcp_label_submit">
	</form>
	<!-- Label Setting Tabbing Html End -->
</div>