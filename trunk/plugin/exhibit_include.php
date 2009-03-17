<?php
	global $wp_query;
	$thePostID = $wp_query->post->ID;     
	if (isset($thePostID)) {
		// If a page, this is the page ID.
		// If the main page or a list of posts, this is the TOP post ID.
        include('head_for_lightbox.php');
		include('head_for_exhibit.php');
	}
?>
