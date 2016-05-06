<?php

class AS_PAGE_FOOTER extends AS_MAIN {
 private function as_check_footer()
    {
        if (!as_option('as_option_check_footer', '1'))
        {
            return false;
        }
        else
        {
            $check_page_custom = rwmb_meta('as_custom_page_metaboxes', 'type=checkbox_list');
            if (in_array('page_footer_options', $check_page_custom))
            {
                $as_footer = rwmb_meta('as_footer_menu');
                if ($as_footer == 999)
                {
                    return false;
                }
                else if ($as_footer != 0)
                {
                    return array(
                        $as_footer
                    );
                }
            }
            return true;
        }

        return true;
    }

    public function as_get_footer()
    {
        $as_footer = $this->as_check_footer();  
        if ($as_footer)
        {
            if (is_array($as_footer))
            {
                echo get_template_part('template/footers/footer' , $as_footer[0]);
            }
            else if ($as_footer == true)
            {
                $slug = as_option('as_option_custom_footer');
                echo get_template_part('template/footers/footer' , $slug);
            }
        }
        return false;
    }

}
