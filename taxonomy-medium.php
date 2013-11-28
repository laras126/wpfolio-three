<?php
/*

Template for the medium taxonomy. 

*/
?>

<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="clearfix" role="main">

				<h1 class="medium-title"><span><?php _e( '', 'bonestheme' ); ?></span> <?php single_cat_title(); ?></h1>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix project-thumb' ); ?> role="article">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail();
						} else { 
							// Use thumbnails based on post format
							if ( has_post_format( 'video' )) { ?>
								<img src="<?php bloginfo('template_directory'); ?>/library/images/default-thumb-video.png" alt="<?php the_title(); ?>"/>
							<?php } else if ( has_post_format( 'audio' )) { ?>
								<img src="<?php bloginfo('template_directory'); ?>/library/images/default-thumb-audio.png" alt="<?php the_title(); ?>"/>
							<?php } else { ?>
								<img src="<?php bloginfo('template_directory'); ?>/library/images/default-thumb-image.png" alt="<?php the_title(); ?>"/>
							<?php } ?>
						<?php } ?>
						<h5 class="project-thumb-title line-clamp"><?php the_title(); ?></h5>
					</a>
				</article>

				<?php endwhile; ?>

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

			</div>

		</div>

	</div>

<?php get_footer(); ?>
