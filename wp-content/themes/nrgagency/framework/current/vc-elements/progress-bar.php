<?php

class WPBakeryShortCode_Progress_Bar extends WPBakeryShortCode {
    protected function content( $atts, $content = null){
        extract( shortcode_atts( array(
            "desc"     => "",
            "precentage"     => "",
            "extra_class" => ""
        ), $atts ) );
        
        $result = "<div class='our-progress time-line $extra_class'>
                            <h5>$desc</h5>
                            <div class='line'>
                                <div class='line-active'>
                                <span class='timer countto' data-to='$precentage' data-speed='3000'>$precentage</span>
                                </div>
                            </div>
                    </div>";
        return $result;
    }
}

vc_map( array(
    "name" => __("Progress Bar", 'nrgagency'),
    "description" => __("Show Process", 'nrgagency'),
    "base" => 'progress_bar',
    "class" => "",
    "icon" => "tt-icon progress-bar",
    "category" => __('Themeton', 'nrgagency'),
    "show_settings_on_create" => true,
    "params" => array(
        array(
            'type' => 'textfield',
            "param_name" => "desc",
            "heading" => __("Description", 'nrgagency'),
            "value" => '',
            "holder" => 'div'
        ),
        array(
            'type' => 'textfield',
            "param_name" => "precentage",
            "heading" => __("Precentage", 'nrgagency'),
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