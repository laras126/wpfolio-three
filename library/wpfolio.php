<?php

/*********************
SET UP ZE THEME
*********************/

// Firing all out initial functions at the start
add_action('after_setup_theme','wpfolio_ahoy', 16);

function wpfolio_ahoy() {

    // clean up gallery output in wp
    add_filter('gallery_style', 'wpfolio_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'wpfolio_scripts_and_styles', 999);

    // launch theme support functions
    wpfolio_theme_support();

    // adding sidebars to Wordpress (these are created in functions.php)
    add_action( 'widgets_init', 'wpfolio_register_sidebars' );

    // adding the bones search form (created in functions.php)
    add_filter( 'get_search_form', 'wpfolio_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'wpfolio_filter_ptags_on_images');
    
    // cleaning up excerpt
    add_filter('excerpt_more', 'wpfolio_excerpt_more');

    // add body classes according to blog category to determine layout
    add_filter('body_class','wpfolio_body_class');

} /* end wpfolio ahoy */





/*********************
THEME SUPPORT 
*********************/

// Adding WP 3+ Functions & Theme Support
// Hooked in wpfolio_ahoy
function wpfolio_theme_support() {

    // wp thumbnails (sizes handled in functions.php)
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

    // rss thingy
    add_theme_support('automatic-feed-links');

    // to add header image support go here: http://themble.com/support/adding-header-background-image-support/

    // wp menus
    add_theme_support( 'menus' );

    // Custom background
    add_theme_support( 'custom-background' );

    // registering wp3+ menus
    register_nav_menus(
        array(
            'main-nav' => __( 'The Main Menu', 'wpfolio' ),   // main nav in header
        )
    );
} /* end wpfolio theme support */





/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function wpfolio_scripts_and_styles() {
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
    wp_register_script( 'wpf-js', get_template_directory_uri() . '/library/js/production.js', array( 'jquery' ), '', true );
    
    // enqueue styles and scripts
    wp_enqueue_script( 'wpf-modernizr' );
    wp_enqueue_style( 'wpf-stylesheet' );
    wp_enqueue_style('wpf-ie-only');

    $wp_styles->add_data( 'wpf-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

    wp_enqueue_script( 'wpf-js' );
  }
}




/*********************
MENUS & NAVIGATION 
*********************/

// the main menu
function wpfolio_main_nav() {
    wp_nav_menu(array(
        'container' => false,
        'menu' => __( 'The Main Menu', 'wpfolio' ),
        'menu_class' => 'sf-menu',
        'theme_location' => 'main-nav',
        'depth' => 0,
        'fallback_cb' => 'wpfolio_main_nav_fallback'
    ));
} /* end bones main nav */

// this is the fallback for header menu
// NOTE: This should be wp_page_menu but
// Superfish doesn't like having a div.sf-menu around the ul
// This will likely be a problem in future
// so need to rewrite css to account for it 
// and use wp_page_menu
// http://wordpress.stackexchange.com/questions/116656/menu-fallback-menu-class-rendering-a-div-instead-of-a-ul
// https://github.com/laras126/wpfolio-three/issues/1

function wpfolio_main_nav_fallback() {
    wp_nav_menu( array(
        'container' => false,
        'menu_class' => 'sf-menu',
        'show_home' => true,
        'depth' => 0,
    ) );
}






/*********************
BODY CLASSES & LAYOUT
*********************/

// Add a specific classes for news and portfolio layouts.
// Check to see if it's the blog category

function wpfolio_body_class($classes) {

    global $post;

    $wpf_blog_cats = array('news','latest', 'updates', 'blog', 'notable', );
    // TODO: fix the blog option
    // $wpf_blog_option = of_get_option('blog_cat', 'none');
    print_r($wpf_blog_option);


    if ( in_category($wpf_blog_cats) || is_home() ) {
        $classes[] = 'standard-layout';
    } else {
        $classes[] = 'portfolio-layout';
    }

    return $classes;

}


// Use the appropriate markup according to the body class
// Called in the templates
// http://stackoverflow.com/questions/15033888/how-to-check-for-class-in-body-class-in-wordpress

function wpfolio_layout() {

    $classes = get_body_class();
    
    if (in_array('standard-layout', $classes)) {
        if(is_single()) {
            get_template_part('include/single', 'standard');
        } else {
            get_template_part('include/loop','standard');
        }
    } else {
        if(is_single()) {
            get_template_part('include/single', 'portfolio');
            echo 'poop';
        } else {
            get_template_part('include/loop', 'portfolio');
        }
    }
}

// Only show the sidebars on blog layouts
function wpfolio_sidebar() {

    $classes = get_body_class();
    
    if (in_array('standard-layout', $classes)) {
        get_sidebar();
    }
}






/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function wpfolio_page_navi($before = '', $after = '') {
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
AUTO FEATURED IMAGE
*********************/


//** Use the first attachment image if there is no featured thumbnail

// Get post attachments
// http://www.kingrosales.com/how-to-display-your-posts-first-image-thumbnail-automatically-in-wordpress/
// -- (although this link is now dead, and function has been significantly hacked, it's worth a credit.)

function wpf_get_attachments() {
	global $post;
	return get_posts(
		array(
			'post_parent' => get_the_ID(),
			'post_type' => 'attachment',
			'post_mime_type' => 'image')
		);
}

// Pull a post image for the thumb if there isn't one set
// Get the URL of the first attachment image.
// If no attachments, display default-thumb.png

function wpfolio_get_first_thumb() {

	$attr = array(
		'class'	=> "attachment-post-thumbnail wp-post-image");

	$imgs = wpf_get_attachments();
	if ($imgs) {
		$keys = array_reverse($imgs);
		$num = $keys[0];
		$url = wp_get_attachment_image($num->ID, 'wpf-thumb-300', true,$attr);
		print $url;
	} else { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/library/images/default-thumb.png" alt="<?php the_title(); ?>"/>
	<?php }
}



    

/*********************
RELATED POSTS FUNCTION
*********************/

// NOTE not used anywhere
// Related Posts Function (call using wpfolio_related_posts(); )
function wpfolio_related_posts() {
    echo '<ul id="wpfolio-related-posts">';
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
} /* end wpfolio related posts function */






/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function wpfolio_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the […] to a Read More link
function wpfolio_excerpt_more($more) {
    global $post;
    // edit here if you like
    return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'wpfolio') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'wpfolio') .'</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function wpfolio_get_the_author_posts_link() {
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

// remove injected CSS from gallery
function wpfolio_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}










/*********************
REQUIRE SOME PLUGINS 
*********************/


add_action( 'tgmpa_register', 'wpf_register_required_plugins' );

function wpf_register_required_plugins() {
/**
 * Register the required plugins for this theme and get them from the WP repo
 **/

    $plugins = array(

        array(
            'name'                  => 'Cleaner Gallery Plugin', // The plugin name
            'slug'                  => 'cleaner-gallery', // The plugin slug (typically the folder name)
            'required'              => true,
            'force_activation'      => true,
            'external_url'          => 'http://wordpress.org/plugins/cleaner-gallery/',
        ),

        array(
            'name'                  => 'Options Framework', // The plugin name
            'slug'                  => 'options-framework', // The plugin slug (typically the folder name)
            'required'              => true,
            'force_activation'      => true,
            'external_url'          => 'http://wordpress.org/plugins/options-framework/',
        ),


    );

    $config = array(
        'domain'            => 'wpfolio',           // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                           // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
        'parent_url_slug'   => 'themes.php',         // Default parent URL slug
        'menu'              => 'install-required-plugins',   // Menu slug
        'has_notices'       => true,                         // Show admin notices or not
        'is_automatic'      => true,            // Automatically activate plugins after installation or not
        'message'           => '',               // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => __( 'Install Required Plugins', 'wpfolio' ),
            'menu_title'                                => __( 'Install Plugins', 'wpfolio' ),
            'installing'                                => __( 'Installing Plugin: %s', 'wpfolio' ), // %1$s = plugin name
            'oops'                                      => __( 'Something went wrong with the plugin API.', 'wpfolio' ),
            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                    => __( 'Return to Required Plugins Installer', 'wpfolio' ),
            'plugin_activated'                          => __( 'Plugin activated successfully.', 'wpfolio' ),
            'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'wpfolio' ) // %1$s = dashboard link
        )
    );

    tgmpa( $plugins, $config );

}



?>