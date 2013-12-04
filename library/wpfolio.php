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


/************* ARTWORK METABOX ********************/

// This metabox shows up in all posts

function wpf_artinfo_metaboxes( $meta_boxes ) {
    $post_title = the_title();
    $prefix = '_ctmb_'; // Prefix for all fields
    $meta_boxes[] = array(
            'id' => 'artwork-info',
            'title' => 'Artwork Info',
            'pages' => array('project'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on left
            'fields' => array(
					array(
						'name' => '',
						'desc' => '<p>Print this information by typing the shortcode <code>[artwork_info]</code> in the post editor. Blank fields will not display.</p>
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
                            'name' => 'Description',
                            'desc' => 'A short, text description of the work. Use the post editor for longer descriptions that include photos or video.',
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
                            'id' => $prefix . 'url',
                            'type' => 'text'
                        ),
					array(
						'name' => '',
						'desc' => '<p>Are these fields useful? Do you have suggestions for other ones? <a href="mailto:lara@notlaura.com">Let me know.</a></p>',
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

/////----
// ATTENTION!!
// Using a custom type now which negates this section
/////----


/*  Add a specific classes for news and portfolio layouts.
    Check to see if it's the blog category
*/

// Add portfolio body class to anything that isn't the blog 
// function add_body_class($class) {

//     global $post;
    
//     if ( in_category('blog') || is_home() ) {
//         $class[] = 'news-layout';
//         return $class;
//     } else {
//         $class[] = 'portfolio-layout';
//         return $class;  
//     }
// }

// add_filter('body_class','add_body_class');

// Use the appropriate markup according to the body class
// http://stackoverflow.com/questions/15033888/how-to-check-for-class-in-body-class-in-wordpress

// function wpf_show_layout_according_to_bodyclass() {
//     $classes = get_body_class();
//     if (in_array('news-layout',$classes)) {
//         if(is_single()) {
//             get_template_part('include/single', 'news');    
//         } else {
//             get_template_part('inclue/loop','news');
//         }
//     } else {
//         if(is_single()) {
//             get_template_part('include/single', 'portfolio');
//         } else {
//             get_template_part('include/loop', 'portfolio');
//         }
//     }
// }

// // Only show the sidebars on news layouts
// function wpf_show_sidebar_according_to_bodyclass() {
//     $classes = get_body_class();
//     if (in_array('news-layout',$classes)) {
//         get_sidebar();
//     } 
// }


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
    include($path . '/include/artwork-meta.php');
    return ob_get_clean();
} 
add_shortcode('artwork_info', 'artwork_meta_shortcode');





/************* REQUIRE SOME PLUGINS ********************/
// TODO: Use this, not doing this immediately though.


/************* MISC FILTERS ********************/

// Remove taxonomy title from wp_title
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


?>