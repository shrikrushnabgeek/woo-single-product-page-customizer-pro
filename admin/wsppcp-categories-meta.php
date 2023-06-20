<?php


add_action('product_cat_edit_form_fields', 'wsppcp_taxonomy_edit_meta_field', 30, 2);


//Product Cat Edit page
function wsppcp_taxonomy_edit_meta_field($term) {

    $term_id = $term->term_id;
    wp_nonce_field('custom_nonce_action', 'custom_nonce');

        $wsppcp_hooks = get_term_meta($term_id, 'wsppcp_product_categories_position', true);

        ?>
        <tr class="form-field wsppcp-category-title">
            <td colspan="3">
                <h2 class="wsppcp-h2-title"><?php _e('Woocommerce Single Product Page Customizer Pro', 'remove-woocommerce-product-content-pro') ?></h2>
            </td>
        </tr>
       <tr>
           <td colspan="3"> 
               <div class="wrap wsppcp-main-box wsppcp-categories-box">
                    <div class='inner wsppcp_inner'>
                        <?php
                        if ( isset( $errormsg ) ) {
                            ?>
                            <div class="error fade"><p><?php _e($errormsg); ?></p></div>
                            <?php
                        }
                        ?>
                        <ul class="wsppcp_toggle wsppcp_tab">
                            <?php if(!empty($wsppcp_hooks)){ 
                                $wsppcp_hooks = array_reverse($wsppcp_hooks);
                                foreach($wsppcp_hooks as $key=>$wsppcp_hook) {?>
                                <li><span class="wsppcp_hook_name"><?php _e(str_replace("_"," ",$key));?></span>
                                    <span class="wsppcp_hook_action">
                                    <span class="wsppcp_ajax_loader edit_ajax_loader"></span>
                                    <a class="wsppcp_edit_hook wsppcp_edit_single_product_hook" data-page="term" data-hook='<?php _e($key); ?>' href="javascript:void(0)" data-product-id="<?php _e($term_id); ?>"><?php _e('Edit','woo-single-product-page-customizer-pro'); ?></a>
                                    <a class="wsppcp_remove_hook wsppcp_remove_single_product_hook" data-page="term" data-hook='<?php _e($key); ?>' href="javascript:void(0)" data-product-id="<?php _e($term_id); ?>"><?php _e('Remove','woo-single-product-page-customizer-pro'); ?></a>
                                    </span>
                                    <div class="wsppcphook_details" style="display:none">					
                                    </div>
                                </li>
                            <?php } 
                        }?></ul>
                        <a class="wsppcp_add_form_link wsppcp_add_single_product_position" href="javascript:void(0);" data-page="term"  data-product-id="<?php _e($term_id); ?>"><?php _e('Add New Position','woo-single-product-page-customizer-pro'); ?></a>
            
                        <span class="wsppcp_ajax_loader"></span>
                        <div class="wsppcp_add_hook_form"></div>
                    </div>
                    <div class="single-page-position-box">
                        <h3 class="wsppcp-h2-title"><?php _e('Woocommerce Single Product Page Position','woo-single-product-page-customizer-pro'); ?> <span class="wsppcp-position-map-accordion"><?php _e('Guide Map','woo-single-product-page-customizer-pro'); ?></span></h3>
                        <img  class="wsppcp-woo-single-page-position-map-img" style="display:none;" src="<?php _e(plugins_url('../admin/assets/image/wsppcp-product-page-guide-map-new.jpg', __FILE__)); ?>" alt="Woocommerce Single page position map Image">	
                        <?php 
                            $ajax_add_nonce = wp_create_nonce( "wsppcp_ajax_add_nonce" ); 
                            $ajax_edit_nonce = wp_create_nonce( "wsppcp_ajax_edit_nonce" );
                            $ajax_remove_nonce = wp_create_nonce( "wsppcp_ajax_remove_nonce" );
                    

                        ?>
                        <input type="hidden" value="<?php _e($ajax_add_nonce); ?>" name="ajax_add_nonce" class="wsppcp_ajax_add_nonce">
                        <input type="hidden" value="<?php _e($ajax_edit_nonce); ?>" name="ajax_edit_nonce" class="wsppcp_ajax_edit_nonce">
                        <input type="hidden" value="<?php _e($ajax_remove_nonce); ?>" name="ajax_remove_nonce" class="wsppcp_ajax_remove_nonce">

                    </div>
                </div>
            </td>
       </tr>
        <?php
}

add_action('edited_product_cat', 'wsppcp_save_taxonomy_custom_meta', 10, 1);

function wsppcp_save_taxonomy_custom_meta($term_id) {



    $single_page_hook_list = array();
    
    $add_position_hook = sanitize_text_field($_POST['hook']);

    
    if(isset($add_position_hook) && !empty($add_position_hook)){


        $content=htmlentities($_POST['wsppcp_product_content']);
        
        $prodcut_position_hook = get_term_meta($term_id, 'wsppcp_product_categories_position', true);
        
        if(isset($prodcut_position_hook) && !empty($prodcut_position_hook)) {
            $single_page_hook_list = $prodcut_position_hook;
            
        }
        $single_page_hook_list[$add_position_hook] = sanitize_text_field($content);
        
        update_term_meta($term_id, 'wsppcp_product_categories_position', $single_page_hook_list);
    }
    

}
?>