<?php

// The comments template

/*  Comments are conditionally displayed
	according to the option selected in the 
	theme options - extensions/options-functions.php
*/

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<div class="alert alert-help">
			<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "wpfolio"); ?></p>
		</div>
	<?php
		return;
	}
?>
<?php
// Comments option - in options.php
$comment_option = of_get_option('comments');
if ( $comment_option == 'all' || $comment_option == 'blog' && is_singular('post') ): ?>
	<?php if ( have_comments() ) : ?>

		<h3 id="comments" class="h4"><?php comments_number(__('<span>No</span> Responses', 'wpfolio'), __('<span>One</span> Response', 'wpfolio'), _n('<span>%</span> Response', '<span>%</span> Responses', get_comments_number(),'wpfolio') );?> to &#8220;<?php the_title(); ?>&#8221;</h3>
		<nav id="comment-nav" class="nav"> 
			<ul class="clearfix">
				<li><?php previous_comments_link() ?></li>
				<li><?php next_comments_link() ?></li>
			</ul>
		</nav>
		<ol class="commentlist">
			<?php 

			wp_list_comments('type=comment&callback=bones_comments'); ?>
		</ol>

		<?php else : // this is displayed if there are no comments so far ?>

		<?php if ( comments_open() ) : ?>
				<!-- If comments are open, but there are no comments. -->

		<?php else : // comments are closed ?>

		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e("Comments are closed.", "wpfolio"); ?></p>

		<?php endif; ?>

	<?php endif; ?>


	<?php if ( comments_open() ) : ?>

		<?php comment_form(); ?>

	<?php endif; // if you delete this the sky will fall on your head ?>

<?php endif; ?>