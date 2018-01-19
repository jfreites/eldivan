<div <?php post_class('col-md-4 col-sm-4 post-item'); ?>>
    <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'nrgagency-blog-thumb'); ?></a>
    <h5><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h5>
    <p><i class="fa fa-user"></i> <?php the_author(); ?>  <i class="fa fa-calendar-o"></i> <?php the_time('F d / Y') ?></p>
    <a class="read-more" href="<?php echo get_permalink(); ?>">
        <?php esc_attr_e('Read more', 'nrgagency'); ?>
        <i class="fa fa-long-arrow-right"></i>
    </a>
</div>