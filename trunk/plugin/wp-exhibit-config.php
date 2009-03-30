<?php

class WpExhibitConfig {
    // datapress schema version
    public static $DB_VERSION = "2";

    // table keys
    public static $EXHIBITS_TABLE_KEY = "exhibits";
    public static $PARROTABLE_URLS_TABLE_KEY = "parrotable_urls";
    public static $EXHIBITS_ASSOC_TABLE_KEY = "posts_exhibits";
	// Form prefixes
	public static $DATA_FORM_PREFIX = "data";
	public static $FACET_FORM_PREFIX = "facet";
	public static $LENSE_FORM_PREFIX = "lens";
	public static $VIEW_FORM_PREFIX = "view";	
	public static $EXHIBIT_FORM_PREFIX = "exhibit";	
    
    // wp configuration keys
    public static $WP_EXHIBIT_DB_VERSION_KEY = "wp_exhibit_dbversion";
 
    static function table_name($table_name) {
        global $wpdb;
        return $wpdb->prefix . "_wp_exhibit_" . $table_name;
    }
}

?>
