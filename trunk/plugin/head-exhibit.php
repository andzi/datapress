<?php
global $exhibits_to_show;

if (count($exhibits_to_show) == 1) {
    if ((! $exhibits_to_show[0]->get('lightbox')) || (isset($lightboxed_exhibit))) {
        $google_map_api_key = get_option( 'google_map_api_key' );
        ?>
        <script src="http://api.simile-widgets.org/exhibit/2.2.0/exhibit-api.js?autoCreate=false" type="text/javascript"></script> 
        <script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/time/time-extension.js" type="text/javascript"></script>
        <script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/chart/chart-extension.js" type="text/javascript"></script>
        <?php 
        if ($google_map_api_key != null) { 
            ?><script src="http://api.simile-widgets.org/exhibit/2.2.0/extensions/map/map-extension.js?gmapkey=<?php echo $google_map_api_key ?>"></script><?php
        }
        
        $css = $exhibits_to_show[0]->get('css');
        if ($css != NULL) {
    		?><link rel="stylesheet" href="<?php echo $css ?>" type="text/css" /><?php
    	}
    	
    	echo('<script type="text/javascript">');
    	include('head-start-exhibit.js');    
    	echo('</script>');
    }
}

?>