<?php
/**
 * You can extend it with new icons. 
 * Please see the icon list from here, http://fortawesome.github.io/Font-Awesome/cheatsheet/
 * And extend following array with name and hex code.
 */
global $tt_social_icons;
$tt_social_icons = array(
    "facebook" => "facebook",
    "twitter" => "twitter",
    "pinterest" => "pinterest",
    "instagram" => "instagram",
    "googleplus" => "google-plus",
    "dribbble" => "dribbble",
    "skype" => "skype",
    "wordpress" => "wordpress",
    "vimeo" => "vimeo-square",
    "flickr" => "flickr",
    "linkedin" => "linkedin",
    "youtube" => "youtube",
    "tumblr" => "tumblr",
    "link" => "link",
    "stumbleupon" => "stumbleupon",
    "delicious" => "delicious",
);


add_action('admin_enqueue_scripts', 'admin_common_render_scripts');
function admin_common_render_scripts() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style('themeton-admin-common-style', tt_file_require(get_template_directory_uri().'/framework/admin-assets/common.css', true) );

    wp_enqueue_script('jquery');
    wp_enqueue_script('wp-color-picker');
    
    wp_enqueue_script('themeton-admin-common-js', tt_file_require(get_template_directory_uri().'/framework/admin-assets/common.js', true), false, false, true);
}



function add_video_radio($embed) {
    if (strstr($embed, 'http://www.youtube.com/embed/')) {
        return str_replace('?fs=1', '?fs=1&rel=0', $embed);
    } else {
        return $embed;
    }
}

add_filter('oembed_result', 'add_video_radio', 1, true);

if (!function_exists('custom_upload_mimes')) {
    add_filter('upload_mimes', 'custom_upload_mimes');

    function custom_upload_mimes($existing_mimes = array()) {
        $existing_mimes['ico'] = "image/x-icon";
        return $existing_mimes;
    }

}


if (!function_exists('format_class')) {

    // Returns post format class by string
    function format_class($post_id) {
        $format = get_post_format($post_id);
        if ($format === false)
            $format = 'standard';
        return 'format_' . $format;
    }
}


/**
 * Comment Count Number
 * @return html 
 */
function comment_count_text() {
    $comment_count = get_comments_number('0', '1', '%');
    $comment_text = $comment_count . ' ' . __('Comments', 'nrgagency');
    if( (int)$comment_count == 1 ){
        $comment_text = $comment_count . ' ' . __('Comment', 'nrgagency');
    }
    else if( (int)$comment_count < 1 ){
        $comment_text = __('No Comment', 'nrgagency');
    }
    return "<a href='" . get_comments_link() . "' title='" . $comment_text . "'> " . $comment_text . "</a>";
}

function comment_count() {
    $comment_count = get_comments_number('0', '1', '%');
    $comment_trans = '<i class="fa fa-comment"></i> ' . $comment_count;
    return "<a href='" . get_comments_link() . "' title='" . $comment_trans . "'> " . $comment_trans . "</a>";
}

/**
 * Returns Author link
 * @return html
 */
function get_author_posts_link() {
    $output = '';
    ob_start();
    the_author_posts_link();
    $output .= ob_get_contents();
    ob_end_clean();
    return $output;
}






/**
 * This code filters the Categories archive widget to include the post count inside the link
 */
add_filter('wp_list_categories', 'cat_count_span');

function cat_count_span($links) {
    $links = str_replace('</a> (', ' <span>', $links);
    $links = str_replace('<span class="count">(', '<span>', $links);
    $links = str_replace(')', '</span></a>', $links);
    return $links;
}

/**
 * This code filters the Archive widget to include the post count inside the link
 */
add_filter('get_archives_link', 'archive_count_span');

function archive_count_span($links) {
    $links = str_replace('</a>&nbsp;(', ' <span>', $links);
    $links = str_replace(')</li>', '</span></a></li>', $links);
    return $links;
}



if (!function_exists('tt_comment_form')) :

    function tt_comment_form($fields) {
        global $id, $post_id;
        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();

        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields = array(
            'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name', 'nrgagency') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<input placeholder="' . __('Name', 'nrgagency') . '" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
            'email' => '<p class="comment-form-email"><label for="email">' . __('Email', 'nrgagency') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<input placeholder="' . __('Email', 'nrgagency') . '" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
            'url' => '<p class="comment-form-url"><label for="url">' . __('Website', 'nrgagency') . '</label>' .
            '<input placeholder="' . __('Website', 'nrgagency') . '" id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
        );
        return $fields;
    }
    add_filter('comment_form_default_fields', 'tt_comment_form');
endif;



if (!function_exists('about_author')) {
    
    function about_author() {
        ?>
        <div class="item-author clearfix">
            <?php
            $author_email = get_the_author_meta('email');
            echo get_avatar($author_email, $size = '60');
            ?>
            <h3><?php _e('Written by ', 'nrgagency'); ?><?php if (is_author()) the_author(); else the_author_posts_link(); ?></h3>
            <div class="author-title-line"></div>
            <p>
                <?php
                $description = get_the_author_meta('description');
                if ($description != '')
                    print($description);
                else
                    _e('The author didnt add any Information to his profile yet', 'nrgagency');
                ?>
            </p>
        </div>
        <?php
    }

}

if (!function_exists('social_share')) {

    /**
     * Prints Social Share Options
     * @global array $tt_social_icons
     * @global type $post : Current post
     */
    function social_share() {
        global $tt_social_icons, $post;
        
        echo '<span class="sf_text">' . __('Share', 'nrgagency') . ': </span>';
        echo '<ul class="post_share list-inline">';
        if( TT::get_mod('share_facebook')=='1' ) {
            echo '<li><a href="https://www.facebook.com/sharer/sharer.php?u=' . get_permalink() . '" title="Facebook" target="_blank"><i class="fa ' . $tt_social_icons['facebook'] . '"></i></a></li>';
        }
        if( TT::get_mod('share_twitter')=='1' ) {
            echo '<li><a href="https://twitter.com/share?url=' . get_permalink() . '" title="Twitter" target="_blank"><i class="fa ' . $tt_social_icons['twitter'] . '"></i></a></li>';
        }
        if( TT::get_mod('share_instagram')=='1' ) {
            echo '<li><a href="https://instagram.com/share?url=' . get_permalink() . '" title="Instagram" target="_blank"><i class="fa ' . $tt_social_icons['instagram'] . '"></i></a></li>';
        }
        if( TT::get_mod('share_google_plus')=='1' ) {
            echo '<li><a href="https://plus.google.com/share?url='.get_permalink().'" title="GooglePlus" target="_blank"><i class="fa ' . $tt_social_icons['googleplus'] . '"></i></a></li>';
        }
        if( TT::get_mod('share_pinterest')=='1' ) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
            echo '<li><a href="//pinterest.com/pin/create/button/?url=' . get_permalink() . '&media=' . $image[0] . '&description=' . get_the_title() . '" title="Pinterest" target="_blank"><i class="fa ' . $tt_social_icons['pinterest'] . '"></i></a></li>';
        }
        if( TT::get_mod('share_email')=='1' ) {
            echo '<li><a href="mailto:?subject=' . strip_tags(get_the_title()) . '&body=' . strip_tags(get_the_excerpt()) . get_permalink() . '" title="Email" target="_blank"><i class="fa ' . $tt_social_icons['email'] . '"></i></a></li>';
        }
        echo '</ul>';

    }

}




// ADDING ADMIN BAR MENU
if (!function_exists('tt_admin_bar_menu')) {
    add_action('admin_bar_menu', 'tt_admin_bar_menu', 90);

    function tt_admin_bar_menu() {

        if (!current_user_can('manage_options'))
            return;

        global $wp_admin_bar;

        $admin_url = admin_url('admin.php');
        
        $customizer = array(
            'id' => 'customizer-options',
            'title' => __('Site Customize', 'nrgagency'),
            'href' => admin_url() . "customize.php",
        );
        $wp_admin_bar->add_menu($customizer);

        $customizer = array(
            'id' => 'demo-data-importer',
            'title' => __('Import Demo', 'nrgagency'),
            'href' => admin_url() . "themes.php?page=themeton-demo-importer",
        );
        $wp_admin_bar->add_menu($customizer);
    }

}


/**
 * Prints Custom Logo Image for Login Page
 */
function custom_login_logo() {
    $logo = TT::get_mod('logo_admin');
    if (!empty($logo)) {
        $logo = str_replace('[site_url]', site_url(), $logo);
        echo '<style type="text/css">.login h1 a { background: url(' . $logo . ') center center no-repeat !important;width: auto !important;}</style>';
    }
}

add_action('login_head', 'custom_login_logo');


/*
 * Random order
 * Preventing duplication of post on paged
 */

function register_tt_session(){
    if( !session_id() ){
        session_start();
    }
}

if(!is_admin() && true) {

    function edit_posts_orderby($orderby_statement) {

        add_action('init', 'register_tt_session');
        //add_filter('posts_orderby', 'edit_posts_orderby');

        if (isset($_SESSION['expiretime'])) {
            if ($_SESSION['expiretime'] < time()) {
                session_unset();
            }
        } else {
            $_SESSION['expiretime'] = time() + 300;
        }

        $seed = rand();
        if (isset($_SESSION['seed'])) {
            $seed = $_SESSION['seed'];
        } else {
            $_SESSION['seed'] = $seed;
        }
        $orderby_statement = 'RAND(' . $seed . ')';
        return $orderby_statement;
    }
}







/*
    Post Like Event
    =================================
*/
add_action('wp_ajax_blox_post_like', 'blox_post_like_hook');
add_action('wp_ajax_nopriv_blox_post_like', 'blox_post_like_hook');
function blox_post_like_hook() {
    try {
        $post_id = (int)$_POST['post_id'];
        $count = (int)TT::getmeta('post_like', $post_id);
        if( $post_id>0 ){
            TT::setmeta($post_id, 'post_like', $count+1);
        }
        echo "1";
    } catch (Exception $e) {
        echo "-1";
    }
    exit;
}

function blox_post_liked($post_id){
    $cookie_id = '';
    if( isset($_COOKIE['liked']) ){
        $cookie_id = $_COOKIE['liked'];
        $ids = explode(',', $cookie_id);
        foreach ($ids as $value) {
            if( $value+'' == $post_id+'' ){
                return 'liked';
            }
        }
    }
    return '';
}


function get_post_like($post_id){
    return '<a href="javascript:;" data-pid="'. $post_id .'" class="'. blox_post_liked($post_id) .'"><i class="fa fa-heart"></i> <span>'. (int)TT::getmeta('post_like', $post_id) .'</span></a>';
}