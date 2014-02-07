			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap clearfix">
					<?php 
						$credit_option = of_get_option('credits');
						if ( $credit_option == 'yes' ): ?>
							<p class="credits">Proudly Powered by <a href="http://wordpress.org">WordPress</a>, theme <a href="http://wpfolio.notlaura.com">WPFolio</a>.</p>
					<?php endif; ?>
					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>

				</div> <!-- end #inner-footer -->

			</footer> <!-- end footer -->

		</div> <!-- end #container -->

		<?php wp_footer(); ?>

	</body>

</html>
