<?php
/*
Template Name: Careerpoint JobPosting - Single Job Posting View
Plugin URI: http://www.web-savvy-marketing.com/
Description: Adds the JobPosting schema.org meta boxes to post editing screen.
Author: Web Savvy Marketing
Version: 1.0
Author URI: http://www.web-savvy-marketing.com/
Text Domain: careerpoint-jobposting
*/

//* Custom entry
add_action( 'genesis_after_entry_content', 'jobposting_single_entry' );

function jobposting_single_entry() {

	$post_id = get_the_ID( $post->ID );
	
	$prefix = '_careerpoint_jobposting_';

	// Get meta data from CPT
	$jp_valid_through 		= get_post_meta( $post_id, $prefix . 'valid_through', true );

	$jp_job_location 		= get_post_meta( $post_id, $prefix . 'job_location_locality', true );
	$jp_job_location_region = get_post_meta( $post_id, $prefix . 'job_location_region', true );

	// Add in country (region) if present. Locality is required. 
	if ( $jp_job_location_region ) $jp_job_location .= ', ' . $jp_job_location_region;

	?>
	<p class="jp-entry-meta">
	<span class="jp-meta-content">VALID THROUGH: <strong><?php echo $jp_valid_through; ?> </strong></span><br>
	<span class="jp-meta-content">LOCATION: <strong><?php echo $jp_job_location; ?> </strong></span>
	</p>
	<?php

}
genesis();
