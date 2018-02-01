<?php
/* 
Template  Name: front-page
*/

/**
 * This file adds the Front Page to the careerpointkenya2.0 theme.
 *
 * @author Web Savvy Marketing
 * @package careerpointkenya2.0
 * @subpackage Customizations
 */
 

//* Hook first ad space widget area after site header
add_action( 'genesis_before_loop', 'wsm_add_front_page_top_ad_space_widget' );
function wsm_add_front_page_top_ad_space_widget() {

	if ( get_query_var( 'paged' ) >= 2 ) { 
		//* Do something different on following pages 
	}

	genesis_widget_area( 'front-page-top-ad-space', array(
		'before' => '<div class="front-page-top-ad-space">',
		'after'  => '</div>',
	) );

}
//* Add widget area after selected posts on front page
add_action( 'genesis_after_entry', 'wsm_front_page_ad_widgets' );
function wsm_front_page_ad_widgets() {
	if ( ! is_front_page() )	return;

	global $wp_query;
	if ( 1 == $wp_query->current_post ) {   //* Dump it out after the 2nd post
		genesis_widget_area( 'front-page-content-ad-1', array(
			'before' => '<div class="home-mid-content-ad clearfix">',
			'after'  => '</div>',
		) );
	} elseif ( 4 == $wp_query->current_post ) {  //* Dump it out after the 5th post
		genesis_widget_area( 'front-page-content-ad-2', array(
			'before' => '<div class="home-mid-content-ad clearfix">',
			'after'  => '</div>',
		) );
	}
}
//* Run the Genesis function
genesis();
