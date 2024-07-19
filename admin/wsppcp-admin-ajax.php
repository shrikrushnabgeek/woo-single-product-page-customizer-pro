<?php

/** Admin Panel Edit Hook Form Start */
add_action('wp_ajax_wsppcp_get_edit_form', 'wsppcp_edit_form');
add_action('wp_ajax_nopriv_wsppcp_get_edit_form', 'wsppcp_edit_form');
function wsppcp_edit_form()
{
	$hook					=  "";
	$hook_value				=  "";
	$all_hook				= array();
	$wsppcp_hook_exclude	= array();

	if ($_POST['form_action'] == 'add_form') {
		check_ajax_referer('wsppcp_ajax_add_nonce', 'security');
	}
	if ($_POST['form_action'] == 'edit_form') {
		check_ajax_referer('wsppcp_ajax_edit_nonce', 'security');
	}

	if (isset($_POST['hook_name']) && !empty($_POST['hook_name'])) {
		$hook		= sanitize_text_field($_POST['hook_name']);
		$hook_value = wsppcp_get_hook_value($hook);
	}

	$all_hook				= wsppcp_get_hook();
	$wsppcp_hook_exclude	= wsppcp_get_hook_exclude();
?>
	<form method="post" class="wsppcp_form">
		<table class="form-table">
			<tbody>
				<tr valign="top" class="wsppcp_hook_dropdowns">

					<?php
					if (empty($hook)) { ?>
						<th scope="row" class="wsppcp_exclude_dropdown_wrap">
							<span><strong><?php _e('Select Position', 'woo-single-product-page-customizer-pro'); ?></strong></span>
							<span>
								<select id="" name="hook">
									<?php
									global $hook_list;
									$i = 1;
									if (isset($hook_list) && !empty($hook_list)) {
										foreach ($hook_list as $hooks) {
											$disable_key = (isset($all_hook[$hooks])) ? 'disabled="disabled"' : ''; ?>
											<option <?php echo $disable_key ?> value="<?php echo $hooks ?>"><?php echo  $i . ". " . str_replace("_", " ", $hooks); ?></option>
									<?php
											$i++;
										}
									}
									?>
								</select>
								<p class="description"><?php _e('Refer bellow position map.', 'woo-single-product-page-customizer-pro'); ?></p>
							</span>
						</th>
					<?php
					} else { ?>
						<input type="hidden" name="hook" value="<?php echo $hook; ?>">
						<input type="hidden" name="edit_form" value="1">
					<?php
					} ?>

				</tr>
				<tr class="wsppcp_exclude_dropdown">
					<th scope="row" class="wsppcp_exclude_dropdown_wrap">
						<span><strong><?php _e('Exclude Product', 'woo-single-product-page-customizer-pro'); ?></strong></span>
						<span>
							<select id="wsppcp_exclude_post" name="wsppcp_exclude-post[]" multiple="multiple">
								<?php
								if (isset($wsppcp_hook_exclude) && !empty($wsppcp_hook_exclude) && array_key_exists($hook . '_exclude', $wsppcp_hook_exclude)) {
									$wsppcp_exclude_posts = $wsppcp_hook_exclude[$hook . '_exclude']['exclude_post'];
									if (isset($wsppcp_exclude_posts) && !empty($wsppcp_exclude_posts)) {
										foreach ($wsppcp_exclude_posts as $wsppcp_exclude_post) { ?>
											<option value="<?php echo $wsppcp_exclude_post; ?>" selected="selected"> <?php echo get_the_title($wsppcp_exclude_post) ?></option>
								<?php
										}
									}
								} ?>
							</select>
							<p class="description"><?php _e('Select Post which you want to exclude.', 'woo-single-product-page-customizer-pro'); ?></p>
						</span>
					</th>
					<th scope="row" class="wsppcp_exclude_dropdown_wrap">
						<span><strong><?php _e('Exclude Category', 'woo-single-product-page-customizer-pro'); ?></strong></span>
						<span>
							<select id="wsppcp_exclude_category" name="wsppcp_exclude-category[]" multiple="multiple">
								<?php
								if (isset($wsppcp_hook_exclude) && !empty($wsppcp_hook_exclude)  && array_key_exists($hook . '_exclude', $wsppcp_hook_exclude)) {
									$wsppcp_exclude_categories = $wsppcp_hook_exclude[$hook . '_exclude']['exclude_category'];
									if (isset($wsppcp_exclude_categories) && !empty($wsppcp_exclude_categories)) {
										foreach ($wsppcp_exclude_categories as $wsppcp_exclude_category) { ?>
											<option value="<?php echo $wsppcp_exclude_category; ?>" selected="selected"> <?php echo get_the_category_by_ID((int)$wsppcp_exclude_category); ?></option>
								<?php
										}
									}
								} ?>
							</select>
							<p class="description"><?php _e('Select Category which you want to exclude.', 'woo-single-product-page-customizer-pro'); ?></p>
						</span>
					</th>
					<th scope="row" class="wsppcp_exclude_dropdown_wrap">
						<span><strong><?php _e('Exclude Tag', 'woo-single-product-page-customizer-pro'); ?></strong></span>
						<span>
							<select id="wsppcp_exclude_tag" name="wsppcp_exclude-tag[]" multiple="multiple">
								<?php
								if (isset($wsppcp_hook_exclude) && !empty($wsppcp_hook_exclude)  && array_key_exists($hook . '_exclude', $wsppcp_hook_exclude)) {
									$wsppcp_exclude_tags = $wsppcp_hook_exclude[$hook . '_exclude']['exclude_tag'];
									if (isset($wsppcp_exclude_tags) && !empty($wsppcp_exclude_tags)) {
										foreach ($wsppcp_exclude_tags as $wsppcp_exclude_tag) { 
											
											$tag = get_term_by('id', (int)$wsppcp_exclude_tag, 'product_tag');
											?>
											<option value="<?php echo $wsppcp_exclude_tag; ?>" selected="selected"> <?php echo _e($tag->name); ?></option>
								<?php
										}
									}
								} ?>
							</select>
							<p class="description"><?php _e('Select Tag which you want to exclude.', 'woo-single-product-page-customizer-pro'); ?></p>
						</span>
					</th>

				</tr>
				<tr valign="top">
					<td>
						<textarea name="content" id="content_<?php echo $hook; ?>" rows="12" class="wsppcp_content wp-editor"> <?php echo wp_unslash($hook_value); ?></textarea>
						<p class="description"><?php _e('This content will be show on single product page as per choosen position.', 'woo-single-product-page-customizer-pro'); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="single_page_wpnonce" value="<?php echo $nonce = wp_create_nonce('wsppcp_single_page_wpnonce'); ?>">
		<input type="submit" class="button button-primary " name="update_option" value="Update">
	</form>
<?php
	die;
}

/** Admin Panel Remove Hook Form Start */
add_action("wp_ajax_wsppcp_remove_global_hook", "wsppcp_removed_hook");
function wsppcp_removed_hook()
{
	check_ajax_referer('wsppcp_ajax_remove_nonce', 'security');
	$hook			= '';
	$wsppcp_hook	= '';
	if (isset($_POST['hook_name'])) {
		$hook = sanitize_text_field($_POST['hook_name']);
	}
	if (isset($hook) && !empty($hook)) {

		$wsppcp_hook = wsppcp_get_hook();
		unset($wsppcp_hook[$hook]);
		update_option('wsppcp_hook', $wsppcp_hook);
		echo true;
	} else {
		echo false;
	}
	die;
}

/** Single Product Page Hook Add Ajax Strat */
add_action('wp_ajax_wsppcp_single_product_add_form', 'wsppcp_single_product_add_form');
add_action('wp_ajax_nopriv_wsppcp_single_product_add_form', 'wsppcp_single_product_add_form');

function wsppcp_single_product_add_form()
{
	$hook			= "";
	$hook_value		= "";
	$product_id		= "";
	$current_page	= "";
	$all_hook		= array();

	if (isset($_POST['product_id']))				$product_id = $_POST['product_id'];
	if (isset($_REQUEST['current_page']))		$current_page = $_REQUEST['current_page'];
	if ($_POST['form_action'] == 'add_form')		check_ajax_referer('wsppcp_ajax_add_nonce', 'security');
	if ($_POST['form_action'] == 'edit_form')		check_ajax_referer('wsppcp_ajax_edit_nonce', 'security');

	$hook = (isset($_POST['hook_name']) && !empty($_POST['hook_name'])) ? sanitize_text_field($_POST['hook_name']) : '';

	// if (isset($current_page) && !empty($current_page) && $current_page == "term") {
	// 	$all_hook	= get_term_meta($product_id, 'wsppcp_product_categories_position', true);
	// 	if (isset($hook) && !empty($hook)) {
	// 		if (isset($all_hook) && !empty($all_hook)) $hook_value  = $all_hook[$hook];
	// 	}
	// } else {
	// 	$all_hook = get_post_meta($product_id, 'wsppcp_single_product_position', true);
	// 	if (isset($hook) && !empty($hook)) {
	// 		$hook_value = (isset($all_hook) && !empty($all_hook)) ? $all_hook[$hook] : '';
	// 	}
	// }


	if (isset($current_page) && !empty($current_page) && $current_page == "term") {
		$category_hook = get_term_meta($product_id, 'wsppcp_product_categories_position', true);
		if (isset($hook) && !empty($hook) && isset($category_hook[$hook])) {
			$hook_value = $category_hook[$hook];
		} elseif (isset($hook) && !empty($hook)) {
			$tag_hook = get_term_meta($product_id, 'wsppcp_product_tags_position', true);
			if (isset($tag_hook[$hook])) {
				$hook_value = $tag_hook[$hook];
			}
		}
	} else {
		$all_hook = get_post_meta($product_id, 'wsppcp_single_product_position', true);
		if (isset($hook) && !empty($hook)) {
			$hook_value = (isset($all_hook) && !empty($all_hook)) ? $all_hook[$hook] : '';
		}
	}


?>
	<section method="post" class="wsppcp_form">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<?php
					if (empty($hook)) { ?>
						<th scope="row" class="wsppcp_exclude_dropdown_wrap">
							<span><strong><?php _e('Select Position', 'woo-single-product-page-customizer-pro'); ?></strong></span>
							<span>
								<select name="hook">
									<?php
									global $hook_list;
									$i	= 1;
									if (isset($hook_list) && !empty($hook_list)) {
										foreach ($hook_list as $hooks) {
											$disable_key = (isset($all_hook[$hooks])) ? 'disabled="disabled"' : ''; ?>
											<option <?php echo $disable_key; ?> value="<?php echo $hooks ?>"><?php echo  $i . ". " . str_replace("_", " ", $hooks); ?></option>
									<?php
											$i++;
										}
									} ?>
								</select>
								<p class="description"><?php _e('Refere bellow position map.', 'woo-single-product-page-customizer-pro'); ?></p>
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
						<textarea name="wsppcp_product_content" id="content_<?php echo $hook; ?>" rows="12" class="wsppcp_content wp-editor"> <?php echo wp_unslash($hook_value); ?></textarea>
						<p class="description"><?php _e('This content will be show on single product page as per choosen position.', 'woo-single-product-page-customizer-pro'); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="single_page_wpnonce" value="<?php echo $nonce = wp_create_nonce('wsppcp_single_page_wpnonce'); ?>">
		<input type="submit" class="button button-primary " name="update_option" value="Update">
	</section>
<?php
	die;
}

/**  Single Product Page Remove Hook Form Start */
add_action("wp_ajax_wsppcp_remove_single_product_hook", "wsppcp_remove_single_product_hook");
function wsppcp_remove_single_product_hook()
{
	check_ajax_referer('wsppcp_ajax_remove_nonce', 'security');
	$hook			= '';
	$product_id		= $_POST['product_id'];
	$current_page	= "";

	if (isset($_POST['product_id']))		$product_id		= $_POST['product_id'];
	if (isset($_REQUEST['current_page']))	$current_page	= $_REQUEST['current_page'];
	if (isset($_POST['hook_name']))			$hook			= sanitize_text_field($_POST['hook_name']);


	if (isset($product_id) && !empty($product_id)) {
		$single_page_hook_list = array();
		if (isset($current_page) && !empty($current_page) && $current_page == "term") {

			$single_page_hook_list = get_term_meta($product_id, 'wsppcp_product_categories_position', true);
			if (!empty($single_page_hook_list)) {
				unset($single_page_hook_list[$hook]);
				update_term_meta($product_id, 'wsppcp_product_categories_position', $single_page_hook_list);
			}

			$single_page_hook_list = get_term_meta($product_id, 'wsppcp_product_tags_position', true);
			if (!empty($single_page_hook_list)) {
				unset($single_page_hook_list[$hook]);
				update_term_meta($product_id, 'wsppcp_product_tags_position', $single_page_hook_list);
			}
		} else {

			$single_page_hook_list = get_post_meta($product_id, 'wsppcp_single_product_position', true);
			unset($single_page_hook_list[$hook]);
			update_post_meta($product_id, 'wsppcp_single_product_position', $single_page_hook_list);
		}

		echo true;
	} else {
		echo false;
	}
	die;
}
/**  Single Product Page Remove Hook Form end */

/** Admin Panel Clear All Form Start */
add_action("wp_ajax_wsppcp_clear_all", "wsppcp_clear_all");
function wsppcp_clear_all()
{
	check_ajax_referer('wsppcp_ajax_remove_nonce', 'security');

	$product_id				= null;
	$current_page			= "";
	$single_page_hook_list	= array();
	$wsppcp_hook			= array();

	if (isset($_POST['product_id']))		$product_id		= $_POST['product_id'];
	if (isset($_REQUEST['current_page']))	$current_page	= $_REQUEST['current_page'];
	if (isset($product_id) && !empty($product_id)) {
		if (isset($current_page) && !empty($current_page) && $current_page == "term") {
			$single_page_hook_list = get_term_meta($product_id, 'wsppcp_product_categories_position', true);
			if (isset($single_page_hook_list) && !empty($single_page_hook_list)) {
				$single_page_hook_list = array();
				echo update_term_meta($product_id, 'wsppcp_product_categories_position', $single_page_hook_list);
			}

			$single_page_hook_list = get_term_meta($product_id, 'wsppcp_product_tags_position', true);
			if (isset($single_page_hook_list) && !empty($single_page_hook_list)) {
				$single_page_hook_list = array();
				update_term_meta($product_id, 'wsppcp_product_tags_position', $single_page_hook_list);
			}
		} else {
			$single_page_hook_list = get_post_meta($product_id, 'wsppcp_single_product_position', true);
			if (isset($single_page_hook_list) && !empty($single_page_hook_list)) {
				$single_page_hook_list = array();
				echo update_post_meta($product_id, 'wsppcp_single_product_position', $single_page_hook_list);
			}
		}
	} else {
		$wsppcp_hook = wsppcp_get_hook();
		if (isset($wsppcp_hook) && !empty($wsppcp_hook)) {
			$wsppcp_hook = array();
			update_option('wsppcp_hook_exclude', $wsppcp_hook);
			echo update_option('wsppcp_hook', $wsppcp_hook);
		}
	}
	die;
}
/** Admin Panel Clear All Form end */

/**
 * AJAX callback function for excluding Product.
 */
function wsppcp_exclude_post_fun()
{
	// Verify the AJAX request
	check_ajax_referer('wsppcp_ajax_add_nonce', 'security'); // Verify the AJAX request

	$result = array();
	$search = sanitize_text_field($_POST['search']); // Get the search term from the AJAX request

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		's'              => $search,
	);

	// Get the product IDs that match the search term
	$product_ids = get_posts($args);

	foreach ($product_ids as $product_id) {
		$product_title = get_the_title($product_id);

		// Add the product ID and title to the result array
		$result[] = array(
			'id'    => $product_id,
			'title' => $product_title,
		);
	}

	// Encode the result array as JSON and send the response
	wp_send_json($result);

	wp_die(); // Terminate the script execution
}
// Hook the AJAX action
add_action('wp_ajax_wsppcp_exclude_post', 'wsppcp_exclude_post_fun');

/**
 * AJAX callback function for excluding categories.
 */
add_action('wp_ajax_wsppcp_exclude_category', 'wsppcp_exclude_category_fun');
function wsppcp_exclude_category_fun()
{
	// Verify the AJAX request
	check_ajax_referer('wsppcp_ajax_add_nonce', 'security');

	$result = array();
	$term = sanitize_text_field($_POST['search']);

	$args = array(
		'taxonomy'     => 'product_cat',
		'hide_empty'   => false,
		'search'       => $term,
		'number'       => 10,
	);

	$categories = get_terms($args);

	foreach ($categories as $category) {
		$result[] = array(
			'id'    => $category->term_id,
			'title' => $category->name,
		);
	}

	// Encode the result array as JSON and send the response
	wp_send_json($result);

	wp_die(); // Terminate the script execution
}


/**
 * AJAX callback function for excluding tags.
 */
add_action('wp_ajax_wsppcp_exclude_tag', 'wsppcp_exclude_tag_fun');
function wsppcp_exclude_tag_fun()
{
	// Verify the AJAX request
	check_ajax_referer('wsppcp_ajax_add_nonce', 'security');

	$result = array();
	$term = sanitize_text_field($_POST['search']);

	$args = array(
		'taxonomy'     => 'product_tag',
		'hide_empty'   => false,
		'search'       => $term,
		'number'       => 10,
	);

	$tags = get_terms($args);

	foreach ($tags as $tag) {
		$result[] = array(
			'id'    => $tag->term_id,
			'title' => $tag->name,
		);
	}

	// Encode the result array as JSON and send the response
	wp_send_json($result);

	wp_die(); // Terminate the script execution
}
