<?php

class AS_WOO extends AS_MAIN {

    public function as_init()
    {
        //Actions
        $this->as_add_action('after_setup_theme', 'as_action_init_wish_list');
        $this->as_add_action('after_setup_theme', 'as_action_init_compare');

        //Filters
        $this->as_add_filter('woocommerce_add_to_cart_fragments', 'as_woocommerce_header_add_to_cart_fragment');
        $this->as_add_filter('body_class', 'as_get_class_body');
    }

    // Function Woo Header
    function as_woo()
    {
        if (class_exists('woocommerce'))
        {
            global $woocommerce;
            if (is_object($woocommerce->cart))
            {
                echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);
            }
        }
    }

    function as_class_data()
    {
        $as_woo_control_style = '';
        if (class_exists('Woocommerce'))
        {
            $as_woo_control_style = 'as-woo-control-style-wrapper';
        }
        $as_class_data = array(
            'as_woo_control_style' => $as_woo_control_style,
        );
        return $as_class_data;
    }

    //Woo Actions
// Function Wish-list Product
    public function as_action_init_wish_list()
    {
        //Check wish list page
        global $wpdb;
        $page_found = $wpdb->get_var($wpdb->prepare("SELECT `ID` FROM `{$wpdb->posts}` WHERE `post_name` = %s LIMIT 1;", 'wishlist'));
        if ($page_found)
        {
            update_option('as-wishlist-page-id', $page_found);
            return;
        }

        $page_data = array(
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_author'    => 1,
            'post_name'      => esc_sql(_x('wishlist', 'page_slug', 'as')),
            'post_title'     => esc_html__('Wishlist', 'as'),
            'post_content'   => '[as_wish_list]',
            'post_parent'    => 0,
            'comment_status' => 'closed'
        );
        $page_id   = wp_insert_post($page_data);
        update_option('as-wishlist-page-id', $page_id);
    }

// Function Compare Product
    public function as_action_init_compare()
    {
        //Check wish list page
        global $wpdb;
        $page_found = $wpdb->get_var($wpdb->prepare("SELECT `ID` FROM `{$wpdb->posts}` WHERE `post_name` = %s LIMIT 1;", 'compare'));
        if ($page_found)
        {
            update_option('as-compare-page-id', $page_found);
            return;
        }

        $page_data = array(
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_author'    => 1,
            'post_name'      => esc_sql(_x('compare', 'page_slug', 'as')),
            'post_title'     => esc_html__('Compare', 'as'),
            'post_content'   => '[as_compare]',
            'post_parent'    => 0,
            'comment_status' => 'closed'
        );
        $page_id   = wp_insert_post($page_data);
        update_option('as-compare-page-id', $page_id);
    }

    //Woo Actions / End
    //Woo Filters
    public function as_woocommerce_header_add_to_cart_fragment($fragments)
    {
        ob_start();
        ?>
        <span class="as-quatity-item-woo"><?php echo sprintf(_n('%d', '%d', WC()->cart->cart_contents_count, 'woothemes'), WC()->cart->cart_contents_count); ?></span>
        <?php
        $fragments['.as-quatity-item-woo'] = ob_get_clean();

        return $fragments;
    }

    public function as_get_class_body($as_classes)
    {

        $as_class_data = $this->as_class_data();

        $as_classes[] = $as_class_data['as_woo_control_style'];
        // return the $classes array
        return $as_classes;
    }

    //Woo Filters / End
}
