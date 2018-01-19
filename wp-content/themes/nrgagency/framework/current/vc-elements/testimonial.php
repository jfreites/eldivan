<?php

class WPBakeryShortCode_Boxed_Testimonial extends WPBakeryShortCode {
    protected function content( $atts, $content = null){
        extract( shortcode_atts( array(
            "image"     => "",
            "quote"     => "",
            "author"    => "John Doe",
            "company"   => "",
            "link"      => "",
            "extra_class" => ""
        ), $atts ) );

        $thumb = $image != '' ? wp_get_attachment_image($image, 'full', false, array('class'=>'testim-pic')) : '';

        $quote = $quote != '' ? "$quote" : '';
        $company = $company != '' ? ", <span>$company</span>" : '';

        $classes = $image != '' ? 'with-thumb' : '';
        $classes .= ' '.$extra_class;

        $author = $link != '' ? "<a href='$link'>$author</a>" : $author;
        $result = "<div class='swiper-slide'>
                    <div class='words $classes'>
                        <p class='im-center'>
                            <img src='".get_template_directory_uri()."/img/semicolon.jpg' alt='Semicolon'/>
                        </p>
                        <p class='im-center'>
                            $thumb
                        </p>
                        <p class='t-describe'>$quote</p>
                        <p class='t-author'>$author$company.</p>
                    </div>
                </div>";

        return $result;
    }
}

vc_map( array(
    "name" => __("Boxed Testimonial", 'nrgagency'),
    "description" => __("For Quote, Blockquote & User Feedback", 'nrgagency'),
    "base" => 'boxed_testimonial',
    "class" => "",
    "icon" => "tt-icon testimonial",
    "category" => __('Themeton', 'nrgagency'),
    "as_child" => array("only" => "boxed_testimonial_container"),
    "show_settings_on_create" => true,
    "params" => array(
        array(
            'type' => 'attach_image',
            "param_name" => "image",
            "heading" => __("Image", 'nrgagency'),
            "value" => ''
        ),
        array(
            'type' => 'textarea',
            "param_name" => "quote",
            "heading" => __("Quote", 'nrgagency'),
            "value" => ''
        ),
        array(
            'type' => 'textfield',
            "param_name" => "author",
            "heading" => __("Author", 'nrgagency'),
            "value" => '',
            "holder" => 'div'
        ),
        array(
            'type' => 'textfield',
            "param_name" => "company",
            "heading" => __("Company", 'nrgagency'),
            "value" => ''
        ),
        array(
            'type' => 'textfield',
            "param_name" => "Link",
            "heading" => __("Link", 'nrgagency'),
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
) );