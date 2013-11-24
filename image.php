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

									Hey WordPress: 
									Why does this this template need to be so complicated?

									Hey anyone who actually reads this:		
									Does this template need to be so complicated?

									Code below taken graciously from the 
									Portfolio Press theme by
									Devin Price at WP Theming:
									http://wptheming.com/2010/07/portfolio-theme/

									Thx! &hearts; Lara
									 
									 ---
									 
									 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
									 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
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

								<p class="attachment-meta byline">
									<?php
										// TODO there is some extra information being pulled in here (i.e. width, height)
										// Remove it!
										$metadata = wp_get_attachment_metadata();
										printf( __( '<span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span> | <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'portfoliopress' ),
											esc_attr( get_the_time() ),
											get_the_date('Y'),
											wp_get_attachment_url(),
											$metadata['width'],
											$metadata['height'],
											get_permalink( $post->post_parent ),
											get_the_title( $post->post_parent )
										);
									?>
									<?php edit_post_link( __( 'Edit', 'portfoliopress' ), ' | <span class="edit-link">', '</span>' ); ?>
								</p>

								<nav class="prev-next">
									<span class="prev"><?php previous_image_link( false, __( '&larr; Previous' , 'portfoliopress' ) ); ?></span>
									<span class="next"><?php next_image_link( false, __( 'Next &rarr;' , 'portfoliopress' ) ); ?></span>
								</nav><!-- .prev-next -->
								
							</footer>

						</article>

						<?php endwhile; ?>

						<?php else : ?>

								<article id="post-not-found" class="hentry clearfix">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single-project_type.php template.', 'bonestheme' ); ?></p>
									</footer>
								</article>

						<?php endif; ?>

					</div>

				</div>

			</div>

<?php get_footer(); ?>
