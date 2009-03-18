<?php
class WpExhibitLens extends WpExhibitModel {
	
	protected $fields = array(
		'kind' => NULL,
		'class'  => NULL,
		'html' => NULL,
		'exhibitid' => NULL,
	);
	
	function WpExhibitLens($opts = NULL) {
		parent::WpExhibitModel($opts);		
	}

	function getTableName() {
		return WpExhibitConfig::table_name(WpExhibitConfig::$LENSES_TABLE_KEY);
	}
	
	function getFormPrefix() {
		return WpExhibitConfig::$LENSE_FORM_PREFIX;
	}
	
	function getShortKind() {
		switch($this->get('kind')) {
			case 'lens':
				return "Lens";
			default:
				return "UnknownLens";
		}
	}	

	function getLinkCaption() {
		return $this->getShortKind() . " for " . $this->get('class');
	}	
	
	function htmlContent() {
		$klass = $this->get('class');
		$html = $this->get('html');
		$massaged_html = $this->massage_html($html);
		$ret = "<div ex:role=\"lens\" itemTypes=\"$klass\" style=\"display: none;\">$massaged_html</div>";
		return $ret;
	}
	
	function massage_html($html) {
		$pattern = "~{{([^\}]*)}}~";
		$replacement = "<span ex:content=\"$1\"></span>";
		return preg_replace($pattern, $replacement, $html);
	}
	
	function getEditInfo() {
	    switch($this->get('kind')) {
			//case 'lens':
            //    return 'editable: true, tabid: "exhibit-views-bar"';
	    	default:
        	    return 'editable: false';
		}
	}
}
?>
