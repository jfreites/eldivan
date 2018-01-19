<?php

class TPL{

    public static function post_thumbnail(){
        global $post;
        if ( post_password_required() ){
            return;
        }

        $media = TPL::get_post_media();
        if( !empty($media) )
            echo "<div class='card-image'>$media</div>";
    }


    public static function get_post_thumb(){
        global $post;

        $result = '';
        if( has_post_thumbnail() ){
            $img = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
            $result = '<div class="post_thumbnail_row row m0">
                            <a href="'.esc_url(get_permalink()).'">
                                <img src="'.esc_attr($img).'" alt="" class="post_thumbnail">
                                <div class="post_thumbnail_bg"></div>
                                '.TPL::get_post_icon().'
                            </a>
                        </div>';
        }

        return $result;
    }


    public static function get_post_media(){
        global $post;
        $media = '';
        if( has_post_thumbnail() ){
            $media = '<a class="post-thumbnail" href="'.get_permalink().'" aria-hidden="true">'. get_the_post_thumbnail() .'</a>';
        }

        $format = get_post_format();
        if ( current_theme_supports( 'post-formats', $format ) ) {
            if( $format=='quote' ){
                preg_match("/<blockquote>(.)*<\/blockquote>/msi", get_the_content(), $matches);
                if( isset($matches[0]) && !empty($matches[0]) ){
                    $media = $matches[0];
                    if( has_post_thumbnail() ){
                        $img = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'featured-img' );
                        $media = str_replace("<blockquote", "<blockquote style='background-image:url($img);'", $media);
                    }
                }
            }
            else if( $format=='gallery' && has_shortcode($post->post_content, 'gallery') ){
                $gallery = get_post_gallery( get_the_ID(), false );
                $ids = explode(",", isset($gallery['ids']) ? $gallery['ids'] : "");

                $gallery_id = uniqid();
                $gallery = '';
                $indicators = '';
                $indx = 0;
                foreach ($ids as $gid) {
                    $img = wp_get_attachment_image( $gid, 'featured-img' );
                    $gallery .= "<li>$img</li>";
                    $indx++;
                }

                $media = !empty($gallery) ? "<div class='slider'>
                                                <ul class='slides'>$gallery</ul>
                                            </div>" : $media;

                $media = $media;
            }
            else if( $format=='audio' ){
                $pattern = get_shortcode_regex();
                preg_match('/'.$pattern.'/s', $post->post_content, $matches);
                if (is_array($matches) && isset($matches[2]) && $matches[2] == 'audio') {
                    $shortcode = $matches[0];
                    $media = '<div class="mejs-wrapper audio">'. do_shortcode($shortcode) . '</div>';
                }
                else{
                    preg_match("/<iframe(.)*<\/iframe>/msi", get_the_content(), $matches);
                    if( isset($matches[0]) && !empty($matches[0]) )
                        $media = $matches[0];
                }
                $media = $media;
            }
            else if( $format=='video' ){
                $pattern = get_shortcode_regex();
                preg_match('/'.$pattern.'/s', $post->post_content, $matches);
                if (is_array($matches) && isset($matches[2]) && $matches[2] == 'video') {
                    $shortcode = $matches[0];
                    $media = '<div class="mejs-wrapper video">'. do_shortcode($shortcode) . '</div>';
                    $media = "<div class='entry-media'>$media</div>";
                }
                else{
                    preg_match("/<iframe(.)*<\/iframe>/msi", get_the_content(), $matches);
                    if( isset($matches[0]) && !empty($matches[0]) ){
                        $media = $matches[0];
                        $media = "<div class='video-container'>$media</div>";
                    }
                }
            }
        }

        return $media;
    }


    public static function get_author(){
        return '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a>';
    }

     
    public static function pagination( $query=null ) {
         
        global $wp_query;
        $query = $query ? $query : $wp_query;
        $big = 999999999;

        $paginate = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'type' => 'array',
            'total' => $query->max_num_pages,
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'prev_text' => '<i class="fa fa-angle-left"></i>',
            'next_text' => '<i class="fa fa-angle-right"></i>',
            )
        );

        if ($query->max_num_pages > 1) :
        echo '<ul class="pagination">';
            echo '<li>' . __('Pages', 'nrgagency') . '</li>';
        foreach ( $paginate as $page ) {
            echo '<li>' . $page . '</li>';
        }
        echo '</ul>';
        endif;
        
    }



    public static function get_next_post(){
        $next_post = get_next_post();
        if ( is_a( $next_post , 'WP_Post' ) ) {
            return '<a href="'.esc_url(get_permalink( $next_post->ID )).'">'.get_the_title( $next_post->ID ).' <i class="fa fa-arrow-circle-o-right"></i></a>';
        }
        return '';
    }
    public static function get_prev_post(){
        $prev_post = get_previous_post();
        if ( is_a( $prev_post , 'WP_Post' ) ) {
            return '<a href="'.esc_url(get_permalink( $prev_post->ID )).'"><i class="fa fa-arrow-circle-o-left"></i> '.get_the_title( $prev_post->ID ).'</a>';
        }
        return '';
    }




    public static function get_related_posts( $options=array() ){
        $options = array_merge(array(
                    'per_page'=>'3'
                    ),
                    $options);

        global $post;

        $args = array(
            'post__not_in' => array($post->ID),
            'posts_per_page' => $options['per_page']
        );
        $post_type_class = 'blog';

        $categories = get_the_category($post->ID);
        if ($categories) {
            $category_ids = array();
            foreach ($categories as $individual_category) {
                $category_ids[] = $individual_category->term_id;
            }
            $args['category__in'] = $category_ids;
        }

        // For portfolio post and another than Post
        if($post->post_type == 'portfolio') {
            $tax_name = 'portfolio_entries'; //should change it to dynamic and for any custom post types
            $args['post_type'] =  get_post_type(get_the_ID());
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $tax_name,
                    'field' => 'id',
                    'terms' => wp_get_post_terms($post->ID, $tax_name, array('fields'=>'ids'))
                )
            );
            $post_type_class = 'portfolio';
        }

        if(isset($args)) {
            $my_query = new wp_query($args);
            if ($my_query->have_posts()) {

                $html = '';
                while ($my_query->have_posts()) {
                    $my_query->the_post();

                    $img = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'small-thumb' );
                    if( !empty($img) ){
                        $img = '<div class="row m0">
                                    <a href="'. esc_url(get_permalink()) .'"><img src="'.esc_attr($img).'" alt="" class="img-responsive"></a>
                                </div>';
                    }

                    $html .= '<div class="col-sm-12 col-md-4 youMightLikeBlog">
                                    '. $img .'
                                    <div class="row m0">
                                        <a href="'. esc_url(get_permalink()) .'"><h6>'.get_the_title().'</h6></a>
                                        <div class="row m0 meta">'. get_the_date() .'</div>
                                    </div>
                                </div>';
                }


                if($post->post_type == 'portfolio'){
                    echo '<div class="row m0 youMightLike '.$post_type_class.'">
                            <div class="row sectionTitle">
                                <h4>' . __('Related Projects', 'nrgagency') . '</h4>
                            </div>
                            <div class="row">
                                '. $html .'
                            </div>
                          </div>';
                }
                else{
                    echo '<div class="row m0 youMightLike '.$post_type_class.'">
                            <h4>' . __('You might also like', 'nrgagency') . '</h4>
                            <div class="row">
                                '. $html .'
                            </div>
                          </div>';
                }
                
            }
        }
        wp_reset_postdata();
    }



    public static function get_post_icon(){
        global $post;
        $class = '';
        $format = get_post_format();
        if( $format===false ){
            $class = 'fa fa-file-text';
        }
        else if( $format=='aside' ){
            $class = 'fa fa-file-text';
        }
        else if( $format=='image' ){
            $class = 'fa fa-file-image-o';
        }
        else if( $format=='gallery' ){
            $class = 'fa fa-file-image-o';
        }
        else if( $format=='video' ){
            $class = 'fa fa-file-video-o';
        }
        else if( $format=='audio' ){
            $class = 'fa fa-file-audio-o';
        }
        else if( $format=='quote' ){
            $class = 'fa fa-comment';
        }
        else if( $format=='link' ){
            $class = 'fa fa-link';
        }
        else if( $format=='status' ){
            $class = 'fa fa-link';
        }
        else if( $format=='chat' ){
            $class = 'fa fa-comments';
        }
        return "<i class='$class'></i>";
    }


    public static function getCategories($post_id, $post_type){
        $cats = array();
        $taxonomies = get_object_taxonomies($post_type);
        if( !empty($taxonomies) ){
            $tax = $taxonomies[0];
            if( $post_type=='product' )
                $tax = 'product_cat';
            $terms = wp_get_post_terms($post_id, $tax);
            foreach ($terms as $term){
                $cats[] = array(
                                'term_id' => $term->term_id,
                                'name' => $term->name,
                                'slug' => $term->slug,
                                'link' => get_term_link($term)
                                );
            }
        }

        return $cats;
    }

    public static function getPostViews($postID){
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count=='' || $count=='0'){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0 View";
        }
        return $count.' Views';
    }
    public static function setPostViews($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

}



add_action('wp_head', 'print_search_template');
function print_search_template(){
?>
<!--Template: Header Search-->
<script type="text/template" id="tpl-header-search">
<div class="search-template">
    <div class="inner-table">
        <div class="inner-row">
            <div class="container">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <div class="input-group">
                        <input type="search" class="search-field" placeholder="<?php _e('Type and hit Enter ...', 'nrgagency'); ?>" value="" name="s" autocomplete="off">
                        <input type="submit" class="search-submit" value="<?php _e('Go', 'nrgagency'); ?>">
                        <input type="hidden" name="lang" value="<?php echo defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : ''; ?>"/>
                        <a href="javascript:;" class="close-search"><i class="icon_close"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</script>
<?php
}




function getPageSlider($onTop){
    global $post;
    $slider_class = 'fullscreen-section no-padding';

    if (TT::getmeta('slider') != '' && TT::getmeta('slider') != 'none'):
        echo '<div id="tt-slider" class="tt-slider '.$slider_class.'">';
            $slider_name = TT::getmeta("slider");
            $slider = explode("_", $slider_name);
            $shortcode = '';
            if (strpos($slider_name, "layerslider") !== false)
                $shortcode = "[" . $slider[0] . " id='" . $slider[1] . "']";
            elseif (strpos($slider_name, "revslider") !== false)
                $shortcode = "[rev_slider " . $slider[1] . "]";
            elseif (strpos($slider_name, "masterslider") !== false)
                $shortcode = "[master_slider id='" . $slider[1] . "']";
            echo do_shortcode($shortcode);
        echo '</div>';
    endif;
}






function portfolio_entry_media(){
    global $post;
    $video = TT::getmeta('portfolio_video_mp4');
    $video_webm = TT::getmeta('portfolio_video_webm');
    $galleries = TT::getmeta('portfolio_gallery');


    if( !empty($video) ):
        if( preg_match("/.mp4/", $video) || preg_match("/.m4v/", $video) ):
            $media = "[video mp4='$video' webm='$video_webm'][/video]";
            $media = '<div class="mejs-wrapper video">'.do_shortcode($media).'</div>';
            return "<div class='entry-media'>$media</div><br>";
        else:
            $media = wp_oembed_get($video);
            return "<div class='entry-media embed-responsive embed-responsive-16by9'>$media</div><br>";
        endif;
    elseif( !empty($galleries) ):
        $ids = explode(",", $galleries);

        $gallery_id = 'carousel-'.uniqid();
        $gallery = '';
        $indicators = '';
        $indx = 0;
        foreach ($ids as $gid) {
            $img = wp_get_attachment_image( $gid, 'featured-img' );
            $gallery .= "<div class='item".($indx==0 ? ' active' : '')."'>$img</div>";
            $indicators .= "<li data-target='#$gallery_id' data-slide-to='$indx' class='".($indx==0 ? ' active' : '')."'></li>";
            $indx++;
        }

        $media =  "<div id='$gallery_id' class='carousel slide' data-ride='carousel'>
                    <ol class='carousel-indicators'>$indicators</ol>
                    <div class='carousel-inner' role='listbox'>$gallery</div>
                    <a class='left carousel-control' href='#$gallery_id' role='button' data-slide='prev'>
                        <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
                        <span class='sr-only'>Previous</span>
                    </a>
                    <a class='right carousel-control' href='#$gallery_id' role='button' data-slide='next'>
                        <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span>
                        <span class='sr-only'>Next</span>
                    </a>
                </div>";

        return "<div class='entry-media'>$media</div><br>";
    elseif( has_post_thumbnail() ):
        $media = '<a class="post-thumbnail" href="'.get_permalink().'" aria-hidden="true">
                    '. get_the_post_thumbnail() .'
                </a>';
        return "<div class='entry-media'>$media</div><br>";
    endif;

    return "";
}



function get_post_comment_count(){
    global $post;
    $comments = '';
    $comment_obj = wp_count_comments($post->ID);
    $comments = $comment_obj->total_comments;
    if( $comments==0 )
        $comments = __('No Comments', 'nrgagency');
    elseif( $comments==1 )
        $comments = __('1 Comment', 'nrgagency');
    else
        $comments = $comments.__(' Comments', 'nrgagency');

    return $comments;
}





// Comment Navigation
if ( ! function_exists( 'themeton_comment_nav' ) ) :
    function themeton_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
        ?>
        <nav class="navigation comment-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php _e('Comment navigation', 'nrgagency'); ?></h2>
            <div class="nav-links">
                <?php
                    if ( $prev_link = get_previous_comments_link( __('Older Comments', 'nrgagency') ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( __('Newer Comments', 'nrgagency') ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .comment-navigation -->
        <?php
        endif;
    }
endif;




function alter_comment_form_fields($fields){
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields['author'] = '<div class="input-group">
                            <span class="input-group-addon icon_profile"></span>
                            <input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" tabindex="1" class="form-control" placeholder="Name *" ' . $aria_req . '/>
                        </div>';

    $fields['email'] = '<div class="input-group">
                            <span class="input-group-addon icon_mail_alt"></span>
                            <input type="text" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" tabindex="2" class="form-control"  placeholder="Email *"/>
                        </div>';
    $fields['url'] = '<div class="input-group clearfix">
                            <span class="input-group-addon icon_globe-2"></span>
                            <input type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" tabindex="3" class="form-control"  placeholder="Website"/>
                        </div>';

    return $fields;
}

add_filter('comment_form_default_fields', 'alter_comment_form_fields');






function get_tags_list(){
    global $post;
    $tags_list = get_the_tag_list( '', _x( ' ', 'Used between list items, there is a space after the comma.', 'nrgagency' ) );
    if ( $tags_list ) {
        printf( '<div class="tag-links text-right"><span class="sf_text hidden-xxs">%1$s: </span>%2$s</div>',
            _x( 'Tags', 'Used before tag names.', 'nrgagency' ),
            $tags_list
        );
    }
}



function get_share_links(){
    global $post;
    echo '<span class="sf_text hidden-xxs">'. __('Share on:', 'nrgagency') .' </span>';
    echo get_social_links();
}

function get_social_links(){
    global $post;
    $social = array();

    $social[] = '<a href="http://www.facebook.com/sharer.php?u='.esc_url(get_permalink()).'" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>';
    $social[] = '<a href="https://twitter.com/share?url='.esc_url(get_permalink()).'&text='.esc_attr(get_the_title()).'" target="_blank"><i class="fa fa-twitter"></i></a>';
    $social[] = '<a href="https://plus.google.com/share?url='.esc_url(get_permalink()).'" target="_blank"><i class="fa fa-google-plus"></i></a>';
    $social[] = '<a href="https://pinterest.com/pin/create/bookmarklet/?media='.esc_url(isset($thumb[0]) ? $thumb[0] : '').'&url='.esc_url(get_permalink()).'&description='.esc_attr(get_the_title()).'" target="_blank"><i class="fa fa-pinterest"></i></a>';
    $social[] = '<a href="#" onclick="window.print();return false;"><i class="fa fa-print"></i></a>'; 

    return $social;
}








function improved_trim_excerpt($text) {
    global $post;
    if ( '' == $text ) {
        $text = get_the_content('');
        $text = apply_filters('the_content', $text);
        $text = str_replace('\]\]\>', ']]&gt;', $text);
        $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
        $text = strip_tags($text, '<p>');
        $excerpt_length = 80;
        $words = explode(' ', $text, $excerpt_length + 1);
        if (count($words)> $excerpt_length) {
            array_pop($words);
            array_push($words, '[...]');
            $text = implode(' ', $words);
        }
    }
    return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');








function themeton_custom_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }

    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <<?php echo esc_attr($tag); ?> class="post pingback">
        <p><?php _e('Pingback:', 'nrgagency'); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('Edit', 'nrgagency'), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
            break;
        default:
    ?>

    <<?php echo esc_attr($tag) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">

    <div class="comment-box">
        <div class="col-md-2 col-xs-4">
            <?php echo get_avatar( $comment, 80 ); ?>
        </div>
        <div class="col-md-10 col-xs-8">
            <div class="vcard author post-author">
                <h5 class="comment-user-name"><?php the_author();?></h5>
                <?php printf( __('%1$s at %2$s', 'nrgagency'), get_comment_date(),  get_comment_time() ); ?>
            </div>
            <p class="comments-desc">
                <?php comment_text(); ?>
                <?php edit_comment_link( __('Edit', 'nrgagency'), '  ', '' ); ?>           
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </p>
        </div>
    </div>
<?php
        break;
    endswitch;
}

