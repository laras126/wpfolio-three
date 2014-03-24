<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="clearfix" role="main">

						<?php if (is_category()) { ?>
							<h1 class="archive-title h2">
								<span><?php _e( '', 'bonestheme' ); ?></span> <?php single_cat_title(); ?>
							</h1>

						<?php } elseif (is_tag()) { ?>
							<h1 class="archive-title h2">
								<span><?php _e( 'Tagged:', 'bonestheme' ); ?></span> <?php single_tag_title(); ?>
							</h1>

						<?php } elseif (is_author()) {
							global $post;
							$author_id = $post->post_author;
						?>
							<h1 class="archive-title h2">

								<span><?php _e( 'Posts By:', 'bonestheme' ); ?></span> <?php the_author_meta('display_name', $author_id); ?>

							</h1>
						<?php } elseif (is_day()) { ?>
							<h1 class="archive-title h2">
								<span><?php _e( 'Daily Archives:', 'bonestheme' ); ?></span> <?php the_time('l, F j, Y'); ?>
							</h1>

						<?php } elseif (is_month()) { ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Monthly Archives:', 'bonestheme' ); ?></span> <?php the_time('F Y'); ?>
								</h1>

						<?php } elseif (is_year()) { ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Yearly Archives:', 'bonestheme' ); ?></span> <?php the_time('Y'); ?>
								</h1>
						<?php } ?>

						<?php
						// TODO: there is a more elegant solution than wrapping this in a clearfix -
						// The issue is that the portfolio items are floating and get messed up w/o it
						?>

						<div class="clearfix">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

								<?php wpf_layout(); ?>

							<?php endwhile; ?>
						</div>

							<?php if ( function_exists( 'bones_page_navi' ) ) { ?>
								<?php bones_page_navi(); ?>
							<?php } else { ?>
								<nav class="wp-prev-next">
									<ul class="clearfix">
										<li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'bonestheme' )) ?></li>
										<li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'bonestheme' )) ?></li>
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
