<?php

// change default settings for default gallery
add_action( 'after_setup_theme', 'stride_attachment_display_settings' );
function stride_attachment_display_settings() {
    update_option( 'image_default_link_type', 'file' );
}


// Print global js variables
add_action('wp_head', 'print_theme_wp_head');
function print_theme_wp_head(){
    echo '<script>
                var theme_options = { ajax_url: "'.admin_url( 'admin-ajax.php' ).'" };
          </script>';
}


// Print custom styles
add_action('wp_head', 'print_theme_styles', 1024);
function print_theme_styles(){
    global $post;

    $custom_css = TT::get_mod('custom_css');
    $custom_css .= TT::get_mod('custom_css_tablet') != '' ?    '@media (min-width: 768px) and (max-width: 985px) { ' . TT::get_mod('custom_css_tablet') . ' }' : '';
    $custom_css .= TT::get_mod('custom_css_widephone') != '' ? '@media (min-width: 481px) and (max-width: 767px) { ' . TT::get_mod('custom_css_widephone') . ' }' : '';
    $custom_css .= TT::get_mod('custom_css_phone') != '' ?     '@media (max-width: 480px) { '                        . TT::get_mod('custom_css_phone') . ' }' : '';

    $page_title = '';
    $page_title_color = TT::getmeta('title_color');
    $page_title_bg_color = TT::getmeta('title_bg_color');

    if( !empty($page_title_color) ) {
        $page_title .= ".page-title .block-title, .page-title .sub-title { color: $page_title_color; }";
    }

    if( !empty($page_title_bg_color) ) {
        $page_title .= ".page-title { background-color: $page_title_bg_color; }";
    }

    echo "<style type='text/css' id='theme-customize-css'>
            $custom_css
            $page_title
        </style>";
        
}



// Quick Load Element for VC
require_once tt_file_require(get_stylesheet_directory() . '/framework/current/ExtendVCRow.php');


// Import VC Custom Elements
if( function_exists('vc_map') ){
    $file_dir = tt_file_require( get_stylesheet_directory().'/framework/current/vc-elements/' );
    foreach( glob( $file_dir . '*.php' ) as $filename ) {
        require_once $filename;
    }
}



?>