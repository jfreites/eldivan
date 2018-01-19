<?php


class WPBakeryShortCode_Boxed_Testimonial_Carousel extends WPBakeryShortCodesContainer{
    protected function content($atts, $content=NULL){
        extract(shortcode_atts(array(
            'extra_class' => ""
        ), $atts));

        $result = '';


        $result = '<div class="swiper-parent '.$extra_class.'">
                        <div class="swiper-container" data-mode="horizontal" data-loop="0" data-slides-per-view="1" data-autoplay="true">
                            <div class="swiper-wrapper">
                                '.do_shortcode($content).'
                            </div>
                            <div class="pagination swiper-pagination ts-pagination"></div>
                       </div>
                    </div>';

        return $result;
    }
}


vc_map( array(
    "name" => __("Boxed Testimonial Carousel", 'nrgagency'),
    "description" => __("Boxed Testimonial Slider Container", 'nrgagency'),
    "show_settings_on_create" => true,
    'is_container' => true,
    "content_element" => true,
    "as_parent" => array("only" => "boxed_testimonial"),
    "base" => "boxed_testimonial_carousel",
    "icon" => "tt-icon boxed-testimonial-container",
    "category" => __('Themeton', 'nrgagency'),
    "params" => array(
        array(
            "type" => "textfield",
            "param_name" => "extra_class",
            "heading" => __("Extra Class", 'nrgagency'),
            "value" => "",
            "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'nrgagency'),
        )
    ),
    "js_view" => 'VcColumnView'
));