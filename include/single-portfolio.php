	<div id="main" class="clearfix" role="main">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<section class="entry-content clearfix" itemprop="articleBody">
					<?php the_content(); ?>
				</section> <!-- end article section -->

				<footer class="article-footer">
					<p class="clearfix"><?php the_tags('<span class="tags">' . __('Tags:', 'bonestheme') . '</span> ', ', ', ''); ?></p>
				</footer> <!-- end article footer -->


				<?php comments_template(); ?>

			</article> <!-- end article -->

		<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part('include/post', 'notfound'); ?>

		<?php endif; ?>

	</div> <!-- end #main -->

</div> <!-- end #main -->