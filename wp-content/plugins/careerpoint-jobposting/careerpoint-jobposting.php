<?php
/*
Plugin Name: Careerpoint JobPosting
Plugin URI: http://www.web-savvy-marketing.com/
Description: Adds the JobPosting schema.org meta boxes to post editing screen.
Author: Web Savvy Marketing
Version: 1.0
Author URI: http://www.web-savvy-marketing.com/
Text Domain: careerpoint-jobposting
*/

namespace WebSavvyMarketing\CareerpointJobPosting;

//* Set up rewrite rules flushing on plugin activation/deactivation. Get rid of nasty 404 errors. 
register_activation_hook(   __FILE__, 'cptui_register_my_cpts_activation' );
register_deactivation_hook( __FILE__, 'cptui_register_my_cpts_deactivation' );


// Get all the things
require_once( dirname( __FILE__ ) . '/post-types.php' );
require_once( dirname( __FILE__ ) . '/metaboxes.php' );
require_once( dirname( __FILE__ ) . '/taxonomies.php' );
require_once( dirname( __FILE__ ) . '/helper-functions.php' );

// Set up templates for new post type
add_filter( 'single_template', 'wsm_cpk_load_single_template' );