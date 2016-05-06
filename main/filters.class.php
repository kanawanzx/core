<?php

class AS_FILTERS extends AS_MAIN {

    public function as_init()
    {
        $this->as_add_filter('wp_title', 'as_wp_title', 10, 2);
        $this->as_add_filter('pagination_as', 'as_get_pagination');
        $this->as_add_filter('number_comment', 'as_get_number_comment');
        $this->as_add_filter('excerpt_length', 'as_customize_excerpt_number', 999);
    }

    public function as_customize_excerpt_number($length)
    {
        $as_number_except = as_option('as_blog_content_except');
        return $as_number_except;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Custom Title WP */
    /* ----------------------------------------------------------------------------------- */

    public function as_wp_title($title, $sep)
    {
        global $paged, $page;

        if (is_feed())
            return $title;

        // Add the site name.
        $title .= get_bloginfo('name');

        // Add the site description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && ( is_home() || is_front_page() ))
            $title            = "$title $sep $site_description";

        // Add a page number if necessary.
        if ($paged >= 2 || $page >= 2)
            $title = "$title $sep " . sprintf(esc_html__('Page %s', 'alenastudio'), max($paged, $page));

        return $title;
    }

    /* ----------------------------------------------------------------------------------- */
    /* 	Pagination */
    /* ----------------------------------------------------------------------------------- */

    public function as_get_pagination()
    {
        global $wp_rewrite;
        global $wp_query;
        return paginate_links(array(
            'base'      => str_replace('99999', '%#%', esc_url(get_pagenum_link(99999))),
            'format'    => $wp_rewrite->using_permalinks() ? 'page/%#%' : '?paged=%#%',
            'current'   => max(1, get_query_var('paged')),
            'total'     => $wp_query->max_num_pages,
            'prev_text' => '<span class="dslc-icon dslc-icon-double-angle-left"></span>',
            'next_text' => '<span class="dslc-icon dslc-icon-double-angle-right"></span>',
            'type'      => 'list'
        ));
    }

    function as_get_number_comment()
    {
        global $post;
        $num_comments   = get_comments_number(); // get_comments_number returns only a numeric value
        $comments       = '';
        $write_comments = '';
        if (comments_open())
        {
            if ($num_comments == 0)
            {
                $comments = esc_html__('No comments', 'alenastudio');
            }
            elseif ($num_comments > 1)
            {
                $comments = $num_comments . esc_html__(' comments', 'alenastudio');
            }
            else
            {
                $comments = esc_html__('1 comment', 'alenastudio');
            }
            $write_comments = '<a href="' . esc_url(get_comments_link()) . '">' . $comments . '</a>';
        }
        else
        {
            $write_comments = esc_html__('Comments are off for this post.', 'alenastudio');
        }
        echo '<span class="dslc-icon dslc-icon-comment-alt"></span>&nbsp;' . $write_comments;
    }

}
