<?php

// theme setups
add_action('init', 'oneblogtheme_setup');

if (!function_exists('oneblogtheme_setup')) {

    function oneblogtheme_setup() {

        load_theme_textdomain('oneblog', get_template_directory() . '/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');

        // menu
        register_nav_menus(array(
            'primary'   => __('Primary Menu', 'oneblog'),
            'secondary' => __('Secondary Menu', 'oneblog'),
        ));

        add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video'));

                                                          // custom imaage size
        add_image_size('category-thumb', 300, 300, true); // 300 pixels wide (and unlimited height)
        add_image_size('post-thumb', 500, 300, true);     // (cropped)
    }
}

// setup css and js file
add_action('wp_enqueue_scripts', 'oneblog_theme_scripts');

if (!function_exists('oneblog_theme_scripts')) {
    function oneblog_theme_scripts() {
        wp_enqueue_style('oneblog-style', get_stylesheet_uri());
        wp_enqueue_style('oneblog-boosttrap', get_template_directory_uri() . "/assets/css/bootstrap.min.css", [], wp_get_theme()->get('Version'), 'all');
        wp_enqueue_style('oneblog-main-style', get_template_directory_uri() . "/assets/css/style.css", [], wp_get_theme()->get('Version'), 'all');

        wp_enqueue_script('jquery');
        wp_enqueue_script('oneblog-bootstrap', get_template_directory_uri() . "/assets/js/bootstrap.bundle.min.js", [], wp_get_theme()->get('Version'), true);
        wp_enqueue_script('oneblog-main-script', get_template_directory_uri() . "/assets/js/script.js", ['jquery'], wp_get_theme()->get('Version'), true);
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}

//theme customizer
add_action('customize_register', 'oneblog_customize_register');
if (!function_exists('oneblog_customize_register')) {
    function oneblog_customize_register($wp_customize) {

        $wp_customize->add_panel('theme_option', array(
            'title'       => __('Theme Option', 'oneblog'),
            'description' => __('Setup Header footer', 'oneblog'),
            'priority'    => 160,
        ));

        $wp_customize->add_section('oneblog_header', array(
            'title'       => __('Header Area', 'oneblog'),
            'description' => '',
            'priority'    => 120,
            'panel'       => 'theme_option',
        ));

        $wp_customize->add_setting('oneblog_logo', array(
            'default'    => esc_url(get_template_directory_uri()) . '/assets/images/logo.png',
            'capability' => 'edit_theme_options',
            'type'       => 'option',

        ))->transport = 'postMessage';

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'oneblog_logo', array(
            'label'     => __('Upload Logo', 'oneblog'),
            'section'   => 'oneblog_header',
            'settings'  => 'oneblog_logo',
            'mime_type' => 'image',
        )));

        $wp_customize->selective_refresh->add_partial('oneblog_logo', array(
            'selector'        => '.navbar-brand',
            'render_callback' => function () {
                return esc_url(get_template_directory_uri()) . '/assets/images/logo.png';
            },
        ));

        // header layouts settings
        $wp_customize->add_setting('oneblog_header_layout', array(
            'default'    => 'left',
            'capability' => 'edit_theme_options',
            'type'       => 'option',

        ));
        $wp_customize->add_control('oneblog_header_layout', array(
            'label'    => __('Header Layout', 'oneblog'),
            'section'  => 'oneblog_header',
            'settings' => 'oneblog_header_layout',
            'type'     => 'radio',
            'choices'  => array(
                'left'   => 'Left',
                'center' => 'Center',
                'right'  => 'Right',
            ),
        ));
    }
}

// sidbar
add_action('widgets_init', 'wpdocs_register_widgets');

function wpdocs_register_widgets() {
    register_sidebar([
        'name' => 'blog side bar',
        'id'   => 'sidbar_1',
    ]);
}

// Set UI labels for Custom Post Type
add_action('init', 'custom_post_type');
function custom_post_type() {

    $labels = array(
        'name'               => _x('Movies', 'Post Type General Name', 'oneblog'),
        'singular_name'      => _x('Movie', 'Post Type Singular Name', 'oneblog'),
        'menu_name'          => __('Movies', 'oneblog'),
        'parent_item_colon'  => __('Parent Movie', 'oneblog'),
        'all_items'          => __('All Movies', 'oneblog'),
        'view_item'          => __('View Movie', 'oneblog'),
        'add_new_item'       => __('Add New Movie', 'oneblog'),
        'add_new'            => __('Add New', 'oneblog'),
        'edit_item'          => __('Edit Movie', 'oneblog'),
        'update_item'        => __('Update Movie', 'oneblog'),
        'search_items'       => __('Search Movie', 'oneblog'),
        'not_found'          => __('Not Found', 'oneblog'),
        'not_found_in_trash' => __('Not found in Trash', 'oneblog'),
    );

    $args = array(
        'label'               => __('movies', 'oneblog'),
        'description'         => __('Movie news and reviews', 'oneblog'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
        'taxonomies'          => array('subjects'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
        'rewrite'             => array('slug' => 'movies'),

    );

    // Registering your Custom Post Type
    register_post_type('movies', $args);

}

//create a custom taxonomy name it subjects for your posts
add_action('init', 'create_movies_taxonomy');

function create_movies_taxonomy() {

    $labels = array(
        'name'              => _x('Subjects', 'taxonomy general name'),
        'singular_name'     => _x('Subject', 'taxonomy singular name'),
        'search_items'      => __('Search Subjects'),
        'all_items'         => __('All Subjects'),
        'parent_item'       => __('Parent Subject'),
        'parent_item_colon' => __('Parent Subject:'),
        'edit_item'         => __('Edit Subject'),
        'update_item'       => __('Update Subject'),
        'add_new_item'      => __('Add New Subject'),
        'new_item_name'     => __('New Subject Name'),
        'menu_name'         => __('Subjects'),
    );

    register_taxonomy('subjects', array('movies'), array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'subject'),
    ));

}

// function that runs when shortcode is called
add_shortcode('greeting', 'wpb_demo_shortcode');
function wpb_demo_shortcode() {

    return "<h1>ok</h1>";
}

add_shortcode('new_button', 'wpb_button_shortcode');
function wpb_button_shortcode($atts, $content) {
    $valus = shortcode_atts([
        'url' => '#',
    ], $atts);
    return '<a href="' . esc_attr($valus['url']) . '">' . $content . '</a>';
}

add_shortcode('movies', 'wpb_movies_shortcode');
function wpb_movies_shortcode($atts, $content) {
    $valus = shortcode_atts([
        'url' => '#',
    ], $atts);
    return '<a href="' . esc_attr($valus['url']) . '">' . $content . '</a>';
}
