<?php
/*

Image attachment template

It looks very similar to the single project template
Should it be differentiated more?

*/
?>

<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="clearfix" role="main">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

					<h1 class="single-title project-title"><?php the_title(); ?></h1>

					<section class="entry-content clearfix">

						<div class="attachment">
						<?php
							/**
							 *
							 * Code below taken graciously from the 
							 * Portfolio Press theme by Devin Price at WP Theming:
							 * http://wptheming.com/2010/07/portfolio-theme/
							 *
							 *
							 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
							 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
							 *
							 */

							$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
							foreach ( $attachments as $k => $attachment ) {
								if ( $attachment->ID == $post->ID )
									break;
							}
							$k++;
							// If there is more than 1 attachment in a gallery
							if ( count( $attachments ) > 1 ) {
								if ( isset( $attachments[ $k ] ) )
									// get the URL of the next image attachment
									$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
								else
									// or get the URL of the first image attachment
									$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
							} else {
								// or, if there's only 1 image, get the URL of the image
								$next_attachment_url = wp_get_attachment_url();
							}
						?>

						<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
						$attachment_size = apply_filters( 'portfoliopress_attachment_size', 1200 );
						echo wp_get_attachment_image( $post->ID, array( $attachment_size, $attachment_size ) ); // filterable image width with, essentially, no limit for image height.
						?></a>
					</div><!-- .attachment -->
					</section>

					<footer class="article-footer">
						<nav class="prev-next">
							<div class="prev">
								&nbsp;
								<?php 
								// NOTE: reversing these so they make more sense
								next_image_link( false, __( '&larr; Previous' , 'wpfolio' ) ); ?>
							</div>
							<div class="nav-meta">
								<?php
								// TODO is there unused information being pulled in here?
								$metadata = wp_get_attachment_metadata();
								printf( __( '<abbr class="published" title="%1$s">%2$s</abbr> | <strong><a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a></strong>', 'wpfolio	' ),
									esc_attr( get_the_time() ),
									get_the_date('Y'),
									wp_get_attachment_url(),
									$metadata['width'],
									$metadata['height'],
									get_permalink( $post->post_parent ),
									get_the_title( $post->post_parent )
								);
							?>
							</div>

							<div class="next">
								&nbsp;
								<?php previous_image_link( false, __( 'Next &rarr;' , 'wpfolio' ) ); ?>
							</div>

							<div class="mobile-prevnext">
								<?php previous_image_link( false, __( '<span class="first">&larr; Previous</span>&nbsp;' , 'wpfolio' ) ); ?>
								<?php next_image_link( false, __( '<span class="last">Next &rarr;</span>' , 'wpfolio' ) ); ?>
							</div>
						</nav>

					</footer>

				</article>

				<?php endwhile; ?>

				<?php else : ?>

						<?php get_template_part('include/post', 'notfound'); ?>

				<?php endif; ?>

			</div>

		</div>

	</div>

<?php get_footer(); ?>
