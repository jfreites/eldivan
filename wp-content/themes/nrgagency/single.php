<?php get_header(); ?>
    
    <?php
        while ( have_posts() ) : the_post();
    ?>

    <?php get_template_part("tpl", "page-title"); ?>

    <div class="blog blog-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="row">
                        <?php
                            get_template_part( 'content', get_post_format() );
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php 
        endwhile;
    ?>

<?php get_footer(); ?>