<?php

// ----
// ---- Artwork Info Metabox
// ----

/**
 *
 * This metabox shows up in all projects
 * TODO: maybe add an option to hide it?
 *
 */

function wpf_artinfo_metaboxes( $meta_boxes ) {
    $post_title = the_title();
    $prefix = '_ctmb_'; // Prefix for all fields
    $meta_boxes[] = array(
            'id' => 'artwork-info',
            'title' => 'Artwork Info',
            'pages' => array('post'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on left
            'fields' => array(
					array(
						'name' => '',
						'desc' => '<p>This information will display by default at the bottom of the post. You should add any images or embed content in the main WordPress editor above.</p>
						',
						'type' => 'title',
						'id' => $prefix . 'fields_description'
					),
                    array(
                            'name' => 'Medium',
                            'desc' => 'A few words describing your work\'s medium.',
                            'id' => $prefix . 'medium',
                            'type' => 'text'
                        ),
                    array(
                            'name' => 'Date',
                            'desc' => 'The year this work was created.',
                            'id' => $prefix . 'date',
                            'type' => 'text'
                        ),
                    array(
                            'name' => 'Short Description',
                            'desc' => 'A short, text description of the work. Good for things like price or dimensions.',
                            'id' => $prefix . 'description',
                            'type' => 'wysiwyg'
                        ),
					array(
                            'name' => 'Acknowledgments',
                            'desc' => 'Use this space to describe any people or places related to this project.',
                            'id' => $prefix . 'acknowledgments',
                            'type' => 'wysiwyg'
                        ),
					array(
                            'name' => 'Link',
                            'desc' => 'If the project has it\'s own website, paste the URL here.',
                            'id' => $prefix . 'link',
                            'type' => 'text'
                        ),
                    array(
                            'name' => 'Link Text',
                            'desc' => 'What do you want the text of the link to be? e.g. Project Link, Download, View it on Etsy, etc.',
                            'id' => $prefix . 'link_text',
                            'type' => 'text'
                        ),
					array(
    						'name' => '',
    						'desc' => '<p>Are these fields useful? Do you have suggestions for other ones? <a href="mailto:lara@notlaura.com">Let me know.</a></p>',
    						'type' => 'title',
    						'id' => $prefix . 'feedback'
					),

                ),
        );

    return $meta_boxes;
}

add_filter( 'cmb_meta_boxes', 'wpf_artinfo_metaboxes');


function wpf_initialize_cmb_meta_boxes() {
    if ( !class_exists('cmb_Meta_Box') ) {
        require_once('metabox/init.php');
    }
}

add_action( 'init', 'wpf_initialize_cmb_meta_boxes', 999);







// ---- 
// ---- Body Classes and Layout
// ----

/**  
 * Add a specific classes for News and Portfolio layouts.
 *    
 * Check to see if it's the blog category. If it is,
 * add the standard-layout class, if not,
 * add portfolio-layout class
 *
 */

add_filter('body_class','wpf_add_body_class');

function wpf_add_body_class($class) {

    global $post;
    $blog_cats = of_get_option( 'blog_cat' );

    if ( in_category( $blog_cats ) || is_home() ) {
        $class[] = 'standard-layout';
        return $class;
    } else {
        $class[] = 'portfolio-layout';
        return $class;
    }
}


/* 
 *
 * These are custom functions to include the appropriate templates
 * according to the News category specified in Theme Options.
 *
 * wpf_layout and wpf_sidebar are called in place of the primary loop and get_sidebar in post templates.
 *
*/

// Use the appropriate markup according to the body class
// http://stackoverflow.com/questions/15033888/how-to-check-for-class-in-body-class-in-wordpress

function wpf_layout() {
    $classes = get_body_class();
    if (in_array('standard-layout',$classes)) {
        if(is_single()) {
            get_template_part('include/single', 'standard');
        } else {
            get_template_part('include/loop','standard');
        }
    } else {
        if(is_single()) {
            get_template_part('include/single', 'portfolio');
        } else {
            get_template_part('include/loop', 'portfolio');
        }
    }
}


// Only show the sidebars on News layouts
function wpf_sidebar() {
    $classes = get_body_class();
    if (in_array('standard-layout', $classes)) {
        get_sidebar();
    }
}


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



// ---- 
// ---- Shortcodes 
// ----

/** 
 * Shortcode to add wide margins to a post page - works as is, but is applied in post lists
 */

add_shortcode('margin', 'wide_margins_shortcode');

function wide_margins_shortcode ($atts, $content = null) {
    return '<div class="widemargins">' . do_shortcode($content) . '</div>';
}


// Shortcode to print artwork meta info
add_shortcode('artwork_info', 'artwork_meta_shortcode');

function artwork_meta_shortcode ($atts) {
    ob_start();
    $path = get_template_directory();
    get_template_part($path . '/include/artwork-meta.php');
    return ob_get_clean();
}






// ----
// ---- Require some plugins
// ----

/**
 * 
 * Specifically:
 * Cleaner Gallery (TODO: bake this into theme)
 * Option Framework (TODO: also bake this into theme with default WP options)
 *
 */

// Require them with the plugin
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





//---- 
//---- Misc Display Functions
//---- 

// Get post attachments
// http://www.kingrosales.com/how-to-display-your-posts-first-image-thumbnail-automatically-in-wordpress/ -- (although this link is now dead, and function has been significantly hacked, it's worth a credit.)
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

function wpf_get_first_thumb() {

	$attr = array(
		'class'	=> "attachment-post-thumbnail wp-post-image");

	$imgs = wpf_get_attachments();
	if ($imgs) {
		$keys = array_reverse($imgs);
		$num = $keys[0];
		$url = wp_get_attachment_image($num->ID, 'wpf-thumb-300', true,$attr);
		print $url;
	} else { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-thumb.png" alt="<?php the_title(); ?>"/>
	<?php }
}


?>
