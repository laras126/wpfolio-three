<?php 

/************* OPTIONS FRAMEWORK ********************/

/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */

if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = false) {
		
		$optionsframework_settings = get_option('optionsframework');
		
		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];
		
		if ( get_option($option_name) ) {
			$options = get_option($option_name);
		}
			
		if ( isset($options[$name]) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}

/************* MEDIUM TAXONOMY ********************/

/* 	Not using this yet. 
	Unsure how useful it will be - 
	it seems like many users have more extensive mediums, 
	such as many sculptural materials. 
	It might be limiting to have them contrained to a dropdown */

// register_taxonomy( 'medium', 
// 	array('post'),
// 	array('hierarchical' => true,     /* if this is true, it acts like categories */             
// 		'labels' => array(
// 			'name' => __( 'Mediums', 'bonestheme' ), /* name of the custom taxonomy */
// 			'singular_name' => __( 'Medium', 'bonestheme' ), /* single taxonomy name */
// 			'search_items' =>  __( 'Search Mediums', 'bonestheme' ), /* search title for taxomony */
// 			'all_items' => __( 'All Mediums', 'bonestheme' ), /* all title for taxonomies */
// 			'parent_item' => __( 'Parent Medium', 'bonestheme' ),  parent title for taxonomy 
// 			'parent_item_colon' => __( 'Parent Medium:', 'bonestheme' ), /* parent taxonomy title */
// 			'edit_item' => __( 'Edit Medium', 'bonestheme' ), /* edit custom taxonomy title */
// 			'update_item' => __( 'Update Medium', 'bonestheme' ), /* update title for taxonomy */
// 			'add_new_item' => __( 'Add New Medium', 'bonestheme' ), /* add new title for taxonomy */
// 			'new_item_name' => __( 'New Medium', 'bonestheme' ) /* name title for taxonomy */
// 		),
// 		'show_admin_column' => true, 
// 		'show_ui' => true,
// 		'query_var' => true,
// 		'rewrite' => array( 'slug' => 'medium' ),
// 	)
// );  

/************* ARTWORK METABOX ********************/

// This metabox shows up in all posts

function wpf_artinfo_metaboxes( $meta_boxes ) {
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
						'desc' => '<span class="metabox-desc">Use these fields to add information below an image of your artwork (added to the post editor above). Any fields left blank will not be displayed.</span>
						',
						'type' => 'title',
						'id' => $prefix . 'test_title'
					),
                    array(
                            'name' => 'Title',
                            'desc' => 'The title of your artwork.',
                            'id' => $prefix . 'title',
                            'type' => 'text'
                        ),
                    // Not sure if we want a select medium or text medium
                    // array(
                    //         'name' => 'Medium',
                    //         'desc' => 'Choose your work\'s medium. You can add and edit mediums here.',
                    //         'id' => $prefix . 'taxonomy',
                    //         'taxonomy' => 'medium',
                    //         'type' => 'taxonomy_select'
                    //     ),
                    array(
                            'name' => 'Medium',
                            'desc' => 'Type your work\'s medium.',
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
                            'name' => 'Description',
                            'desc' => 'A short, text description of the work. Use the post editor for longer descriptions that include photos or video.',
                            'id' => $prefix . 'description',
                            'type' => 'textarea'
                        ),
					array(
                            'name' => 'Collaborators',
                            'desc' => 'List the names of any collaborators.',
                            'id' => $prefix . 'collaborators',
                            'type' => 'text'
                        ),
					array(
                            'name' => 'Link',
                            'desc' => 'If the project has it\'s own website, paste the URL here.',
                            'id' => $prefix . 'url',
                            'type' => 'text'
                        ),
					array(
						'name' => '',
						'desc' => '<span class="metabox-desc">Are these fields useful? Do you have suggestions for other ones? <a href="mailto:lara@notlaura.com">Let me know.</a></span>',
						'type' => 'title',
						'id' => $prefix . 'test_title'
					),
                    
                ),
        );

    return $meta_boxes;
}

add_filter( 'cmb_meta_boxes', 'wpf_artinfo_metaboxes');

add_action( 'init', 'wpf_initialize_cmb_meta_boxes', 999);
function wpf_initialize_cmb_meta_boxes() {
    if ( !class_exists('cmb_Meta_Box') ) {
        require_once('metabox/init.php');
    }
}


/************* BODY CLASSES & LAYOUT ********************/

/*  Add a specific classes for news and portfolio layouts.
    Check to see if it's the blog category
*/

// Add portfolio body class to anything that isn't the blog 
function add_body_class($class) {

    global $post;
    
    if ( in_category('blog') || is_home() ) {
        $class[] = 'news-layout';
        return $class;
    } else {
        $class[] = 'portfolio-layout';
        return $class;  
    }
}

add_filter('body_class','add_body_class');

// Use the appropriate markup according to the body class
// http://stackoverflow.com/questions/15033888/how-to-check-for-class-in-body-class-in-wordpress

function wpf_show_layout_according_to_bodyclass() {
    $classes = get_body_class();
    if (in_array('news-layout',$classes)) {
        if(is_single()) {
            get_template_part('include/single', 'news');    
        } else {
            get_template_part('inclue/loop','news');
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
function wpf_show_sidebar_according_to_bodyclass() {
    $classes = get_body_class();
    if (in_array('news-layout',$classes)) {
        get_sidebar();
    } 
}


/************* SHORTCODES ********************/

// Shortcode to add wide margins to a post page - works as is, but is applied in post lists

function wide_margins_shortcode ($atts, $content = null) {
    return '<div class="widemargins">' . do_shortcode($content) . '</div>';
} 
add_shortcode('margin', 'wide_margins_shortcode');


?>