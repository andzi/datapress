<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';
?>

<script src="<?php echo $exhibituri ?>/js/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="<?php echo $exhibituri ?>/js/jquery.fancybox-1.0.0.js" type="text/javascript"></script> 
<link rel="stylesheet" href="<?php echo $exhibituri ?>/css/fancy.css" type="text/css" media="screen"/>
    
<script type="text/javascript">
$(document).ready(function() { 
	$('a.exhibit_link').fancybox({ 'frameWidth': $('body').width(), 'frameHeight': $('body').height() });
});
</script>
