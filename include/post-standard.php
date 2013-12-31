<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

	<header class="article-header">
	<?php echo $cat_id; ?>
		<h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<p class="byline vcard"><?php
			printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> <span class="amp">&</span> filed under %4$s.', 'bonestheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), '', get_the_category_list(', '));
		?></p>
	</header> <!-- end article header -->

	<section class="entry-content clearfix">

		<?php 
		if ( has_excerpt() ) {
			the_excerpt();
		} else {
			the_content();
		} ?>
		
	</section> <!-- end article section -->

	<footer class="article-footer">
		<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', ''); ?></p>
		<?php edit_post_link('edit', '<p>', '</p>'); ?>

	</footer> <!-- end article footer -->

	<?php // comments_template(); // uncomment if you want to use them ?>

</article> <!-- end article -->