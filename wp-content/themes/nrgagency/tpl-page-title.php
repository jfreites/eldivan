<?php
function tt_print_page_title(){
	global $post;
	global $wp_query;

	if( is_page() && TT::getmeta('title_show')=='0' ){ return; }
?>
<div class="page-title">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="block-title">
					<?php
		            if( is_archive() ):
		                if(function_exists('the_archive_title')) :
		                    the_archive_title();
		                else:
		                    ?><?php printf( esc_attr__('Category: %s', 'nrgagency'), single_cat_title( '', false ) ); ?><?php
		                endif;
		            
		            elseif( function_exists('is_shop') && is_shop() ):
		                printf(esc_attr__('Shop', 'nrgagency'));
		            elseif( function_exists('is_shop') && is_product() ):
		                printf(esc_attr__('Shop', 'nrgagency'));

		            elseif( is_search() ):
		                printf( 'Results for: %s', get_search_query() );
		            elseif( is_singular('portfolio') ):
		                printf( '%s', TT::get_mod('portfolio_label') );
		            elseif( is_single() ):
		                printf( '%s', get_the_title() );
		            elseif( is_front_page() && is_home() ):
		            	if( is_home() ):
		            		printf('%s', esc_html__('Blog', 'nrgagency'));
		                elseif( get_query_var('post_type')=='portfolio' ):
		                    printf('%s', esc_attr__('Projects', 'nrgagency'));
		                else:
		                    printf('%s', esc_attr__('Home', 'nrgagency'));
		                endif;
		            else:
		                the_title();
		            endif;
		            ?>
				</h2>
				<?php
				if( is_single() ){
					echo '<p class="sub-title">';
					echo '<span class="post-meta">';
					echo get_the_author().'  |  ';
					echo the_time('F d / Y').'  |  ';

					$categories = get_the_category();
					$separator = ', ';
					$output = '';
					if($categories){
						foreach($categories as $category) {
							$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( esc_attr__("View all posts in %s", 'nrgagency'), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
						}
						echo trim($output, $separator);
					}

					if(has_tag()) {
						echo '  |  ';
						$tags = get_the_tags();
						$separator = ', ';
						$output = '';
						if($tags){
							foreach($tags as $tag) {
								$output .= '<a href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( esc_attr__("View all posts in %s", 'nrgagency'), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator;
							}
							echo trim($output, $separator);
						}

					}
					echo '</span>';
					echo '</p>';
				}
				else if( is_page() ){
					$subtitle = TT::getmeta('title_desc');
					if( !empty($subtitle) ){
						printf( "<p class='sub-title'>%s</p>", $subtitle );
					}
				}
				?>
				
			</div>
		</div>
	</div>
</div>
<?php
}

tt_print_page_title();

?>