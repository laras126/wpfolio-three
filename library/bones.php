<?php

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

add_action('after_setup_theme','wpf_setup');

function wpf_setup() {

	// Multi language support
	load_theme_textdomain( '_s', get_template_directory() . '/library/translation' );

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

    // adding the bones search form (created in functions.php)
    add_filter( 'get_search_form', 'wpf_wpsearch' );

    // cleaning up random code around images
    // add_filter('the_content', 'bones_filter_ptags_on_images');
    // cleaning up excerpt
    add_filter('excerpt_more', 'bones_excerpt_more');

	// Post thumbnails
	add_theme_support('post-thumbnails');

    // default thumb size
	set_post_thumbnail_size(300, 300);

	// Customize the Media option defaults
	// http://wordpress.org/support/topic/how-set-default-image-size
	update_option('thumbnail_size_w', 300);
	update_option('thumbnail_size_h', 300);

	update_option('medium_size_w', 450);
	update_option('medium_size_h', 450);

	update_option('large_size_w', 600);
	update_option('large_size_h', 600);
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

add_action( 'widgets_init', 'wpf_widgets_init' );
    
function wpf_widgets_init() {
	register_sidebar(array(
		'id' => 'primary-sidebar',
		'name' => __('Sidebar', 'wpfolio'),
		'description' => __('The first (primary) sidebar.', 'wpfolio'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

}


// ----
// ---- Menus and Navigation
// ----

// The main menu
// Called in header.php
function wpf_main_nav() {
    wp_nav_menu(array(
    	'container' => false,
    	'menu' => __( 'The Main Menu', 'wpfolio' ),
    	'menu_class' => 'sf-menu',
    	'theme_location' => 'main-nav',
        'depth' => 0,
    	'fallback_cb' => 'bones_main_nav_fallback'
	));
}

// this is the fallback for header menu
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
	
	
/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function bones_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ol class="bones_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( "First", 'wpfolio' );
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('&larr; Previous');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('Next &rarr;');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( "Last", 'wpfolio' );
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
} /* end page navi */


// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
	global $post;
	// edit here if you like
return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'wpfolio') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'wpfolio') .'</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function bones_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s', 'wpfolio' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

?>