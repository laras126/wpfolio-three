<?php

/**
 *
 * Template for Single portfolio (non-news) posts
 *
 */

?>

<?php while (have_posts()) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

		<h1 class="project-title single-title" itemprop="headline"><?php the_title(); ?></h1>

		<section class="entry-content clearfix">
			
			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php include('artwork-meta.php'); ?>

			<p><?php echo get_the_term_list( get_the_ID(), 'post_tag', '<span class="tags-title">' . __( 'Tags:', 'wpfolio' ) . '</span> ', ' ' ) ?></p>
			<?php edit_post_link(); ?>
		</section>

		<footer class="article-footer clearfix">
			<?php get_template_part('include/nav', 'prevnext'); ?>
		</footer>

		<?php comments_template(); ?>

	</article>

<?php endwhile; ?>
