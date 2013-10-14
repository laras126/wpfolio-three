<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

	// Comments options
	$comments_arr = array(
		'all' => __('Keep all comments', 'options_check'),
		'blog' => __('Show only on the Blog', 'options_check'),
		'none' => __('Disable all comments', 'options_check'),
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );


	//
	// Body Typography
	//

	$body_typography_defaults = array(
		'size' => '12px',
		'face' => 'Helvetica'
	);
	

	$body_typography_options = array(
		'sizes' => array('12', '16', '18'),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => false,
	);


	//
	// Heading Typography
	//

	$heading_typography_options = array(
		'sizes' => false,
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => false,
		'color' => false
	);

	$heading_typography_defaults = array(
		'face' => 'helvetica',
		 );
	

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	

	/************* BASIC SETTINGS ********************/

	/* 	This includes:
		1. Blog Category (multicheck)
		2. Comments (radio)
		3. Custom Favicon (upload)
	*/

	$options = array();

	$options[] = array(
		'name' => __('Basic Settings', 'options_check'),
		'type' => 'heading');

	// 1. Select the blog categories
	$options[] = array(
		'name' => __('Blog Layout Categories', 'options_check'),
		'desc' => __('Select the categories be used in your blog. These posts will use the blog layout, all other categories will use the portfolio layout.', 'options_check'),
		'id' => 'blog_cats',
		'std' => '1',
		'type' => 'multicheck',
		'options' => $options_categories);
	
	// 2. Comments?
	$options[] = array(
		'name' => __('Comments', 'options_check'),
		'desc' => __('Where would you like to see comments to show? By default they are only in the Blog category.', 'options_check'),
		'id' => 'comments',
		'std' => 'all',
		'type' => 'radio',
		'options' => $comments_arr);

	// 3. Favicon
	$options[] = array(
		'name' => __('Custom Favicon', 'options_check'),
		'desc' => __('Upload a 16px x 16px png/gif/ico image for your website\'s favicon. You can create a favicon from a larger image with the <a href="http://www.degraeve.com/favicon/" taget="blank">Favicon Generator</a> then upload it here.', 'options_check'),
		'id' => 'example_uploader',
		'type' => 'upload');



	/************* STYLES ********************/
	
	/* 	This includes:
		1. Body Typography
		2. Heading Typography
		3. Secondary Color
		4. Custom CSS
		5. Background color
		6. Container color

		-- is that too many?
	*/

	$options[] = array(
		'name' => __('Styles', 'options_check'),
		'type' => 'heading');

	/*
	*	Typography
	*/

	// 1. Choose font, base font size, and color for body typography
	$options[] = array( 
		'name' => __('Body Typography', 'options_check'),
		'desc' => __('Choose the font, color, and base size for your websites text.', 'options_check'),
		'id' => "body_typography",
		'std' => $body_typography_defaults,
		'type' => 'typography', 
		'options' => $body_typography_options );
	
	// 2. Header font
	$options[] = array( 
		'name' => __('Heading Typography', 'options_check'),
		'desc' => __('You can choose a different font and color for the heading text.', 'options_check'),
		'id' => "heading_typography",
		'std' => $heading_typography_defaults,
		'type' => 'typography',
		'options' => $heading_typography_options );
		
	// TODO: add logo option
		
	// 3. The color for links, blog description, post meta, menu items, prev/next navigation, borders, widget text.
	$options[] = array(
		'name' => __('Secondary Font Color', 'options_check'),
		'desc' => __('Blog description, post meta, menu items, prev/next navigation, borders, widget text.', 'options_check'),
		'id' => 'secondary_font_color',
		'std' => '#f0f0f0',
		'type' => 'color' );
	
	// Color for the menu highlight
	$options[] = array(
		'name' => __('Menu Highlight Color', 'options_check'),
		'desc' => __('The hover color.', 'options_check'),
		'id' => 'menu_highlight_color',
		'std' => '#f0f0f0',
		'type' => 'color' );


	/* 
	*	Background
	*/

	// Change the background color or upload an image
	$options[] = array(
		'name' =>  __('Background', 'options_check'),
		'desc' => __('Choose a color for the background, or you can upload an image. Check out <a href="http://subtlepatterns.com" target="blank">Subtle Patterns</a> for some, well, subtle patterns to use on your site.', 'options_check'),
		'id' => 'example_background',
		'std' => $background_defaults,
		'type' => 'background' );

	// Custom CSS ftw
	$options[] = array(
		'name' => __('Custom CSS', 'options_check'),
		'desc' => __('Quickly add some CSS by typing it here. If you are adding more than 5 or 6 styles, consider using a <a href="http://themeshaper.com/modify-wordpress-themes/" target="blank">Child Theme.</a>', 'options_check'),
		'id' => 'custom_css',
		'std' => '#wrapper {'."\n\t".'border-radius: 0.3em;'."\n".'}',
		'type' => 'textarea');



	$options[] = array(
		'name' => __('Blerg', 'options_check'),
		'type' => 'heading' );



	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 10,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	
	$options[] = array(
		'name' => __('Default Text Editor', 'options_check'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_check' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'textarea',
		'class' => 'large',
		'settings' => $wp_editor_settings );


	










	$options[] = array(
		'name' => __('Custom Typography', 'options_check'),
		'desc' => __('Custom typography options.', 'options_check'),
		'id' => "custom_typography",
		'std' => $typography_defaults,
		'type' => 'typography',
		'options' => $typography_options );


	$options[] = array(
		'name' => __('Input Text Mini', 'options_check'),
		'desc' => __('A mini text input field.', 'options_check'),
		'id' => 'example_text_mini',
		'std' => 'Default',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Input Text', 'options_check'),
		'desc' => __('A text input field.', 'options_check'),
		'id' => 'example_text',
		'std' => 'Default Value',
		'type' => 'text');

	$options[] = array(
		'name' => __('Textarea', 'options_check'),
		'desc' => __('Textarea description.', 'options_check'),
		'id' => 'example_textarea',
		'std' => 'Default Text',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Select a Tag', 'options_check'),
		'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
		'id' => 'example_select_tags',
		'type' => 'select',
		'options' => $options_tags);

	$options[] = array(
		'name' => __('Select a Page', 'options_check'),
		'desc' => __('Passed an pages with ID and post_title', 'options_check'),
		'id' => 'example_select_pages',
		'type' => 'select',
		'options' => $options_pages);

	
	$options[] = array(
		'name' => __('Example Info', 'options_check'),
		'desc' => __('This is just some example information you can put in the panel.', 'options_check'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Input Checkbox', 'options_check'),
		'desc' => __('Example checkbox, defaults to true.', 'options_check'),
		'id' => 'example_checkbox',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Advanced Settings', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Check to Show a Hidden Text Input', 'options_check'),
		'desc' => __('Click here and see what happens.', 'options_check'),
		'id' => 'example_showhidden',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Hidden Text Input', 'options_check'),
		'desc' => __('This option is hidden unless activated by a checkbox click.', 'options_check'),
		'id' => 'example_text_hidden',
		'std' => 'Hello',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Uploader Test', 'options_check'),
		'desc' => __('This creates a full size uploader that previews the image.', 'options_check'),
		'id' => 'example_uploader',
		'type' => 'upload');

	$options[] = array(
		'name' => "Example Image Selector",
		'desc' => "Images for layout.",
		'id' => "example_images",
		'std' => "2c-l-fixed",
		'type' => "images",
		'options' => array(
			'1col-fixed' => $imagepath . '1col.png',
			'2c-l-fixed' => $imagepath . '2cl.png',
			'2c-r-fixed' => $imagepath . '2cr.png')
	);

	
	$options[] = array(
		'name' => __('Multicheck', 'options_check'),
		'desc' => __('Multicheck description.', 'options_check'),
		'id' => 'example_multicheck',
		'std' => $multicheck_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $multicheck_array);

	$options[] = array(
		'name' => __('Colorpicker', 'options_check'),
		'desc' => __('No color selected by default.', 'options_check'),
		'id' => 'example_colorpicker',
		'std' => '',
		'type' => 'color' );
		
	$options[] = array( 'name' => __('Typography', 'options_check'),
		'desc' => __('Example typography.', 'options_check'),
		'id' => "example_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );
		

	return $options;
}