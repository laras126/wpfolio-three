<?php

// Included in extensions/options-functions.php 
// which is then included in functions.php

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = 'wpfolio';
	update_option('optionsframework', $optionsframework_settings);
	
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {
	

	// -----------
	/************* ARRAYS ********************/
	// -----------
	
	// Set up some value arrays because they are nice:

	// Comments options
    $comments_arr = array(
        'all' => __('Keep all comments', 'wpfolio'),
        'blog' => __('Show only on the Blog', 'wpfolio'),
        'none' => __('Disable all comments', 'wpfolio'),
    );

	$credits_arr = array(
		'yes' => __('Yes', 'wpfolio'),
        'no' => __('No', 'wpfolio'),
	);

    // Background Defaults
    $background_defaults = array(
        'color' => '#ffffff',
        'image' => '',
        'repeat' => 'repeat',
        'position' => 'top center',
        'attachment'=>'scroll' );

	
	// Merge the OS and Google font arrays
	$typography_mixed_fonts = array_merge( options_typography_get_os_fonts() , options_typography_get_google_fonts() );
	asort($typography_mixed_fonts);



	// Typography TODO: maybe use different
	// font sets for each title/headings/body
	// so people don't use Lobster as a body font


	//
	// Title Font
	//

	// TODO: use a textbox like in WPF2 - maybe?
	
	$title_font_options = array(
		'sizes' => false,
		'faces' => $typography_mixed_fonts,
		'styles' => false,
		'color' => false,
	);

	$title_font_defaults = array(
		'face' => 'Merriweather',
	);
	

	//
	// Heading Typography
	//

	$heading_font_options = array(
		'sizes' => false,
		'faces' => $typography_mixed_fonts,
		'styles' => false,
		'color' => false,
	);

	$heading_font_defaults = array(
		'face' => 'Arvo',
	);


	//
	// Body Typography
	//

	$body_font_options = array(
		'sizes' => false,
		'faces' => $typography_mixed_fonts,
		'styles' => false,
		'color' => false
	);

	$body_font_defaults = array(
		'face' => 'Open Sans',
	);

	



	// -----------
	/************* THE OPTIONS ********************/
	// -----------



	/************* BASIC SETTINGS ********************/

	/* 	This includes:
		1. Comments (radio)
		2. Custom Favicon (upload)
		3. Show theme creds?
	*/

	$options = array();

	$options[] = array(
		'name' => __('Basic Settings', 'wpfolio'),
		'type' => 'heading');
	
	// 1. Comments
	$options[] = array(
		'name' => __('Comments', 'wpfolio'),
		'desc' => __('Where would you like to see comments to show? By default they are only in the Blog category.', 'wpfolio'),
		'id' => 'comments',
		'std' => 'all',
		'type' => 'radio',
		'options' => $comments_arr);

	// 2. Favicon
	$options[] = array(
		'name' => __('Custom Favicon', 'wpfolio'),
		'desc' => __('Upload a 16px x 16px png/gif/ico image for your website\'s favicon. You can create a favicon from a larger image with the <a href="http://www.degraeve.com/favicon/" taget="blank">Favicon Generator</a> then upload it here.', 'wpfolio'),
		'id' => 'custom_favicon',
		'type' => 'upload');


	// 3. Theme Creds
	$options[] = array(
		'name' => __('Theme Credits', 'wpfolio'),
		'desc' => __('Show theme credits in the footer? It\'s a nice thing to do, but up to you!', 'wpfolio'),
		'id' => 'credits',
		'std' => 'no',
		'type' => 'radio',
		'options' => $credits_arr);




	/************* STYLES ********************/
	
	/* 	This includes:
		1. Typography
			- Title 
			- Headings
			- Body
		2. Background
		3. Color Scheme (TODO)
		4. Custom CSS

		TODO: should this be only a Pro option?
	*/


	$options[] = array(
		'name' => __('Styles', 'wpfolio'),
		'type' => 'heading');


	// --- 1. Typography --- //

	// 1. Title Font
	$options[] = array( 
		'name' => __('Title Font', 'wpfolio'),
		'desc' => __('Choose a font for your site title.', 'wpfolio'),
		'id' => 'title_font',
		'std' => $title_font_defaults,
		'type' => 'typography',
		'class' => 'small',
		// Using same font set for headings and title
		'options' => $heading_font_options );
	

	// 2. Header font
	$options[] = array( 
		'name' => __('Headings Font', 'wpfolio'),
		'desc' => __('You can choose a different font and color for the heading text.', 'wpfolio'),
		'id' => "heading_font",
		'std' => $heading_font_defaults,
		'type' => 'typography',
		'options' => $heading_font_options );
	

	// 3. Body font
	$options[] = array( 
		'name' => __('Body Font', 'wpfolio'),
		'desc' => __('Choose the font for your website\'s content text.', 'wpfolio'),
		'id' => 'body_typography',
		'std' => $body_font_defaults,
		'type' => 'typography', 
		'options' => $body_font_options );

		
	//	
	// TODO: add logo option -- maybe?
	//

	//
	// TODO: add color scheme option instead of specific colors
	// -- Pro only?
	
	
	// --- 2. Background --- //
	
	// Change the background color or upload an image
	$options[] = array(
		'name' =>  __('Background', 'wpfolio'),
		'desc' => __('Choose a color or texture or upload an image for your background. Check out <a href="http://subtlepatterns.com" target="blank">Subtle Patterns</a> for some excellent quality textures. Note that an image will override a color.', 'wpfolio'),
		'id' => 'body_background',
		'std' => $background_defaults,
		'type' => 'background' );


	// --- 3. Custom CSS FTW --- //

	// Textarea for custom CSS
	$options[] = array(
		'name' => __('Custom CSS', 'wpfolio'),
		'desc' => __('Quickly add some CSS by typing it here. If you are adding more than 5 or 6 styles, consider using a <a href="http://themeshaper.com/modify-wordpress-themes/" target="blank">Child Theme.</a>', 'wpfolio'),
		'id' => 'custom_css',
		'std' => '',
		'type' => 'textarea');



	return $options;



} // end main options function



?>