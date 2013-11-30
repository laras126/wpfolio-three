<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
function project_type() { 
	// creating (registering) the custom type 
	register_post_type( 'project', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Portfolio', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Project', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Projects', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Project', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Project', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Project', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Project', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Portfolio', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the example Project', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the Project type menu */
			'rewrite'	=> array( 'slug' => 'project', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'portfolio', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'post-formats')
		) /* end of options */
	); /* end of register post type */
	

	// Medium taxonomy (like Project categories)
	register_taxonomy( 'medium', 
		array('project'),
		array('hierarchical' => true,     /* if this i8s true, it acts like categories */             
			'labels' => array(
				'name' => __( 'Medium', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Medium', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Mediums', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Mediums', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Medium', 'bonestheme' ),  /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Medium:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Medium', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Medium', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Medium', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Medium', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'medium' ),
		)
	);  

	register_taxonomy( 'people', 
		array('project'),
		array('hierarchical' => false,     /* if this i8s true, it acts like categories */             
			'labels' => array(
				'name' => __( 'Medium', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Medium', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Mediums', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Mediums', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Medium', 'bonestheme' ),  /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Medium:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Medium', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Medium', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Medium', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Medium', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'medium' ),
		)
	);  

	/* adds medium taxonomy (categories) to Portfolio */
	register_taxonomy_for_object_type( 'medium', 'project' );
	register_taxonomy_for_object_type( 'people', 'project' );

	/* adds post tags to the project */
	register_taxonomy_for_object_type( 'post_tag', 'project' );
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'project_type');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	

	
	
	// now let's add custom tags (these act like categories)
	// register_taxonomy( 'custom_tag', 
	// 	array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	// 	array('hierarchical' => false,    /* if this is false, it acts like tags */
	// 		'labels' => array(
	// 			'name' => __( 'Custom Tags', 'bonestheme' ), /* name of the custom taxonomy */
	// 			'singular_name' => __( 'Custom Tag', 'bonestheme' ), /* single taxonomy name */
	// 			'search_items' =>  __( 'Search Custom Tags', 'bonestheme' ), /* search title for taxomony */
	// 			'all_items' => __( 'All Custom Tags', 'bonestheme' ), /* all title for taxonomies */
	// 			'parent_item' => __( 'Parent Custom Tag', 'bonestheme' ), /* parent title for taxonomy */
	// 			'parent_item_colon' => __( 'Parent Custom Tag:', 'bonestheme' ), /* parent taxonomy title */
	// 			'edit_item' => __( 'Edit Custom Tag', 'bonestheme' ), /* edit custom taxonomy title */
	// 			'update_item' => __( 'Update Custom Tag', 'bonestheme' ), /* update title for taxonomy */
	// 			'add_new_item' => __( 'Add New Custom Tag', 'bonestheme' ), /* add new title for taxonomy */
	// 			'new_item_name' => __( 'New Custom Tag Name', 'bonestheme' ) /* name title for taxonomy */
	// 		),
	// 		'show_admin_column' => true,
	// 		'show_ui' => true,
	// 		'query_var' => true,
	// 	)
	// );
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>
