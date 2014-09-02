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

					<?php while (have_posts()) : the_post();
						
							get_template_part('include/content', 'page');
						
						endwhile; ?>

				</div> <!-- end #main -->

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
