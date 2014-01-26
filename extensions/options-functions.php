<?php

// All the functions for applying the Options Framework
// Included in functions.php


// Include functions to return options
require_once( get_template_directory() . '/options.php' );


if ( !function_exists( 'of_get_option' ) ) {
    function of_get_option($name, $default = false) {
        
        $optionsframework_settings = get_option('optionsframework');
        
        // Gets the unique option id
        $option_name = $optionsframework_settings['id'];
        
        if ( get_option($option_name) ) {
            $options = get_option($option_name);
        }
            
        if ( isset($options[$name]) ) {
            return $options[$name];
        } else {
            return $default;
        }
    }
}



// --- GOOGLE FONTS FUNCTIONS --- //

// What an excellent tutorial by Devin at WP Theming!
// http://wptheming.com/2012/06/loading-google-fonts-from-theme-options/


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
        $heading_google_mixed = of_get_option('heading_font', false);
        $title_google_mixed = of_get_option('title_font', false);

        // Get the font face for each option and put it in an array
        $selected_fonts = array(
            $body_google_mixed['face'],
            $heading_google_mixed['face'],
            $title_google_mixed['face']
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




// --- RETURN STLYE OPTIONS --- //

/*
 * Returns styling options so they can be printed in the <head>
 */

function options_background_style($option, $selectors) {
    
    // http://stackoverflow.com/questions/13906286/php-css-output-options-framework-content
    
    $background = $option;
    $output = $selectors . ' { ';

    if ($background['color'] || $background['image']) {

        if ($background['color']) {   
            $output .= 'background: ' .$background['color']. ';';
        }

        if ($background['image']) {
            $output .=  'background: url('.$background['image']. ') ';
            $output .= $background['repeat']. ' ';
            $output .= $background['position']. ' ';
            $output .= $background['attachment']. ';';
        } 

        $output .=  '}';
        $output .= "\n";
        
        return $output;
    }
    
}

function options_font_family($option, $selectors) {
    $output = $selectors . ' { ';
    $output .= 'font-family: ' . $option['face'] . '; ';
    $output .= '}';
    $output .= "\n";
    return $output;
}


/*
 * Outputs the selected option panel styles inline into the <head>
 */
function options_head_css() {
    $output = '';
    $input = '';

    if ( of_get_option( 'body_typography' ) ) {
        $input = of_get_option( 'body_typography' );
        $output .= options_font_family( $input, 'body, input, textarea, button' );
    }

    if ( of_get_option( 'body_background' ) ) {
        $input = of_get_option( 'body_background' );
        $output .= options_background_style( $input , 'body');
    }

    if ( of_get_option( 'heading_font' ) ) {
        $input = of_get_option( 'heading_font' );
        $output .= options_font_family( $input , 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6');
    }

    if ( of_get_option( 'title_font' ) ) {
        $input = of_get_option( 'title_font' );
        $output .= options_font_family( $input , 'h1.site-title a');
    }

    if ( of_get_option( 'custom_css' ) ) {
        $input = of_get_option( 'custom_css' );
        $output .= "/* Custom CSS */\n";
        $output .= $input;
    }

    // Output styles
    if ($output <> '') {
        $output = "<!-- Options Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
        echo $output;
    }


}

add_action('wp_head', 'options_head_css');



// --- FAVICON OPTION --- //

function options_favicon() {
    $favicon = of_get_option('custom_favicon', false);
    if ( $favicon ) {
        echo '<link rel="shortcut icon" href="'.  $favicon  .'"/>'."\n";
    }
}

add_action('wp_head', 'options_favicon');






?>