<?php

/*

Author: Lara Schenck
URL: htp://notlaura.com

Theme WPFolio, built from the starter theme
Bones by Eddie Machado:
http://themble.com/bones

*/


/********************* 
INCLUDE NEEDED FILES 
*********************/

// Sets up the options panel and default functions
require_once( get_template_directory() . '/extensions/options-functions.php' );

/*
1. library/wpfolio.php
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- auto assign featured image
	- portfolio vs. blog body classes
	- conditional layouts for said classes
	- TODO: fill this in more
	- require plugins
*/
require_once('library/wpfolio.php');

/*
2. library/translation/translation.php
	- adding support for other languages
*/
require_once('library/translation/translation.php'); // this comes turned off by default


/*
5. extensions/class-tgm-plugin-activation.php
	- Require/recommend some plugins
	- https://github.com/thomasgriffin/TGM-Plugin-Activation
*/

require_once get_template_directory() . '/extensions/class-tgm-plugin-activation.php';



/*********************
THUMBNAIL SIZE OPTIONS 
*********************/

// Thumbnail sizes
add_image_size( 'wpf-thumb-300', 300, 300, true );

// remove inline style for gallery shortcode
add_filter( 'use_default_gallery_style', '__return_false' );


/********************* 
ACTIVE SIDEBARS 
********************/

// Sidebars & Widgetizes Areas
if ( ! function_exists( 'wpfolio_register_sidebars' ) ):
	function wpfolio_register_sidebars() {
		register_sidebar(array(
			'id' => 'sidebar1',
			'name' => __('Sidebar', 'bonestheme'),
			'description' => __('The first (primary) sidebar.', 'bonestheme'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));

	} // don't remove this bracket!
endif;




/*********************
COMMENT LAYOUT 
*********************/

// Comment Layout
function wpfolio_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?>>

		<article id="comment-<?php comment_ID(); ?>" class="clearfix">

			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<!-- custom gravatar call -->
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'bonestheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'bonestheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'bonestheme'),'  ','') ?>
			</header>

			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e('Your comment is awaiting moderation.', 'bonestheme') ?></p>
				</div>
			<?php endif; ?>

			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>

			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

		</article>

	<!-- </li> is added by WordPress automatically -->

<?php
} // don't remove this bracket!




/********************* 
SEARCH FORM LAYOUT 
*********************/

// Search Form
function wpfolio_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestheme').'" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!




/*********************
MISC THEME REQUIREMENTS 
*****************/

if ( ! isset( $content_width ) ) $content_width = 960;

?>