<?php
require_once('db-methods.php');

class WpPostExhibit {
    // Used to save the exhibit in a DB
	protected $dbfields = array(
	    'id' => NULL,
		'postid' => NULL,
    	'exhibit_config' => NULL,
	    'version' => 1,
	);
	
	// Use null for non-list strings
	// Use an object to clone for arrays of objects
	protected $exhibitfields = array(
	    'lightbox' => NULL,
   	    'lenses' => NULL,
  	    'views' => NULL,
  	    'facets' => NULL,
  	    'datasources' => NULL,
		'css' => NULL,
		'custom_html' => NULL
	);
	
	static function getForPost($postid) {
        global $wpdb;
        $table = WpExhibitConfig::table_name(WpExhibitConfig::$EXHIBITS_ASSOC_TABLE_KEY);
        $exhibitid = $wpdb->get_var("SELECT exhibitid FROM $table WHERE postid=$postid ;");
        if (!($exhibitid == 0)) {
    	 	$post_exhibit = new WpPostExhibit();
    		if (DbMethods::loadFromDatabase($post_exhibit, $id, 'postid')) {
    			return $post_exhibit;
    		}
        }
		return NULL;
	}
	
	protected $constructedexhibit = array();
	
	function WpPostExhibit() {
        $this->exhibitfields['lenses'] = new WpExhibitLens();
  	    $this->exhibitfields['views'] = new WpExhibitView();
   	    $this->exhibitfields['facets'] = new WpExhibitFacet();
    	$this->exhibitfields['datasources'] = new WpExhibitDatasource();
    }

	function getTableName() {
		return WpExhibitConfig::table_name(WpExhibitConfig::$EXHIBITS_TABLE_KEY);
	}
	
	function getFormPrefix() {
		return WpExhibitConfig::$EXHIBIT_FORM_PREFIX;
	}
	
	function getLinkCaption() {
		return "Exhibit #" . $this->getId();
	}
	
	function afterDbLoad() {
	   $this->dbfields['exhibit_config'] = base64_decode($this->dbfields['exhibit_config']);
	   $this->constructedexhibit = self::build_from_json($this->dbfields['exhibit_config'], $this->exhibitfields);	  
	}
	
	function getFields() {
	    return $this->fields;
	}
	
    function get($field, $nice=false) {
        if (array_key_exists($field, $this->dbfields)) {
            return $this->dbfields[$field];
        } else if (array_key_exists($field, $this->exhibitfields)) {
			return $this->constructedexhibit[$field];
		} else {
			if (! $nice) {
				die("Attempted to get a field that does not exist: $field.");							
			}
		}
	}
	
	function set($field, $value, $nice=false) {
		if (array_key_exists($field, $this->dbfields)) {
			$this->dbfields[$field] = $value;
		} else if (array_key_exists($field, $this->exhibitfields)) {
			$this->constructedexhibit[$field] = $value;
		} else {
			if (! $nice) {
				die("Attempted to set a field that does not exist: $field.");				
			}
		}
	}
	
	function getStatisticReport($currentView) {
    	$postid = $this->get('postid');
		$permalink = base64_encode(get_permalink($this->get('postid')));
		$viewState = base64_encode($this->get('lightbox') ? "lightbox" : "inline");
		$postType = base64_encode(get_post($postid)->post_type);
		$currentView = base64_encode($currentView);
		$report = "{currentview: \"$currentView\", viewstate: \"$viewState\", posttype: \"$postType\", permalink: \"$permalink\"}";
		return $report;
	}
	
	function save() {
  		global $wpdb;

	    $this->dbfields['exhibit_config'] = self::get_json($this->exhibitfields, $this->constructedexhibit);

	    $table = $this->getTableName();
	    if ($this->dbfields['id'] == NULL) {
			// Do an insert
			$sql = "INSERT INTO $table (id, postid, exhibit_config, version) VALUES (%d, %d, %s, %d);";
			$sql = $wpdb->prepare($sql, $this->dbfields['id'], $this->dbfields['postid'], base64_encode($this->dbfields['exhibit_config']), $this->dbfields['version']);
		} else {
			// Do an update
			$sql = "UPDATE $table SET postid=%d, exhibit_config=%s, version=%d WHERE id=%d";
			$sql = $wpdb->prepare($sql, $this->dbfields['postid'], base64_encode($this->dbfields['exhibit_config']), $this->dbfields['version'], $this->dbfields['id']);
		}
		
		$result = $wpdb->query($sql);
		if ($this->dbfields['id'] == NULL) {
			// Get the ID of the insert and set it.
			$sql = "SELECT LAST_INSERT_ID();";
			$this->set('id', $wpdb->get_var($sql));
		}
	}
	
	static function get_json($fieldlist, $constructed) {
	    $structure = array();
	    foreach ($fieldlist as $kind => $factory) {
	        if ($factory == NULL) { // it's a string field
	            $structure[$kind] = $constructed[$kind];
	        } else {  // it's a list of cloneable objects
	            $arrays = array();
				if (array_key_exists($kind, $constructed) && ($constructed[$kind] != NULL)) {
		            foreach ($constructed[$kind] as $object) {
		                array_push($arrays, $object->getFields());
		            }					
				}
	            $structure[$kind] = $arrays;
	        }
	    }
	   	$json_encoded = json_encode($structure);
		return $json_encoded;
	}
	
	static function build_from_json($json, $fieldlist) {
        $decoded = (array) json_decode($json);
        $loadinto = array();
        foreach ($fieldlist as $kind => $factory) {
            if ($factory == NULL) { // it's a string field
           	    if ($json != NULL) {
                    $loadinto[$kind] = $decoded[$kind];
                } else {
                    $loadinto[$kind] = "";
                }
            } else { // it's a list of cloneable objects
    	        $objects = array();
    	        if (($json != NULL) && ($decoded != NULL)) {
                    foreach ($decoded[$kind] as $pairs) {
                        $cloned = clone $factory;
                        foreach ((array) $pairs as $key => $value ) {
                            $cloned->set($key, $value);
                        }
                        array_push($objects, $cloned);
                    }
                }
                $loadinto[$kind] = $objects;
            }
        }
        return $loadinto;
    }
}
?>
