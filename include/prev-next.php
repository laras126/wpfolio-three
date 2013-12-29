<nav class="prev-next">
	<div class="prev">
		<?php 
		// NOTE: reversing these so they make more sense
		next_post_link('%link', '<strong>&larr; Previous</strong>'); ?>
	</div>
	<div class="next">
	<?php 
		// TODO: more reliable way to navigate through taxonomies?
		previous_post_link('%link', '<strong>Next &rarr;</strong>'); ?>
	</div>
</nav>