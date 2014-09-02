<?php
/*

Template for Single portfolio (non-news) posts

*/
?>

<div id="main" class="clearfix" role="main">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

		<section class="entry-content clearfix">
			<h1 class="project-title single-title" itemprop="headline"><?php the_title(); ?></h1>
			<div class="clearfix">
				<?php the_content(); ?>
			</div>
			<?php include('artwork-meta.php'); ?>

			<p><?php echo get_the_term_list( get_the_ID(), 'post_tag', '<span class="tags-title">' . __( 'Tags:', 'wpfolio' ) . '</span> ', ' ' ) ?></p>
		</section>

		<footer class="article-footer clearfix">

			<div class="prev mobile-hide">
				<?php //TODO: better way to placehold in case this is empty (entity not very semantic) ?>
				&nbsp;
				<?php
				// NOTE: reversing these so they make more sense
				next_post_link('%link', '<strong>&larr; Previous</strong>'); ?>
			</div>

			<div class="pv-middle">
				<?php $category = get_the_term_list( get_the_ID(), 'category', ' ', ', ' );  ?>
				<strong><?php the_title() ?></strong> | <?php the_date('Y'); ?> | <strong><?php echo $category; ?></strong>
			</div>

			<div class="next mobile-hide">
				&nbsp;
				<?php previous_post_link('%link', '<strong>Next &rarr;</strong>'); ?>
			</div>

			<div class="mobile-show">
				&nbsp;
				<?php next_post_link('%link', '<strong class="prev">&larr; Previous</strong>'); ?>
				<?php previous_post_link('%link', '<strong class="next">Next &rarr;</strong>'); ?>
			</div>

		</footer>

		<?php comments_template(); ?>

	</article>

	<?php endwhile; ?>

	<?php else : ?>

			<?php get_template_part('include/post', 'notfound'); ?>

	<?php endif; ?>

</div> <!-- end #main -->
