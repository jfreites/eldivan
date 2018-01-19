<?php while ( have_posts() ) : the_post(); ?>

<div id="gallery-box" class="mfp-with-anim portfolio-popup">
    <div class="sw-container blog-section">
        <div class="plase-box background-parent">
            <?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'full' );
				} 	
			?>
        </div>

        <div class="place-info">
	        <h3 class="country-name"><?php the_title(); ?></h3>
	        <span class="tag"><?php
	            $cat_titles = array();
	            $terms = wp_get_post_terms(get_the_ID(), 'portfolio_entries');
	            foreach ($terms as $term){
	                $cat_titles[] = $term->name;
	            }

	            echo implode(", ", $cat_titles);
	        ?></span>
	        <?php the_content(); ?>	
	    </div>
    </div>
</div>

<?php  endwhile; ?>