<?php

class AS_PAGE extends AS_MAIN {

    protected $post;
    protected $project;

    public function __construct()
    {
        parent::__construct();
        $this->post    = new AS_POST();
        $this->project = new AS_POST_PROJECT();
    }
    private function as_page_get_sidebar_class()
    {
        $as_blog_sidebar = rwmb_meta('as_blog_option');

        $as_sidebar = '';
        if (isset($as_blog_sidebar) && !empty($as_blog_sidebar) && ($as_blog_sidebar != 'default'))
        {
            $as_sidebar = $as_blog_sidebar;
        }
        else
        {
            $as_sidebar = as_option('as_blog_position_sidebar');
        }
        $full_col = '';
        $last_col = '';
        $cont_col = '';
        if (((as_option('as_blog_position_sidebar') == "left") && ($as_blog_sidebar == 'default')) | ($as_sidebar == "left"))
        {
            $full_col = ' dslc-8-col';
            $last_col = ' dslc-last-col';
            $cont_col = ' as-sidebar-border-right';
        }
        if (((as_option('as_blog_position_sidebar') == "right") && ($as_blog_sidebar == 'default')) | ($as_sidebar == "right"))
        {
            $full_col = ' dslc-8-col';
            $cont_col = ' as-sidebar-border-left';
        }
        if (($as_sidebar == "full"))
        {
            $full_col = ' dslc-12-col dslc-last-col as-fullwidth';
        }
        if (($as_sidebar == "fullwidth") && (as_option('as_blog_position_sidebar') == "fullwidth"))
        {
            $full_col = ' dslc-12-col dslc-last-col as-fullwidth';
        }
        return array(
            'full_col' => $full_col,
            'last_col' => $last_col,
            'cont_col' => $cont_col,
        );
    }

    public function as_render()
    {
        $as_col = $this->as_page_get_sidebar_class();
        ?>
        <!-- Content -->
        <div class="as-page-wrapper">
            <div class="as-content-wrapper ">
                <div id="as-page-blog-classic" class="as-wrapper clearfix <?php echo esc_attr($as_col['cont_col']); ?>">
                    <?php
                    //Left Sidebar / Start
                    if (as_option('as_blog_position_sidebar') == "left")
                    {
                        ?>
                        <div class="dslc-col dslc-4-col">
                            <?php get_sidebar(); ?>
                        </div>
                        <?php
                    }
                    //Left Sidebar / End
                    ?>
                    <div class="dslc-col <?php echo esc_attr($as_col['full_col']); ?> <?php echo esc_attr($as_col['last_col']); ?>">
                        <?php
                        //Post Content / Start
                        echo $this->post->as_render();
                        //Post Content / End
                        //Page Pagination / Start
                        echo $this->as_page_pagination();
                        //Page Pagination / End
                        ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                    <?php
                    //Right Sidebar / Start
                    if (as_option('as_blog_position_sidebar') == "right")
                    {
                        ?>
                        <div class="dslc-col dslc-4-col dslc-last-col">
                            <?php get_sidebar(); ?>
                        </div><!-- Sidebar / End -->
                        <?php
                    }
                    //Right Sidebar / End
                    ?>
                </div><!-- Wrapper / End -->
            </div>
        </div>
        <!-- Content / End -->
        <?php
    }

    public function as_render_blank()
    {
        echo $this->post->as_render_blank();
    }

    public function as_page_pagination()
    {
        $as_pagination = array(
            'before'           => '<div class="as-pagination-pages-wrapper">',
            'after'            => '</div>',
            'link_before'      => '',
            'link_after'       => '',
            'next_or_number'   => 'next',
            'separator'        => ' ',
            'nextpagelink'     => esc_html__('Next page', 'alenastudio') . '<span class="dslc-icon dslc-icon-angle-right"></span>',
            'previouspagelink' => '<span class="dslc-icon dslc-icon-angle-left"></span>' . esc_html__('Previous page', 'alenastudio'),
            'pagelink'         => '%',
            'echo'             => 1
        );
        return (wp_link_pages($as_pagination));
    }

}
