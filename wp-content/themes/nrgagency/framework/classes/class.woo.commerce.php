<?php
class TT_WooCommerce{
    public $size = 'woo-item';

    function __construct(){
        add_theme_support( 'woocommerce' );

        add_filter('woocommerce_show_page_title', array($this, 'woo_page_title'));
        add_filter('loop_shop_columns', array($this, 'loop_columns'), 1, 10 );

        /* WOO PAGINATION HOOK
        =============================================*/
        remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
        add_action( 'woocommerce_after_shop_loop', array($this, 'woo_pagination'), 10);
        
        add_action( 'woocommerce_before_shop_loop_item', array($this, 'ttwc_before_shop_loop_item'), 10);
        add_action( 'woocommerce_after_shop_loop_item', array($this, 'ttwc_after_shop_loop_item'), 10);
        
    }

    public function woo_page_title() {
        return false;
    }

    public function loop_columns($number_columns){
        return 3;
    }

    public function woo_pagination() {
        global $wp_query;
        TPL::pagination($wp_query);
    }

    public function ttwc_before_shop_loop_item(){
        $item_url = get_permalink(get_the_ID());
        $magnific_url = $item_url;
        if( has_post_thumbnail( get_the_ID() ) ){
            $img_full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
            $magnific_url = !empty($img_full) ? $img_full[0] : $magnific_url;
        }
        echo '<div class="product-box">';
        echo '<div class="product-hover">
                <ul>
                    <li><a href="'.$magnific_url.'" class="magnific-pops">'.__('quick view', 'nrgagency').'</a></li>
                    <li><i class="fa fa-heart-o"></i></li>
                    <li><a href="'.$item_url.'"><img src="'.get_template_directory_uri().'/images/icon/repeat-icon.png" alt="repeat icon"></a></li>
                </ul>
            </div>';
    }

    public function ttwc_after_shop_loop_item(){
        echo '</div>';
    }

}


if( class_exists( 'woocommerce' ) )
    new TT_WooCommerce();


function get_woo_cart_link(){
    if( class_exists( 'woocommerce' ) ){
        global $woocommerce;
        return '<a href="'.$woocommerce->cart->get_cart_url().'"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a>';
    }
    return '';
}