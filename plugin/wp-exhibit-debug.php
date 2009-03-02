<?php
class WpExhibitDebug {
    static function htmlpp($var) {
        echo "<pre>";
	    print_r($var);
   	    echo "</pre>";
    }
}
?>
