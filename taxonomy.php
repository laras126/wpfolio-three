<?php
/*

Template for the medium taxonomy archive. 

*/
?>

<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="clearfix" role="main">

				<!-- TODO: conditionally show taxonomy term (i.e. People: Lara Schenck, Places: Louvre) -->
				<h2 class="medium-title"><span><?php _e( '', 'bonestheme' ); ?></span> <?php single_cat_title(); ?></h2>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix project-thumb' ); ?> role="article">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail();
						} else { ?>
							<img src="<?php bloginfo('template_directory'); ?>/library/images/default-thumb-image.png" alt="<?php the_title(); ?>"/>
						<?php } ?>
						<h5 class="project-thumb-title line-clamp"><?php the_title(); ?></h5>
					</a>
				</article>

				<?php endwhile; ?>

				<?php else : ?>

						<?php get_template_part('include/post', 'notfound'); ?>

				<?php endif; ?>

			</div>

		</div>

	</div>

<?php get_footer(); ?>



<?php


// Loop through gallery images and output as list
// Called in index/....
function show_gallery_images_in_slideshow( $content ) {

 	global $post;

 	// Retrieve the first gallery in the post
 	$gallery = get_post_gallery_images( $post );

	$image_list = '<ul class="carousel">';

	// Loop through each image in each gallery
	foreach( $gallery as $image ) {

		$image_list .= '<li><img src="' . $image . '" /></li>';

	}

	$image_list .= '</ul>';

	// Append our image list to the content of our post
	return $image_list;

}

?>