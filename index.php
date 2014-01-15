<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="clearfix sidebar-layout" role="main">

				<h1 class="archive-title h2">
					<?php echo wp_title(''); ?>
				</h1>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<?php get_template_part('include/post', 'standard'); ?>

				<?php endwhile; ?>
						
						<?php if (function_exists('bones_page_navi')) { ?>
								<?php bones_page_navi(); ?>
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

			<?php get_sidebar(); ?>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->	
 
<?php get_footer(); ?>
