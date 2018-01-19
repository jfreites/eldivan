<?php

if (!function_exists('tt_customizer_options')):

    function tt_customizer_options() {
        global $tt_sidebars;

        $template_uri = get_template_directory_uri();

        $pages = array();
        $all_pages = get_pages();
        foreach ($all_pages as $page) {
            $pages[$page->ID] = $page->post_title;
        }

        $option = array(
            // General
            array(
                'type' => 'section',
                'id' => 'section_general',
                'label' => 'General',
                'desc' => '',
                'controls' => array(
                    array(
                        'type' => 'color',
                        'id' => 'brand-color',
                        'label' => 'Brand Primary Color',
                        'default' => getLessValue('brand-color'),
                        'desc' => 'The main aspect color that express menu active & hover, link hover, title border, pagination colors, quote format, tag link and more.'
                    ),
                    array(
                        'type' => 'font',
                        'id' => 'font-title',
                        'label' => 'Font: Titles and Metas',
                        'default' => getLessValue('font-title'),
                        'desc' => 'Titles, and meta texts.'
                    ),
                    array(
                        'type' => 'font',
                        'id' => 'font-text',
                        'label' => 'Font: Content text',
                        'default' => getLessValue('font-text'),
                        'desc' => 'Content text and small titles.'
                    ),
                    array(
                        'type' => 'image',
                        'id' => 'logo',
                        'label' => 'Logo Image',
                        'default' => $template_uri . "/img/logo.png"
                    ),
                    array(
                        'type' => 'pixel',
                        'id' => 'logo-width',
                        'label' => 'Logo Width',
                        'default' => getLessValue('logo-width'),
                        'desc' => 'Original logo width and this option is benefitial for your retina logo sizing. Just click on above image and see the Attachment details. Also you can use this option for making space for your text logo.'
                    ),
                    array(
                        'id' => 'favicon',
                        'label' => 'Favicon',
                        'desc' => '16x16 pixel, PNG/ICO/JPG',
                        'default' => $template_uri . "/img/favicon.ico",
                        'type' => 'image'
                    ),
                    array(
                        'type' => 'image',
                        'id' => 'logo_admin',
                        'label' => 'Login Page Logo',
                        'desc' => 'Up to 274x95px',
                        'default' => $template_uri . "/images/logo-admin.png"
                    )
                )
            ),// end General

                    // Header
                    array(
                        'type' => 'section',
                        'id' => 'section_header',
                        'label' => 'Header',
                        'desc' => '',
                        'controls' => array(
                            array(
                                'id' => 'header_style',
                                'label' => 'Header Style',
                                'default' => 'h-transparent',
                                'type' => 'select',
                                'choices' => array(
                                    'h-transparent' => 'Default (Transparent)',
                                    'default' => 'Background color', 
                                )
                            ),
                            array(
                                'id' => 'header_non_sticky',
                                'label' => 'Stop header sticky',
                                'type' => 'switch',
                                'default' => '0'
                            ),
                            array(
                                'type' => 'color',
                                'id' => 'menu-bg-color',
                                'label' => 'Header Background Color',
                                'default' => getLessValue('menu-bg-color')
                            ),
                            array(
                                'id' => 'header-height',
                                'label' => 'Header Height (px)',
                                'default' => getLessValue('header-height'),
                                'type' => 'pixel'
                            ),
                            array(
                                'type' => 'color',
                                'id' => 'menu-color',
                                'label' => 'Menu Color',
                                'default' => getLessValue('menu-color')
                            ),
                            array(
                                'type' => 'color',
                                'id' => 'menu-color-active',
                                'label' => 'Menu Active Color',
                                'default' => getLessValue('menu-color-active'),
                                'desc' => 'Overwrites brand color'
                            )
                        )
                    ), // end Header

                    // Page Title
                    array(
                        'type' => 'section',
                        'id' => 'page_title',
                        'label' => 'Page Title',
                        'controls' => array(
                            array(
                                'id' => 'page-title-pt',
                                'label' => 'Title Top Space',
                                'default' => getLessValue('page-title-pt'),
                                'type' => 'pixel'
                            ),
                            array(
                                'id' => 'page-title-pb',
                                'label' => 'Title Bottom Space',
                                'default' => getLessValue('page-title-pb'),
                                'type' => 'pixel'
                            ),
                            array(
                                'type' => 'color',
                                'id' => 'page-title-color',
                                'label' => 'Title Color',
                                'default' => getLessValue('page-title-color')
                            ),
                            array(
                                'type' => 'color',
                                'id' => 'page-title-bg-color',
                                'label' => 'Background Color',
                                'default' => getLessValue('page-title-bg-color')
                            )
                        ),
                    ), //end Page Title

                    // Content
                    array(
                        'type' => 'section',
                        'id' => 'page_content',
                        'label' => 'Content',
                        'controls' => array(
                            array(
                                'type' => 'color',
                                'id' => 'content-bg-color',
                                'label' => 'Background Color',
                                'default' => getLessValue('content-bg-color')
                            ),
                            array(
                                'type' => 'color',
                                'id' => 'title-color',
                                'label' => 'Heading Color',
                                'default' => getLessValue('title-color')
                            ),
                            array(
                                'type' => 'color',
                                'id' => 'text-color',
                                'label' => 'Text Color',
                                'default' => getLessValue('text-color')
                            )
                        ),
                    ), //end Content
                    
                    // Footer
                    array(
                        'type' => 'section',
                        'id' => 'section_footer',
                        'label' => 'Footer',
                        'controls' => array(
                            array(
                                'id' => 'footer',
                                'label' => 'Enable Footer',
                                'default' => '1',
                                'type' => 'switch'
                            ),
                            array(
                                'id' => 'footer_style',
                                'label' => 'Footer Style',
                                'default' => '1',
                                'type' => 'select',
                                'choices' => array('1' => 'Full', '2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns', '5' => '1/2 + 1/4 + 1/4', '6' => '1/4 + 1/4 + 1/2')
                            ),
                            array(
                                'type' => 'image',
                                'id' => 'footer_logo',
                                'label' => 'Footer Logo',
                                'default' => $template_uri . "/img/footer-logo.png"
                            ),
                            array(
                                'id' => 'footer_text',
                                'label' => 'Footer Content',
                                'default' => 'Maecenas vitae venenatis lorem. Pellentesque et lacinia eros, condimentum hendrerit nisl. In iaculis a nunc a euismod. Phasellus aliquam sagittis congue.',
                                'type' => 'textarea',
                                'desc' => 'Here you can add some simple text or markup content. If you need more advanced things, you can add widgets on footer area on Appearence=>Widgets.'
                            ),
                            array(
                                'id' => 'footer-text-color',
                                'label' => 'Footer Text Color',
                                'default' => '#cfd1db',
                                'type' => 'color'
                            ),
                            array(
                                'id' => 'footer-bg-color',
                                'label' => 'Footer Background Color',
                                'default' => '#35373e',
                                'desc' => '',
                                'type' => 'color'
                            ),
                            array(
                                'id' => 'sub-footer-color',
                                'label' => 'Sub Footer Text Color',
                                'default' => '#cfd1db',
                                'type' => 'color',
                                'desc' => ''
                            ),
                            array(
                                'id' => 'sf-bg-color',
                                'label' => 'Sub Footer Background Color',
                                'default' => '#2f3138',
                                'type' => 'color',
                                'desc' => ''
                            ),
                            array(
                                'id' => 'copyright_content',
                                'label' => 'CopyRight Content',
                                'default' => 'Copyright © 2015 - All Rights Reserved',
                                'desc' => '',
                                'type' => 'textarea'
                             )  
                        ),
                    ),// end Footer

            // Post Types
            array(
                'id' => 'panel_options',
                'label' => 'Post Types',
                'desc' => 'You can customize here mostly post type options including singular pages options.',
                'sections' => array(
                    // Post
                    array(
                        'id' => 'section_post',
                        'label' => 'Post',
                        'controls' => array(
                            array(
                                'id' => 'post_comment',
                                'label' => 'Post Comment',
                                'default' => 1,
                                'type' => 'switch'
                            ),
                            array(
                                'id' => 'post_nextprev',
                                'label' => 'Next/Prev links',
                                'default' => 1,
                                'type' => 'switch'
                            ),
                        ),
                    ),// end Post
                    // Page
                    array(
                        'id' => 'section_page',
                        'label' => 'Page',
                        'controls' => array(
                            array(
                                'id' => 'page_nextprev',
                                'label' => 'Next/Prev links',
                                'default' => 1,
                                'type' => 'switch'
                            ),
                            array(
                                'id' => 'page_comment',
                                'label' => 'Page Comment',
                                'default' => 0,
                                'type' => 'switch'
                            ),
                        ),
                    ),// end Page

                    // Portfolio
                    array(
                        'id' => 'section_portfolio',
                        'label' => 'Portfolio',
                        'controls' => array(
                            array(
                                'id' => 'portfolio_label',
                                'label' => 'Portfolio Label',
                                'default' => 'Portfolio',
                                'type' => 'input'
                            ),
                            array(
                                'id' => 'portfolio_slug',
                                'label' => 'Portfolio Slug',
                                'default' => 'portfolio-item',
                                'type' => 'input'
                            ),
                            array(
                                'id' => 'portfolio_sbar',
                                'label' => 'Layout',
                                'default' => 'full',
                                'type' => 'select',
                                'choices' => array('full' => 'No sidebar', 'left' => 'Left sidebar', 'right' => 'Right sidebar')
                            ),
                            
                            array(
                                'id' => 'sub_portfolio_single',
                                'type' => 'sub_title',
                                'label' => 'Single Post Options',
                                'default' => ''
                            ),
                            array(
                                'id' => 'portfolio_related',
                                'label' => 'Related Posts',
                                'default' => 1,
                                'type' => 'switch'
                            ),
                            array(
                                'id' => 'portfolio_comment',
                                'label' => 'Comment',
                                'default' => 0,
                                'type' => 'switch'
                            ),
                            array(
                                'id' => 'portfolio_nextprev',
                                'label' => 'Next/Prev links',
                                'default' => 1,
                                'type' => 'switch'
                            ),
                            array(
                                'id' => 'portfolio_page',
                                'label' => 'Portfolio Main Page',
                                'default' => 'pages',
                                'type' => 'select',
                                'choices' => array('0' => "Choose your page:") + $pages
                            ),
                        ),
                    )// end Portfolio
                )
            ),// end Post Types
            // Extras
            array(
                'id' => 'panel_extra',
                'label' => 'Extras',
                'desc' => 'Export Import and Custom CSS.',
                'sections' => array(
                    // Backup
                    array(
                        'type' => 'section',
                        'id' => 'section_backup',
                        'label' => 'Export/Import',
                        'desc' => '',
                        'controls' => array(
                            array(
                                'id' => 'backup_settings',
                                'label' => 'Export Data',
                                'desc' => 'Copy to Customizer Data',
                                'default' => '',
                                'type' => 'backup'
                            ),
                            array(
                                'id' => 'import_settings',
                                'label' => 'Import Data',
                                'desc' => 'Import Customizer Exported Data',
                                'default' => '',
                                'type' => 'import'
                            )
                        )
                    ), // end backup
                    // Custom
                    array(
                        'type' => 'section',
                        'id' => 'section_custom_css',
                        'label' => 'Custom CSS',
                        'desc' => '',
                        'controls' => array(
                            array(
                                'id' => 'custom_css',
                                'label' => 'Custom CSS (general)',
                                'default' => '',
                                'type' => 'textarea'
                            ),
                            array(
                                'id' => 'custom_css_tablet',
                                'label' => 'Tablet CSS',
                                'default' => '',
                                'type' => 'textarea',
                                'desc' => 'Screen width between 768px and 991px.'
                            ),
                            array(
                                'id' => 'custom_css_widephone',
                                'label' => 'Wide Phone CSS',
                                'default' => '',
                                'type' => 'textarea',
                                'desc' => 'Screen width between 481px and 767px. Ex: iPhone landscape.'
                            ),
                            array(
                                'id' => 'custom_css_phone',
                                'label' => 'Phone CSS',
                                'default' => '',
                                'type' => 'textarea',
                                'desc' => 'Screen width up to 480px. Ex: iPhone portrait.'
                            ),
                        )
                    ) // end Custom
                )
            ) // end Extras
        );

        return $option;
    }

endif;

// create instance of TT Theme Customizer
new TT_Theme_Customizer();
