<?php

/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

/*********************
LAUNCH BONES
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

// we're firing all out initial functions at the start
add_action('after_setup_theme','bones_ahoy', 16);

function bones_ahoy() {

    // launching operation cleanup
    add_action('init', 'bones_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'bones_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'bones_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'bones_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'bones_scripts_and_styles', 999);
    // ie conditional wrapper

    // launching this stuff after theme setup
    bones_theme_support();

    // adding sidebars to Wordpress (these are created in functions.php)
    add_action( 'widgets_init', 'bones_register_sidebars' );
    // adding the bones search form (created in functions.php)
    add_filter( 'get_search_form', 'bones_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'bones_filter_ptags_on_images');
    // cleaning up excerpt
    add_filter('excerpt_more', 'bones_excerpt_more');

} /* end bones ahoy */

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function bones_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 );

} /* end bones head cleanup */

// remove WP version from RSS
function bones_rss_version() { return ''; }

// remove WP version from scripts
function bones_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function bones_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function bones_scripts_and_styles() {
  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
  if (!is_admin()) {

    // modernizr (without media query polyfill)
    wp_register_script( 'wpf-modernizr', get_template_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

    // register main stylesheet
    // Using get_stylesheet_directory_uri() to allow for child themes
    wp_register_style( 'wpf-stylesheet', get_stylesheet_directory_uri() . '/style.css', array(), '', 'all' );

    // ie-only style sheet
    wp_register_style( 'wpf-ie-only', get_template_directory_uri() . '/library/css/ie.css', array(), '' );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script( 'wpf-js', get_template_directory_uri() . '/library/build/js/production.min.js', array( 'jquery' ), '', true );
	
    // enqueue styles and scripts
    wp_enqueue_script( 'wpf-modernizr' );
    wp_enqueue_style( 'wpf-stylesheet' );
    wp_enqueue_style('wpf-ie-only');

    $wp_styles->add_data( 'wpf-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

    // Load jquery in the footer using Google CDN
    if( !is_admin()){
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"), false, '1.10.1', true);
		wp_enqueue_script('jquery');
	}

    wp_enqueue_script( 'wpf-js' );
  }
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function bones_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(300, 300);

	// Note: Do we need both of these? Is one not necessary at all?

	// Customize the Media option defaults
	// http://wordpress.org/support/topic/how-set-default-image-size
	update_option('thumbnail_size_w', 300);
	update_option('thumbnail_size_h', 300);

	update_option('medium_size_w', 450);
	update_option('medium_size_h', 450);

	update_option('large_size_w', 600);
	update_option('large_size_h', 600);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	
	// TODO: Do we want to use these? For text based posts or something? 

	// No support for post formats - sorry, WP, they aren't that useful! (IMHO)
	// // adding post format support
	// add_theme_support( 'post-formats',
	// 	array(
	// 		'image',
	// 	)
	// );

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'wpfolio' ),   // main nav in header
		)
	);
} /* end bones theme support */


/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function bones_main_nav() {
    wp_nav_menu(array(
    	'container' => false,
    	'menu' => __( 'The Main Menu', 'wpfolio' ),
    	'menu_class' => 'sf-menu',
    	'theme_location' => 'main-nav',
        'depth' => 0,
    	'fallback_cb' => 'bones_main_nav_fallback'
	));
} /* end bones main nav */

// this is the fallback for header menu
// BIG NOTE: This should be wp_page_menu but
// Superfish dunn like having a div.sf-menu around the ul
// This will likely be a problem in future
// so need to rewrite css to account for it 
// and use wp_page_menu
// http://wordpress.stackexchange.com/questions/116656/menu-fallback-menu-class-rendering-a-div-instead-of-a-ul
// https://github.com/laras126/wpfolio-three/issues/1

function bones_main_nav_fallback() {
	wp_nav_menu( array(
		'container' => false,
		'menu_class' => 'sf-menu',
		'show_home' => true,
        'depth' => 0,
	) );
}
	

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
        $args = array(
        	'tag' => $tag_arr,
        	'numberposts' => 5, /* you can change this to show more */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts($args);
        if($related_posts) {
        	foreach ($related_posts as $post) : setup_postdata($post); ?>
	           	<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	        <?php endforeach; }
	    else { ?>
            <?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'wpfolio' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end bones related posts function */

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

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

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