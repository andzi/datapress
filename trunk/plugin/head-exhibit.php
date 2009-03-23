<?
global $exhibits_to_show;

if (count($exhibits_to_show) > 0) {
    	$google_map_api_key = get_option( 'google_map_api_key' );
    ?>
    <script src="http://api.simile-widgets.org/exhibit/2.2.0/exhibit-api.js?autoCreate=false" type="text/javascript"></script> 
    <script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/time/time-extension.js" type="text/javascript"></script>
    <script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/chart/chart-extension.js" type="text/javascript"></script>
    <?php 
    if ($google_map_api_key != null) { ?>
    <script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/map/map-extension.js?gmapkey=<?php echo $google_map_api_key ?>"></script>
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