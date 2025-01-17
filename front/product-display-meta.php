<?php
// Ensure the class is not already defined before declaring it
if (!class_exists('wsppcp_product_categories_hook_content')) {

	class wsppcp_product_categories_hook_content
    {
        // Properties
        public $wsppcp_remove_action_hook   = 'wsppcp_single_product_page_hook';
        public $all_categories_hook         = '';
        public $all_tags_hook         		= '';
        public $wsppcp_priority             = 10;
        public $categories_positions        = array();
        public $tags_positions        		= array();
        public $product_positions           = array();
        public $wsppcp_content_classes      = array();
        
        // Action hooks configuration for product categories
        public function wsppcp_content_actions() {
            return array(
				'woocommerce_before_single_product' => array(
					'action-hook'               => 'woocommerce_before_single_product',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_before_single_product_summary' => array(
					'action-hook'               => 'woocommerce_before_single_product_summary',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_single_product_summary' => array(
					'action-hook'               => 'woocommerce_single_product_summary',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => 4,
				),
				'woocommerce_after_product_title' => array(
					'action-hook'               => 'woocommerce_single_product_summary',
					'remove-action-callback'    => 'woocommerce_after_product_title',
					'priority'                  => 5,
				),
				'woocommerce_after_product_price' => array(
					'action-hook'               => 'woocommerce_single_product_summary',
					'remove-action-callback'    => 'woocommerce_after_product_price',
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_before_add_to_cart_form' => array(
					'action-hook'               => 'woocommerce_before_add_to_cart_form',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_before_variations_form' => array(
					'action-hook'               => 'woocommerce_before_variations_form',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_before_add_to_cart_button' => array(
					'action-hook'               => 'woocommerce_before_add_to_cart_button',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_before_single_variation' => array(
					'action-hook'               => 'woocommerce_before_single_variation',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_single_variation' => array(
					'action-hook'               => 'woocommerce_single_variation',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_after_single_variation' => array(
					'action-hook'               => 'woocommerce_after_single_variation',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_after_add_to_cart_button' => array(
					'action-hook'               => 'woocommerce_after_add_to_cart_button',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_after_variations_form' => array(
					'action-hook'               => 'woocommerce_after_variations_form',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_after_add_to_cart_form' => array(
					'action-hook'               => 'woocommerce_after_add_to_cart_form',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_product_meta_start' => array(
					'action-hook'               => 'woocommerce_product_meta_start',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_product_meta_end' => array(
					'action-hook'               => 'woocommerce_product_meta_end',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_share' => array(
					'action-hook'               => 'woocommerce_share',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_product_thumbnails' => array(
					'action-hook'               => 'woocommerce_product_thumbnails',
					'remove-action-callback'    => 'woocommerce_product_thumbnails',
					'priority'                  => 5,
				),
				'woocommerce_after_single_product_summary' => array(
					'action-hook'               => 'woocommerce_after_single_product_summary',
					'remove-action-callback'    => 'wsppcp_single_product_product_summary_hook',
					'priority'                  => 8,
				),
				'woocommerce_after_single_product' => array(
					'action-hook'               => 'woocommerce_after_single_product',
					'remove-action-callback'    => $this->wsppcp_remove_action_hook,
					'priority'                  => $this->wsppcp_priority,
				),
				'woocommerce_after_product_thumbnails' => array(),
			);
        }

        // Initialize the class and set up hooks
        public function wsppcp_construct_function()
        {
            // Hook into WordPress to print product category content class and single product content
            add_action('wp', array($this, 'wsppcp_product_tags_print_content_class'));
            add_action('wp', array($this, 'wsppcp_product_categories_print_content_class'));
            add_action('wp', array($this, 'wsppcp_single_product_print_content'));
        }

		// Function to print product tag content
		public function wsppcp_product_tags_print_content_class()
		{
			// Check if not in admin context
            if (!is_admin()) {
                // Retrieve the current product ID
                $product_id =  get_the_ID();

                // Get the product tags associated with the product
                $wsppcp_product_tag = get_the_terms($product_id, 'product_tag');
                $wsppcp_all_product_tag = array();

                if (isset($wsppcp_product_tag) && !empty($wsppcp_product_tag)) {
                    // Collect tag IDs
                    foreach ($wsppcp_product_tag as $productInfo) {
                        $term_id = $productInfo->term_id;
                        $wsppcp_all_product_tag[] = $term_id;
                    }
                }

                if (!empty($wsppcp_all_product_tag) && isset($wsppcp_all_product_tag)) {
                    $wsppcp_all_product_tag = array_unique($wsppcp_all_product_tag);

                    foreach ($wsppcp_all_product_tag as $term_id) {

                        // Get the hooks for each tag
                        $inner_count = 1;
                        $all_tags_hook = get_term_meta($term_id, 'wsppcp_product_tags_position', true);
                        if (!empty($all_tags_hook) && count($all_tags_hook) != 0) {
                            $this->wsppcp_content_classes = $this->wsppcp_content_actions();
                            foreach ($all_tags_hook as $key => $wsppcp_hook) {
								if($key == "woocommerce_after_product_thumbnails") {
									$this->{'wapt_pos_tag_callback_'. $key } = function() use ($key, $inner_count, $wsppcp_hook) {
										?>
										<div class="woocommerce-after-product-thumbnails-script">
											<script>function htmlspecialcharsDecode(t){var e={"&amp;":"&","&lt;":"<","&gt;":">","&quot;":'"',"&#039;":"'"};return t.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g,function(t){return e[t]})}</script>
											<?php
												echo sprintf( '<script type="text/javascript">window.addEventListener("load",function(){var e=document.querySelector(".woocommerce-product-gallery");if(e){var r=e.querySelector(".woocommerce_after_product_thumbnails");if(r)r.innerHTML=htmlspecialcharsDecode("%1$s");else{var o=document.createElement("div");o.className="woocommerce_after_product_thumbnails",o.innerHTML=htmlspecialcharsDecode("%2$s"),e.appendChild(o)}}});</script></div>', wsppcp_output($wsppcp_hook,true), wsppcp_output($wsppcp_hook,true) );
											?>
										</div>
										<?php
                                    };

									if(has_action('wp_footer','woocommerce_single_after_product_thumbnails')) {
										remove_action('wp_footer','woocommerce_single_after_product_thumbnails');
									}

									if(isset($this->{'wapt_pos_tag_callback_'. $key }))		add_action('wp_footer', $this->{'wapt_pos_tag_callback_'. $key }, $this->wsppcp_priority);

									$inner_count++;
									continue;
								}
								
                                if (array_key_exists($key, $this->wsppcp_content_classes)) {
                                    $wsppcp_content_actions_key = $this->wsppcp_content_classes[$key];
                                    $this->tags_positions[$key][] = $wsppcp_hook;

                                    // Create a callback function for the action hook
                                    $this->{'tag_callback_'. $key } = function() use ($key, $inner_count, $wsppcp_hook) {
										if(isset($this->tags_positions[$key])) {
                                        	foreach ($this->tags_positions[$key] as $value) {
												if(isset($value) && !empty($value)) {
													echo sprintf( "<div class='wsppcp_div_block wsppcp_tag_pos%s'>%s</div>", $inner_count, wsppcp_output($value) );
												}
											}
										}
                                    };

                                    // Remove the original action hook and add the custom hook
                                    if(isset($wsppcp_content_actions_key['action-hook']) && !empty($wsppcp_content_actions_key))	remove_action($wsppcp_content_actions_key['action-hook'], $wsppcp_content_actions_key['remove-action-callback'], $wsppcp_content_actions_key['priority']);
                                    if(isset($this->{'tag_callback_'. $key }) && isset($wsppcp_content_actions_key) && !empty($wsppcp_content_actions_key))		add_action($wsppcp_content_actions_key['action-hook'], $this->{'tag_callback_'. $key }, $wsppcp_content_actions_key['priority']);
                                }
                                $inner_count++;
                            }
                        }
                    }
                }
            }
		}

        // Function to print product category content
        public function wsppcp_product_categories_print_content_class()
        {
            // Check if not in admin context
            if (!is_admin()) {
                // Retrieve the current product ID
                $product_id =  get_the_ID();

                // Get the product categories associated with the product
                $wsppcp_product_cat = get_the_terms($product_id, 'product_cat');
                $wsppcp_all_product_cat = array();

                if (isset($wsppcp_product_cat) && !empty($wsppcp_product_cat)) {
                    // Collect category and parent IDs
                    foreach ($wsppcp_product_cat as $productInfo) {
                        $term_id = $productInfo->term_id;
                        $wsppcp_all_product_cat[] = $term_id;
                        if (isset($productInfo->parent) && $productInfo->parent != 0) {
                            $wsppcp_all_product_cat[] = $productInfo->parent;
                        }
                    }
                }

                if (!empty($wsppcp_all_product_cat) && isset($wsppcp_all_product_cat)) {
                    $wsppcp_all_product_cat = array_unique($wsppcp_all_product_cat);

                    foreach ($wsppcp_all_product_cat as $term_id) {

                        // Get the hooks for each category
                        $inner_count = 1;
                        $all_categories_hook = get_term_meta($term_id, 'wsppcp_product_categories_position', true);
                        if (!empty($all_categories_hook) && count($all_categories_hook) != 0) {
                            $this->wsppcp_content_classes = $this->wsppcp_content_actions();
                            foreach ($all_categories_hook as $key => $wsppcp_hook) {
								if($key == "woocommerce_after_product_thumbnails") {
									$this->{'wapt_pos_cat_callback_'. $key } = function() use ($key, $inner_count, $wsppcp_hook) {
										?>
										<div class="woocommerce-after-product-thumbnails-script">
											<script>function htmlspecialcharsDecode(t){var e={"&amp;":"&","&lt;":"<","&gt;":">","&quot;":'"',"&#039;":"'"};return t.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g,function(t){return e[t]})}</script>
											<?php
												echo sprintf( '<script type="text/javascript">window.addEventListener("load",function(){var e=document.querySelector(".woocommerce-product-gallery");if(e){var r=e.querySelector(".woocommerce_after_product_thumbnails");if(r)r.innerHTML=htmlspecialcharsDecode("%1$s");else{var o=document.createElement("div");o.className="woocommerce_after_product_thumbnails",o.innerHTML=htmlspecialcharsDecode("%2$s"),e.appendChild(o)}}});</script></div>', wsppcp_output($wsppcp_hook,true), wsppcp_output($wsppcp_hook,true) );
											?>
										</div>
										<?php
                                    };

									if(has_action('wp_footer','woocommerce_single_after_product_thumbnails')) {
										remove_action('wp_footer','woocommerce_single_after_product_thumbnails');
									}

									// Remove to override product thumbnails position content
									if(isset($this->{'wapt_pos_tag_callback_'. $key }))		remove_action('wp_footer', $this->{'wapt_pos_tag_callback_'. $key }, $this->wsppcp_priority);

									// Add after product thumbnails position content
									if(isset($this->{'wapt_pos_cat_callback_'. $key }))		add_action('wp_footer', $this->{'wapt_pos_cat_callback_'. $key }, $this->wsppcp_priority);
									
									$inner_count++;
									continue;
								}
								
                                if (array_key_exists($key, $this->wsppcp_content_classes)) {
                                    $wsppcp_content_actions_key = $this->wsppcp_content_classes[$key];
                                    $this->categories_positions[$key][] = $wsppcp_hook;

                                    // Create a callback function for the action hook
                                    $this->{'cat_callback_'. $key } = function() use ($key, $inner_count) {
										if(isset($this->categories_positions[$key])) {
                                        	foreach ($this->categories_positions[$key] as $value) {
												if(isset($value) && !empty($value)) {
													echo sprintf( "<div class='wsppcp_div_block wsppcp_category_pos%s'>%s</div>", $inner_count, wsppcp_output($value) );
												}
											}
										}
                                    };

                                    // Remove the original action hook and add the custom hook
                                    if(isset($wsppcp_content_actions_key['action-hook']) && !empty($wsppcp_content_actions_key))	remove_action($wsppcp_content_actions_key['action-hook'], $wsppcp_content_actions_key['remove-action-callback'], $wsppcp_content_actions_key['priority']);
									if(isset($this->{'tag_callback_'. $key }) && isset($wsppcp_content_actions_key) && !empty($wsppcp_content_actions_key)) remove_action($wsppcp_content_actions_key['action-hook'], $this->{'tag_callback_'. $key }, $wsppcp_content_actions_key['priority']);
									

                                    if(isset($this->{'cat_callback_'. $key }) && isset($wsppcp_content_actions_key) && !empty($wsppcp_content_actions_key))		add_action($wsppcp_content_actions_key['action-hook'], $this->{'cat_callback_'. $key }, $wsppcp_content_actions_key['priority']);
                                }
                                $inner_count++;
                            }
                        }
                    }
                }
            }
        }

        // Function to print single product page content
        public function wsppcp_single_product_print_content()
        {
            // Check if not in admin context
            if (!is_admin()) {
               
				$product_id =  get_the_ID(); // Retrieve the current product ID
                $single_page_hook_list = get_post_meta($product_id, 'wsppcp_single_product_position'); // Get the single product page hooks list
                
				if (!empty($single_page_hook_list) && isset($single_page_hook_list)) {
					
					$single_page_hook_list = $single_page_hook_list[0];
					$wsppcp_content_classes = $this->wsppcp_content_actions();
					$inner_count = 1;
					if (!empty($single_page_hook_list) && isset($single_page_hook_list)) {
						foreach ($single_page_hook_list as $key => $wsppcp_hook) {
							if($key == "woocommerce_after_product_thumbnails") {
								$this->{'wapt_pos_single_callback_'. $key } = function() use ($key, $inner_count, $wsppcp_hook) {
									?>
										<div class="woocommerce-after-product-thumbnails-script">
											<script>function htmlspecialcharsDecode(t){var e={"&amp;":"&","&lt;":"<","&gt;":">","&quot;":'"',"&#039;":"'"};return t.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g,function(t){return e[t]})}</script>
											<?php
												echo sprintf( '<script type="text/javascript">window.addEventListener("load",function(){var e=document.querySelector(".woocommerce-product-gallery");if(e){var r=e.querySelector(".woocommerce_after_product_thumbnails");if(r)r.innerHTML=htmlspecialcharsDecode("%1$s");else{var o=document.createElement("div");o.className="woocommerce_after_product_thumbnails",o.innerHTML=htmlspecialcharsDecode("%2$s"),e.appendChild(o)}}});</script></div>', wsppcp_output($wsppcp_hook,true), wsppcp_output($wsppcp_hook,true) );
											?>
										</div>
									<?php
								};
								
								if(has_action('wp_footer','woocommerce_single_after_product_thumbnails')) {
									remove_action('wp_footer','woocommerce_single_after_product_thumbnails');
								}

								// Remove to override product thumbnails position content
								if(isset($this->{'wapt_pos_tag_callback_'. $key }))		remove_action('wp_footer', $this->{'wapt_pos_tag_callback_'. $key }, $this->wsppcp_priority);

								if(isset($this->{'wapt_pos_cat_callback_'. $key }))		remove_action('wp_footer', $this->{'wapt_pos_cat_callback_'. $key }, $this->wsppcp_priority);

								if(isset($this->{'wapt_pos_single_callback_'. $key }))		add_action('wp_footer', $this->{'wapt_pos_single_callback_'. $key }, $this->wsppcp_priority);

								$inner_count++;
								continue;
							}

							if (array_key_exists($key, $wsppcp_content_classes)) {
								$wsppcp_content_actions_key = $wsppcp_content_classes[$key];
								$this->product_positions[$key][] = $wsppcp_hook;

								// Create a callback function for the action hook
								$wsppcp_product_function = function() use ($key, $inner_count) {
									if(isset($this->product_positions[$key])) {
										foreach ($this->product_positions[$key] as $value) {
											if(isset($value) && !empty($value)) {
												echo sprintf( "<div class='wsppcp_div_block wsppcp_category_pos%s'>%s</div>", $inner_count, wsppcp_output($value) );
											}
										}
										
									}
								};

								// Remove the original action hook and add the custom hook
								if(isset($wsppcp_content_actions_key) && !empty($wsppcp_content_actions_key))	remove_action($wsppcp_content_actions_key['action-hook'], $wsppcp_content_actions_key['remove-action-callback'], $wsppcp_content_actions_key['priority']);
								if(isset($this->{'tag_callback_'. $key }) && isset($wsppcp_content_actions_key) && !empty($wsppcp_content_actions_key)) remove_action($wsppcp_content_actions_key['action-hook'], $this->{'tag_callback_'. $key }, $wsppcp_content_actions_key['priority']);
								if(isset($this->{'cat_callback_'. $key }) && isset($wsppcp_content_actions_key) && !empty($wsppcp_content_actions_key)) remove_action($wsppcp_content_actions_key['action-hook'], $this->{'cat_callback_'. $key }, $wsppcp_content_actions_key['priority']);
								if(isset($wsppcp_content_actions_key) && !empty($wsppcp_content_actions_key)) 	add_action($wsppcp_content_actions_key['action-hook'], $wsppcp_product_function, $wsppcp_content_actions_key['priority']);
							}
							$inner_count++;
						}
					}
				}
            }
        }

    }
}

// Instantiate the class and set up hooks
$categories_hook = new wsppcp_product_categories_hook_content();
$categories_hook->wsppcp_construct_function();
