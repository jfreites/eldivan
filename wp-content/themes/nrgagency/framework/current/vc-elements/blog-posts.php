<?php

class WPBakeryShortCode_Tt_Blog_Posts extends WPBakeryShortCode {
    protected function content( $atts, $content = null){
        extract(shortcode_atts(array(
            'count' => '2',
            'categories' => '',
            'extra_class' => ''
        ), $atts));

        $cats = array();
        if( !empty($categories) ){
            $exps = explode(",", $categories);
            foreach($exps as $val){
                if( (int)$val>-1 ){
                    $cats[]=(int)$val;
                }
            }
        }

        $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $count,
                        'ignore_sticky_posts' => true
                    );
        if(!empty($cats)){
            $args['category__in'] = $cats;
        }

        $items = '';
        $posts_query = new WP_Query($args);
        while ( $posts_query->have_posts() ) {
            $posts_query->the_post();

            $excerpt = wp_trim_words( wp_strip_all_tags(strip_shortcodes(get_the_content())), 10 );

            $img = '';
            if( has_post_thumbnail() ){
                $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'nrgagency-blog-thumb' );
                $img = !empty($img) ? $img[0] : '';
            }

            $postclass = implode(' ',get_post_class());
            $items .= "<div class='col-md-4 col-sm-4 post $postclass $extra_class'>
    <a href='".get_permalink()."'>".get_the_post_thumbnail( get_the_ID(), 'nrgagency-blog-thumb')."</a>
    <h5><a href='". get_permalink()."'>".get_the_title()."</a></h5>
    <p><i class='fa fa-user'></i> ".get_the_author()."  <i class='fa fa-calendar-o'></i> ". get_the_time('F d / Y')."</p>
    <a class='read-more red-blog' href='". get_permalink()."'>".__('Read more', 'nrgagency')."<i class='fa fa-long-arrow-right'></i></a>
</div>";
}

        // reset query
        wp_reset_postdata();
       
        return "<div class='tt-blog-element $extra_class'>
                    $items
                </div>";
    }
}

vc_map( array(
    "name" => __('Blog Posts', 'nrgagency'),
    "description" => __("Only post type: post", 'nrgagency'),
    "base" => 'tt_blog_posts',
    "icon" => "tt-icon blog",
    "content_element" => true,
    "category" => __('Themeton', 'nrgagency'),
    'params' => array(
        array(
            "type" => 'textfield',
            "param_name" => "count",
            "heading" => __("Posts Count", 'nrgagency'),
            "value" => '2'
        ),
        array(
            "type" => 'textfield',
            "param_name" => "categories",
            "heading" => __("Categories", 'nrgagency'),
            "description" => __("Specify category Id or leave blank to display items from all categories.", 'nrgagency'),
            "value" => ''
        ),
        array(
            "type" => "textfield",
            "param_name" => "extra_class",
            "heading" => __("Extra Class", 'nrgagency'),
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nrgagency'),
        )
    )
));