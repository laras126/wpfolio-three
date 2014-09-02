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


	// ----
	// ---- Arrays
	// ----

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
  // Categories
  //

  // Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}




	// ----
	// ---- The Options
	// ----



	// ---- Basic Settings

	/* 	This includes:
    	1. Blog Layout (multicheck)
		2. Comments (radio)
		3. Custom Favicon (upload)
		4. Show theme creds? (radio)
	*/

	$options = array();

	$options[] = array(
		'name' => __('Basic Settings', 'wpfolio'),
		'type' => 'heading');


  		// 1. Blog Layout
	$options[] = array(
		'name' => __('Blog Category', 'options_check'),
		'desc' => __('Select the categories use the blog layout.', 'wpfolio'),
		'id' => 'blog_cat',
		'std' => '0',
		'type' => 'select',
		'options' => $options_categories);


  	// 2. Comments
	$options[] = array(
		'name' => __('Comments', 'wpfolio'),
		'desc' => __('Where would you like to see comments to show? By default they are only in the Blog category.', 'wpfolio'),
		'id' => 'comments',
		'std' => 'all',
		'type' => 'radio',
		'options' => $comments_arr);

	// 3. Favicon
	$options[] = array(
		'name' => __('Custom Favicon', 'wpfolio'),
		'desc' => __('Upload a 16px x 16px png/gif/ico image for your website\'s favicon. You can create a favicon from a larger image with the <a href="http://www.degraeve.com/favicon/" taget="blank">Favicon Generator</a> then upload it here.', 'wpfolio'),
		'id' => 'custom_favicon',
		'type' => 'upload');

	// 4. Theme Creds
	$options[] = array(
		'name' => __('Theme Credits', 'wpfolio'),
		'desc' => __('Show theme credits in the footer? It\'s a nice thing to do, but up to you!', 'wpfolio'),
		'id' => 'credits',
		'std' => 'no',
		'type' => 'radio',
		'options' => $credits_arr);




	// ---- Styles --- //

	/* 	This includes:
		1. Title Font
		2. Custom CSS

		TODO: should this be only a Pro option?
	*/

	// --- 1. Typography

	// 1. Title Font
	$options[] = array(
		'name' => __('Title Font', 'wpfolio'),
		'desc' => __('Choose a font for your site title.', 'wpfolio'),
		'id' => 'title_font',
		'std' => $title_font_defaults,
		'type' => 'typography',
		'class' => 'small',
		'options' => $title_font_options );


	// --- 2. Custom CSS FTW

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
