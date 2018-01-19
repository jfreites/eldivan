<?php get_header(); ?>
    
    <div class="blog blog-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    
                    <h2><?php esc_attr_e('404', 'nrgagency');?></h2>
                    

                </div>
                <div class="col-md-6">
                    <p><?php esc_attr_e('It looks like nothing was found at this location. Maybe try a search?', 'nrgagency'); ?></p>
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="input-group">
                            <input type="search" class="search-field" placeholder="Search ..." value="" name="s"/>
                            <input type="submit" class="search-submit" value="Search"/>
                        </div><!-- end .input-group -->
                    </form>

                    <p><?php esc_attr_e('For best search results, mind the following suggestions:', 'nrgagency'); ?></p>
                    <ul class="borderlist-not">
                        <li><?php esc_attr_e('Always double check your spelling.', 'nrgagency'); ?></li>
                        <li><?php esc_attr_e('Try similar keywords, for example: tablet instead of laptop.', 'nrgagency'); ?></li>
                        <li><?php esc_attr_e('Try using more than one keyword.', 'nrgagency'); ?></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>


<?php get_footer(); ?>