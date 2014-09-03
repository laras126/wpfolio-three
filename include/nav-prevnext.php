<div class="prev">
	<?php //TODO: better way to placehold in case this is empty (entity not very semantic) ?>
	&nbsp;
	<?php
	// NOTE: reversing these so they make more sense
	next_post_link('%link', '<strong>&larr; Previous</strong>'); ?>
</div>

<div class="nav-meta">
	<?php $category = get_the_term_list( get_the_ID(), 'category', ' ', ', ' );  ?>
	<strong><?php the_title() ?></strong> | <?php the_date('Y'); ?> | <strong><?php echo $category; ?></strong>
</div>

<div class="next">
	&nbsp;
	<?php previous_post_link('%link', '<strong>Next &rarr;</strong>'); ?>
</div>

<div class="mobile-prevnext">
	&nbsp;
	<?php next_post_link('%link', '<strong class="first">&larr; Previous</strong>'); ?>
	<?php previous_post_link('%link', '<strong class="last">Next &rarr;</strong>'); ?>
</div>
