<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="clearfix" role="main">

				<h1 class="archive-title h2">
					<?php echo wp_title(''); ?>
				</h1>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php wpf_layout(); ?>

				<?php endwhile; ?>

						<?php if (function_exists('wpfolio_page_navi')) { ?>
								<?php wpfolio_page_navi(); ?>
						<?php } else { ?>
								<nav class="wp-prev-next">
									<ul class="clearfix">
										<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "bonestheme")) ?></li>
										<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "bonestheme")) ?></li>
									</ul>
								</nav>
						<?php } ?>

				<?php else : ?>

						<?php get_template_part('include/post', 'notfound'); ?>

				<?php endif; ?>

			</div> <!-- end #main -->

			<?php wpf_sidebar(); ?>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
