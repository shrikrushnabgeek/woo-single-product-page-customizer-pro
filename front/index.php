<?php
/**
 * Front Side Global Content Print Start
 */
add_action('wp', 'global_content_print_function');
function global_content_print_function()
{
    global $wp_query;
    if (is_product()) {
        $wsppcp_current_product_categories_id = $wsppcp_exclude_posts = $wsppcp_exclude_categories = $wsppcp_hook_exclude = [];

        $wsppcp_current_product_id           = $wp_query->post->ID;
        $wsppcp_hooks                        = wsppcp_get_hook();
        $wsppcp_hook_exclude                 = wsppcp_get_hook_exclude();
        $wsppcp_current_product_categories   = wp_get_post_terms($wsppcp_current_product_id, 'product_cat');

        foreach ($wsppcp_current_product_categories as $wsppcp_current_product_category) {
            array_push($wsppcp_current_product_categories_id, $wsppcp_current_product_category->term_id);
            if ($wsppcp_current_product_category->parent !== 0) {
                array_push($wsppcp_current_product_categories_id, $wsppcp_current_product_category->parent);
            }
        }
        $wsppcp_current_product_categories_id = array_unique($wsppcp_current_product_categories_id);

        if (!empty($wsppcp_hooks)) {
            foreach ($wsppcp_hooks as $key => $wsppcp_hook) {

                if (isset($wsppcp_hook_exclude) && !empty($wsppcp_hook_exclude)) {
                    if (array_key_exists($key . '_exclude', $wsppcp_hook_exclude)) {
                        $wsppcp_exclude_posts       = $wsppcp_hook_exclude[$key . '_exclude']['exclude_post'];
                        $wsppcp_exclude_categories  = $wsppcp_hook_exclude[$key . '_exclude']['exclude_category'];
                    } else {
                        $wsppcp_exclude_posts       = array();
                        $wsppcp_exclude_categories  = array();
                    }
                }

                if (!in_array($wsppcp_current_product_id, $wsppcp_exclude_posts) && !array_intersect($wsppcp_exclude_categories, $wsppcp_current_product_categories_id)) {

                    switch ($key) {
                        case 'woocommerce_after_single_product_summary':
                            add_action($key, 'wsppcp_single_product_product_summary_hook', 8);
                            break;

                        case 'woocommerce_single_product_summary':
                            add_action($key, 'wsppcp_single_product_page_hook', 4);
                            break;

                        case 'woocommerce_after_product_title':
                            add_action('woocommerce_single_product_summary', 'woocommerce_after_product_title', 5);
                            break;

                        case 'woocommerce_after_product_price':
                            add_action('woocommerce_single_product_summary', 'woocommerce_after_product_price', 10);
                            break;

                        case 'woocommerce_product_thumbnails':
                            add_action('woocommerce_product_thumbnails', 'woocommerce_product_thumbnails', 5);
                            break;

                        case 'woocommerce_after_product_thumbnails':
                            add_action('wp_footer', 'woocommerce_single_after_product_thumbnails', 10);
                            break;

                        default:
                            add_action($key, 'wsppcp_single_product_page_hook', 10);
                            break;
                    }
                }
            }
        }
    }
}
/**
 * Function to output content based on the hook
 */
function wsppcp_single_product_page_hook($arg)
{
    $hook = current_filter();
    $wsppcp_hooks = wsppcp_get_hook();
    if (isset($wsppcp_hooks[$hook]) && !empty($wsppcp_hooks[$hook])) {
        echo "<div class='wsppcp_div_block " . esc_attr($hook) . "'>";
        echo wp_kses_post(wsppcp_output($wsppcp_hooks[$hook]));
        echo "</div>";
    }
}

/**
 * Function to output content for woocommerce_after_single_product_summary hook
 */
function wsppcp_single_product_product_summary_hook($arg)
{
    $hook = current_filter();
    $wsppcp_hooks = wsppcp_get_hook();
    if (isset($wsppcp_hooks[$hook]) && !empty($wsppcp_hooks[$hook])) {
        echo "<div class='wsppcp_div_block wsppcp_product_summary_text'>";
        echo wp_kses_post(wsppcp_output($wsppcp_hooks[$hook]));
        echo "</div>";
    }
}

/**
 * Function to output content for woocommerce_after_product_title hook
 */
function woocommerce_after_product_title()
{
    $wsppcp_hooks = wsppcp_get_hook();
    if (isset($wsppcp_hooks['woocommerce_after_product_title']) && !empty($wsppcp_hooks['woocommerce_after_product_title'])) {

        echo "<div class='wsppcp_div_block woocommerce_after_product_title'>";
        echo wp_kses_post(wsppcp_output($wsppcp_hooks['woocommerce_after_product_title']));
        echo "</div>";
    }
}

/**
 * Function to output content for woocommerce_after_product_price hook
 */
function woocommerce_after_product_price()
{
    $wsppcp_hooks = wsppcp_get_hook();
    if (isset($wsppcp_hooks['woocommerce_after_product_price']) && !empty($wsppcp_hooks['woocommerce_after_product_price'])) {

        echo "<div class='wsppcp_div_block woocommerce_after_product_price'>";
        echo wp_kses_post(wsppcp_output($wsppcp_hooks['woocommerce_after_product_price']));
        echo "</div>";
    }
}

/**
 * Function to output content for woocommerce_product_thumbnails hook
 */
function woocommerce_product_thumbnails($arg)
{
    $wsppcp_hooks = wsppcp_get_hook();
    if (isset($wsppcp_hooks['woocommerce_product_thumbnails']) && !empty($wsppcp_hooks['woocommerce_product_thumbnails'])) {

        echo "<div class='woocommerce_product_thumbnails'>";
        echo wp_kses_post(wsppcp_output($wsppcp_hooks['woocommerce_product_thumbnails']));
        echo "</div>";
    }
}

/**
 * Function to output content for woocommerce_after_product_thumbnails hook
 */
function woocommerce_single_after_product_thumbnails() {
    $wsppcp_hooks = wsppcp_get_hook();
    if (isset($wsppcp_hooks['woocommerce_after_product_thumbnails']) && !empty($wsppcp_hooks['woocommerce_after_product_thumbnails'])) {
        echo '<div class="woocommerce-after-product-thumbnails-script"><script type="text/javascript">';
        echo 'window.addEventListener("load",function(){if(document.querySelectorAll(".woocommerce-product-gallery").length>0&&document.querySelectorAll(".woocommerce-product-gallery").length>0){var e=document.querySelector(".woocommerce-product-gallery"),r=document.createElement("div");r.className="woocommerce_after_product_thumbnails",r.innerHTML=';
        echo "'".wp_kses_post(wsppcp_output($wsppcp_hooks['woocommerce_after_product_thumbnails']))."'";
        echo ',e.appendChild(r)}});';
        echo '</script></div>';
    }
}

/**
 * Front side CSS
 */
function wsppcp_front_site_css_add()
{
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

        .product-type-simple .woocommerce_product_thumbnails {
            display: inline-block;
            width: 100%;
        }

        .product-type-variable .woocommerce_product_thumbnails {
            display: inline-block;
        }
    </style>
<?php
}
add_action('wp_head', 'wsppcp_front_site_css_add');
