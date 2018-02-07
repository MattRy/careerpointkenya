<?php
/**
 * The custom jobposting archive template.
 * Description: Adds the JobPosting schema.org meta boxes to post editing screen.
 * Author: Web Savvy Marketing
 * Version: 1.0
 * Author URI: http://www.web-savvy-marketing.com/
 * Text Domain: careerpoint-jobposting
 */

// Do good stuff.

/**
 * Remove the standard loop
 */

// remove_action( 'genesis_loop', 'genesis_do_loop' );

//* Custom Loop
// add_action( 'genesis_loop', 'jobposting_loop' );

function jobposting_loop() {
	echo '<div class="jobposting-entries">';
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			global $post;
			global $wp_query;
			$post_id = get_the_ID( $post->ID );

			$jp_content = '';
			$post_id = get_the_ID( $post->ID );

			$prefix = '_careerpoint_jobposting_';
			$jp_excerpt = substr( get_post_meta( $post_id, $prefix . 'description', true ), 0, 200 );
			$jp_date_posted = get_post_meta( $post_id, $prefix . 'date_posted', true );
			
			// Load up output string
			$jp_content .= sprintf('<div class="entry-title"><a href="%s" rel="dofollow">%s</a></span></div>', get_permalink( $post_id ), get_the_title( $post_id ) );
			$jp_content .= sprintf('<p>%s</p>', get_the_date() );
			$jp_content .= sprintf('<p>%s</p>', $jp_excerpt );
			$jp_content .= sprintf('<span class="more-link"><a href="%s" rel="dofollow">Read More</a></span>', get_permalink( $post_id ) ); 
			$jp_content .= '<hr>';

			// Dump everything out
			printf( '<article class="jobpost-archive-entry">%s</article>', $jp_content );

// Dump out a widget area every 3rd post. 
			if ( 2 == $wp_query->current_post ) {
				genesis_widget_area( 'archive-content-ad', array(
					'before' => '<div class="archive-ad archive-content-ad clearfix">',
					'after'  => '</div>',
				) );
			}

		endwhile;
		genesis_posts_nav();
	endif;
	echo '</div>';

	//* Restore original query
	wp_reset_query();
}
genesis();
