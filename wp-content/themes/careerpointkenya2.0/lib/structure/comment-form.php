<?php
/**
 * Child Comment Form
 *
 * This file calls the defines the output for the HTML5 blog comment form.
 *
 * @category     Child
 * @package      Structure
 * @author       Web Savvy Marketing
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        2.0.0
 */


/** Edit comments form text **/

add_filter( 'comment_form_defaults', 'wsm_genesis_comment_form_args' );

function wsm_genesis_comment_form_args( $defaults ) {

	global $user_identity, $id;

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );

	$author = '<p class="gforms-placeholder gform_wrapper comment-form-author">' .
			 '<input id="author" name="author" type="text" placeholder="' . __( 'Name', 'wsm' ) .   ( $req ? '*' : '' ) .'" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' . // With Placeholder
			 // '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' . // No Placeholder
			 '<label for="author">' . __( 'Name', 'wsm' ) .   ( $req ? '<span class="required">*</span>' : '' ) .'</label> ' .
			 '</p><!-- .form-section-author .form-section -->';

	$email = '<p class="gforms-placeholder gform_wrapper comment-form-email">' .
			'<input id="email" name="email" type="text" placeholder="' . __( 'Email', 'wsm' ) .   ( $req ? '*' : '' ) .'" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' . //With Placeholder
			//'<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' . // No Placeholder
			'<label for="email">' . __( 'Email', 'wsm' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
			'</p><!-- .form-section-email .form-section -->';

		$url = '<p class="gforms-placeholder gform_wrapper comment-form-url">' .
			'<input id="url" name="url" type="text" placeholder="' . __( 'Website', 'wsm' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="2" />' . // With Placeholder
			// '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="2" />' . // No Placeholder
	         '<label for="url">' . __( 'Website', 'wsm' ) . '</label> ' .
	         '</p><!-- .form-section-url .form-section -->';

	$comment_field = '<p class="gforms-placeholder gform_wrapper comment-form-comment">' .
					'<label for="comment">' . __( 'Comment', 'wsm' ) . '</label>' .
	                  '<textarea id="comment" name="comment" placeholder="' . __( 'Comment', 'wsm' ) . '" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' . // With placeholder
	                  // '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' . // No Placeholder
	                 '</p>';

	$args = array(
		'fields'               => array(
			'author' => $author,
			'email'  => $email,
			'url'    => $url,
		),
		'comment_field'        => $comment_field,
		'title_reply'          => __( 'Leave a Comment', 'wsm' ),
		'label_submit' => __( 'Post Comment', 'wsm' ), //default='Post Comment'
		'title_reply_to' => __( 'Reply', 'wsm' ), //Default: __( 'Leave a Reply to %s' )
		'cancel_reply_link' => __( 'Cancel', 'wsm' ),//Default: __( 'Cancel reply' )
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
	);

	/** Merge $args with $defaults */
	$args = wp_parse_args( $args, $defaults );

		/** Return filterable array of $args, along with other optional variables */
	return apply_filters( 'genesis_comment_form_args', $args, $user_identity, $id, $commenter, $req, $aria_req );

}