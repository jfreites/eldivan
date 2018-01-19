<?php

class WPBakeryShortCode_Template_Box extends WPBakeryShortCode {
    protected function content( $atts, $content = null){
        extract(shortcode_atts(array(
            'name' => '',
            'image' => '',
            'border_color' => '',
            'button_text' => '',
            'link' => '#'
        ), $atts));

        $image = $image != '' ? wp_get_attachment_image($image, 'large') : '';

        $result = "<div class='template-box'>
                        <div class='img-box' style='border-color: $border_color;'>
                            <div class='template-link'>
                                <a class='read-more' href='$link'>$button_text <i class='fa fa-long-arrow-right'></i></a>
                            </div>
                            $image
                        </div>
                        <p>$name</p>
        </div>";

        return $result;
    }
}

vc_map( array(
    "name" => __('Template Box', 'nrgagency'),
    "description" => __("Template Box", 'nrgagency'),
    "base" => 'template_box',
    "icon" => "tt-icon template-box",
    "content_element" => true,
    "category" => __('Themeton', 'nrgagency'),
    'params' => array(
        array(
            "type" => 'textfield',
            "param_name" => "name",
            "heading" => __("Name", 'nrgagency'),
            "value" => '',
            "holder" => 'div'
        ),
        array(
            "type" => 'attach_image',
            "param_name" => "image",
            "heading" => __("Image", 'nrgagency'),
            "value" => ''
        ),
        array(
            "type" => 'colorpicker',
            "param_name" => "border_color",
            "heading" => __("Border Color", 'nrgagency'),
            "value" => ''
        ),
        array(
            "type" => 'textfield',
            "param_name" => "button_text",
            "heading" => __("Button Text", 'nrgagency'),
            "value" => ''
        ),
        array(
            "type" => 'textfield',
            "param_name" => "link",
            "heading" => __("Button link", 'nrgagency'),
            "value" => ''
        )
    )
));