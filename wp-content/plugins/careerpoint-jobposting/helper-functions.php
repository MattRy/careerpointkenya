<?php

 /**
 * load evaluation archive template
 * @param  template $archive_template requires Genesis
 *
 * @since  1.0.0
 */
function wsm_cpk_load_archive_template( $archive_template ) {
	if ( is_post_type_archive( array('job_posting') ) ) {
		return dirname( __FILE__ ) . '/views/single-job_posting.php';
	}
	return false;
}

/**
 * load single evaluation template
 * 
 * @param  template $single_template requires Genesis
 * @since 1.0.0
 */
function wsm_cpk_load_single_template( $single_template ) {
	if ( is_singular( 'job_posting' )  || is_post_type_archive('job_posting') ) {
		return dirname( __FILE__ ) . '/views/single-job_posting.php';
	}
	return false;
}