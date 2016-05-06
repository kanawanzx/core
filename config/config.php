<?php

return array(
    'main_class'   => array(
        'AJAX_PREFIX'        => 'wp_ajax_',
        'AJAX_NOPRIV_PREFIX' => 'wp_ajax_nopriv_',
        'FILTER_SCRIPT'      => 'as_enqueue_script',
        'FILTER_STYLE'       => 'as_enqueue_style'
    ),
    'wish-list'    => array(
        'WISHLIST_WOO_PLUGIN_URL' => get_template_directory_uri() . "/plugins/woocommerce/wish-list",
        'WISHLIST_COOKIE_NAME'    => 'as_wishlist_products',
    ),
    'compare'      => array(
        'COMPARE_WOO_PLUGIN_URL' => get_template_directory_uri() . "/plugins/woocommerce/compare",
        'COMPARE_COOKIE_NAME'    => 'as_compare_products',
    ),
    'sidebars'     => include (get_template_directory() . '/core/config/sidebars.php'),
    'allowed_html' => array(
        //formatting
        'strong' => array(),
        'em'     => array(),
        'b'      => array(),
        'i'      => array(),
        'br'     => array(),
        //links
        'a'      => array(
            'href' => array()
        )
    )
);
