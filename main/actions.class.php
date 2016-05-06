<?php

class AS_ACTIONS extends AS_MAIN {

    public function as_init()
    {
        require_once get_template_directory() . '/widgets/widgets.php';
        $this->as_add_action('wp_enqueue_scripts', 'as_init_script');
        $this->as_add_action('wp_print_styles', 'as_init_style');
        $this->as_add_action('init', 'as_init_theme');
        $this->as_add_action('widgets_init', 'as_widgets_sidebars_init');
        $this->as_add_action('wp_footer', 'as_scripts_in_footer', 100);
    }

    public function as_scripts_in_footer()
    {
        ?>
        <script type="text/javascript">
            var root_ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
        </script>
        <?php
    }

    public function as_widgets_sidebars_init()
    {
        $this->as_register_widget_init();
        $this->as_register_sidebar_init();
    }

    function as_register_sidebar_init()
    {
        $array_sidebar = $this->config["sidebars"];
        if (!empty($array_sidebar))
        {
            foreach ($array_sidebar as $sidebar)
            {
                register_sidebar($sidebar);
            }
        }
    }

    public function as_register_widget_init()
    {
        register_widget('AS_Social_Photo');
        register_widget('AS_Contact_Info_Widget');
        register_widget('AS_Recent_Posts_Widget');
        register_widget('AS_Social_Info_Widget');
        register_widget('AS_Widget_Image');
        register_widget('AS_Subscribe');
        register_widget('AS_Facebook_widget');
        register_widget('AS_introduce_widget');
    }

    public function as_init_theme()
    {
        // Add tile
        add_theme_support("title-tag");
        // Auto feed
        add_theme_support('automatic-feed-links');
        // Woocommerce
        add_theme_support('woocommerce');
        // Add post formats
        add_theme_support('post-formats', array(
            'gallery',
            'image',
            'video',
            'quote',
            'link',
            'audio'));
        add_post_type_support('dslc_projects', 'post-formats');
        // Add featured images
        add_theme_support('post-thumbnails');
        // Add custom background
        add_theme_support('custom-background');
        // Add custom header
        add_theme_support('custom-header');
        /* === Register Menus === */
        register_nav_menu('as_header_menu', esc_html__('Theme Main Menu', 'alenastudio'));
        register_nav_menu('as_sub_menu', esc_html__('Theme Sub Menu', 'alenastudio'));
        register_nav_menu('as_sidebar_menu', esc_html__('Theme Sidebar Menu', 'alenastudio'));
        register_nav_menu('as_footer_menu', esc_html__('Theme Footer Menu', 'alenastudio'));
    }

    public function as_init_style()
    {
        if (!(function_exists('dslc_register_modules')))
        {
            $this->as_add_style('as-font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '1.0', 'all');
            // AS Icon Font
            $this->as_add_style('as-icon-font', get_template_directory_uri() . '/css/as-icon-font.css', array(), '1.0', 'all');
            // Add temp style
            $this->as_add_style('as-css-temp', get_template_directory_uri() . '/css/temp-style-dslc.css', array(), '1.0', 'all');
        }

        // Dialog
        $this->as_add_style('as-dialog', get_template_directory_uri() . '/css/libs/dialog/dialog.css', array(), '1.0', 'all');
        $this->as_add_style('as-dialog-wilma', get_template_directory_uri() . '/css/libs/dialog/dialog-wilma.css', array(
            'as-dialog'), '1.0', 'all');
        // Style.css
        $this->as_add_style('as-style', get_stylesheet_uri());
        // Responsive Style
        $this->as_add_style('responsive-style', get_template_directory_uri() . '/css/responsive-style.css', array(), '1.0', 'all');
        // Custom Style
        $this->as_add_style('custom', get_template_directory_uri() . '/css/custom-style.php', array(), '1.0', 'all');
        //video audio
        $this->as_add_style('video', get_template_directory_uri() . '/css/libs/html5/video.css', array(), '1.0', 'all');

        if (file_exists(get_template_directory() . '/demo/css/style_end.css'))
        {
            //style demo
            $this->as_add_style('style_end', get_template_directory_uri() . '/demo/css/style_end.css', array(), '1.0', 'all');
        }
    }

    public function as_init_script()
    {
        if (as_option('as_option_smooth_scroll', '1'))
        {
// Smoothscroll JS
            $this->as_add_script('smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array(
                'jquery'));
        }
// Modernize JS
        $this->as_add_script('modernizr', get_template_directory_uri() . '/js/libs/modernizr.custom.js', array(
            'jquery'));
        if (as_option('as_option_retina_img', '1'))
        {
            $this->as_add_script('retina', get_template_directory_uri() . '/js/libs/retina.min.js', array(
                'jquery'));
        }
        $this->as_add_script('front', get_template_directory_uri() . '/js/front.js', array(
            'jquery'));

        $this->as_add_script('js-appear', get_template_directory_uri() . '/js/libs/main.js', array(
            'jquery'));

// Internet Explorer HTML5 support 
        $this->as_add_script('html5shiv', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.7.3', false);
        wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');

// Add js easing when plugin not active
        if (!(function_exists('dslc_register_modules')))
        {
//add js easing
            $this->as_add_script('js-easing', get_template_directory_uri() . '/js/libs/jquery.easing.js', array(
                'jquery'));
        }
        wp_localize_script('front', 'as_globals', array(
            'ajaxURL' => admin_url('admin-ajax.php'),
            'imgURL'  => get_template_directory_uri() . '/img/'
        ));
// Custom
        $this->as_add_script('main', get_template_directory_uri() . '/js/main.js', array(
            'jquery'));
// add style demo
        if (file_exists(get_template_directory() . '/demo/js/custom_panel.js'))
        {
            $this->as_add_script('custom_panel', get_template_directory_uri() . '/demo/js/custom_panel.js', array(
                'jquery'));
        }
    }

}
