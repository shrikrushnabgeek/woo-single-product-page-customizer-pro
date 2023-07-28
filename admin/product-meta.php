<?php
class wsppcp_admin_product_page_meta_box
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        if (is_admin()) {
            add_action('add_meta_boxes', array($this, 'add_metabox'));
            add_action('save_post',      array($this, 'save_metabox'), 10, 2);
        }
    }

    /**
     * Adds the meta box.
    */
    public function add_metabox()
    {
        add_meta_box(
            'my-meta-box',
            __('Woocommerce Single Product Page Customizer', 'textdomain'),
            array($this, 'render_metabox'),
            'product',
            'advanced',
            'default'
        );
    }

    /**
     * Renders the meta box.
    */
    public function render_metabox($post)
    {
        wp_nonce_field('custom_nonce_action', 'custom_nonce');

        $wsppcp_hooks = get_post_meta($post->ID, 'wsppcp_single_product_position', true); ?>
        <div class="wrap wsppcp-main-box wsppcp-meta-box">
            <?php 
            if(!empty($wsppcp_hooks)){ ?>
                <div class="wsppcp-page-title">
                    <span class="wsppcp_ajax_loader edit_ajax_loader"></span>
                    <input type="button" value="Remove All" id="wsppcp_clear_all" data-product-id="<?php _e($post->ID); ?>" class="wsppcp-submit-button wsppcp-cancel-button">
                </div>
                <?php 
            }?>
            <div class='inner wsppcp_inner'>
                <?php
                if ( isset( $errormsg ) ) {
                    ?>
                    <div class="error fade"><p><?php _e($errormsg); ?></p></div>
                    <?php
                } ?>
                <ul class="wsppcp_toggle wsppcp_tab wsppcp_hooks_list">
                    <?php if(!empty($wsppcp_hooks)){ 
                        $wsppcp_hooks = array_reverse($wsppcp_hooks);
                        foreach($wsppcp_hooks as $key=>$wsppcp_hook) {?>
                        <li><span class="wsppcp_hook_name"><?php _e(str_replace("_"," ",$key));?></span>
                            <span class="wsppcp_hook_action">
                            <span class="wsppcp_ajax_loader edit_ajax_loader"></span>
                            <a class="wsppcp_edit_hook wsppcp_edit_single_product_hook" data-hook='<?php _e($key); ?>' href="javascript:void(0)" data-product-id="<?php _e($post->ID); ?>"><?php _e('Edit','woo-single-product-page-customizer-pro'); ?></a>

                            <a class="wsppcp_remove_hook wsppcp_remove_single_product_hook" data-hook='<?php _e($key); ?>' href="javascript:void(0)" data-product-id="<?php _e($post->ID); ?>"><?php _e('Remove','woo-single-product-page-customizer-pro'); ?></a>
                            </span>
                            <div class="wsppcphook_details" style="display:none"></div>
                        </li>
                    <?php } 
                }?></ul>
                <a class="wsppcp_add_form_link wsppcp_add_single_product_position" href="javascript:void(0);"  data-product-id="<?php _e($post->ID); ?>"><?php _e('Add New Position','woo-single-product-page-customizer-pro'); ?></a>
      
                <span class="wsppcp_ajax_loader"></span>
                <div class="wsppcp_add_hook_form"></div>
            </div>
            <div class="single-page-position-box">
                <h1 class="wsppcp-h1-title"><?php _e('Woocommerce Single Product Page Position','woo-single-product-page-customizer-pro'); ?> <span class="wsppcp-position-map-accordion"><?php _e('Guide Map','woo-single-product-page-customizer-pro'); ?></span></h1>
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
        <?php
    }

    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
    */
    public function save_metabox($post_id, $post)
    {
        $nonce_name   = isset($_POST['custom_nonce']) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';

        if (!wp_verify_nonce($nonce_name, $nonce_action)) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (wp_is_post_autosave($post_id)) {
            return;
        }

        if (wp_is_post_revision($post_id)) {
            return;
        }

        $single_page_hook_list = array();        
        $add_position_hook = isset($_POST['hook'])? sanitize_text_field($_POST['hook']) : '';

        if(isset($add_position_hook) && !empty($add_position_hook)){
            $content=htmlentities($_POST['wsppcp_product_content']);    
            $prodcut_position_hook = get_post_meta($post->ID, 'wsppcp_single_product_position', true);
            
            if(isset($prodcut_position_hook) && !empty($prodcut_position_hook)) {
                $single_page_hook_list = $prodcut_position_hook;
            }
            $single_page_hook_list[$add_position_hook] = $content;
            update_post_meta($post_id, 'wsppcp_single_product_position', $single_page_hook_list);
        }
    }
}

new wsppcp_admin_product_page_meta_box();