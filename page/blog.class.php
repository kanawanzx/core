<?php

class AS_PAGE_BLOG extends AS_PAGE {

    protected function as_page_get_sidebar_class()
    {
        $as_blog_sidebar_metabox_opt = rwmb_meta('as_blog_option');
        $as_blog_sidebar_theme_opt   = as_option('as_blog_position_sidebar');
        $as_sidebar_position         = 'right';
        $full_col                    = '';
        $last_col                    = '';
        $cont_col                    = '';
        if (isset($as_blog_sidebar_metabox_opt) && !empty($as_blog_sidebar_metabox_opt) && ($as_blog_sidebar_metabox_opt != 'default'))
        {
            $as_sidebar_position = $as_blog_sidebar_metabox_opt;
        }
        else
        {
            $as_sidebar_position = $as_blog_sidebar_theme_opt;
        }
        if ($as_sidebar_position == "left")
        {
            $full_col = ' dslc-8-col';
            $last_col = ' dslc-last-col';
            $cont_col = ' as-sidebar-border-right';
        }
        else if ($as_sidebar_position == "left")
        {
            $full_col = ' dslc-8-col';
            $cont_col = ' as-sidebar-border-left';
        }
        else
        {
            $full_col = ' dslc-12-col dslc-last-col as-fullwidth';
        }
        return array(
            'full_col'   => $full_col,
            'last_col'   => $last_col,
            'cont_col'   => $cont_col,
            'as_sidebar' => $as_sidebar_position
        );
    }

}
