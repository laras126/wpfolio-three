<?php while (have_posts()) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

		<header class="article-header">
			<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
			<p class="byline vcard"><?php
			printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'wpfolio' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );
			?></p>
		</header>

		<section class="entry-content clearfix" itemprop="articleBody">
			<?php the_content(); ?>
		</section>

		<footer class="article-footer clearfix">

			<?php get_template_part('include/nav', 'prevnext'); ?>

			<!-- <div class="prev mobile-hide">
				<?php
				// NOTE: reversing these so they make more sense
				next_post_link('%link', '<strong>&larr; Previous</strong>'); ?>
		  	</div>
			<div class="pv-middle">
				<?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'wpfolio' ) . '</span> ', ', ', '</p>' ); ?>
			</div>
			<div class="next mobile-hide">
				<?php previous_post_link('%link', '<strong>Next &rarr;</strong>'); ?>
			</div>

			<div class="mobile-show">
				<?php next_post_link('%link', '<strong class="prev">&larr; Previous</strong>'); ?>
				<?php previous_post_link('%link', '<strong class="next">Next &rarr;</strong>'); ?>
			</div> -->

		</footer>

		<?php comments_template(); ?>

	</article>

<?php endwhile; ?>