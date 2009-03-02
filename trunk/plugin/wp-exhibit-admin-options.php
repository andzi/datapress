<?php 
// mt_options_page() displays the page content for the Test Options submenu
function exhibit_options_page() {
	// variables for the field and option names 
	    $opt_name = 'google_map_api_key';
	    $hidden_field_name = 'mt_submit_hidden';
	    $data_field_name = 'google_map_api_key';

	    // Read in existing option value from database
	    $google_map_api_key = get_option( $opt_name );

	    // See if the user has posted us some information
	    // If they did, this hidden field will be set to 'Y'
	    if( $_POST[ $hidden_field_name ] == 'Y' ) {
	        // Read their posted value
	        $google_map_api_key = $_POST[ $data_field_name ];

	        // Save the posted value in the database
	        update_option( $opt_name, $google_map_api_key );

	        // Put an options updated message on the screen

	?>
	<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
	<?php

	    }

	    // Now display the options editing screen

	    echo '<div class="wrap">';

	    // header

	    echo "<h2>" . __( 'Exhibit Plugin Options', 'mt_trans_domain' ) . "</h2>";

	    // options form

	    ?>

	<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

	<p><?php _e("Google Maps API Key:", 'mt_trans_domain' ); ?> 
	<input type="text" style="width: 350px;" name="<?php echo $data_field_name; ?>" value="<?php echo $google_map_api_key; ?>" size="20">(<a href="http://code.google.com/apis/maps/signup.html">Get a Google Maps Key</a>)<br />
	<i>This key provides Exhibits on Wordpress site access to Google Map functionality.</i>
	</p>

	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
	</p>

	</form>
	</div>

	<?php
}
?>