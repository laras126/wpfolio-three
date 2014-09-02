	<aside id="primary-sidebar" class="sidebar clearfix" role="complementary">

		<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

			<?php dynamic_sidebar( 'primary-sidebar' ); ?>

		<?php else : ?>

			<!-- This content shows up if there are no widgets defined in the backend. -->

			<div class="alert alert-help">
				<p><?php _e("Please activate some Widgets.", "wpfolio");  ?></p>
			</div>

		<?php endif; ?>

	</aside> <!-- end #sidebar1 -->