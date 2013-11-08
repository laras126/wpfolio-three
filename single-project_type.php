<?php
/*

Template for single Projects

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

								<?php the_content(); ?>

							</section>

							<footer class="article-footer">
								<p class="tags"><?php 
								// No tags for now!
								// echo get_the_term_list( get_the_ID(), 'custom_tag', '<span class="tags-title">' . __( 'Custom Tags:', 'bonestheme' ) . '</span> ', ', ' ) ?></p>
								<?php include('include/artwork-meta.php'); ?>
							</footer>

							<?php comments_template(); ?>

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
