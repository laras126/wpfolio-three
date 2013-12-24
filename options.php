<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */


// Functions to apply the options
require_once('library/options-functions.php');


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
		'color' => '#ffffff',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );


	// Use a mixture of Google Fonts and system fonts
	// What an excellent tutorial by Devin at WP Theming!
	// http://wptheming.com/2012/06/loading-google-fonts-from-theme-options/

	/**
	 * Returns a select list of Google fonts
	 */
	function options_typography_get_google_fonts() {
		// Google Font Defaults
		$google_faces = array(
			'Abril Fatface, serif' => 'Abril Fatface',
			'Arvo, serif' => 'Arvo',
			// 'Droid Serif, serif' => 'Droid Serif',
			// 'Gentium Book Basic, serif' => 'Gentium Book Basic',
			'Josefin Slab, sans-serif' => 'Josefin Slab',
			'Merriweather, serif' => 'Merriweather',
			'Open Sans, sans-serif' => 'Open Sans',
			// 'Oswald, sans-serif' => 'Oswald',
			// 'Pacifico, cursive' => 'Pacifico',
			// 'PT Sans, sans-serif' => 'PT Sans',
			// 'Quattrocento, serif' => 'Quattrocento',
			// 'Old Standard TT, serif' => 'Old Standard TT',
			// 'Raleway, cursive' => 'Raleway',
			// 'Ubuntu, sans-serif' => 'Ubuntu',
			// 'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz',
		);
		return $google_faces;
	}

	/**
	 * Returns an array of system fonts
	 */

	function options_typography_get_os_fonts() {
		// OS Font Defaults
		$os_faces = array(
			'Arial, sans-serif' => 'Arial',
			//'"Avant Garde", sans-serif' => 'Avant Garde',
			//'Cambria, Georgia, serif' => 'Cambria',
			//'Copse, sans-serif' => 'Copse',
			//'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
			'Georgia, serif' => 'Georgia',
			'"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
			//'Tahoma, Geneva, sans-serif' => 'Tahoma'
		);
		return $os_faces;
	}

	// Merge the OS and Google font arrays
	$typography_mixed_fonts = array_merge( options_typography_get_os_fonts() , options_typography_get_google_fonts() );
	asort($typography_mixed_fonts);


	//
	// Title Font
	//

	$title_font_options = array(
		'sizes' => false,
		'faces' => $typography_mixed_fonts,
		'styles' => false,
		'color' => false,
	);

	$title_font_defaults = array(
		'face' => 'Oswald',
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
		'face' => 'Oswald',
	);


	//
	// Body Typography
	//

	$body_typography_options = array(
		'sizes' => false,
		'faces' => $typography_mixed_fonts,
		'styles' => false,
		'color' => false
	);

	

	// Pull all the categories into an array
	// TODO: remove this when you decide to take 
	// all of blog cat option out
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	



	/************* BASIC SETTINGS ********************/

	/* 	This includes:
		1. Comments (radio)
		2. Custom Favicon (upload)
	*/

	$options = array();

	$options[] = array(
		'name' => __('Basic Settings', 'options_check'),
		'type' => 'heading');
	
	// 1. Comments
	$options[] = array(
		'name' => __('Comments', 'options_check'),
		'desc' => __('Where would you like to see comments to show? By default they are only in the Blog category.', 'options_check'),
		'id' => 'comments',
		'std' => 'all',
		'type' => 'radio',
		'options' => $comments_arr);

	// 2. Favicon
	// TODO: Did I add this yet?
	$options[] = array(
		'name' => __('Custom Favicon', 'options_check'),
		'desc' => __('Upload a 16px x 16px png/gif/ico image for your website\'s favicon. You can create a favicon from a larger image with the <a href="http://www.degraeve.com/favicon/" taget="blank">Favicon Generator</a> then upload it here.', 'options_check'),
		'id' => 'example_uploader',
		'type' => 'upload');





	/************* STYLES ********************/
	
	/* 	This includes:
		1. Body Typography
		2. Heading Typography
		3. Color Scheme
		4. Custom CSS
		5. Background

		-- is that too many?
	*/


	$options[] = array(
		'name' => __('Styles', 'options_check'),
		'type' => 'heading');


	// --- TYPOGRAPHY --- //

	// 1. Title Font
	$options[] = array( 
		'name' => __('Title Font', 'options_check'),
		'desc' => __('Choose a font for your site title.'),
		'id' => 'title_font',
		'std' => $title_font_defaults,
		'type' => 'typography',
		'class' => 'small',
		// Using same font set for headings and title
		'options' => $heading_font_options );
	

	// 2. Header font
	$options[] = array( 
		'name' => __('Headings Typography', 'options_check'),
		'desc' => __('You can choose a different font and color for the heading text.', 'options_check'),
		'id' => "heading_font",
		'std' => $heading_font_defaults,
		'type' => 'typography',
		'options' => $heading_font_options );
	

	// 3. Choose font, base font size, and color for body typography
	$options[] = array( 
		'name' => __('Body Font', 'options_check'),
		'desc' => __('Choose the font for your website\'s content text.', 'options_check'),
		'id' => 'body_typography',
		'std' => $body_typography_defaults,
		'type' => 'typography', 
		'options' => $body_typography_options );

		
	//	
	// TODO: add logo option
	//

	//
	// TODO: add color scheme option instead of specific colors
	//

	
	/* 
	*	Background
	*/

	// Change the background color or upload an image
	$options[] = array(
		'name' =>  __('Background', 'options_check'),
		'desc' => __('Choose a color or texture or upload an image for your background. Check out <a href="http://subtlepatterns.com" target="blank">Subtle Patterns</a> for some excellent quality textures. Note that an image will override a color.', 'options_check'),
		'id' => 'body_background',
		'std' => $background_defaults,
		'type' => 'background' );

	// Custom CSS ftw
	$options[] = array(
		'name' => __('Custom CSS', 'options_check'),
		'desc' => __('Quickly add some CSS by typing it here. If you are adding more than 5 or 6 styles, consider using a <a href="http://themeshaper.com/modify-wordpress-themes/" target="blank">Child Theme.</a>', 'options_check'),
		'id' => 'custom_css',
		'std' => '#wrapper {'."\n\t".'border-radius: 0.3em;'."\n".'}',
		'type' => 'textarea');

	return $options;

} // end main options function






?>