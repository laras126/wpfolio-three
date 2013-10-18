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
			'Droid Serif, serif' => 'Droid Serif',
			'Gentium Book Basic, serif' => 'Gentium Book Basic',
			'Josefin Slab, sans-serif' => 'Josefin Slab',
			'Merriweather, serif' => 'Merriweather',
			'Open Sans, sans-serif' => 'Open Sans',
			'Oswald, sans-serif' => 'Oswald',
			'Pacifico, cursive' => 'Pacifico',
			'PT Sans, sans-serif' => 'PT Sans',
			'Quattrocento, serif' => 'Quattrocento',
			'Old Standard TT, serif' => 'Old Standard TT',
			'Raleway, cursive' => 'Raleway',
			'Ubuntu, sans-serif' => 'Ubuntu',
			'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz',
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
			'"Avant Garde", sans-serif' => 'Avant Garde',
			'Cambria, Georgia, serif' => 'Cambria',
			'Copse, sans-serif' => 'Copse',
			'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
			'Georgia, serif' => 'Georgia',
			'"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
			'Tahoma, Geneva, sans-serif' => 'Tahoma'
		);
		return $os_faces;
	}

	// Merge the OS and Google font arrays
	$typography_mixed_fonts = array_merge( options_typography_get_os_fonts() , options_typography_get_google_fonts() );
	asort($typography_mixed_fonts);


	//
	// Body Typography
	//

	$body_typography_options = array(
		'sizes' => array('12', '14', '16', '18'),
		'faces' => $typography_mixed_fonts,
		'styles' => false,
	);


	$body_typography_defaults = array(
		'size' => '14px',
		'face' => 'Merriweather',
		'color' => '#444444'
	);

	//
	// Heading Typography
	//

	$heading_typography_options = array(
		'sizes' => false,
		'faces' => $typography_mixed_fonts,
		'styles' => false,
		'colors' => false,
	);

	$heading_typography_defaults = array(
		'face' => 'Arvo',
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
		'name' => __('Blog Category', 'options_check'),
		'desc' => __('Select the category to be used for your blog. Posts in this category will use the blog layout, all others will use the portfolio layout.', 'options_check'),
		'id' => 'blog_cat',
		'std' => '0',
		'type' => 'select',
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
		'name' => __('Main Typography', 'options_check'),
		'desc' => __('Choose the font, color, and base size for your website\'s text.', 'options_check'),
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
		
	//	
	// TODO: add logo option
	//

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







// Example options

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
} // end main options function








/***********************/
/**** OUTPUT STYLES ****/
/***********************/

// Applying options here


/**
 * Checks font options to see if a Google font is selected.
 * If so, options_typography_enqueue_google_font is called to enqueue the font.
 * Ensures that each Google font is only enqueued once.
 */

if ( !function_exists( 'options_typography_google_fonts' ) ) {
    function options_typography_google_fonts() {
        $all_google_fonts = array_keys( options_typography_get_google_fonts() );
        
        // Define all the options that possibly have a unique Google font
        $body_google_mixed = of_get_option('body_typography', false);
		$heading_google_mixed = of_get_option('heading_typography', false);
		
        // Get the font face for each option and put it in an array
        $selected_fonts = array(
            $body_google_mixed['face'],
            $heading_google_mixed['face']
            );

        // Remove any duplicates in the list
        $selected_fonts = array_unique($selected_fonts);
        
        // Check each of the unique fonts against the defined Google fonts
        // If it is a Google font, go ahead and call the function to enqueue it
        foreach ( $selected_fonts as $font ) {
            if ( in_array( $font, $all_google_fonts ) ) {
                options_typography_enqueue_google_font($font);
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'options_typography_google_fonts' );

/**
 * Enqueues the Google $font that is passed
 */
function options_typography_enqueue_google_font($font) {
	$font = explode(',', $font);
	$font = $font[0];
	// Certain Google fonts need slight tweaks in order to load properly
	// Like our friend "Raleway"
	if ( $font == 'Raleway' )
		$font = 'Raleway:100';
	$font = str_replace(" ", "+", $font);
	wp_enqueue_style( "options_typography_$font", "http://fonts.googleapis.com/css?family=$font", false, null, 'all' );
}

/*
 * Outputs the selected option panel styles inline into the <head>
 */
function options_output_styles() {
	$output = '';
	$input = '';
	
	if ( of_get_option( 'body_typography' ) ) {
		$input = of_get_option( 'body_typography' );
		$output .= options_typography_font_styles( $input , 'body');
	}

	if ( of_get_option( 'heading_typography' ) ) {
		$input = of_get_option( 'heading_typography' );
		$output .= options_typography_font_styles( $input , 'h1,h2,h3,h4,h5,h6');
	}

	if ( of_get_option( 'body_background' ) ) {
		$input = of_get_option( 'body_background' );
		$output .= options_background_style( $input , 'body');
	}

	if ( $output != '' ) {
		$output = "\n<style>\n" . $output . "</style>\n";
		echo $output;
     }

}

add_action('wp_head', 'options_output_styles');


/*
 * Returns a typography option in a format that can be outputted as inline CSS
 */
function options_typography_font_styles($option, $selectors) {
	$output = $selectors . ' {';
	$output .= ' color:' . $option['color'] .'; ';
	$output .= 'font-family:' . $option['face'] . '; ';
	$output .= 'font-weight:' . $option['style'] . '; ';
	$output .= 'font-size:' . $option['size'] . '; ';
	$output .= '}';
	$output .= "\n";
	// $output = $scss_var . ':';
	// $output .= $option['face'];
	// $output .= ';';

	return $output;

	// // Open the file to get existing content
	// $current = file_get_contents($file);
	// // Append a new person to the file
	// $current .= $output;
	// // Write the contents back to the file
	// file_put_contents($file, $current);

	// Could write to a separate stylesheet, that would be cool
	// $file = STYLESHEETPATH . '/library/scss/libs/_options.scss';
	// $handle = fopen($file, 'w') or die('Cannot open file:  '.$my_file);
	// $data = $output;
	// fwrite($handle, $data);
	// fclose($handle);
}

function options_background_style($option, $selectors) {
	$output = $selectors . ' {';
	if ( $option['image'] != '') {
		$output .= 'background-image:' . $option['image'];
	}
	$output .= '}';
	$output .= "\n";
	
}




?>