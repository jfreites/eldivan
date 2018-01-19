<?php
/*
* The function allows us to include deep directory PHP files if they exist in child theme path.
* Otherwise it works just regularly include main theme files.
*/
if (!function_exists('tt_file_require')) {
    function tt_file_require($file, $uri = false) {
        $file = str_replace("\\", "/", $file); // Replaces If the customer runs on Win machine. Otherway it doesn't perform
        if (is_child_theme()) {
            if (!$uri) {
                $dir = str_replace("\\", "/", get_template_directory());
                $replace = str_replace("\\", "/", get_stylesheet_directory());
                $file_exist = str_replace($dir, $replace, $file);
                $file = str_replace($replace, $dir, $file);
            } else {
                $dir = get_template_directory_uri();
                $replace = get_stylesheet_directory_uri();
                $file_exist = str_replace($dir, $replace, $file);

                $file_child_url = str_replace($dir, get_stylesheet_directory(), $file);
                if( file_exists($file_child_url) ){
                    return $file_exist;
                }
            }

            if( file_exists($file_exist) ){
                $file_child = str_replace($dir, $replace, $file);
                return $file_child;
            }
            return $file;

        } else {
            return $file;
        }
    }
}


// Theme setup
if ( ! function_exists( 'nrgagency_theme_setup' ) ) :
    function nrgagency_theme_setup() {

        load_theme_textdomain( 'nrgagency', get_template_directory() . '/languages' );

        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_editor_style( 'editor-style.css' );
        add_theme_support( 'post-thumbnails' );

        set_post_thumbnail_size( 860, 290, true );
        add_image_size( 'nrgagency-blog-thumb', 360, 270, true );
        add_image_size( 'nrgagency-member', 269, 400, true );
        add_image_size( 'nrgagency-project-img', 400, 400, true );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary' => __('Primary Menu', 'nrgagency'),
            'footer' => __('Footer Menu', 'nrgagency')
        ) );

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        // Enable support for Post Formats.
        add_theme_support( 'post-formats', array(
            'image', 'video', 'quote', 'gallery', 'audio'
        ) );
    }
endif;
add_action( 'after_setup_theme', 'nrgagency_theme_setup' );



// default content width
if ( ! isset( $content_width ) ) $content_width = 940;



$tt_sidebars = array();

// Register widget area.
function nrgagency_widgets_init() {
    
    global $tt_sidebars;
    if(isset($tt_sidebars)) {
        foreach ($tt_sidebars as $id => $sidebar) {
            if( !empty($id) ){
                if( $id=='sidebar-portfolio' && !class_exists('TT_Portfolio_PT') ){
                    continue;
                }

                if( $id=='sidebar-woo' && !function_exists('is_shop') ){
                    continue;
                }
                
                register_sidebar(array(
                    'name' => $sidebar,
                    'id' => $id,
                    'description' => __('Add widgets here to appear in your sidebar.', 'nrgagency'),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h3 class="widget-title">',
                    'after_title'   => '</h3>'
                ));                
            }
        }
    }
    
    // Footer widget areas
    $footer_widget_num = TT::get_mod('footer_style');

    for($i=1; $i<=$footer_widget_num ; $i++ ) {
        register_sidebar(
            array(
                'name'          => esc_html__('Footer Column', 'nrgagency') . ' ' .$i,
                'id'            => 'footer'.$i,
                'description'   => esc_html__('Add widgets here to appear in your footer column', 'nrgagency') . ' ' .$i,
                'before_widget' => '<div id="%1$s" class="footer_widget widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            )
        );
    }

}
add_action( 'widgets_init', 'nrgagency_widgets_init' );



if ( ! function_exists( 'tt_body_class_filter' ) ) :
    function tt_body_class_filter( $classes ) {
        global $post;
        $page_for_posts = get_option('page_for_posts');
        $is_blog_page = is_home() && get_post_type($post) && !empty($page_for_posts) ? true : false;

        $header_style = TT::get_mod('header_style');
        $header_sticky = TT::get_mod('header_non_sticky');

        if( $header_sticky == '1' ) {
            $classes[] = 'non-sticky-header';
        }

        if( is_page() || $is_blog_page ){
            if(TT::getmeta('remove_padding')) {
                $classes[] = 'no-content-padding';
            }

            if($is_blog_page){
                $post = get_post($page_for_posts);
            }
            
            if( TT::getmeta('one_page_menu', $post->ID)=='1' ){
                $classes[] = "one-page-menu";
            }

        }

        if( !empty($header_style) && $header_style!="default" ){
            $classes[] = $header_style;
        }

        return $classes;
    }
endif;
add_filter( 'body_class', 'tt_body_class_filter' );



if ( ! function_exists( 'themeton_fonts_url' ) ) :
    function themeton_fonts_url() {
        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        $fonts[] = 'Maven+Pro:400,700,500';
        $fonts[] = 'Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic';

        if ( $fonts ) {
            $fonts_url = esc_url(add_query_arg( array(
                'family' => implode( '|', $fonts ),
                'subset' => urlencode( $subsets ),
            ), '//fonts.googleapis.com/css' ));
        }

        return $fonts_url;
    }
endif;



if( ! function_exists('nrgagency_enqueue_scripts') ) :
    function nrgagency_enqueue_scripts() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'wp-mediaelement' );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        // Add custom fonts, used in the main stylesheet.
        wp_enqueue_style( 'nrgagency-fonts', themeton_fonts_url(), array(), null );

        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
        wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
        wp_enqueue_style( 'nrgagency-stylesheet', get_stylesheet_uri() );

        wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/idangerous.swiper.min.js', false, false, true );
        wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', false, false, true );
        wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', false, false, true );
        wp_enqueue_script( 'magnific', get_template_directory_uri() . '/js/magnific.js', false, false, true );
        wp_enqueue_script( 'placeholder', get_template_directory_uri() . '/js/placeholder.min.js', false, false, true );
        wp_enqueue_script( 'countTo', get_template_directory_uri() . '/js/jquery.countTo.js', false, false, true );
        wp_enqueue_script( 'global', get_template_directory_uri() . '/js/global.js', false, false, true );

    }
endif;
add_action( 'wp_enqueue_scripts', 'nrgagency_enqueue_scripts' );



if( ! function_exists('tt_custom_excerpt_length') ) :
    function tt_custom_excerpt_length( $length ) {
        return 20;
    }
endif;
add_filter( 'excerpt_length', 'tt_custom_excerpt_length', 999 );



if( ! function_exists('tt_custom_excerpt_more') ) :
    function tt_custom_excerpt_more( $excerpt ) {
        return ' ...';
    }
endif;
add_filter( 'excerpt_more', 'tt_custom_excerpt_more' );



if( ! function_exists('tt_mime_types') ) :
    function tt_mime_types($mime_types){
        $mime_types['svg'] = 'image/svg+xml';
        return $mime_types;
    }
endif;
add_filter('upload_mimes', 'tt_mime_types', 1, 1);



if( ! function_exists('tt_print_main_menu') ) :
    function tt_print_main_menu($menu_class = ''){
        global $post;
        $po = $post;
        $page_for_posts = get_option('page_for_posts');
        $is_blog_page = is_home() && get_post_type($post) && !empty($page_for_posts) ? true : false;
        if( (is_page() || $is_blog_page) && $is_blog_page )
            $po = get_post($page_for_posts);

        if( isset($po->ID) && TT::getmeta('one_page_menu', $po->ID)=='1' ){
            $content = $po->post_content;
            $pattern = get_shortcode_regex();

            echo "<ul class='$menu_class'>";
            if( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) && array_key_exists( 2, $matches ) && in_array( 'vc_row', $matches[2] ) ){
                foreach ($matches[3] as $attr) {
                    $props = array();
                    $sarray = explode('" ', trim($attr));
                    foreach ($sarray as $val) {
                        $el =explode("=", $val);
                        $s1 = str_replace('"', '', trim($el[0]));
                        $s2 = str_replace('"', '', trim($el[1]));
                        $props[$s1] = $s2;
                    }

                    $op_section = isset($props['one_page_section']) ? $props['one_page_section'] : '';
                    $label = isset($props['one_page_label']) ? $props['one_page_label'] : '';
                    $slug = isset($props['one_page_slug']) ? $props['one_page_slug'] : '';
                    $data_icon = '';

                    if( $op_section!="yes" ){ continue; }
                    if( empty($label) ){ continue; }

                    
                    $icon_type = isset($props['op_icon_type']) ? $props['op_icon_type'] : '';
                    $icon = isset($props['one_page_icon']) ? $props['one_page_icon'] : '';
                    $img = isset($props['one_page_image']) ? $props['one_page_image'] : '';

                    if( TT::getmeta('page_header', $po->ID)=='left-side-menu' ){
                        if( $icon_type=='icon_image' ){
                            $image_src = !empty($img) ? wp_get_attachment_image_src($img, 'thumbnail') : '';
                            $data_icon = !empty($image_src) ? "<img src='$image_src[0]'>" : '';
                        }
                        else{
                            $data_icon = !empty($icon) ? "<i class='$icon'></i>" : '';
                        }
                    }

                    if( isset($po->ID) && TT::getmeta('one_page_menu', $po->ID)=='1' ){
                        $content = $po->post_content;
                        $pattern = get_shortcode_regex();
                        echo "<li class='menu-item'><a class='scroll-to-link' href='".esc_attr($slug)."'>$data_icon $label</a></li>";
                    }
                }
            }
            echo "</ul>";
        }
        else{
            wp_nav_menu( array(
                'menu_id'           => 'primary-nav',
                'menu_class'        => $menu_class,
                'theme_location'    => 'primary',
                'container'         => '',
                'fallback_cb'       => 'tt_primary_callback'
            ) );
        }
    }
endif;



// Primary menu callback & it prints one page menu if current page specified
if ( ! function_exists( 'tt_primary_callback' ) ) :
    function tt_primary_callback(){
        echo '<ul>';
        wp_list_pages( array(
            'sort_column'  => 'menu_order, post_title',
            'title_li' => '') );
        echo '</ul>';
    }
endif;



// Footer menu callback
if ( ! function_exists( 'tt_footer_callback' ) ) :
    function tt_footer_callback(){
        echo '<nav class="ftr-nav f-ftr-nav clearfix">';
        echo '<ul>';
        wp_list_pages( array(
            'sort_column'  => 'menu_order, post_title',
            'title_li' => '',
            'depth' => 1) );
        echo '</ul>';
        echo '</nav>';
    }
endif;



// Print Favicon
add_action('wp_head', 'tt_print_favicon');
if ( ! function_exists( 'tt_print_favicon' ) ) :
    function tt_print_favicon(){
        if(TT::get_mod('favicon') != '')
            echo '<link rel="shortcut icon" type="image/x-icon" href="'.TT::get_mod('favicon').'"/>';
    }
endif;



/*

 _____ _                 _              _____ _                     
|_   _| |_ ___ _____ ___| |_ ___ ___   |     | |___ ___ ___ ___ ___ 
  | | |   | -_|     | -_|  _| . |   |  |   --| | .'|_ -|_ -| -_|_ -|
  |_| |_|_|___|_|_|_|___|_| |___|_|_|  |_____|_|__,|___|___|___|___|

*/

// Themeton Standard Package
require_once tt_file_require(get_template_directory() . '/framework/classes/class.themeton.std.php');

// Less Compiler
require_once tt_file_require(get_template_directory() . '/framework/classes/class.less.php');

// Meta fields for Posts
require_once tt_file_require(get_template_directory() . '/framework/classes/class.render.meta.php');
require_once tt_file_require(get_template_directory() . '/framework/classes/class.meta.post.php');
require_once tt_file_require(get_template_directory() . '/framework/classes/class.meta.page.php');
require_once tt_file_require(get_template_directory() . '/framework/classes/class.meta.portfolio.php');

// WP Customizer
require_once tt_file_require(get_template_directory() . '/framework/classes/class.wp.customize.controls.php');
require_once tt_file_require(get_template_directory() . '/framework/classes/class.wp.customize.php');
require_once tt_file_require(get_template_directory() . '/framework/functions/functions.customizer.php');

// Import functions
require_once tt_file_require(get_template_directory() . '/framework/functions/functions.for.theme.php');
require_once tt_file_require(get_template_directory() . '/framework/functions/functions.breadcrumb.php');

// Import Demo Data
require_once tt_file_require(get_template_directory() . '/framework/classes/class.import.data.php');

// Import Menu
require_once tt_file_require(get_template_directory() . '/framework/widgets/init_widget.php');

// TGM Plugin Activation
require_once tt_file_require(get_template_directory() . '/framework/functions/plugin-install.php');

// Include current theme customize
require_once tt_file_require(get_template_directory() . '/framework/current/functions.php');

// Import Template tags
require_once tt_file_require(get_template_directory() . '/framework/current/template-tags.php');
?>