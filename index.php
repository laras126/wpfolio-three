<?php 

// ********* NOTE NOTE NOTE!! ********* //

/*	WPFolio Three queries the index page to only show posts in 
	the Blog category as set in the Theme Options.
	If a blog category hasn't been set, a prompt to do so will be shown 
	in the admin, and it will just be a normal loop
*/

// ************* END NOTE ************* //


get_header(); ?>

		<div id="content">

			<div id="inner-content" class="wrap clearfix">

					<div id="main" class="clearfix" role="main">

						<?php 
						// Only show posts in the blog category

						// If the blog cat option has been selected, query the posts

						// Get the blog category id from the option
						$cat_id = of_get_option('blog_cat');

						if($cat_id != '') {
							// Query posts for that category
							global $query_string;
							query_posts ($query_string . 'cat=' . $cat_id);
						} ?>							
						

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

								<header class="article-header">
								<?php echo $cat_id; ?>
									<h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
									<p class="byline vcard"><?php
										printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'bonestheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', '));
									?></p>
								</header> <!-- end article header -->

								<section class="entry-content clearfix">
									<?php the_content(); ?>
								</section> <!-- end article section -->

								<footer class="article-footer">
									<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', ''); ?></p>
									<?php edit_post_link('edit', '<p>', '</p>'); ?>

								</footer> <!-- end article footer -->

								<?php // comments_template(); // uncomment if you want to use them ?>

							</article> <!-- end article -->

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

									<article id="post-not-found" class="hentry clearfix">
											<header class="article-header">
												<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e("This is the error message in the index.php template.", "bonestheme"); ?></p>
										</footer>
									</article>

							<?php endif; ?>

							<?php wp_reset_query(); ?>

					</div> <!-- end #main -->

					<?php get_sidebar(); ?>

			</div> <!-- end #inner-content -->

		</div> <!-- end #content -->	
 
<?php get_footer(); ?>
