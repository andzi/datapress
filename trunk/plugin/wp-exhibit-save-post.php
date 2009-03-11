<?php
class SaveExhibitPost {
    function save() {
	    $ex_post_id = $_POST['post_ID'];
	    $ex_exhibit_id = $_POST['exhibitid'];
	    if ($ex_exhibit_id != null) {
	        $ex_exhibit = new WpPostExhibit();
	        $ex_success = DbMethods::loadFromDatabase($ex_exhibit, $ex_exhibit_id);
	        if ($ex_success == true) {
		        // Create a new one
		        $ex_exhibit->set('postid', $ex_post_id);
	        }
            $ex_exhibit->save();
        }
    }
}
?>
