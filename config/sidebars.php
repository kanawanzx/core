<?php

 return array(
    /**
     * Creates a sidebar blog
     * @param string|array  Builds Sidebar based off of 'name' and 'id' values.
     */
    array(
        'name'          => esc_html__('Main Sidebar', 'alenastudio'),
        'id'            => 'main_sidebar',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="as-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>'
    ),
    /**
     * Creates a sidebar shop
     * @param string|array  Builds Sidebar based off of 'name' and 'id' values.
     */
    array(
        'name'          => esc_html__('Shop Sidebar', 'alenastudio'),
        'id'            => 'shop_sidebar',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="as-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>'
    ),
    /**
     * Creates a sidebar for footer
     * @param string|array  Builds Sidebar based off of 'name' and 'id' values.
     */
    /* Footer Area 1 */
    array(
        'name'          => esc_html__('Footer Area 1', 'alenastudio'),
        'id'            => 'footer_area_1',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="as-widget-footer %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title-footer">',
        'after_title'   => '</h4>'
    ),
    /* Footer Area 1 */
    array(
        'name'          => __('Footer Area 1', 'alenastudio'),
        'id'            => 'footer_area_1',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="as-widget-footer %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title-footer">',
        'after_title'   => '</h4>'
    ),
    /* Footer Area 2 */
    array(
        'name'          => esc_html__('Footer Area 2', 'alenastudio'),
        'id'            => 'footer_area_2',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="as-widget-footer %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title-footer">',
        'after_title'   => '</h4>'
    ),
    /* Footer Area 3 */
    array(
        'name'          => esc_html__('Footer Area 3', 'alenastudio'),
        'id'            => 'footer_area_3',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="as-widget-footer %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title-footer">',
        'after_title'   => '</h4>'
    ),
    /* Footer Area 4 */
    array(
        'name'          => esc_html__('Footer Area 4', 'alenastudio'),
        'id'            => 'footer_area_4',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div id="%1$s" class="as-widget-footer %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title-footer">',
        'after_title'   => '</h4>'
    )
);
