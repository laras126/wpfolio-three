<?php

/* 	A file for the artwork meta! 
   	It includes some lovely variables and markup to display said variables 
   	via the [artwork_info] shortcode on Projects
	The custom fields are defined in wpfolio.php in the Artwork Info Metabox section 
*/

global $post;

// Artwork Info Metabox fields
//$aw_title = the_title();
$aw_date = get_post_meta( $post->ID, '_ctmb_date', true );
$aw_medium = get_post_meta( $post->ID, '_ctmb_medium', true );
$aw_desc = get_post_meta( $post->ID, '_ctmb_description', true );
$aw_acknow = get_post_meta( $post->ID, '_ctmb_acknowledgments', true );
$aw_link = get_post_meta( $post->ID, '_ctmb_link', true );
$aw_link_text = get_post_meta( $post->ID, '_ctmb_link_text', true ); 
?>

<!-- <div class="clearfix"> -->
	<h4><?php echo the_title(); ?></h4>

	<ul class="artwork-meta">
		<?php 
		// Put each meta item in a list item if it isn't empty

		if ( $aw_date ) {
			echo '<li>' . $aw_date . '</li>';
		}

		if ( $aw_medium ) {
			echo '<li>' . $aw_medium . '</li>';
		}

		if ( $aw_link ) {
			echo '<li class="aw-sep project-link"><a href="' . $aw_link . '">' . $aw_link_text . '</a></li>';
		}

		if ( $aw_desc ) {
			echo '<li class="aw-sep">' . $aw_desc . '</li>';
		}

		if ( $aw_acknow ) {
			echo '<li class="aw-sep"><h5>Acknowledgements</h5>' . $aw_acknow . '</li>';
		}

		?>
	</ul>
<!-- </div> -->