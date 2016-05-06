<?php

class AS_PAGE_PROJECT extends AS_PAGE {

    public function as_render()
    {
        ?>
        <div class="as-page-wrapper">
            <div class="as-content-wrapper">
                <div id="as-page-blog-classic" class="as-wrapper clearfix">
                    <div class="dslc-col dslc-6-col">
                        <?php $this->as_post_content(); ?>
                        <div class="dslc-col dslc-12-col dslc-last-col">     
                            <?php $this->as_post_link(); ?>
                        </div>
                        <?php
                        if (as_option('as_port_author_port', '1') || as_option('as_port_comment_port', '1'))
                        {
                            $this->as_post_comment();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function as_post_content()
    {
        if (have_posts())
        {
            while (have_posts()): the_post();
                $format = get_post_format();
                ?>
                <div class="dslc-col dslc-6-col">
                    <div <?php post_class('as-post-item'); ?>>
                        <?php get_template_part('template/posts/content-' . $format); ?>
                    </div>	
                </div>
                <div class="dslc-col dslc-6-col dslc-last-col">
                    <div <?php post_class('as-post-item'); ?>>
                        <?php
                        if ($format != 'quote')
                        {
                            get_template_part('template/projects/project-info');
                        }
                        ?>
                    </div>	
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        }
        else
        {
            ?>
            <div class="dslc-col dslc-6-col"></div>
            <div class="dslc-col dslc-6-col"></div>
            <?php
        }
        wp_reset_postdata();
    }

    protected function as_post_link()
    {
        ?>
        <div class="as-prj-single-more-link">            	
            <?php get_template_part('template/posts/post-new-link'); ?>
        </div>
        <?php
    }

    protected function as_post_comment()
    {
        ?>
        <div class="dslc-col dslc-12-col dslc-last-col" style="margin-top: 50px;">
            <?php
            if (as_option('as_port_author_port', '1'))
            {
                get_template_part('template/posts/post-author');
            }
            if (as_option('as_port_comment_port', '1'))
            {
                comments_template();
            }
            ?>
        </div>
        <?php
    }

}
