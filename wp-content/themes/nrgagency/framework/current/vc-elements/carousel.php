<?php

class WPBakeryShortCode_Image_Carousel extends WPBakeryShortCode {
    protected function content( $atts, $content = null){
        extract( shortcode_atts( array(
           'categories' => '',
            'title' => 'Latest works',
            'count' => '5',
            "extra_class" => ""
        ), $atts ) );

        $cats = array();
        if( !empty($categories) ){
            $exps = explode(",", $categories);
            foreach($exps as $val){
                if( (int)$val>-1 ){
                    $cats[]=(int)$val;
                }
            }
        }


        // build query
        $args = array(
                        'post_type' => 'portfolio',
                        'posts_per_page' => $count,
                        'ignore_sticky_posts' => true
                    );
        if(!empty($cats)){
            $args['tax_query'] = array(
                                    'relation' => 'IN',
                                    array(
                                        'taxonomy' => 'portfolio_entries',
                                        'field' => 'id',
                                        'terms' => $cats
                                    )
                                );
        }

        
        $filter_html = '';
        $cat_array = array();
        $items = '';
        $encoded_args = urlencode(serialize($args));
        $img = '';

        $posts_query = new WP_Query($args);
        while ( $posts_query->have_posts() ) {
            $posts_query->the_post();
            
            if( has_post_thumbnail() ){
                $img = wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'nrgagency-project-img' );
            }


            $cats = '';
            $cat_titles = array();
            $terms = wp_get_post_terms(get_the_ID(), 'portfolio_entries');
            foreach ($terms as $term){
                $cat_title = $term->name;
                $cat_slug = $term->slug;

                $cat_titles []= $cat_title;
                if( !in_array($term->term_id, $cat_array) ){
                    
                    $cat_array[] = $term->term_id;
                }

                $cats .= "ftr-$cat_slug ";
            }

            $items .= "<div class='swiper-slide'>
            <a class='work-img $cats' href='".get_permalink()."' data-category='$cats'>
                            $img
                        </a></div>";
            
        }
        // reset query
        wp_reset_postdata();



        return "<div class='lates-work swiper-container tt-carousel-image-gallery $extra_class' data-mode='horizontal' data-slides-per-view='responsive' data-xs-slides='1' data-sm-slides='1' data-md-slides='1' data-lg-slides='1' data-loop='0'>
                    <div class='swiper-wrapper'>
                       $items
                    </div>
                    <div class='pagination swiper-pagination'></div> 
                   
                        <div class='arrow arrow-left'><i class='fa fa-long-arrow-left'></i></div>
                        <div class='arrow arrow-right'><i class='fa fa-long-arrow-right'></i></div>
                      
                </div>";
    }
}

vc_map( array(
    "name" => esc_html__("Image Carousel", 'nrgagency'),
    "description" => esc_html__("Images in Carousel", 'nrgagency'),
    "base" => 'image_carousel',
    "class" => "",
    "icon" => "tt-icon image-carousel-item",
    "category" => esc_html__('Themeton', 'nrgagency'),
    "show_settings_on_create" => true,
    "params" => array(
         array(
            "type" => 'textfield',
            "param_name" => "title",
            "heading" => __("Title", 'nrgagency'),
            "value" => 'Latest works',
            "holder" => 'div'
        ),
          array(
            "type" => 'textfield',
            "param_name" => "count",
            "heading" => __("Count (posts per page)", 'nrgagency'),
            "value" => '8'
        ),
         array(
            "type" => 'textfield',
            "param_name" => "categories",
            "heading" => __("Categories", 'nrgagency'),
            "description" => __("Specify category ID (multiple IDs with comma) or leave blank to display items from all categories.", 'nrgagency'),
            "value" => ''
        ),
        array(
            "type" => "textfield",
            "param_name" => "extra_class",
            "heading" => esc_html__("Extra Class", 'nrgagency'),
            "value" => "",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nrgagency'),
        )
    )
) );

