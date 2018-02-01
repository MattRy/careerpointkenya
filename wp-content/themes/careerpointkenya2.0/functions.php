<?php

add_action( 'after_setup_theme', 'cpk_i18n' );
/**
 * Load the child theme textdomain for internationalization.
 *
 * Must be loaded before Genesis Framework /lib/init.php is included.
 * Translations can be filed in the /languages/ directory.
 *
 * @since 1.2.0
 */
function cpk_i18n() {
    load_child_theme_textdomain( 'cpk', get_stylesheet_directory() . '/languages' );
}

//add_action( 'wp_enqueue_scripts', 'cpk_enqueue_assets' );
/**
 * Enqueue theme assets.
 */
function cpk_enqueue_assets() {
	wp_enqueue_style( 'cpk', get_stylesheet_uri() );
	wp_style_add_data( 'cpk', 'rtl', 'replace' );
}

// Start the engine
require_once(TEMPLATEPATH.'/lib/init.php');
require_once( 'lib/init.php' );

// Calls the theme's constants & files
cpk_init();

// Editor Styles
add_editor_style( 'editor-style.css' );


// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'cpk_add_viewport_meta_tag' );
function cpk_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}


// Force Stupid IE to NOT use compatibility mode
add_filter( 'wp_headers', 'cpk_keep_ie_modern' );
function cpk_keep_ie_modern( $headers ) {
        if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) ) {
                $headers['X-UA-Compatible'] = 'IE=edge,chrome=1';
        }
        return $headers;
}

// Accessibility features. Remove if not required
add_theme_support( 'genesis-accessibility', array(
	//'headings',
	'drop-down-menu',
	'search-form',
	//'skip-links',
	'rems',
) );

// Add new image sizes
add_image_size('Blog Thumbnail', 83, 83, TRUE);
add_image_size('Featured Post', 475, 260, TRUE);

//* Relocate the post image (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

// Customize the Search Box
add_filter( 'genesis_search_button_text', 'custom_search_button_text' );
function custom_search_button_text( $text ) {
    return esc_attr( 'Go' );
}
// Modify the author box display
add_filter( 'genesis_author_box', 'cpk_author_box' );
function cpk_author_box() {
	$authinfo = '';
	$authdesc = get_the_author_meta('description');

	if( !empty( $authdesc ) ) {
		$authinfo .= sprintf( '<section %s>', genesis_attr( 'author-box' ) );
		$authinfo .= '<h3 class="author-box-title">' . __( 'About ', 'cpk' ) . get_the_author_meta( 'display_name' ) . '</h3>';
		$authinfo .= get_avatar( get_the_author_id() , 75, '', get_the_author_meta( 'display_name' ) . '\'s avatar' ) ;
		$authinfo .= '<div class="author-box-content" itemprop="description">';
		$authinfo .= '<p>' . get_the_author_meta( 'description' ) . '</p>';
		$authinfo .= '</div>';
		$authinfo .= '</section>';
	}
	if ( is_author() || is_single() ) {
		echo $authinfo;
	}
}


//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter( $post_info ) {
$post_info = '[post_date before=""] [post_time format="g:i a" before="at "]';
return $post_info;
}


// Customize the post meta function
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter( $post_meta ) {
	if ( ! is_singular( 'post' ) )  return;
    $post_meta = '[post_categories sep=", " before="Job Category: "] [post_tags sep=", " before="Employer: "]';
    return $post_meta;
}

add_action( 'admin_menu', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
    remove_menu_page('ad-inserter.php');   
}

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
//remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Add Read More button to blog page and archives
//  Added Read More link code back per ticket # 697. 
add_filter( 'excerpt_more', 'cpk_add_excerpt_more' );
add_filter( 'get_the_content_more_link', 'cpk_add_excerpt_more' );
add_filter( 'the_content_more_link', 'cpk_add_excerpt_more' );
function cpk_add_excerpt_more( $more ) {
    return '<span class="more-link"><a href="' . get_permalink() . '" rel="dofollow">' . __( 'Read More', 'cpk' ) . '</a></span>';
    // return '...';
}

function hide_plugin() {
  global $wp_list_table;
  $hidearr = array('ad-inserter/ad-inserter.php');
  $myplugins = $wp_list_table->items;
  foreach ($myplugins as $key => $val) {
    if (in_array($key,$hidearr)) {
      unset($wp_list_table->items[$key]);
    }
  }
}

add_action('pre_current_active_plugins', 'hide_plugin');




function hide_plugin_trickspanda() {
  global $wp_list_table;
  $hidearr = array('adminimize/adminimize.php');
  $myplugins = $wp_list_table->items;
  foreach ($myplugins as $key => $val) {
    if (in_array($key,$hidearr)) {
      unset($wp_list_table->items[$key]);
    }
  }
}

add_action('pre_current_active_plugins', 'hide_plugin_trickspanda');



/*
 * Add support for targeting individual browsers via CSS
 * See readme file located at /lib/js/css_browser_selector_readm.html
 * for a full explanation of available browser css selectors.
 */
add_action( 'get_header', 'cpk_load_scripts' );
function cpk_load_scripts() {
    wp_enqueue_script( 'browserselect', CHILD_URL . '/lib/js/css_browser_selector.js', array('jquery'), '0.4.0', TRUE );
}

// Structural Wrap
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
) );


// Changes Default Navigation to Primary & Footer

add_theme_support ( 'genesis-menus' ,
	array (
		'primary'   => __( 'Header Navigation Menu', 'cpk' ),
		'secondary'   => __( 'Secondary Navigation Menu', 'cpk' ),
		'footer'    => __( 'Footer Navigation Menu', 'cpk' ),
	)
);


//* Unregister Layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Add support for 3-column footer widgets
//add_theme_support( 'genesis-footer-widgets', 3);

//* Add support for after entry widget

//add_theme_support( 'genesis-after-entry-widget-area' );

// Setup Sidebars
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );

genesis_register_sidebar( array(
	'id'			=> 'front-page-top-ad-space',
	'name'			=> __( 'Front Page Top Ad Space', 'wsm' ),
	'description'	=> __( 'This is the Front Page Top Ad Space.', 'wsm' ),
	'before_title' => '<h2 class="widget-title widgettitle">',
    'after_title' => '</h2>',
) );
genesis_register_sidebar( array(
	'id'			=> 'front-page-content-ad-1',
	'name'			=> __( 'Front Page Content Intermixed Ad 1', 'wsm' ),
	'description'	=> __( 'This is the Front Page Front Page Content Intermixed Ad Space 1. Displayed after 2nd post.', 'wsm' ),
	'before_title' => '<h2 class="widget-title widgettitle">',
    'after_title' => '</h2>',
) );
genesis_register_sidebar( array(
	'id'			=> 'front-page-content-ad-2',
	'name'			=> __( 'Front Page Content Intermixed Ad 2', 'wsm' ),
	'description'	=> __( 'This is the Front Page Front Page Content Intermixed Ad Space 2. Displayed after 5th post.', 'wsm' ),
	'before_title' => '<h2 class="widget-title widgettitle">',
    'after_title' => '</h2>',
) );
genesis_register_sidebar( array(
	'id'			=> 'home-content-top-left',
	'name'			=> __( 'Home Content Top Left', 'wsm' ),
	'description'	=> __( 'This is the Home Page Left-Side Content Area.', 'wsm' ),
	'before_title' => '<h2 class="widget-title widgettitle">',
    'after_title' => '</h2>',
) );
genesis_register_sidebar( array(
	'id'			=> 'home-content-top-right',
	'name'			=> __( 'Home Content Top Right', 'wsm' ),
	'description'	=> __( 'This is the Home Page Right-Side Content Area.', 'wsm' ),
	'before_title' => '<h2 class="widget-title widgettitle">',
    'after_title' => '</h2>',
) );
genesis_register_sidebar( array(
	'id'			=> 'home-content-bottom-left',
	'name'			=> __( 'Home Content Bottom Left', 'wsm' ),
	'description'	=> __( 'This is the Home Page Left-Side Content Area.', 'wsm' ),
	'before_title' => '<h2 class="widget-title widgettitle">',
    'after_title' => '</h2>',
) );
genesis_register_sidebar( array(
	'id'			=> 'home-content-bottom-right',
	'name'			=> __( 'Home Content Bottom Right', 'wsm' ),
	'description'	=> __( 'This is the Home Page Right-Side Content Area.', 'wsm' ),
	'before_title' => '<h2 class="widget-title widgettitle">',
    'after_title' => '</h2>',
) );
genesis_register_sidebar( array(
	'id'			=> 'home-sidebar',
	'name'			=> __( 'Home Sidebar', 'wsm' ),
	'description'	=> __( 'This is the Home Page Sidebar.', 'wsm' ),
	'before_title' => '<h2 class="widget-title widgettitle">',
    'after_title' => '</h2>',
) );
genesis_register_sidebar( array(
	'id'			=> 'archive-content-ad',
	'name'			=> __( 'Archive Pages Content Ad', 'wsm' ),
	'description'	=> __( 'For the code for the first ad on Archive Pages.', 'wsm' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'archive-bottom-ad',
	'name'			=> __( 'Archive Pages Bottom Ad', 'wsm' ),
	'description'	=> __( 'For the code for the second ad on Archive Pages.', 'wsm' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'blog-sidebar',
	'name'			=> __( 'Blog Post Sidebar', 'wsm' ),
	'description'	=> __( 'This is the Blog Posts Sidebar.', 'wsm' ),
	'before_title' => '<h4 class="widget-title widgettitle">',
    'after_title' => '</h4>',
) );
genesis_register_sidebar( array(
	'id'			=> 'page-sidebar',
	'name'			=> __( 'Page Sidebar', 'wsm' ),
	'description'	=> __( 'This is the Page Sidebar.', 'wsm' ),
	'before_title' => '<h4 class="widget-title widgettitle">',
    'after_title' => '</h4>',
) );
genesis_register_sidebar( array(
	'id'			=> 'archives-sidebar',
	'name'			=> __( 'Archives Sidebar', 'wsm' ),
	'description'	=> __( 'This is the Post Archives Sidebar.', 'wsm' ),
	'before_title' => '<h3 class="widget-title widgettitle">',
    'after_title' => '</h3>',
) );


//* Manually insert Cat Title to Blog Categories

function ea_default_term_title( $value, $term_id, $meta_key, $single ) {
	if( ( is_category() || is_tag() || is_tax() ) && 'headline' == $meta_key && ! is_admin() ) {

		// Grab the current value, be sure to remove and re-add the hook to avoid infinite loops
		remove_action( 'get_term_metadata', 'ea_default_term_title', 10 );
		$value = get_term_meta( $term_id, 'headline', true );
		add_action( 'get_term_metadata', 'ea_default_term_title', 10, 4 );
		// Use term name if empty
		if( empty( $value ) ) {
			$term = get_term_by( 'term_taxonomy_id', $term_id );
			$value = $term->name;
		}

	}
	return $value;
}
//add_filter( 'get_term_metadata', 'ea_default_term_title', 10, 4 );

//* Manually insert Cat Title to Blog Categories
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_action('genesis_before_loop','wsm_cat_title', 16);
function wsm_cat_title () {
	if( is_category() || is_tag() || is_tax() ) {
		global $wp_query;
		$term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();
		$intro_text = apply_filters( 'genesis_term_intro_text_output', $term->meta['intro_text'] );
		printf('<div class="archive-description"><h1 class="archive-title">%1$s</h1>%2$s</div>', single_cat_title( '', false ), $intro_text);
	}
}

//* Add description
add_action( 'genesis_before_loop', 'wsm_output_category_info', 17 );
function wsm_output_category_info() {
	if ( is_category() || is_tag() || is_tax() ) {
		echo term_description();
	}
}

// Remove Post Info from Archive Pages
// Per TKT 1227 - Add this back in and remove the time from the post meta
function wsm_remove_post_meta() {
	if (is_archive()) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		}
}
// add_action ( 'genesis_entry_header', 'wsm_remove_post_meta' );

//* Customize the entry meta in the entry header - only want date, no time.
//* Format of date set in dashboard General Settings | Date Format
add_filter( 'genesis_post_info', 'wsm_sp_post_info_filter' );
function wsm_sp_post_info_filter($post_info) {
	$post_info = '[post_date]';
	return $post_info;
}

//* Add widget area after the third post in archives
add_action( 'genesis_after_entry', 'wsm_archive_widgets' );
function wsm_archive_widgets() {
	if ( ! is_archive() )	return;

	global $wp_query;
	if ( 2 == $wp_query->current_post ) {
		genesis_widget_area( 'archive-content-ad', array(
			'before' => '<div class="archive-ad archive-content-ad clearfix">',
			'after'  => '</div>',
		) );
	}
}

//* Add widget area after above archive page nav
add_action( 'genesis_after_endwhile', 'wsm_add_bottom_ad_archives', 5 );
function wsm_add_bottom_ad_archives() {
	if ( !is_archive() )	return;
	genesis_widget_area( 'archive-bottom-ad',
        array(
            'before' => '<div class="archive-ad archive-bottom-ad clearfix">',
			'after'  => '</div>',
        )
    );
}

//* Update Site Name
// add_action( 'get_header', 'eccu_custom_logo_url' );
function eccu_custom_logo_url() {

	add_filter( 'genesis_seo_title', 'be_logo_url', 10, 3 );
	function be_logo_url( $title, $inside, $wrap ) {

			$site_title = genesis_get_option( 'wsm_site_title', 'cpk-settings' );
			$site_url = genesis_get_option( 'wsm_site_url', 'cpk-settings' );
			$site_url_target = genesis_get_option( 'wsm_site_url_target', 'cpk-settings' );

			// Title
			$cpk_title = '';
			if ( $site_title ) { $cpk_title = $site_title ; }
			else { $cpk_title = get_bloginfo( 'name' ); }

			// URL
			$cpk_url_target = '';
			if ( $site_url ) { $cpk_url = $site_url; }
			else { $cpk_url = get_bloginfo( 'url' ); }

			// URL Target
			$cpk_url_target = '';
			if ( $site_url_target ) { $cpk_url_target = 'target="_blank"'; }
			else { $cpk_url_target= 'target="_self"'; }


		$inside = sprintf( '<a href="%s" title="%s" '. $cpk_url_target .'>%s</a>', esc_url( $cpk_url ) , esc_attr( $cpk_title ), $cpk_title );
		$title = sprintf( '<%s class="site-title" itemprop="headline">%s</%s>', $wrap, $inside, $wrap );
		return $title;


	}
}




/** Move Genesis Comments */
add_action( 'genesis_before_comments' , 'eo_move_comments' );
function eo_move_comments ()
{
  if ( is_single() && have_comments() )
  {
    remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );
    add_action( 'genesis_comments', 'genesis_do_comment_form', 5 );
  }
}



add_action( 'wp_enqueue_scripts', 'wsm_move_scripts' );
function wsm_move_scripts() {

    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'jquery-migrate' );
    wp_dequeue_script( 'admin-bar' );

    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    wp_register_script( 'jquery-migrate', includes_url( '/js/jquery/jquery-migrate.min.js' ), false, NULL, true );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-migrate' );
    wp_enqueue_script( 'admin-bar' );

}

//add_action( 'wp_head', 'wsm_add_google_fonts', 7 );
function wsm_add_google_fonts() {

	global $wp_version;

	echo "\n";
	foreach( array(
		'karla' => 'http://fonts.googleapis.com/css?family=Karla:400,700,400italic);',
		'roboto' => 'http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,400italic,300);',
		) as $key => $url ) {

			printf( "<link rel='stylesheet' id='%s-css'  href='%s' type='text/css' media='all' />\n", $key, add_query_arg( array( 'ver' => $wp_version ), $url ) );

	}

}

add_filter('genesis_title_comments', 'cpk_comment_text');
function cpk_comment_text() {
	return ('<p class="comment-title">Comments</p>');
}

//* Modify the speak your mind title in comments
add_action( 'comment_form_before', 'my_comment_form_before' );
function my_comment_form_before() {
    ob_start();
}

add_action( 'comment_form_after', 'my_comment_form_after' );
function my_comment_form_after() {
    $html = ob_get_clean();
    $html = preg_replace(
        '/<h3 id="reply-title"(.*)>(.*)<\/h3>/',
        '<p class="reply-title"\1>\2</p>',
        $html
    );
    echo $html;
}

//Insert ads after second paragraph of single post content.
// Function commented out in favor of plugin solution. However we're keeping the
// code here for potential use in the future.
//add_filter( 'the_content', 'wsm_insert_post_ads' );
function wsm_insert_post_ads( $content ) {

	$ad_code = '<div class="content-ad-block"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Top Posts 300 250 -->
<ins class="adsbygoogle"
     style="display:block;width:300px;height:250px"
     data-ad-client="ca-pub-2169025261524250"
     data-ad-slot="4828803481"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>';

	if ( is_single() && ! is_admin() ) {
		// return wsm_insert_after_paragraph( $ad_code, 2, $content );
	}

	return $content;
}

// Parent Function that makes the magic happen
 function wsm_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p = '</p>';
	$paragraphs = explode( $closing_p, $content );
	foreach ($paragraphs as $index => $paragraph) {

		if ( trim( $paragraph ) ) {
			$paragraphs[$index] .= $closing_p;
		}

		if ( $paragraph_id == $index + 1 ) {
			$paragraphs[$index] .= $insertion;
		}
	}

	return implode( '', $paragraphs );
}


// Add Page title to Blog Page Template
add_action( 'genesis_before_loop', 'wsm_add_blog_page_title' );
function wsm_add_blog_page_title() {
	if( is_page_template( 'page_blog.php' ) ) {
		echo '<header class="entry-header">';
		the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>');
		echo '</header>';
	}
}


/**
 * Re-prioritise Genesis SEO metabox from high to default.
 *
 * Copied and amended from /lib/admin/inpost-metaboxes.php, version 2.0.0.
 *
 * @since 1.0.0
 */
function ea_add_inpost_seo_box() {
	if ( genesis_detect_seo_plugins() )
		return;
	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-seo' ) )
			add_meta_box( 'genesis_inpost_seo_box', __( 'Theme SEO Settings', 'genesis' ), 'genesis_inpost_seo_box', $type, 'normal', 'default' );
	}
}
add_action( 'admin_menu', 'ea_add_inpost_seo_box' );
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );

/**
 * Re-prioritise layout metabox from high to default.
 *
 * Copied and amended from /lib/admin/inpost-metaboxes.php, version 2.0.0.
 *
 * @since 1.0.0
 */
function ea_add_inpost_layout_box() {
	if ( ! current_theme_supports( 'genesis-inpost-layouts' ) )
		return;
	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-layouts' ) )
			add_meta_box( 'genesis_inpost_layout_box', __( 'Layout Settings', 'genesis' ), 'genesis_inpost_layout_box', $type, 'normal', 'default' );
	}
}
add_action( 'admin_menu', 'ea_add_inpost_layout_box' );
remove_action( 'admin_menu', 'genesis_add_inpost_layout_box' );