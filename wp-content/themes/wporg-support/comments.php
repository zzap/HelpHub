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

$post_id = get_the_ID();

$feedback_description = __( 'Feedback you send to us will go only to the folks who maintain documentation. They may reach out in case there are questions or would like to followup feedback. But that too will stay behind the scenes.', 'wporg-forums' );

if ( is_user_logged_in() ) :
	if ( comments_open() || pings_open() ) :
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		comment_form(
			array(
				'title_reply'  => __( 'Was this article helpful? How could it be improved?', 'wporg-forums' ),
				'comment_field' => sprintf(
					'<p class="comment-form-comment">%s %s</p>',
					sprintf(
						'<label for="comment" class="screen-reader-text">%s</label>',
						_x( 'Feedback', 'noun', 'wporg-forums' )
					),
					'<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>'
				),
				'logged_in_as'         => sprintf(
					'<p>%1$s</p><p class="logged-in-as">%2$s</p>',
					$feedback_description,
					sprintf(
						/* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. */
						__( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>', 'wporg-forums' ),
						get_edit_user_link(),
						/* translators: %s: User name. */
						esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.', 'wporg-forums' ), $user_identity ) ),
						$user_identity,
						/** This filter is documented in wp-includes/link-template.php */
						wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
					)
				),
				'label_submit' => __( 'Send Feedback', 'wporg-forums' )
			)
		);

	elseif ( is_single() ) :
	?>

		<div class="comment-respond" id="respond">

			<p class="comments-closed"><?php _e( 'Comments are closed.', 'wporg-forums' ); ?></p>

		</div><!-- #respond -->

	<?php
	endif;

else :
?>

	<div class="comment-respond" id="respond">

		<h3><?php _e( 'Was this article helpful? How could it be improved?', 'wporg-forums' ); ?></h3>
		<?php
		printf(
			'<p>%1$s</p><p class="must-log-in">%2$s</p>',
			$feedback_description,
			sprintf(
				/* translators: %s: Login URL. */
				__( 'Please <a href="%s">log in</a> to leave the feedback.' ),
				/** This filter is documented in wp-includes/link-template.php */
				wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
			)
		);
		?>

	</div><!-- #respond -->

<?php
endif;