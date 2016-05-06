<?php

class Sub_Walker_Res_Menu extends Walker_Nav_Menu {

    function as_start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dl-submenu\">\n";
    }

}
