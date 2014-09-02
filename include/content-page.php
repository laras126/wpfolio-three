<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<header class="article-header">
		<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
	</header> <!-- end article header -->

	<section class="entry-content clearfix" itemprop="articleBody">
		<?php the_content(); ?>
	</section> <!-- end article section -->

	<footer class="article-footer">
		<?php the_tags('<span class="tags">' . __('Tags:', 'wpfolio') . '</span> ', ', ', ''); ?>
		<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
	</footer> <!-- end article footer -->

	<?php comments_template(); ?>

</article> <!-- end article -->