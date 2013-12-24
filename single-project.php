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
							<?php include('include/artwork-meta.php'); ?>

						</section>

						<footer class="article-footer">
							
							<ul>
								
								<li class="tags"><?php echo get_the_term_list( get_the_ID(), 'people', '<span class="tags-title">' . __( 'People:', 'bonestheme' ) . '</span> ', ', ' ) ?></li>
								
								<li class="tags"><?php echo get_the_term_list( get_the_ID(), 'places', '<span class="tags-title">' . __( 'Places:', 'bonestheme' ) . '</span> ', ', ' ) ?></li>

								<li class="tags"><?php echo get_the_term_list( get_the_ID(), 'post_tag', '<span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ' ) ?></li>
							</ul>
							
							<?php edit_post_link('edit', '<p>', '</p>'); ?>
						</footer>

						<?php comments_template(); ?>

					</article>

					<?php endwhile; ?>

					<?php else : ?>

							<?php get_template_part('include/post', 'notfound'); ?>

					<?php endif; ?>

				</div> <!-- end #main -->

			</div> <!-- end #inner-content -->

		</div> <!-- end #content -->

<?php get_footer(); ?>
