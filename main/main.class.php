<?php

if (!class_exists('AS_MAIN'))
{

    class AS_MAIN {

        public $config = array();

        public function __construct()
        {
            $this->config = include (get_template_directory() . '/core/config/config.php');
        }

        public function initialize()
        {
            $this->config['as_class_data'] = $this->as_class_data();
        }

        //Actions
        public function as_add_action($hook, $callback, $priority = 10, $accepted_args = 1)
        {
            add_action($hook, array(
                $this,
                $callback
                    ), $priority, $accepted_args);
        }

        public function as_remove_action($hook, $callback)
        {
            remove_action($hook, array(
                $this,
                $callback
            ));
        }

        //Actions / End
        //Filters
        public function as_add_filter($hook, $callback, $priority = 10, $accepted_args = 1)
        {
            add_filter($hook, array(
                $this,
                $callback
                    ), $priority, $accepted_args);
        }

        public function as_remove_filter($hook, $callback)
        {
            remove_filter($hook, array(
                $this,
                $callback
            ));
        }

        //Filters / End
        //Ajax
        protected function as_add_ajax($hook, $callback, $priv = true, $no_priv = true, $priority = 10, $accepted_args = 1)
        {
            if ($priv)
            {
                add_action($this->config['main_class']['AJAX_PREFIX'] . $hook, array($this,$callback), $priority, $accepted_args);
            }
            if ($no_priv)
            {
                add_action($this->config['main_class']['AJAX_NOPRIV_PREFIX'] . $hook, array($this,$callback), $priority, $accepted_args);
            }
        }

        //Ajax / End
        //Script
        public function as_add_script($handle, $src, $deps = array(), $ver = false, $in_footer = true)
        {
            $scripts = apply_filters($this->config['main_class']['FILTER_SCRIPT'], array(
                'handle'    => $handle,
                'src'       => $src,
                'deps'      => $deps,
                'ver'       => $ver,
                'in_footer' => $in_footer
            ));
            return wp_enqueue_script($scripts['handle'], $scripts['src'], $scripts['deps'], $scripts['ver'], $scripts['in_footer']);
            wp_enqueue_script($scripts['handle']);
        }

        public function as_add_existed_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = true)
        {
            wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
        }

        //Script / End
        //Style
        public function as_add_style($handle, $src = false, $deps = array(), $ver = false, $media = 'all')
        {
            $style = apply_filters($this->config['main_class']['FILTER_STYLE'], array(
                'handle' => $handle,
                'src'    => $src,
                'deps'   => $deps,
                'ver'    => $ver,
                'media'  => $media
            ));
            wp_register_style($style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media']);
            wp_enqueue_style($style['handle']);
        }

        public function as_register_style($handle, $src = false, $deps = array(), $ver = false, $media = 'all')
        {
            $style = apply_filters($this->config['main_class']['FILTER_STYLE'], array(
                'handle' => $handle,
                'src'    => $src,
                'deps'   => $deps,
                'ver'    => $ver,
                'media'  => $media
            ));
            wp_register_style($style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media']);
            wp_enqueue_style($style['handle']);
        }

        /**
         * enqueue existed style
         * @param $handle
         */
        public function as_add_existed_style($handle)
        {
            wp_enqueue_style($handle);
        }

        //Style / End
        public function as_check_boxed_page()
        {
            $as_page_boxed = rwmb_meta('as_boxed_choice');
            switch ($as_page_boxed)
            {
                case 0:
                    if (as_option('as_option_page_width') == 1)
                    {
                        $as_page_width = as_option('as_option_page_set_width');
                        return $as_page_width;
                    }
                    else
                    {
                        return 'full';
                    }

                    break;
                case 1:
                    $as_page_width = rwmb_meta('as_boxed_choice_width');
                    return $as_page_width;
                    break;

                default:
                    return 'full';
                    break;
            }
        }

        protected function as_add_cookie($name, $value, $expire = 0)
        {
            if ($expire == 0)
            {
                $expire = time() + 60 * 60 * 24 * 30;
            }
            $value          = json_encode(stripslashes_deep($value));
            $_COOKIE[$name] = $value;
            wc_setcookie($name, $value, $expire, false);
        }

        protected function as_get_cookie($name)
        {
            if (isset($_COOKIE[$name]))
            {
                return json_decode(stripslashes($_COOKIE[$name]), true);
            }

            return array();
        }

    }

}
