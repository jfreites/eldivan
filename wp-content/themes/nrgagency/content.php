<div <?php post_class('col-md-12 col-sm-12 single-content'); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="content-media">
            <?php the_post_thumbnail( 'full' ); ?>
        </div>
    <?php endif; ?>
    <div class="content-text">
        <?php the_content();
        wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'nrgagency') . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => '<span class="screen-reader-text">' . __('Page', 'nrgagency') . ' </span>%',
            'separator'   => '<span class="screen-reader-text">, </span>',
        ) );
        ?>
    </div>
    <?php if ( TT::get_mod('post_comment')=='1' && (comments_open() || get_comments_number()) ) : ?>
    <div class="content-comment">
        <?php comments_template(); ?>
    </div>
    <?php endif; ?>
</div>