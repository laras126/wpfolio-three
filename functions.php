<?php

// ----
// ---- Include Files
// ----

// Sets up the options panel and default functions
require_once( get_template_directory() . '/extensions/options-functions.php' );

/*
1. library/bones.php
	- theme support functions
	- custom menu output & fallbacks
	- page-navi function
	- customizing the post excerpt
*/
require_once('library/bones.php');

/*
2. library/wpfolio.php
	- WPFolio features functions
		- Wide margins shortcode
	- Call Options Framework
*/
require_once('library/wpfolio.php');

/*
4. library/translation/translation.php
	- adding support for other languages
*/
require_once('library/translation/translation.php');


/*
5. extensions/class-tgm-plugin-activation.php
	- Require/recommend some plugins
	- https://github.com/thomasgriffin/TGM-Plugin-Activation
*/

require_once get_template_directory() . '/extensions/class-tgm-plugin-activation.php';



// ----
// ---- Comment Layout 
// ----


// ----
// ---- Misc Theme Requirements
// ----

if ( ! isset( $content_width ) ) $content_width = 960;

?>
