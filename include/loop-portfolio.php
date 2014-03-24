<figure id="post-<?php the_ID(); ?>" class="project-thumb">
	<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
		<?php if ( has_post_thumbnail() ) {
			the_post_thumbnail('wpf-thumb-300');
		} else {
			wpf_get_first_thumb();
		} ?>
		<h5 class="project-thumb-title line-clamp"><?php the_title(); ?></h5>
	</a>
</figure>
