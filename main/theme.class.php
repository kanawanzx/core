<?php

class AS_THEME extends AS_MAIN {

    public $page_;
    public $page_header;
    public $page_footer;
    public $page_archive;
    public $page_category;
    public $page_date;
    public $page_index;
    public $page_blog;
    public $page_search;
    public $page_single;
    public $actions;
    public $_filters;
    public $ajax;
    public $woo;
    public $_post;
    public $page_comment;

    public function __construct()
    {
        parent::__construct();
        $this->actions  = new AS_ACTIONS();
        $this->_filters = new AS_FILTERS();
        $this->ajax     = new AS_AJAXS();
        $this->woo      = new AS_WOO();
    }

    public function as_init()
    {
        $this->actions->as_init();
        $this->_filters->as_init();
        $this->ajax->as_init();
        $this->woo->as_init();
    }

    public function as_allowed_html_array_f2()
    {
        echo wp_kses((as_option('as_option_copyright_footer_2', 'alenastudio')), $this->config["allowed_html"]);
    }

    public function as_is_active_lc()
    {
        return isset($_GET['dslc']) && $_GET['dslc'] == 'active';
    }

}
