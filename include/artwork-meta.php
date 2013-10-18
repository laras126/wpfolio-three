<?php

/* 	A file for the artwork meta! 
   	It includes some lovely variables and markup to display said variables in:
		=> single-portfolio.php
		=> maybe somewhere else?
	The custom fields are defined in wpfolio.php in the Artwork Info Metabox section 
*/

global $post;

// Artwork Info Metabox fields
$aw_title = '<h4>' . get_post_meta( $post->ID, '_ctmb_title', true ) . '</h4>';
$aw_date = get_post_meta( $post->ID, '_ctmb_date', true );
$aw_medium = get_post_meta( $post->ID, '_ctmb_medium', true );
$aw_desc = get_post_meta( $post->ID, '_ctmb_description', true );
$aw_collabs = get_post_meta( $post->ID, '_ctmb_collaborators', true );
$aw_link = '<a href="' . get_post_meta( $post->ID, '_ctmb_link', true ) .'">Project Link</a>';

$meta_arr = array(
		$aw_title, 
		$aw_date, 
		$aw_medium,
		$aw_desc,
		$aw_collabs,
		$aw_link,
	);

?>

<ul class="artwork-meta">
	<?php 
	// Put each meta item in a list item if it isn't empty
	
	foreach( $meta_arr as $m ) { 
		if( $m != '' ) {
			echo '<li>' . $m . '</li>';
		}
	}
	
	?>
</ul>