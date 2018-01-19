<?php

add_action('wp_loaded', 'create_class_CurrentMetas');
function create_class_CurrentMetas(){

    class CurrentThemeMetas extends TTRenderMeta{

        function __construct(){
            $this->items = $this->items();
            add_action('admin_enqueue_scripts', array($this, 'print_admin_scripts'));
            add_action('add_meta_boxes', array($this, 'add_custom_meta'), 1);
            add_action('edit_post', array($this, 'save_post'), 99);
        }

        public function items(){
            $admin_images = get_template_directory_uri().'/framework/admin-assets/images/';

            $grid_size = array(
                                'type' => 'thumbs',
                                'name' => 'grid_size',
                                'label' => 'Grid Size',
                                'default' => 'small',
                                'option' => array(
                                    'normal' => $admin_images . 'shape11.png',
                                    'vertical' => $admin_images . 'shape21.png',
                                    'large' => $admin_images . 'shape22.png',
                                    'horizontal' => $admin_images . 'shape12.png'
                                ),
                                'desc' => 'Item size for Grid X layout only'
                            );
            
            $force_link_target = array(
                                'name' => 'force_link_target',
                                'type' => 'select',
                                'label' => 'Permalink open type',
                                'default' => '_default',
                                'option' => array(
                                    '_default' => 'Default',
                                    '_self' => 'Opens linked document in current window',
                                    '_blank' => 'Opens linked document in new window or tab',
                                    '_lightbox' => 'Lightbox (only if this post has text & regular content, no javascript)',
                                ),
                                'desc' => 'If you select different value than Default here, your post won\'t controlled by QuickLoad element. Means permanent link option for this post.'
                            );
            $force_link = array(
                                'name' => 'force_link',
                                'type' => 'text',
                                'label' => 'Custom link (optional)',
                                'default' => '',
                                'desc' => 'Add your custom url link such as Facebook or Twitter or Pinterest or another local page url. If you want to make this post unclickable, please just add here a # (hashtag).'
                            );
            return array(
                    'post_grid_options' => array(
                        'label' => 'Options for Grid Element only',
                        'post_type' => 'post',
                        'items' => array(
                            $grid_size,
                            $force_link
                        )
                    ),
                    'portfolio_grid_options' => array(
                        'label' => 'Options for Grid Element only',
                        'post_type' => 'portfolio',
                        'items' => array(
                            $grid_size,
                            $force_link
                        )
                    ),
                    'product_grid_options' => array(
                        'label' => 'Options for Grid Element only',
                        'post_type' => 'product',
                        'items' => array(
                            $grid_size,
                            $force_link
                        )
                    ),
                    'page_grid_options' => array(
                        'label' => 'Options for Grid Element only',
                        'post_type' => 'page',
                        'items' => array(
                            $grid_size,
                            $force_link
                        )
                    )
                );
        }
    }


    if( function_exists('vc_map') )
        new CurrentThemeMetas();
}

?>