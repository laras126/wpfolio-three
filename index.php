<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="clearfix sidebar-layout" role="main">

				<?php

				/////////////
				// NOTE!
				/////////////
				// Removing the blog option - it's too hard to understand.
				// Replacing with a custom post type, sorry everyone
				// Sorry because the migration process will be annoying

				/// ------ old Blog Category Option code:

				// Only show posts in the blog category

				// If the blog cat option has been selected, query the posts

				// Get the blog category id from the option
				// $cat_id = of_get_option('blog_cat');

				// if($cat_id != '') {
				// 	// Query posts for that category
				// 	global $query_string;
				// 	query_posts ($query_string . 'cat=' . $cat_id);
				// } 

				?>							
				
					<h1 class="archive-title h2">
						<span><?php echo wp_title(''); ?>
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

					<?php 
					// Needed this for the blog query
					// wp_reset_query(); ?>

			</div> <!-- end #main -->

			<?php get_sidebar(); ?>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->	
 
<?php get_footer(); ?>
