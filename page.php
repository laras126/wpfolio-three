<?php 

// ********* NOTE NOTE NOTE!! ********* //

/*  WPFolio Three's default page template 
	has no sidebar because, well, who wants a sidebar?
	If the answer is you, use the Sidebar 
	template in the Page Attributes->Template option */

// ************* END NOTE ************* //

get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

				<div id="main" class="clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="article-header">

							<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

						</header> <!-- end article header -->

						<section class="entry-content clearfix widemargins" itemprop="articleBody">
							<?php the_content(); ?>
						</section> <!-- end article section -->

						<footer class="article-footer">
							<?php the_tags('<span class="tags">' . __('Tags:', 'bonestheme') . '</span> ', ', ', ''); ?>
							<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
						</footer> <!-- end article footer -->

						<?php comments_template(); ?>

					</article> <!-- end article -->

					<?php endwhile; else :

							get_template_part('include/post', 'notfound');

						endif; ?>

				</div> <!-- end #main -->

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
