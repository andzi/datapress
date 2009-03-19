<?php
	if (!$guessurl = site_url())
    	$guessurl = wp_guess_url();
    $baseuri = $guessurl;
    $exhibituri = $baseuri . '/wp-content/plugins/datapress';
    $linkstring = "";
    foreach ($exhibits_to_show as $exhibit) {
        $exhibitid = $exhibit->get('id');
        $linkstring .= "$('a.exhibit_link_$exhibitid').fancybox({ 'frameWidth': $(window).width()*.9, 'frameHeight': $(window).height()*.9 });\n";
    }
?>
<script src="<?php echo $exhibituri ?>/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="<?php echo $exhibituri ?>/js/jquery.fancybox-1.2.0.pack.js" type="text/javascript"></script> 
<link rel="stylesheet" href="<?php echo $exhibituri ?>/css/jquery.fancybox.css" type="text/css" media="screen"/>
    
<script type="text/javascript">
$(document).ready(function() { 
    <?php echo $linkstring ?>
});
</script>
