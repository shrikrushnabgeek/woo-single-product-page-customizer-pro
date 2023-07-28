<?php
class wsppcp_label_customizer {
    public $filters = array();

    // Constructor
    public function __construct() {
        $this->filters = get_option('wsppcp_sinagle_page_label_update_setting');
        if (!empty($this->filters)) {
            $this->wsppcp_single_page_customizations();
        }
    }

    // Perform single page customizations based on the configured filters
    private function wsppcp_single_page_customizations() {
        foreach ($this->filters as $filter_name => $filter_value) {
            switch ($filter_name) {
                case 'woocommerce_product_reviews_tab_title':
                    add_filter('woocommerce_product_reviews_tab_title', array($this, 'change_review_tab_title'), 60);
                    break;
                case 'wsppcp_out_of_stock_text':
                    add_filter('woocommerce_get_availability_text', array($this, 'customize_single_out_of_stock_text'), 60, 2);
                    break;
                case 'wsppcp_backorder_text':
                    add_filter('woocommerce_get_availability_text', array($this, 'customize_single_backorder_text'), 60, 2);
                    break;
                case 'wsppcp_sale_flash_text':
                    add_filter('woocommerce_sale_flash', array($this, 'wsppcp_customize_woocommerce_sale_flash'), 60, 3);
                    break;
                case 'wsppcp_default_attribute_options':
                    if (!empty($filter_value)) {
                        add_filter('woocommerce_dropdown_variation_attribute_options_args', array($this, 'customize_dropdown_variation_attribute_options'), 60, 3);
                    }
                    break;
                case 'wsppcp_related_product_no':
                    if (!empty($filter_value)) {
                        add_filter('woocommerce_output_related_products_args', array($this, 'customize_related_products'), 60, 3);
                    }
                    break;
                case 'wsppcp_related_product_column':
                    if (!empty($filter_value)) {
                        add_filter('woocommerce_output_related_products_args', array($this, 'customize_related_products'), 60, 3);
                    }
                    break;
                default:
                    add_filter($filter_name, array($this, 'customize'), 60);
                    break;
            }
        }
    }

    // General customization method to handle all other filters
    public function customize($title) {
        $current_filter = current_filter();

        if (isset($this->filters[$current_filter])) {
            // If 'customizer_true' is provided, return true, otherwise, return the configured value
            return 'customizer_true' === $this->filters[$current_filter];
        }

        return $title;
    }

    // Change the review tab title
    public function change_review_tab_title($title) {
        global $product;

        $customize_title = $this->filters['woocommerce_product_reviews_tab_title'];
        $review_count = $product->get_review_count();
        $title = str_replace("{count}", $review_count, $customize_title);
        return $title;
    }

    // Customize the out-of-stock text
    public function customize_single_out_of_stock_text($text, $product) {
        if (!$product->is_in_stock() && isset($this->filters['wsppcp_out_of_stock_text'])) {
            return $this->filters['wsppcp_out_of_stock_text'];
        }
        return $text;
    }

    // Customize the backorder text
    public function customize_single_backorder_text($text, $product) {
        if (($product->managing_stock() || $product->is_on_backorder(1)) && isset($this->filters['wsppcp_backorder_text'])) {
            return $this->filters['wsppcp_backorder_text'];
        }
        return $text;
    }

    // Customize the sale flash text
    public function wsppcp_customize_woocommerce_sale_flash($html, $_, $product) {
        $text = '';
        if (is_product() && isset($this->filters['wsppcp_sale_flash_text'])) {
            $text = $this->filters['wsppcp_sale_flash_text'];
        }

        if (false !== strpos($text, '{percent}')) {
            $percent = $this->get_sale_percentage($product);
            $text = str_replace('{percent}', "{$percent}%", $text);
        }

        return !empty($text) ? "<span class='onsale'>{$text}</span>" : $html;
    }

    // Customize the dropdown variation attribute options
    public function customize_dropdown_variation_attribute_options($args) {
        $args['show_option_none'] = $this->filters['wsppcp_default_attribute_options'];
        return $args;
    }

    // Customize the number of related products per post and related products column
    public function customize_related_products($args) {
        if (isset($this->filters['wsppcp_related_product_no'])) {
            $args['posts_per_page'] = $this->filters['wsppcp_related_product_no'];
        }

        if (isset($this->filters['wsppcp_related_product_column'])) {
            $args['columns'] = $this->filters['wsppcp_related_product_column'];
        }

        return $args;
    }

    // Helper method to calculate the sale percentage
    private function get_sale_percentage($product) {
        $child_sale_percents = array();
		$percentage          = '0';

		if ( $product->is_type( 'grouped' ) || $product->is_type( 'variable' ) ) {
			foreach ( $product->get_children() as $child_id ) {
				$child = wc_get_product( $child_id );
				if ( $child->is_on_sale() ) {
					$regular_price         = $child->get_regular_price();
					$sale_price            = $child->get_sale_price();
					$child_sale_percents[] = $this->calculate_sale_percentage( $regular_price, $sale_price );
				}
			}

			// filter out duplicate values
			$child_sale_percents = array_unique( $child_sale_percents );

			// only add "up to" if there's > 1 percentage possible
			if ( ! empty ( $child_sale_percents ) ) {

				/* translators: Placeholder: %s - sale percentage */
				$percentage = count( $child_sale_percents ) > 1 ? sprintf( esc_html__( 'up to %s', 'woocommerce-customizer' ), max( $child_sale_percents ) ) : current( $child_sale_percents );
			}
		} else {
			$percentage = $this->calculate_sale_percentage( $product->get_regular_price(), $product->get_sale_price() );
		}

		return $percentage;
    }

    // Helper method to calculate the sale percentage
    private function calculate_sale_percentage($regular_price, $sale_price) {
        $percent = 0;
		$regular = (float) $regular_price;
		$sale    = (float) $sale_price;

		// in case of free products so we don't divide by 0
		if ( $regular ) {
			$percent = round( ( ( $regular - $sale ) / $regular ) * 100 );
		}
		return $percent;
    }
}

// Instantiate the class and perform customizations
$plugin_b = new wsppcp_label_customizer();
