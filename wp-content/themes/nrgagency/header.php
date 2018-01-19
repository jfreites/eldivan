<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="format-detection" content="telephone-no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
    
</head>
<body <?php body_class(); ?>>
    <!--LOADER-->
    <div id="loader-wrapper">
        <div class="loader-content">
            <div class="cube1 f-cube"></div>
            <div class="cube2 f-cube"></div>
        </div>
    </div>
    <!--HEADER-->
    <header class="header">
        <div class="container clearfix nopadding">
            <div id="logo">
                <a href="<?php echo get_home_url(); ?>" style="background-image:url(<?php echo esc_url(TT::get_mod('logo')); ?>);"></a>
            </div>
            <div class="menu-button">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="nav">
                <?php tt_print_main_menu(); ?>
            </nav>
        </div>
    </header>