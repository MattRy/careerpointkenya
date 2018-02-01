<?php
/**
 * CPK Settings
 *
 * This file registers all of CPK's specific Theme Settings, accessible from
 * Genesis --> CPK Settings.
 *
 * NOTE: Change out "CPK" in this file with name of theme and delete this note
 */ 
 
/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 *
 * @since 1.0.0
 *
 * @package cpk
 * @subpackage CPK_Settings
 */
class CPK_Settings extends Genesis_Admin_Boxes {
	
	/**
	 * Create an admin menu item and settings page.
	 * @since 1.0.0
	 */
	function __construct() {
		
		// Specify a unique page ID. 
		$page_id = 'cpk';
		
		// Set it as a child to genesis, and define the menu and page titles
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Career Point Kenya Settings', 'cpk' ),
				'menu_title'  => __( 'Career Point Kenya Settings', 'cpk' ),
				'capability' => 'manage_options',
			)
		);
		
		// Set up page options. These are optional, so only uncomment if you want to change the defaults
		$page_ops = array(
		//	'screen_icon'       => 'options-general',
		//	'save_button_text'  => 'Save Settings',
		//	'reset_button_text' => 'Reset Settings',
		//	'save_notice_text'  => 'Settings saved.',
		//	'reset_notice_text' => 'Settings reset.',
		);		
		
		// Give it a unique settings field. 
		// You'll access them from genesis_get_option( 'option_name', 'cpk-settings' );
		$settings_field = 'cpk-settings';
		
		// Set the default values
		$default_settings = array(
			'wsm_copyright' => 'My Name, All Rights Reserved',
			'wsm_credit' => 'Website by Web Savvy Marketing',
			);
		
		// Create the Admin Page
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		// Initialize the Sanitization Filter
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );
			
	}

	/** 
	 * Set up Sanitization Filters
	 * @since 1.0.0
	 *
	 * See /lib/classes/sanitization.php for all available filters.
	 */	
	function sanitization_filters() {
	
		genesis_add_option_filter( 'no_html', $this->settings_field,
			array(
			'wsm_home_title',
			'wsm_site_url',
			'wsm_site_url_target',
		));
					
		genesis_add_option_filter( 'safe_html', $this->settings_field,
			array(
				'wsm_site_title',
				'wsm_copyright',
				'wsm_credit',
			) );
	}
	
	/**
	 * Set up Help Tab
	 * @since 1.0.0
	 *
	 * Genesis automatically looks for a help() function, and if provided uses it for the help tabs
	 * @link http://wpdevel.wordpress.com/2011/12/06/help-and-screen-api-changes-in-3-3/
	 */
	 function help() {
	 	$screen = get_current_screen();

		$screen->add_help_tab( array(
			'id'      => 'sample-help', 
			'title'   => 'Sample Help',
			'content' => '<p>Help content goes here.</p>',
		) );
	 }
	
	/**
	 * Register metaboxes on Child Theme Settings page
	 * @since 1.0.0
	 */
	function metaboxes() {
		//add_meta_box('wsm_title_metabox', 'Site Title', array( $this, 'wsm_title_metabox' ), $this->pagehook, 'main', 'high');
		add_meta_box('wsm_home_metabox', 'Site Title', array( $this, 'wsm_home_metabox' ), $this->pagehook, 'main', 'high');
		add_meta_box('wsm_footer_info_metabox', 'Footer Info', array( $this, 'wsm_footer_info_metabox' ), $this->pagehook, 'main', 'high');
	}
	
	

	/**
	 * Heading Info Metabox
	 * @since 1.0.0
	 */
	function wsm_title_metabox() {
	
		echo '<p><strong>Replace Site Title:</strong></p>';
		echo '<p><input type="text" name="' . $this->get_field_name( 'wsm_site_title' ) . '" id="' . $this->get_field_id( 'wsm_site_title' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_site_title' ) ) . '" size="70" /></p>';
		
		echo '<p><strong>Replace Site Title URL:</strong></p>';
		echo '<p><input type="text" name="' . $this->get_field_name( 'wsm_site_url' ) . '" id="' . $this->get_field_id( 'wsm_site_url' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_site_url' ) ) . '" size="70" /></p>';
	
		echo '<input type="checkbox" name="' . $this->get_field_name( 'wsm_site_url_target' ) . '" id="' . $this->get_field_id( 'wsm_site_url_target' ) . '" value="1"';
        checked( 1, $this->get_field_value( 'wsm_site_url_target' ) ); echo '/>';
                
        echo '<label for="' . $this->get_field_id( 'wsm_site_url_target' ) . '">' . __( 'Open Link in a New Tab</em></strong>', 'wsm' ) . '</label>';
 
	}
	
	/**
	 * Heading Info Metabox
	 * @since 1.0.0
	 */
	function wsm_home_metabox() {
	
		echo '<p><strong>Home Page Heading:</strong></p>';
		echo '<p><input type="text" name="' . $this->get_field_name( 'wsm_home_title' ) . '" id="' . $this->get_field_id( 'wsm_home_title' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_home_title' ) ) . '" size="70" /></p>';
	}
		

	/**
	 * Footer Info Metabox
	 * @since 1.0.0
	 */
	function wsm_footer_info_metabox() {

		echo '<p><strong>Copyright Info:</strong></p>';
		echo '<p><input type="text" name="' . $this->get_field_name( 'wsm_copyright' ) . '" id="' . $this->get_field_id( 'wsm_copyright' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_copyright' ) ) . '" size="90" /></p>';

		echo '<p><strong>Credit Info:</strong></p>';
		echo '<p><input type="text" name="' . $this->get_field_name( 'wsm_credit' ) . '" id="' . $this->get_field_id( 'wsm_credit' ) . '" value="' . esc_attr( $this->get_field_value( 'wsm_credit' ) ) . '" size="90" /></p>';
		
	}

	
}

/**
 * Add the Theme Settings Page
 * @since 1.0.0
 */
function cpk_add_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new CPK_Settings;	 	
}
add_action( 'genesis_admin_menu', 'cpk_add_settings' );

/**
 * Add Soliloquy key
 *
 * @since 1.0.0
 */
// Soliloquy License
if ( ! get_option( 'soliloquy_license_key' ) )
	update_option( 'soliloquy_license_key', SOLILOQUY_LICENSE_KEY );
