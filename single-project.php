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
						<p class="tags"><?php echo get_the_term_list( get_the_ID(), 'post_tag', '<span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ' ) ?></p>
						<?php edit_post_link('edit', '<p>', '</p>'); ?>
					</footer>

					<?php comments_template(); ?>

				</article>

				<?php endwhile; ?>

				<?php else : ?>

						<?php get_template_part('include/post', 'notfound'); ?>

				<?php endif; ?>

			</div>

		</div>

	</div>

<?php get_footer(); ?>
