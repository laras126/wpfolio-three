<?php
/* Portfolio Custom Post Type 

Create a custom post type for Projects.
Projects have taxonomies for project category,
associate people and places, and support for
regular post tags.

Custom fields are defined in wpfolio.php

Props to Eddie Machado for providing the 
base of this file:
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
			'menu_icon' => get_template_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the Project type menu */
			'rewrite'	=> array( 'slug' => 'project', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'portfolio', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' )
		) /* end of options */
	); /* end of register post type */
	

	// Project Categories)
	register_taxonomy( 'project_category', 
		array('project'),
		array('hierarchical' => true,     /* if this i8s true, it acts like categories */             
			'labels' => array(
				'name' => __( 'Project Categories', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Project Category', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Project Categories', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Project Categories', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Project Category', 'bonestheme' ),  /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Project Category:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Project Category', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Project Category', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Project Category', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Project Category', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'project-type' ),
		)
	);  

	register_taxonomy( 'people', 
		array('project'),
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
		array('project'),
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
	register_taxonomy_for_object_type( 'project_category', 'project' );
	register_taxonomy_for_object_type( 'people', 'project' );
	register_taxonomy_for_object_type( 'place', 'project' );

	/* adds post tags to the project */
	register_taxonomy_for_object_type( 'post_tag', 'project' );
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'project_type');
	

?>