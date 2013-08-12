<?php 

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


?>