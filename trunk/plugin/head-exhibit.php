<?
global $exhibits_to_show;
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';

if (count($exhibits_to_show) > 0) {
    	$google_map_api_key = get_option( 'google_map_api_key' );
    ?>
    <script src="<?php echo $exhibituri ?>/exhibit-api/exhibit-api.js?autoCreate=false" type="text/javascript"></script> 
    <script src="<?php echo $exhibituri ?>/exhibit-api/extensions/time/time-extension.js" type="text/javascript"></script>
    <script src="<?php echo $exhibituri ?>/exhibit-api/extensions/chart/chart-extension.js" type="text/javascript"></script>
    <?php 
    if ($google_map_api_key != null) { ?>
    <script src="<?php echo $exhibituri ?>/exhibit-api/extensions/map/map-extension.js?gmapkey=<?php echo $google_map_api_key ?>"></script>
    <? }

    /*
     * Output CSS if the exhibit is not lightboxed
     */
    foreach ($exhibits_to_show as $exhibit_to_show) {
        // If it isn't lightboxed (i.e., it is straight in the page) or if we're currently inside the lightbox
        if ((! $exhibit_to_show->get('lightbox')) || (isset($lightboxed_exhibit))) {
            $css = $exhibit_to_show->get('css');
            if ($css != NULL) {
        		?><link rel="stylesheet" href="<?php echo $css ?>" type="text/css" /><?php
        	}    
        }    
    }
    
}

?>