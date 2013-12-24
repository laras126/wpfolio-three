<?php 


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
						'desc' => '<p>This information will display by default at the bottom of the post. You should add any images or embed content in the main WordPress editor above.</p>
						',
						'type' => 'title',
						'id' => $prefix . 'fields_description'
					),
                    // array(
                    //         'name' => 'Title',
                    //         'desc' => 'The title of your artwork.',
                    //         'id' => $prefix . 'title',
                    //         'type' => 'text'
                    //     ),
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
// TODO: Use this






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