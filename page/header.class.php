<?php

class AS_PAGE_HEADER extends AS_MAIN {

    public function as_header_icon()
    {

        if (!function_exists('has_site_icon') || !has_site_icon())
        {
            ?>
            <!-- Favicons
            ================================================== -->
            <link rel="shortcut icon" href="<?php echo as_option('as_option_favicon', false, 'url'); ?>">
            <link rel="icon" type="image/png" href="<?php echo as_option('as_option_favicon', false, 'url'); ?>" />
            <link rel="apple-touch-icon" href="<?php echo as_option('touch_icon', false, 'url'); ?>">
            <link rel="apple-touch-icon" sizes="72x72" href="<?php echo as_option('touch_icon_72', false, 'url'); ?>">
            <link rel="apple-touch-icon" sizes="114x114" href="<?php echo as_option('touch_icon_144', false, 'url'); ?>">
            <!-- Favicons / End -->
            <?php
        }
        else
        {
            wp_site_icon();
        }
    }

    public function as_header_pre_loadding()
    {
        if (as_option('as_option_page_preloading', '1'))
        {
            ?>
            <div id="as-preloading-wrapper">
                <div class="as-preloader">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <?php
        }
    }

    private function as_check_header()
    {
        if (!as_option('as_option_check_header', '1'))
        {
            return false;
        }
        else
        {
            $check_page_custom = rwmb_meta('as_custom_page_metaboxes', 'type=checkbox_list');
            if (in_array('page_header_options', $check_page_custom))
            {
                $as_header = rwmb_meta('as_header_box');
                if ($as_header == 999)
                {
                    return false;
                }
                else if ($as_header != 0)
                {
                    return array(
                        $as_header
                    );
                }
            }
            return true;
        }

        return true;
    }

    public function as_get_header()
    {
        $as_slug = $this->as_check_header();
        if (is_array($as_slug))
        {
            echo get_template_part('template/headers/header', $as_slug[0]);
        }
        else if ($as_slug == true)
        {
            echo get_template_part('template/headers/header');
        }
        return;
    }

    private function as_check_breadcrumb()
    {
        if ((!is_page_template('page-home.php') || is_404() || is_search()))
        {
            if (as_option('as_option_breadcrumb_style', 1))
            {
                $check_page_custom = rwmb_meta('as_custom_page_metaboxes', 'type=checkbox_list');
                if (in_array('page_breadcrumb_options', $check_page_custom))
                {
                    $as_breadcrumb = ( rwmb_meta('as_breadcrumb_menu'));
                    if ($as_breadcrumb == 999)
                    {
                        return false;
                    }
                    elseif ($as_breadcrumb != 0)
                    {
                        return array(
                            $as_breadcrumb
                        );
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function as_get_breadcrumb()
    {
        $as_breadcrumb = $this->as_check_breadcrumb();
        if (is_array($as_breadcrumb) && $as_breadcrumb[0] !=1)
        {
            echo get_template_part('template/breadcrumbs/breadcrumb', $as_breadcrumb[0]);
        }
        else if ($as_breadcrumb ==true)
        {
            echo get_template_part('template/breadcrumbs/breadcrumb', 'default');
        }
        return;
    }

    private function as_get_breadcrumb_title()
    {
        global $post;
        //BREADCRUM TITLE
        $is_archive_class = true;
        $breadcrumb_title = "";
        if (is_tax('portfolio_cats'))
        {
            $breadcrumb_title = translate('Portfolio category: ', 'alenastudio');
        }
        elseif (is_tax('product_cat'))
        {
            global $wp_query;
            $current_term     = $wp_query->get_queried_object();
            $breadcrumb_title = esc_html($current_term->name);
        }
        elseif (is_search())
        {
            $breadcrumb_title = translate('Search Results For: ', 'alenastudio') . " " . esc_attr(apply_filters('the_search_query', get_search_query(false)));
        }
        elseif (is_archive())
        {
            if (is_category())
            {
                $breadcrumb_title = translate('Category: ', 'alenastudio') . ' "' . single_cat_title('', false) . '"';
            }
            elseif (is_tag())
            {
                $breadcrumb_title = translate('Posts Tagged: ', 'alenastudio') . ' "' . single_tag_title('', false) . '"';
            }
            elseif (is_day())
            {
                $breadcrumb_title = translate('Archive For: ', 'alenastudio') . ' "' . apply_filters('the_time', get_the_time('F jS, Y'), 'F jS, Y') . '"';
            }
            elseif (is_month())
            {
                $breadcrumb_title = translate('Archive For: ', 'alenastudio') . ' "' . apply_filters('the_time', get_the_time('F, Y'), 'F, Y') . '"';
            }
            elseif (is_year())
            {
                $breadcrumb_title = translate('Archive For: ', 'alenastudio') . ' "' . apply_filters('the_time', get_the_time('Y'), 'Y') . '"';
            }
            elseif (isset($_GET['paged']) && !empty($_GET['paged']))
            {
                $breadcrumb_title = translate('Blog Archives', 'alenastudio');
            }
            else if (is_shop())
            {
                $breadcrumb_title = translate('Shop', 'alenastudio');
            }
        }
        elseif (is_404())
        {
            $breadcrumb_title = translate('"404 ! Page not found !"', 'alenastudio');
        }
        else
        {
            $is_archive_class = false;
            if (!is_singular('post') && !is_singular('portfolio'))
            {
                if (!is_home())
                {
                    $breadcrumb_title = empty($post->post_parent) ? get_the_title($post->ID) : get_the_title($post->post_parent);
                }
                else
                {
                    $breadcrumb_title = translate('Blog', 'alenastudio');
                }
            }
            else
            {
                if (is_singular('post'))
                {
                    $breadcrumb_title = translate('Blog', 'alenastudio');
                }
                elseif (is_singular('portfolio'))
                {
                    $breadcrumb_title = '' . get_the_title();
                }
            }
        }
        return array(
            'breadcrumb_title' => $breadcrumb_title,
            'is_archive_class' => $is_archive_class
        );
    }

    private function as_get_beadcrumb_content()
    {
        //BREADCRUM CONTENT
        $breadcrum_content      = array();
        $breadcrum_divider      = "/";
        $breadcrum_divider_html = $breadcrum_divider_html = '</li> <li><span class="as-breadcrumb-divider">' . $breadcrum_divider . '</span></li><li>';
        global $post;
        if (!is_home())
        {
            $breadcrum_content[] = array(
                "title" => "Home",
                "url"   => esc_url(home_url('/'))
            );

            if (is_category() || is_singular('post'))
            {
                $breadcrum_content[] = get_the_category_list($breadcrum_divider_html);

                if (is_single())
                {
                    $breadcrum_content[] = the_title("", "", false);
                }
            }
            elseif (is_tax('product_cat'))
            {
                global $wp_query;
                $current_term = $wp_query->get_queried_object();
                $ancestors    = array_reverse(get_ancestors($current_term->term_id, 'product_cat'));
                foreach ($ancestors as
                        $ancestor)
                {
                    $ancestor            = get_term($ancestor, 'product_cat');
                    $breadcrum_content[] = array(
                        "title" => esc_html($ancestor->name),
                        "url"   => get_term_link($ancestor)
                    );
                }
                $breadcrum_content[] = esc_html($current_term->name);
            }
            elseif (is_singular('portfolio'))
            {
                $breadcrum_content[] = get_the_term_list($post->ID, 'portfolio_cats', '', $breadcrum_divider_html);
                $breadcrum_content[] = the_title("", "", false);
            }
            elseif (is_singular('product'))
            {
                $breadcrum_content[] = get_the_term_list($post->ID, 'product_cat', '', $breadcrum_divider_html);
                $breadcrum_content[] = the_title("", "", false);
            }
            elseif (is_page())
            {
                if (!empty($post->post_parent))
                {
                    $breadcrum_content[] = array(
                        "title" => get_the_title($post->post_parent),
                        "url"   => get_permalink($post->post_parent)
                    );
                }
                $breadcrum_content[] = the_title("", "", false);
            }
            else if (is_page('Shop'))
            {
                $breadcrum_content[] = "Shop";
            }
        }
        elseif (is_tag())
        {
            $breadcrum_content[] = single_tag_title();
        }
        elseif (is_day())
        {
            $breadcrum_content[] = translate('Archive for', 'alenastudio') . apply_filters('the_time', get_the_time('F jS, Y'), 'F jS, Y');
        }
        elseif (is_month())
        {
            $breadcrum_content[] = translate('Archive for', 'alenastudio') . apply_filters('the_time', get_the_time('F, Y'), 'F, Y');
        }
        elseif (is_year())
        {
            $breadcrum_content[] = translate('Archive for', 'alenastudio') . apply_filters('the_time', get_the_time('Y'), 'Y');
        }
        elseif (is_author())
        {
            $breadcrum_content[] = translate('Author Archive', 'alenastudio');
        }
        elseif (isset($_GET['paged']) && !empty($_GET['paged']))
        {
            $breadcrum_content[] = translate('Blog Archives', 'alenastudio');
        }
        elseif (is_search())
        {
            $breadcrum_content[] = translate('Search Results', 'alenastudio');
        }
        elseif (is_404())
        {
            $breadcrum_content[] = translate('404 page not found', 'alenastudio');
        }
        return array(
            'breadcrum_content' => $breadcrum_content,
            'breadcrum_divider' => $breadcrum_divider
        );
    }

    public function as_breadcrumb_html()
    {
        $as_breadcrumb_title  = $this->as_get_breadcrumb_title();
        $as_breadcrum_content = $this->as_get_beadcrumb_content();
        $breadcrumb_title     = $as_breadcrumb_title['breadcrumb_title'];
        $is_archive_class     = $as_breadcrumb_title['is_archive_class'];
        $breadcrum_content    = $as_breadcrum_content['breadcrum_content'];
        $breadcrum_divider    = $as_breadcrum_content['breadcrum_divider'];
        ?>
        <div id="as-breadcrumb-wrapper">
            <div class="as-wrapper clearfix">
                <div class="dslc-col dslc-12-col dslc-last-col">
                    <?php
                    if (is_home())
                    {
                        ?>
                        <h1 class="as-page-title"><?php echo esc_html($breadcrumb_title); ?></h1>
                        <?php
                    }
                    elseif ($is_archive_class)
                    {
                        ?>
                        <h1 class="as-page-title as-page-title-archive"><?php echo esc_html($breadcrumb_title); ?></h1>
                        <?php
                    }
                    else
                    {
                        ?>
                        <h1 class="as-page-title as-breadcrumb-title"><?php echo esc_html($breadcrumb_title); ?></h1>
                        <?php
                    }
                    $as_breadcrumb   = ( rwmb_meta('as_breadcrumb_menu'));
                    $as_header_check = ( rwmb_meta('as_custom_page_metaboxes', 'type=checkbox_list'));
                    if ((($as_breadcrumb != 1) || !(in_array('page_breadcrumb_options', $as_header_check))) && (as_option('as_option_breadcrumb_link', '1'))):
                        ?>    
                        <!-- Breadcrumb Content -->
                        <ul class="as-breadcrumb-link">
                            <?php
                            if (!empty($breadcrum_content))
                            {
                                $count = 0;
                                foreach ($breadcrum_content as
                                        $link)
                                {
                                    $count++;
                                    echo "<li>";
                                    if (is_array($link))
                                    {
                                        ?>
                                        <a href="<?php echo esc_url($link["url"]) ?>"><?php echo esc_html($link["title"]); ?></a>
                                        <?php
                                    }
                                    else
                                    {
                                        echo balanceTags($link, true);
                                    }
                                    echo "</li>";
                                    if ($count < count($breadcrum_content))
                                    {
                                        echo '<li><span class="as-breadcrumb-divider">' . esc_html($breadcrum_divider) . '</span></li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                        <!-- End - Breadcrumb Content -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }

}
