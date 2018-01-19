<?php

class ThemetonMetaPage extends TTRenderMeta{

    function __construct(){
        $this->items = $this->items();
        add_action('admin_enqueue_scripts', array($this, 'print_admin_scripts'));
        add_action('add_meta_boxes', array($this, 'add_custom_meta'), 1);
        add_action('edit_post', array($this, 'save_post'), 99);

        if( TT::admin_post_type()=="page" ){
            add_action('admin_enqueue_scripts', array($this, 'print_scripts_post'));
        }
    }

    // print admin scripts
    public function print_scripts_post($hook) {
        if( TT::admin_post_type()!='page' ){
            return;
        }
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_style( 'admin-page-script', get_template_directory_uri() . '/framework/admin-assets/meta.page.css' );
        wp_enqueue_script('admin-page-script', get_template_directory_uri() . '/framework/admin-assets/meta.page.js', false, false, true );
    }

    // meta fields
    public function items(){
        global $tt_sidebars, $tt_sliders, $post;

        // Google Font Options
        include_once tt_file_require(get_template_directory() . '/framework/functions/google-fonts.php');
        $google_fonts = get_google_webfonts();

        $google_webfonts = array();
        $google_webfonts["default"] = "Default (Helvetica, Arial, sans-serif)";
        foreach ($google_fonts as $font) {
            $google_webfonts[$font['family']] = $font['family'];
        }


        // Less Options
        $less_options = array();

        global $post;

        $title_color = TT::get_mod('page-title-color');
        $title_bg_color = TT::get_mod('page-title-bg-color');

        $tmp_arr = array(
            'page' => array(
                'label' => 'Page Options',
                'post_type' => 'page',
                'items' => array(
                    array(
                        'type' => 'checkbox',
                        'name' => 'one_page_menu',
                        'label' => 'One Page Menu (current page\'s menu by defined sections)',
                        'default' => '0',
                        'desc' => 'Please edit the Visual Composer rows and set properties that need to be a section of your page. And page menu presents by them when you turned this option On.'
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'remove_padding',
                        'label' => 'Remove Content Area Padding?',
                        'default' => '0',
                        'desc' => 'Turn this on (green) if you want to control your content area padding by your includes.'
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'title_show',
                        'label' => 'Title On Single',
                        'default' => '1',
                        'desc' => 'If your title image is so beautiful and you don\'t wanna put someting on that, you should turn this OFF and hide post title.'
                    ),
                    array(
                        'type' => 'colorpicker',
                        'name' => 'title_color',
                        'label' => 'Title Color',
                        'default' => $title_color
                    ),
                    array(
                        'type' => 'colorpicker',
                        'name' => 'title_bg_color',
                        'label' => 'Title Background Color',
                        'default' => $title_bg_color
                    ),
                    array(
                        'name' => 'title_desc',
                        'type' => 'textarea',
                        'label' => 'Description',
                        'default' => '',
                        'desc' => 'Page Subitle on Page Title'
                    )
                )
            ),
        );

        return $tmp_arr;
    }


}

new ThemetonMetaPage();