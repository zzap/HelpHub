<?php
/**
 * The template file for displaying the comments and comment form
 *
 * @package WPBBP
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
        return;
}

if ( $comments ) {
        ?>

        <div class="comments" id="comments">

                <?php
                $comments_number = absint( get_comments_number() );
                ?>

                <div class="comments-header">

                        <h2 class="comment-reply-title">
                        <?php
                        if ( ! have_comments() ) {
                                _e( 'Leave a comment', 'wporg-forums' );
                        } elseif ( '1' === $comments_number ) {
                                /* translators: %s: post title */
                                printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'wporg-forums' ), esc_html( get_the_title() ) );
                        } else {
                                echo sprintf(
                                        /* translators: 1: number of comments, 2: post title */
                                        _nx(
                                                '%1$s reply on &ldquo;%2$s&rdquo;',
                                                '%1$s replies on &ldquo;%2$s&rdquo;',
                                                $comments_number,
                                                'comments title',
                                                'wporg-forums'
                                        ),
                                        number_format_i18n( $comments_number ),
                                        esc_html( get_the_title() )
                                );
                        }

                        ?>
                        </h2><!-- .comments-title -->

                </div><!-- .comments-header -->

                <div class="comments-list">

                        <?php
                        the_comments_navigation();
                        wp_list_comments(
                                array(
                                        'style' => 'div'
                                )
                        );
                        the_comments_navigation();
                        ?>

                </div><!-- .comments-inner -->

        </div><!-- comments -->

        <?php
}

if ( comments_open() || pings_open() ) {

        comment_form();

} elseif ( is_single() ) {
        ?>

        <div class="comment-respond" id="respond">

                <p class="comments-closed"><?php _e( 'Comments are closed.', 'wporg-forums' ); ?></p>

        </div><!-- #respond -->

        <?php
}
