<?php


class WPBakeryShortCode_Boxed_Team_Carousel extends WPBakeryShortCodesContainer{
    protected function content($atts, $content=NULL){
        extract(shortcode_atts(array(
            'number' => 3,
            'pagination' => "",
            'extra_class' => ""
        ), $atts));

        $result = '';

        if($pagination == 1){
            $pagination = "";
        }else{
            $pagination = "hidden";
        }

        $result = '<div class="boxed-team-carousel swiper-container '.$extra_class.'" data-mode="horizontal" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="2" data-md-slides="3" data-lg-slides="'.$number.'" data-loop="0" data-space-between="30" data-centered="0">
                        <div class="swiper-wrapper">

                            '.do_shortcode($content).'
                            
                        </div>
                        <div class="pagination swiper-pagination ts-pagination hide"></div>
                        <div class="arrows a-arrow '.$pagination.'">
                        <div class="arrow-left"><i class="fa fa-long-arrow-left"></i></div>
                        <div class="arrow-right"><i class="fa fa-long-arrow-right"></i></div>
                        </div>
                    </div>';

        return $result;
    }
}


vc_map( array(
    "name" => __("Boxed Team Carousel", 'nrgagency'),
    "description" => __("Boxed Team Slider Container", 'nrgagency'),
    "show_settings_on_create" => true,
    'is_container' => true,
    "content_element" => true,
    "as_parent" => array("only" => "boxed_team"),
    "base" => "boxed_team_carousel",
    "icon" => "tt-icon boxed-team-container",
    "category" => __('Themeton', 'nrgagency'),
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("How many member displays?", 'nrgagency'),
            "param_name" => "number",
            "value" => array(
                    __("One", 'nrgagency') => "1",
                    __("Two", 'nrgagency') => "2",
                    __("Three", 'nrgagency') => "3",
                    __("Four", 'nrgagency') => "4",
                    __("Five", 'nrgagency') => "5"
                )
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Display arrow slide navigation", 'nrgagency'),
            "param_name" => "pagination",
            "value" => array(
                    __("Yes", 'nrgagency') => "1",
                    __("No", 'nrgagency') => "0"
                )
        ),
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