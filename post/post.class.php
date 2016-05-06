<?php

class AS_POST extends AS_MAIN {

    public function as_render()
    {
        if (is_search())
        {
            $this->as_render_search();
        }
        else
        {
            $this->as_render_default();
        }
        if (is_single())
        {
            $this->as_post_render_comment();
        }
    }

    protected function as_post_render_comment()
    {
        get_template_part('template/posts/post-author');
        comments_template();
    }

    public function as_render_default()
    {
        if (have_posts())
        {
            while (have_posts())
            {
                the_post();
                $this->as_post_render_content();
                ?>
                <div class="as-line-bottom-blog">
                    <div class="as-line-full"></div>
                    <div class="as-line-half"></div>
                </div>
                <?php
            }
        }
        wp_reset_postdata();
        ?>
        <div class="as-pagination-wrapper">
            <?php echo $this->as_post_pagination(); ?>
        </div>
        <?php
    }

    public function as_render_search()
    {
        if (have_posts())
        {
            while (have_posts())
            {
                $this->as_post_render_content();
            }
        }
        else
        {
            ?>
            <div class="search-error">
                <p style="font-size:30px;"><?php esc_html_e('Sorry there are no posts to display, oh man!', 'alenastudio') ?></p>
            </div>
            <?php
        }
        wp_reset_postdata();
    }

    public function as_render_blank()
    {
        if (have_posts())
        {
            ?>
            <?php while (have_posts()) : the_post(); ?>
                <!-- Content-->
                <div class="as-page-wrapper">
                    <div class="as-content-wrapper">
                        <div class="as-wrapper clearfix">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                <!-- Content / End -->
                <?php
            endwhile;
        }
    }

    protected function as_post_render_content()
    {
        $format = get_post_format();
        ?>
        <div <?php post_class('as-post-item'); ?>>
            <?php
            get_template_part('template/posts/post-date-format');
            get_template_part('template/posts/post-content');
            get_template_part('template/posts/post-title-meta');
            if ($format != 'quote')
            {
               get_template_part('template/pages/page-blog-detail');
            }
            ?>
        </div>	
        <div class="clearfix"></div>	
        <?php
    }

    protected function as_post_pagination()
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

    public function as_is_like_post($id)
    {
        if (isset($_COOKIE['as_like_' . $id]) && $_COOKIE['as_like_' . $id] == 1)
            return 'active';
    }

    public function as_next_prev($post, $next_prev, $icon)
    {

        if (isset($post) && !empty($post))
        {
            $as_output             = '';
            $as_post_thumbnail_url = '';
            if (has_post_thumbnail())
            {
                $as_post_thumbnail     = get_post_thumbnail_id($post->ID, '');
                $as_post_thumbnail_url = wp_get_attachment_url($as_post_thumbnail);
            }
            if (is_object($post))
            {
                $as_output .= '<a class="as-post-nav-' . $next_prev . '" href="' . get_permalink($post) . '" style="background-image:url(' . $as_post_thumbnail_url . ');">';
                $as_output .= '<div class="as-mark-image"></div>';
                $as_output .= '<div class="as-content-prev-next-post"><span class="as-icon-link-post"><span class="dslc-icon dslc-icon-' . $icon . '"></span></span>';

                $as_output .= '<div class="as-future-title">';
                $as_output .= '<h6>' . get_the_title($post) . '</h6>';
                $as_output .= '<span class="as-date"><span class="dslc-icon dslc-icon-time"></span>&nbsp' . get_the_date(get_option('date_format'), $post->ID) . '</span>';
                $as_output .= '</div></div>';

                $as_output .= '</a>';
            }

            return $as_output;
        }
    }

    public function as_get_next_previous_port_id($post_id, $next_or_prev)
    {
        // Get a global post reference since get_adjacent_post() references it
        global $post;

        // Store the existing post object for later so we don't lose it
        $oldGlobal = $post;

        // Get the post object for the specified post and place it in the global variable
        $post = get_post($post_id);

        // Get the post object for the previous post
        $previous_post = $next_or_prev == "prev" ? get_previous_post() : get_next_post();

        // Reset our global object
        $post = $oldGlobal;

        if ('' == $previous_post)
        {
            $port = get_posts(array(
                'post_type'      => 'dslc_projects',
                'order'          => $next_or_prev == "prev" ? 'DESC' : 'ASC',
                'posts_per_page' => 1,
            ));
            return $port[0]->ID;
        }

        return $previous_post->ID;
    }

    public function as_customize_excerpt($limit)
    {
        $excerpt = explode(' ', get_the_excerpt(), $limit);
        if (count($excerpt) >= $limit)
        {
            array_pop($excerpt);
            $excerpt = implode(" ", $excerpt) . '...';
        }
        else
        {
            $excerpt = implode(" ", $excerpt);
        }
        return $excerpt;
    }

    public function as_function_comments_better($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class(); ?> id="as-li-comment-<?php comment_ID() ?>">
            <div class="as-comment" id="as-comment-<?php comment_ID(); ?>">

                <div class="as-comment-content">					
                    <?php echo get_avatar($comment, $size               = '65'); ?>
                    <div class="as-comment-meta">
                        <h4><?php comment_author_link() ?>
                            <span><?php comment_date(); ?> at <?php comment_time() ?></span>
                        </h4> 		
                    </div>	
                    <div class="as-comment-text">
                        <?php comment_text() ?>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <p style="font-style:italic;"><?php esc_html_e('Your comment is awaiting moderation.', 'alenastudio') ?></p>
                            <br />
                        <?php endif; ?>
                        <?php edit_comment_link(esc_html__('[Edit]', 'alenastudio'), '  ', '') ?>
                        <?php
                        comment_reply_link(array_merge($args, array(
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'])))
                        ?>
                    </div> 
                </div>
            </div>
        </li>
        <?php
    }

}
