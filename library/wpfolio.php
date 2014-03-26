<?php

/************* ARTWORK METABOX ********************/

// This metabox shows up in all posts
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








/************* BODY CLASSES & LAYOUT ********************/

/*  Add a specific classes for news and portfolio layouts.
    Check to see if it's the blog category
*/

// Add portfolio body class to anything that isn't the blog
function add_body_class($class) {

    global $post;

    if ( in_category('blog') || is_home() ) {
        $class[] = 'standard-layout';
        return $class;
    } else {
        $class[] = 'portfolio-layout';
        return $class;
    }
}

add_filter('body_class','add_body_class');

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

// Only show the sidebars on news layouts
function wpf_sidebar() {
    $classes = get_body_class();
    if (in_array('standard-layout',$classes)) {
        get_sidebar();
    }
}






/************* SHORTCODES ********************/

// Shortcode to add wide margins to a post page - works as is, but is applied in post lists

function wide_margins_shortcode ($atts, $content = null) {
    return '<div class="widemargins">' . do_shortcode($content) . '</div>';
}
add_shortcode('margin', 'wide_margins_shortcode');


// Shortcode to print artwork meta info

function artwork_meta_shortcode ($atts) {
    ob_start();
    $path = get_template_directory();
    get_template_part($path . '/include/artwork-meta.php');
    return ob_get_clean();
}
add_shortcode('artwork_info', 'artwork_meta_shortcode');







/************* TAXONOMIES ********************/


	register_taxonomy( 'people',
		array('post'),
		array('hierarchical' => false,     /* if this i8s true, it acts like categories */
			'labels' => array(
				'name' => __( 'People', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'People', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search People', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All People', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Person', 'bonestheme' ),  /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Person:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit People', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update People', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Person', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Person', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'people' ),
		)
	);

	register_taxonomy( 'places',
		array('post'),
		array('hierarchical' => false,     /* if this i8s true, it acts like categories */
			'labels' => array(
				'name' => __( 'Places', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Places', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Places', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Places', 'bonestheme' ), /* all title for taxonomies */
				'edit_item' => __( 'Edit Places', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Place', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Place', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Place', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'places' ),
		)
	);

	/* adds medium taxonomy (categories) to Portfolio */
	register_taxonomy_for_object_type( 'people', 'post' );
	register_taxonomy_for_object_type( 'place', 'post' );







/************* MISC ********************/

//** Remove taxonomy title from wp_title
// http://wordpress.stackexchange.com/questions/29020/how-to-remove-taxonomy-name-from-wp-title

function wpf_remove_tax_name( $title, $sep, $seplocation ) {
    if ( is_tax() ) {
        $term_title = single_term_title( '', false );

        // Determines position of separator
        if ( 'right' == $seplocation ) {
            $title = $term_title . " $sep ";
        } else {
            $title = " $sep " . $term_title;
        }
    }

    return $title;
}
add_filter( 'wp_title', 'wpf_remove_tax_name', 10, 3 );



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
		<img src="<?php echo get_template_directory_uri(); ?>/library/images/default-thumb.png" alt="<?php the_title(); ?>"/>
	<?php }
}








/************* REQUIRE SOME PLUGINS ********************/


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





// Convert WPF2 meta to WPF3

/*
 * Converts Old Content
 */
function kia_convert_content(){
$wpf_posts = get_posts(array('numberposts'=>-1,'post_type'=>'post'));

foreach( $wpf_posts as $post ) : setup_postdata($post);

    // get old meta
    $wpf2_meta = get_post_meta($post->ID,'_custom_meta');

    $wpf2_medium = $wpf2_meta[0]['medium'];
    $wpf2_title = $wpf2_meta[0]['title'];
    $wpf2_add = $wpf2_meta[0]['additional'];
    $wpf2_collabs = $wpf2_meta[0]['collabs'];


    // update new meta
    update_post_meta($post->ID, $wpf2_medium, '_cmtb_medium');

    // delete old meta
    // delete_post_meta($post->ID, '_custom_meta');

    endforeach;

}


/*
* run Once class
* http://en.bainternet.info/2011/wordpress-run-once-only
*/
if (!class_exists('run_once')){
    class run_once{
        function run($key){
            $test_case = get_option('run_once');
            if (isset($test_case[$key]) && $test_case[$key]){
                return false;
            }else{
                $test_case[$key] = true;
                update_option('run_once',$test_case);
                return true;
            }
        }

        function clear($key){
            $test_case = get_option('run_once');
            if (isset($test_case[$key])){
                unset($test_case[$key]);
            }
        }
    }
}




/*
 * convert the content exactly 1 time
 */
// NOT YET!
$run_once = new run_once;
if ($run_once->run('kia_convert_content')){
    // add_action('init','kia_convert_content');
}





?>
