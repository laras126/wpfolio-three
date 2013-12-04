<?php

/* 	A file for the artwork meta! 
   	It includes some lovely variables and markup to display said variables 
   	via the [artwork_info] shortcode on Projects
	The custom fields are defined in wpfolio.php in the Artwork Info Metabox section 
*/

global $post;

// TODO: do we need all of these?
// Artwork Info Metabox fields
$aw_title = get_post_meta( $post->ID, '_ctmb_title', true ) . '</h4>';
$aw_date = get_post_meta( $post->ID, '_ctmb_date', true );
$aw_medium = get_post_meta( $post->ID, '_ctmb_medium', true );
$aw_desc = get_post_meta( $post->ID, '_ctmb_description', true );
$aw_acknow = get_post_meta( $post->ID, '_ctmb_acknowledgements', true );
$aw_link = get_post_meta( $post->ID, '_ctmb_link', true );
?>

<div class="clearfix">
	<?php if ( $aw_title ) {
		echo '<h4>' . $aw_title . '</h4>';
	} ?>

	<ul class="artwork-meta">
		<?php 
		// Put each meta item in a list item if it isn't empty

		if ( $aw_date ) {
			echo '<li>' . $aw_date . '</li>';
		}

		if ( $aw_medium ) {
			echo '<li>' . $aw_medium . '</li>';
		}

		if ( $aw_collabs ) {
			echo '<li><strong>Acknowledgements:</strong> ' . $aw_acknow . '</li>';
		}

		if ( $aw_link ) {
			echo '<li><a href="' . $aw_link . '">Project Link</a></li>';
		}

		if ( $aw_desc ) {
			echo '<li>' . $aw_desc . '</li>';
		}
		
		?>
	</ul>
</div>