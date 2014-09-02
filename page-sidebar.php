<?php
/*
Template Name: Sidebar
*/

// Oh hey, a sidebar.
?>

<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

				<div id="main" class="sidebar-layout" role="main">

					<?php while (have_posts()) : the_post();
						
							get_template_part('include/content', 'page');
						endwhile; ?>

				</div> <!-- end #main -->

				<?php get_sidebar(); ?>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>