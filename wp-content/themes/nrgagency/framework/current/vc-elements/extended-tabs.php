<?php
class Extend_Tabs{

    function __construct(){
        add_action('init', array($this, 'tabs_init'));

        if(defined('WPB_VC_VERSION') && version_compare( WPB_VC_VERSION, '4.4', '>=' )) {
            add_filter('vc_shortcode_output', array($this, 'vc_shortcode_output'),10,3);
        }

        add_filter( 'vc_shortcodes_css_class', array($this, 'custom_css_classes_for_vc'), 10, 2 );
    }

    
    // Filter to replace default css class names
    function custom_css_classes_for_vc( $class_string, $tag ) {
        if( $tag == 'vc_row' || $tag == 'vc_row_inner' ){  }
        if( $tag == 'vc_column' || $tag == 'vc_column_inner' ){  }
        return $class_string;
    }


    public function vc_shortcode_output($output, $obj, $attr){
        
        if($obj->settings('base')=='vc_tta_tabs'){
            $data_attr = '';
            if( isset($attr['tab_style'], $attr['number']) ){
                $data_attr = ' data-style="'.$attr['tab_style'].'" data-number="'.$attr['number'].'"';
            }

            if( isset($attr['bgimage'], $attr['brightness']) ){
                $bgimage = wp_get_attachment_image_src($attr['bgimage'], 'full');
                $bgimage = !empty($bgimage) ? $bgimage[0] : '';
                $data_attr .= ' data-bgimage="'.$bgimage.'"';
                $data_attr .= ' data-brightness="'.$attr['brightness'].'"';
            }

            $output = preg_replace('/ class="/', $data_attr . ' class="wpb_tabs_extended ', $output, 1);
        }
        else if($obj->settings('base')=='vc_tta_section'){
            $data_attr = '';
            if( isset($attr['icon'], $attr['icon_type']) && $attr['icon_type'] != 'icon_image' ){
                $data_attr .= ' data-icon="'.$attr['icon'].'" ';
            } else {
                $thumb = isset($attr['image']) ? wp_get_attachment_image_src($attr['image'], 'thumbnail') : "";
                $data_attr .= !empty($thumb) ? ' data-icon="'.$thumb[0].'" ' : '';
            }
            if( isset($attr['process']) ){
                $data_attr .= ' data-number="'.$attr['process'].'" ';
            }

            $output = preg_replace('/ class="vc_tta-panel/', $data_attr . ' class="vc_tta-panel', $output, 1);
        }

        // deprecated tabs
        // =========================================
        elseif($obj->settings('base')=='vc_tabs'){
            $data_attr = '';
            if( isset($attr['tab_style'], $attr['number']) ){
                $data_attr = ' data-style="'.$attr['tab_style'].'" data-number="'.$attr['number'].'"';
            }

            if( isset($attr['bgimage'], $attr['brightness']) ){
                $bgimage = wp_get_attachment_image_src($attr['bgimage'], 'full');
                $bgimage = !empty($bgimage) ? $bgimage[0] : '';
                $data_attr .= ' data-bgimage="'.$bgimage.'"';
                $data_attr .= ' data-brightness="'.$attr['brightness'].'"';
            }

            $output = str_replace(' class="wpb_tabs ', $data_attr.' class="wpb_tabs ', $output);
        }
        else if($obj->settings('base')=='vc_tab'){
            $data_attr = '';
            if( isset($attr['icon'], $attr['icon_type']) && $attr['icon_type'] != 'icon_image' ){
                $data_attr .= ' data-icon="'.$attr['icon'].'" ';
            } else {
                $thumb = isset($attr['image']) ? wp_get_attachment_image_src($attr['image'], 'thumbnail') : "";
                $data_attr .= !empty($thumb) ? ' data-icon="'.$thumb[0].'" ' : '';
            }
            if( isset($attr['process']) ){
                $data_attr .= ' data-number="'.$attr['process'].'" ';
            }
            $output = str_replace(' id="tab-', $data_attr.'  id="tab-', $output);
        }
        return $output;
    }



    public function tabs_init(){

        // vc_tta_tabs
        vc_add_param('vc_tta_tabs', array(
            "type" => "dropdown",
            "heading" => __("Tabs Style", 'nrgagency'),
            "param_name" => "tab_style",
            "value" => array(
                    __("Default", 'nrgagency') => "default",
                    __("Process (beautiful, allows process line)", 'nrgagency') => "process",
                    __("Service (creative, left 50% navigations)", 'nrgagency') => "service",
                    __("Service (creative, right 50% navigations and left image)", 'nrgagency') => "service-reversed"
                )
        ));

        vc_add_param('vc_tta_tabs', array(
            "type" => "dropdown",
            "heading" => __("Show Process Number", 'nrgagency'),
            "param_name" => "number",
            "value" => array(
                    __("Yes", 'nrgagency') => "yes",
                    __("No", 'nrgagency') => "no",
                ),
            "dependency" => Array("element" => "tab_style", "value" => array("process"))
        ));

        vc_add_param('vc_tta_tabs', array(
            "type" => "attach_image",
            "heading" => __("Content Background Image", 'nrgagency'),
            "param_name" => "bgimage",
            "dependency" => Array("element" => "tab_style", "value" => array("service","service-reversed"))
        ));

        vc_add_param('vc_tta_tabs', array(
            "type" => "dropdown",
            "heading" => __("Background Image Brightness", 'nrgagency'),
            "param_name" => "brightness",
            "value" => array(
                    __("Dark", 'nrgagency') => "dark",
                    __("Light", 'nrgagency') => "light",
                ),
            "dependency" => Array("element" => "tab_style", "value" => array("service","service-reversed"))
        ));






        vc_add_param('vc_tta_section', array(
                    'type' => 'dropdown',
                    "param_name" => "icon_type",
                    "heading" => __("Icon Type", 'nrgagency'),
                    "value" => array(
                        "Icon font" => "icon_font",
                        "Icon image" => "icon_image"
                    ),
                    "std" => "icon_font",
        ));

        vc_add_param('vc_tta_section', array(
            'type' => 'iconpicker',
            "param_name" => "icon",
            "heading" => __("Icon", 'nrgagency'),
            "description" => "",
            'value' => '', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
            ),
            "std" => "fa fa-adjust",
            "dependency" => Array("element" => "icon_type", "value" => array("icon_font"))
        ));

        vc_add_param('vc_tta_section', array(
            'type' => 'attach_image',
            "param_name" => "image",
            "heading" => __("Image Image", 'nrgagency'),
            "value" => '',
            "dependency" => Array("element" => "icon_type", "value" => array("icon_image"))
        ));

        vc_add_param('vc_tta_section', array(
            "type" => "textfield",
            "heading" => __("Process number", 'nrgagency'),
            "param_name" => "process",
            "value" => ""
        ));



        // Deprecated tabs
        //====================================


        // vc_tabs
        vc_add_param('vc_tabs', array(
            "type" => "dropdown",
            "heading" => __("Tabs Style", 'nrgagency'),
            "param_name" => "tab_style",
            "value" => array(
                    __("Default", 'nrgagency') => "default",
                    __("Process (beautiful, allows process line)", 'nrgagency') => "process",
                    __("Service (creative, left 50% navigations)", 'nrgagency') => "service",
                    __("Service (creative, right 50% navigations and left image)", 'nrgagency') => "service-reversed"
                )
        ));

        vc_add_param('vc_tabs', array(
            "type" => "dropdown",
            "heading" => __("Show Process Number", 'nrgagency'),
            "param_name" => "number",
            "value" => array(
                    __("Yes", 'nrgagency') => "yes",
                    __("No", 'nrgagency') => "no",
                ),
            "dependency" => Array("element" => "tab_style", "value" => array("process"))
        ));

        vc_add_param('vc_tabs', array(
            "type" => "attach_image",
            "heading" => __("Content Background Image", 'nrgagency'),
            "param_name" => "bgimage",
            "dependency" => Array("element" => "tab_style", "value" => array("service", "service-reversed"))
        ));

        vc_add_param('vc_tabs', array(
            "type" => "dropdown",
            "heading" => __("Background Image Brightness", 'nrgagency'),
            "param_name" => "brightness",
            "value" => array(
                    __("Dark", 'nrgagency') => "dark",
                    __("Light", 'nrgagency') => "light",
                ),
            "dependency" => Array("element" => "tab_style", "value" => array("service", "service-reversed"))
        ));






        vc_add_param('vc_tab', array(
                    'type' => 'dropdown',
                    "param_name" => "icon_type",
                    "heading" => __("Icon Type", 'nrgagency'),
                    "value" => array(
                        "Icon font" => "icon_font",
                        "Icon image" => "icon_image"
                    ),
                    "std" => "icon_font",
        ));

        vc_add_param('vc_tab', array(
            'type' => 'iconpicker',
            "param_name" => "icon",
            "heading" => __("Icon", 'nrgagency'),
            "description" => "",
            'value' => '', // default value to backend editor admin_label
            'settings' => array(
                'emptyIcon' => false, // default true, display an "EMPTY" icon?
                'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
            ),
            "std" => "fa fa-adjust",
            "dependency" => Array("element" => "icon_type", "value" => array("icon_font"))
        ));

        vc_add_param('vc_tab', array(
            'type' => 'attach_image',
            "param_name" => "image",
            "heading" => __("Image Image", 'nrgagency'),
            "value" => '',
            "dependency" => Array("element" => "icon_type", "value" => array("icon_image"))
        ));

        vc_add_param('vc_tab', array(
            "type" => "textfield",
            "heading" => __("Process number", 'nrgagency'),
            "param_name" => "process",
            "value" => ""
        ));


    }
}

new Extend_Tabs();