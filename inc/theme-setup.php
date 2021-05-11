<?php

/* 
* CES Theme setup & Support
*/


// Theme Support

if (!function_exists('ces_setup')) :

    function ces_setup()
    {

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');

        register_nav_menus(
            array(
                'menu-1' => esc_html__('Primary', 'ces'),
            )
        );


        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );


        add_theme_support('customize-selective-refresh-widgets');
    }
endif;
add_action('after_setup_theme', 'ces_setup');


// Theme CSS & JS

function ces_scripts_and_style()
{

    // Theme CSS

    // Datatable CSS for activity
    if (is_page('activity') || is_page('all-deals')) {
        wp_enqueue_style('datatable', 'https://cdn.datatables.net/v/bs4/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.css', array(), 1.0);
    }
    // Theme Main CSS
    wp_enqueue_style('ces-main', get_template_directory_uri() . '/dist/css/app.min.css', array(), '1.0');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/plugins/fontawesome/css/all.min.css', array(), '1.0');
    wp_enqueue_style('ces-style', get_stylesheet_uri(), array(), _S_VERSION);

    // Theme JS

    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/plugins/jquery/jquery.min.js', array(), null, false);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/plugins/bootstrap/js/bootstrap.bundle.min.js', array(), null, true);
    wp_enqueue_script('admin-lte', get_template_directory_uri() . '/dist/js/adminlte.min.js', array(), null, true);
    wp_enqueue_script('validate', get_template_directory_uri() . '/js/validation.min.js', array(), null, true);
    if (is_single()) {
        wp_enqueue_script('moment-js', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js', array(), null, true);
        wp_enqueue_script('datetimepicker', get_template_directory_uri() . '/js/datetimepicker.min.js', array(), null, true);
    }
    if (is_page('activity') || is_page('all-deals')) {
        wp_enqueue_script('pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js', array(), null, true);
        wp_enqueue_script('vfs-font', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js', array(), null, true);
        wp_enqueue_script('datatable', 'https://cdn.datatables.net/v/bs4/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.js', array(), null, true);
    }

    wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', array(), _S_VERSION, true);

    $script_data_array = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'rooturl'    => get_site_url(),
        'nonce'    => wp_create_nonce('wp_rest'),
        'security' => wp_create_nonce('load_more_posts'),
    );

    wp_localize_script('app', 'dealFeed', $script_data_array);


    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_single()) {
        wp_enqueue_style('datetimepicker', get_template_directory_uri() . '/dist/css/datetimepicker.min.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'ces_scripts_and_style');
