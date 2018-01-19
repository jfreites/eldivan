<?php get_header(); ?>
    
    <?php get_template_part("tpl", "page-title"); ?>

    <div class="blog blog-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="row blog-posts">
                        <?php
                            while ( have_posts() ) : the_post();
                                get_template_part( 'content-loop', get_post_format() );
                            endwhile;
                        ?>
                    </div>

                    <?php
                    // Previous/next page navigation.
                    TPL::pagination();
                    ?>

                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>