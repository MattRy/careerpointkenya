<?php 
// Updates for TKT 1412/1413

/**
 * CPTUI Function to create and register Job Posting Custom Post Type. 
 * Code crated by CPTUI plugin, exported and then added here. 
 *
 * @return void
 */
function cptui_register_my_cpts() {

	/**
	 * Post Type: Job Postings.
	 */

	$labels = array(
		"name" => __( "Jobs", "wsm" ),
		"singular_name" => __( "Job", "wsm" ),
		"menu_name" => __( "Jobs", "wsm" ),
		"add_new" => __( "Add New Job", "wsm" ),
		"add_new_item" => __( "Add New Job", "wsm" ),
		"edit_item" => __( "Edit Job", "wsm" ),
		"new_item" => __( "New Job", "wsm" ),
		"view_item" => __( "View Job", "wsm" ),
		"view_items" => __( "View Jobs", "wsm" ),
		"archives" => __( "Job Archives", "wsm" ),
		"items_list" => __( "Jobs List", "wsm" ),
	);

	$args = array(
		"label" => __( "Jobs", "wsm" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => "jobs",
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "job", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "dashicons-megaphone",
		"supports" => array( "editor", "title", "genesis-cpt-archives-settings" ),
		"taxonomies" => array( "category", "post_tag", "employment_type" ),
	);

	register_post_type( "job_posting", $args );
}
add_action( 'init', 'cptui_register_my_cpts' );


// Add Job Posting CPT to main RSS feed.
function wsm_add_cpt_to_feed( $query ) {
	if ( $query->is_feed() )
		$query->set( 'post_type', array( 'post', 'job_posting' ) ); 
	return $query;
}
add_filter( 'pre_get_posts', 'wsm_add_cpt_to_feed' );

/**
 * Tweak the placeholder for the Job_Posting CPT Add New meta box. 
 */
add_filter('gettext','wsm_custom_enter_job_post_title');
function wsm_custom_enter_job_post_title( $input ) {
    global $post_type;
    if( is_admin() && 'Enter title here' == $input && 'job_posting' == $post_type )
        return 'Enter Title for this Job Post';
    return $input;
}
