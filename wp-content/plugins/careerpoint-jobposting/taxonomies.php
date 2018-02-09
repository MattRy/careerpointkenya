<?php
/**
 * Include the taxonomy for the custom post type.
 *
 */
function cptui_register_my_taxes_employment_type() {

	/**
	 * Taxonomy: Employment Types.
	 */

	$labels = array(
		"name" => __( "Employment Types", "wsm" ),
		"singular_name" => __( "Employment Type", "wsm" ),
	);

	$args = array(
		"label" => __( "Employment Types", "wsm" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Employment Types",
		"show_ui" => true,  
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'employment-type', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "employment_type", array( "job_posting" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_employment_type' );