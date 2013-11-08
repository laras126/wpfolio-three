	<div id="main" class="clearfix" role="main">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

				<header class="article-header">
					<h1 class="h2 single-title" itemprop="headline"><?php the_title(); ?></h1>
				</header> <!-- end article header -->

				<section class="entry-content clearfix">
					<?php the_content(); ?>
				</section> <!-- end article section -->

				<footer class="article-footer">
					<?php include('artwork-meta.php'); ?>
					<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tagged:', 'bonestheme') . '</span> ', ', ', ''); ?></p>
					<?php edit_post_link('edit', '<p>', '</p>'); ?>
				</footer> <!-- end article footer -->
				
				<?php comments_template(); ?>
			
			</article> <!-- end article -->

		<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part('include/post', 'notfound'); ?>

		<?php endif; ?>

	</div> <!-- end #main -->

</div> <!-- end #main -->