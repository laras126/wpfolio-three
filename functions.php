<?php

// ----
// ---- Include Files
// ----

// Sets up the options panel and default functions
require_once( get_template_directory() . '/extensions/options-functions.php' );

/*
1. library/bones.php
	- theme support functions
	- custom menu output & fallbacks
	- page-navi function
	- customizing the post excerpt
*/
// require_once('library/bones.php');

/*
2. library/wpfolio.php
	- WPFolio features functions
		- Wide margins shortcode
	- Call Options Framework
*/
require_once('library/wpfolio.php');

/*
4. library/translation/translation.php
	- adding support for other languages
*/
require_once('library/translation/translation.php');


/*
5. extensions/class-tgm-plugin-activation.php
	- Require/recommend some plugins
	- https://github.com/thomasgriffin/TGM-Plugin-Activation
*/

require_once get_template_directory() . '/extensions/class-tgm-plugin-activation.php';

/*

Hello!

This theme was originally built using the starter theme
Bones (http://themble.com) but has since been refactored
to fit WordPress's theme repo standards using 
Underscores (http://underscores.me) as a guide.

*/

// ----
// ---- Add everything to the theme
// ----

if ( ! isset( $content_width ) ) $content_width = 960;

add_action('after_setup_theme','wpf_setup');

function wpf_setup() {

	// Multi language support
	load_theme_textdomain( 'wpfolio', get_template_directory() . '/library/translation' );

	// Support for RSS links in header
	add_theme_support('automatic-feed-links');

	// Custom menus
	add_theme_support( 'menus' );

	// Register main menu in header
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'wpfolio' )
		)
	);

	// Post thumbnails
	add_theme_support('post-thumbnails');

    // default thumb size
	set_post_thumbnail_size(300, 300);

	// // Customize the Media option defaults
	// // http://wordpress.org/support/topic/how-set-default-image-size
	// update_option('thumbnail_size_w', 300);
	// update_option('thumbnail_size_h', 300);

	// update_option('medium_size_w', 450);
	// update_option('medium_size_h', 450);

	// update_option('large_size_w', 600);
	// update_option('large_size_h', 600);
}



// ----
// ---- Loading Scripts and Styles
// ----

// Load basic styles and theme JS
add_action( 'wp_enqueue_scripts', 'wpf_scripts_and_styles' );

function wpf_scripts_and_styles() {
  
  	wp_enqueue_style( 'wpf-style', get_stylesheet_uri() );
  
	if (!is_admin()) {
    // Add minified JS file to footer if it isn't the admin
    	wp_register_script( 'wpf-js', get_template_directory_uri() . '/assets/js/scripts.min.js', array( 'jquery' ), '', true );
  	}
}


// ----
// ---- Sidebar and Widgets
// ----

// Sidebar widget area
add_action( 'widgets_init', 'wpf_widgets_init' );
    
function wpf_widgets_init() {
	register_sidebar(array(
		'id' => 'primary-sidebar',
		'name' => __('Sidebar', 'wpfolio'),
		'description' => __('The sidebar to appear when using the Sidebar Page template.', 'wpfolio'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

}


// ----
// ---- Menus and Navigation
// ----

// The Main Menu
// Called in header.php
function wpf_main_nav() {
    wp_nav_menu(array(
    	'container' => false,
    	'menu' => __( 'The Main Menu', 'wpfolio' ),
    	'menu_class' => 'sf-menu',
    	'theme_location' => 'main-nav',
        'depth' => 0,
    	'fallback_cb' => 'wpf_main_nav_fallback'
	));
}

// Fallback for header menu

// BIG NOTE: This should be wp_page_menu but
// Superfish doesn't like having a div.sf-menu around the ul
// This will likely be a problem in future
// so need to rewrite css to account for it 
// and use wp_page_menu
// http://wordpress.stackexchange.com/questions/116656/menu-fallback-menu-class-rendering-a-div-instead-of-a-ul
// https://github.com/laras126/wpfolio-three/issues/1

function wpf_main_nav_fallback() {
	wp_nav_menu( array(
		'container' => false,
		'menu_class' => 'sf-menu',
		'show_home' => true,
        'depth' => 0,
	) );
}
	
	
// ----
// ---- Misc Customization
// ----

// Customize Read More link (change [...] to 'Read More')
add_filter('excerpt_more', 'wpf_excerpt_more');

function wpf_excerpt_more($more) {
	global $post;
	
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'wpfolio') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'wpfolio') .'</a>';
}


// Customize the <title> display
add_filter( 'wp_title', 'wpf_wp_title', 10, 2 );

function wpf_wp_title( $title, $sep ) {
	global $paged, $page;
 
	if ( is_feed() ) {
		return $title;
	} // end if
 
	// Add the site name.
	$title .= get_bloginfo( 'name' );
 
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	} // end if
 
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = sprintf( __( 'Page %s', 'wpfolio' ), max( $paged, $page ) ) . " $sep $title";
	} // end if
 
	return $title;
 
} // end mayer_wp_title

?>