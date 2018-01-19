<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comment-area col-sm-12">

    <?php if ( have_comments() ) : ?>
        <h2 class="comment-title">
            <?php
                printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'nrgagency' ),
                    number_format_i18n( get_comments_number() ), get_the_title() );
            ?>
        </h2>

        <?php themeton_comment_nav(); ?>

        <ol class="comment-list">
            <?php
                wp_list_comments( array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 56,
                    'callback'    => 'themeton_custom_comment'
                ) );
            ?>
        </ol><!-- .comment-list -->

        <?php themeton_comment_nav(); ?>

    <?php endif; // have_comments() ?>

    <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
        <p class="no-comments"><?php esc_attr_e('Comments are closed.', 'nrgagency'); ?></p>
    <?php endif; ?>

    <?php
        if( is_user_logged_in() ):
            comment_form(
                array(
                    'comment_field' => '<label class="sr-only" for="comment">Message</label>
                                        <textarea id="comment" name="comment" cols="50" rows="6" tabindex="4" class="tx-style" aria-required="true" placeholder="Message"></textarea>',
                    'class_submit' => 'send',
                    'comment_notes_after' => ''
                )
            );
        else:
            $req = get_option( 'require_name_email' );
            $aria_req = ( $req ? " aria-required='true'" : '' );
            comment_form(
                array(
                    'fields' => array(
                        'author' => '<div class="row"><div class="col-md-6">
                                        <label for="author" class="sr-only">' . esc_attr__('Name', 'nrgagency') . '</label>
                                        <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                                            '" size="30"' . $aria_req . ' class="input-style" placeholder="' . esc_attr__('Name', 'nrgagency') . '" />
                                   </div>',

                        'email' => '<div class="col-md-6">
                                    <label for="email" class="sr-only">' . esc_attr__('Email', 'nrgagency') . '</label> 
                                    <input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                                        '" size="30"' . $aria_req . ' class="input-style" placeholder="' . esc_attr__('Email', 'nrgagency') . '" />
                                  </div></div>',

                        'url' => '<div class="row"><div class="col-md-12">
                                    <label for="url" class="sr-only">' . esc_attr__('Website', 'nrgagency') . '</label>
                                    <input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                                        '" size="30" class="input-style" placeholder="' . esc_attr__('Website', 'nrgagency') . '" />
                                  </div></div>',
                    ),
                    'comment_field' => '<div class="row"><div class="col-md-12 col-sm-12">
                                            <label class="sr-only" for="comment">Message</label>
                                            <textarea id="comment" name="comment" cols="50" rows="6" tabindex="4" class="tx-style" aria-required="true" placeholder="Message"></textarea>
                                        </div></div>',
                    'class_submit' => 'send',
                    'comment_notes_before' => '<p class="comment-notes">' .
                                                esc_attr__('Your email address will not be published.', 'nrgagency') .
                                                '</p>',
                    'comment_notes_after' => ''
                )
            );
        endif;
    ?>

</div><!-- .comments-area -->