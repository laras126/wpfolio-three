<li id="post-<?php the_ID(); ?>" class="project-thumb">
	<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
		<?php if ( has_post_thumbnail() ) {
			the_post_thumbnail('wpf-thumb-300');
		} else { ?>
			<img src="<?php echo get_template_directory_uri(); ?>/library/images/default-thumb.png" alt="<?php the_title(); ?>"/>
		<?php } ?>
		<h5 class="project-thumb-title line-clamp"><?php the_title(); ?></h5>
	</a>
</li>