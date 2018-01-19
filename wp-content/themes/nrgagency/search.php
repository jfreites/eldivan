<?php get_header(); ?>
    
    <?php get_template_part("tpl", "page-title"); ?>

    <div class="blog blog-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="row">
                        <?php
                        if(have_posts()) {
                            while ( have_posts() ) : the_post();
                                get_template_part( 'content-loop', get_post_format() );
                            endwhile;
                        } else {
                            echo '<div class="text-center"><p>';
                            _e('<h4>Nothing found, please search again with an another query.</h4>', 'nrgagency');
                            echo '</p>';
                            the_widget('WP_Widget_Search');
                            echo '</div>';
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>