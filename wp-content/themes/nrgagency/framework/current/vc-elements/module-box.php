<?php

class WPBakeryShortCode_Module_Box extends WPBakeryShortCode {
    protected function content( $atts, $content = null){
        extract(shortcode_atts(array(
            'title' => '',
            "icon_type" => 'icon',
            'icon' => '',
            'image' => ''
        ), $atts));

        $image = $image != '' ? wp_get_attachment_image($image, 'large') : '';

        if( $icon_type == 'icon_font' ) {
            $img = "<i class='".$icon."'></i>";
        }else {
            $img = $image;
        }

        $content = wpb_js_remove_wpautop( $content, true );

        $result = "<div class='module'>
                        $img
                        <div class='content'>
                            <h3>$title</h3>
                            $content
                        </div>
                    </div>";

        return $result;
    }
}

vc_map( array(
    "name" => __('Module Box', 'nrgagency'),
    "description" => __("Module Box", 'nrgagency'),
    "base" => 'module_box',
    "icon" => "tt-icon module-box",
    "content_element" => true,
    "category" => __('Themeton', 'nrgagency'),
    'params' => array(
        array(
            "type" => 'textfield',
            "param_name" => "title",
            "heading" => __("Title", 'nrgagency'),
            "value" => '',
            "holder" => 'div'
        ),
        array(
            'type' => 'dropdown',
            "param_name" => "icon_type",
            "heading" => __("Icon Type", 'nrgagency'),
            "value" => array(
                "Icon font" => "icon_font",
                "Icon image" => "icon_image"
            ),
            "std" => "icon_font",
        ),
        array(
            'type' => 'attach_image',
            "param_name" => "image",
            "heading" => __("Image Image", 'nrgagency'),
            "value" => '',
            "dependency" => Array("element" => "icon_type", "value" => array("icon_image"))
        ),
        array(
            'type' => 'iconpicker',
            "param_name" => "icon",
            "heading" => __("Icon", 'nrgagency'),
            "description" => "",
            'value' => '',
            'std' => 'fa fa-adjust', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
            ),
            "std" => "fa fa-adjust",
            "dependency" => Array("element" => "icon_type", "value" => array("icon_font"))
        ),
        array(
            "type" => 'textarea_html',
            "param_name" => "content",
            "heading" => __("Content", 'nrgagency'),
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