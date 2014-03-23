<?php 

// Add hooks and filters here
// Read more: 


// Example: enqueue a custom JS script (uncomment add_action to use)
// add_action('wp_enqueue_scripts','am_custom_scripts');
function am_custom_scripts() {
	if( !is_admin()){
		wp_register_script( 'child-scripts', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'), NULL, true );
		wp_enqueue_script( 'child-scripts' );
	}
}

	
?>