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

add_filter( 'pre_get_posts', 'wsm_cpk_show_cpt_archives' );
add_action( 'pre_get_posts', 'wsm_cpk_add_custom_post_types_to_loop' );
/**
 * wsm_cpk_show_cpt_archives - Display job posting entires on taxonomy archive pages
 *
 * @param [type] $query
 * @return void
 */
function wsm_cpk_show_cpt_archives( $query ) {
	if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) { 
		$query->set( 'post_type', array(
			'post', 'nav_menu_item', 'job_posting'
		));
		return $query;
	}
}

/**
 * wsm_cpk_add_custom_post_types_to_loop - Add JobPosting CPT to front page loop.
 *
 * @param [type] $query
 * @return void
 */
function wsm_cpk_add_custom_post_types_to_loop( $query ) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'post', 'job_posting' ) );
		return $query;
    }
}

/**
 * Add a little intro above the post editor screen for Job_post CPT. 
 */
add_action( 'edit_form_after_title', 'wsm_add_editor_intro' );
function wsm_add_editor_intro() {
	global $post, $post_type;
	if( is_admin() && 'job_posting' == $post_type ) { 
		echo 'Enter full job description in box below, including, but not limited to: education requirements, experience needed, recommended skills, job responsibilities, benefits, application requirements, salary, etc.';
	}
}