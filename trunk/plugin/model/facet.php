<?php
class WpExhibitFacet extends WpExhibitModel {
	
	protected $fields = array(
		'kind' => NULL,
		'field'  => NULL,
		'label' => NULL,
		'exhibitid' => NULL,
		'location' => NULL
	);
	
	function WpExhibitFacet($opts = NULL) {
		parent::WpExhibitModel($opts);		
	}

	function getTableName() {
		return WpExhibitConfig::table_name(WpExhibitConfig::$FACETS_TABLE_KEY);
	}
	
	function getFormPrefix() {
		return WpExhibitConfig::$FACET_FORM_PREFIX;
	}
	
	function getShortKind() {
		switch($this->get('kind')) {
			case 'search':
				return "Search Box";
			case 'browse':
				return "Data Browser";
			case 'tagcloud':
				return "Tag Cloud";				
			default:
				return "UnknownFacet";
		}
	}	

	function getLinkCaption() {
		return $this->getShortKind() . ": " . $this->get('label');
	}	
	
	function htmlContent() {
		$kind = $this->get('kind');
		$field = $this->get('field');
		$label = $this->get('label');
		
		if ($kind == "search") {
			return "<div ex:role=\"facet\" ex:facetClass=\"TextSearch\" ex:facetLabel=\"$label\"></div>";
		} else if ($kind == "browse") {
			return "<div ex:role=\"facet\" ex:expression=\".$field\" ex:facetLabel=\"$label\"></div>";
		} else if ($kind == "tagcloud") {
			return "<div ex:role=\"facet\" ex:facetClass=\"Cloud\" ex:expression=\".$field\" ex:facetLabel=\"$label\"></div>";		
		}
	}
	
	static function addFieldDisplay() {
	    return "{
	        location:function(key, value, field_name) {
	            options = ['left', 'right', 'top', 'bottom', 'widget'];
	            var str = \"<select name='\" + field_name + \"'>\";
	            jQuery.each(options, function(option) {
	                str += \"<option\";
	                if (options[option] == value) {
	                    str += \" selected\";
	                }
	                str += \">\" + options[option] + \"</option>\";
	            });
	            str += \"</select>\";
	            return str;
	        }
	    }";
	}
	
	function getAddFieldDisplay() {
        return self::addFieldDisplay();
	}
	
	function getEditInfo() {
	    switch($this->get('kind')) {
   			case 'search':
           	    return 'editable: true, tabid: "exhibit-facet-search"';
			case 'browse':
           	    return 'editable: true, tabid: "exhibit-facet-list"';
			case 'tagcloud':
           	    return 'editable: true, tabid: "exhibit-facet-tagcloud"';
	    	default:
        	    return 'editable: false';
		}
	}
}
?>
