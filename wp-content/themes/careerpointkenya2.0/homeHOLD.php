<?php

do_action( 'genesis_home' );

// Remove the standard loop 
remove_action( 'genesis_loop', 'genesis_do_loop' );
	
// Execute custom child loop
add_action( 'genesis_loop', 'cpk_home_loop_helper' ); 
function cpk_home_loop_helper() {	
echo '<div class="main-content">';
$home_title = genesis_get_option( 'wsm_home_title', 'cpk-settings' );
if ( $home_title ) { echo '<h1 class="home-title">'. $home_title .'</h1>'; }
	genesis_widget_area( 'home-content-top-left', array( 'before' => '<div class="one-half first home-content-top-left widget-area">', 'after' => '</div>') );
	genesis_widget_area( 'home-content-top-right', array( 'before' => '<div class="one-half home-content-top-right widget-area">', 'after' => '</div>') );
	genesis_widget_area( 'home-content-bottom-left', array( 'before' => '<div class="one-half first home-content-bottom-left widget-area">', 'after' => '</div>') );
	genesis_widget_area( 'home-content-bottom-right', array( 'before' => '<div class="one-half home-content-bottom-right widget-area">', 'after' => '</div>') );
echo '</div>';
}


genesis();