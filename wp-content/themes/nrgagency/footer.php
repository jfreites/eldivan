<!--FOOTER-->
<?php if( TT::get_mod('footer')!= 0 ): ?>
    <footer class="footer b-footer">
        <div class="container container-footer">
            
            <img src="<?php echo TT::get_mod('footer_logo') ?>" alt="logo"/>
            <p class="footer-info s-footer-info"><?php echo TT::get_mod('footer_text') ?></p>

            <?php 
                switch (TT::get_mod('footer_style')) {
                    case 1:
                        $col = 1;
                        $percent = array('col-xs-12 col-sm-12 col-md-12 col-lg-12');
                        break;
                    case 2:
                        $col = 2;
                        $percent = array(
                            'col-xs-12 col-sm-6 col-md-6 col-lg-6',
                            'col-xs-12 col-sm-6 col-md-6 col-lg-6');
                        break;
                    case 3:
                        $col = 3;
                        $percent = array(
                            'col-md-4 col-sm-4',
                            'col-md-4 col-sm-4',
                            'col-md-4 col-sm-4');
                        break;
                    case 4:
                        $col = 4;
                        $percent = array(
                            'col-md-3 col-sm-6',
                            'col-md-3 col-sm-6',
                            'col-md-3 col-sm-6',
                            'col-md-3 col-sm-6');
                        break;
                    case 5:
                        $col = 3;
                        $percent = array(
                            'col-xs-12 col-sm-12 col-md-6 col-lg-6',
                            'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                            'col-xs-12 col-sm-6 col-md-3 col-lg-3');
                        break;
                    case 6:
                        $col = 3;
                        $percent = array(
                            'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                            'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                            'col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-right');
                        break;
                    default:
                        $col = 4;
                        $percent = array(
                            'col-md-3 col-sm-6',
                            'col-md-3 col-sm-6',
                            'col-md-3 col-sm-6',
                            'col-md-3 col-sm-6');
                        break;
                }
                for ($i = 1; $i <= $col; $i++) {                                
                    echo "<div class='".esc_attr($percent[$i - 1])." footer-column-$i'>";
                    dynamic_sidebar('footer'.$i);
                    echo '</div>';
                }
            ?>

        </div>
        <div class="ftr-nav-container"> 

         <div class="sub-footer">
            <div class="row">
                <div class="col-sm-12">
                    <div class="entry-footer">
                      <?php echo TT::get_mod('copyright_content'); ?>
                    </div>
                </div>
            </div>
        </div>

            <div class="container">
                <?php wp_nav_menu( array( 
                    'theme_location' => 'footer', 
                    'container_class' => 'ftr-nav f-ftr-nav clearfix', 
                    'container' => 'nav',
                    'fallback_cb' => '',
                    'depth' => 1
                     ) ); ?>
            </div> 
        </div>


    </footer>
<?php endif; ?>

<?php 
/*
*************************************************
  WordPress Footer Hook
*************************************************
*/
wp_footer(); ?>

</body>
</html>