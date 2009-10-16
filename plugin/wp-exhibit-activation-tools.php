<?php 

class WpExhibitActivationTools {
    static function activate_plugin() {
        self::setup_exhibits_table();
        self::setup_parrotable_urls_table();
        self::setup_post_exhibits_table();
    
        if (get_option(WpExhibitConfig::$WP_EXHIBIT_DB_VERSION_KEY)) {
            update_option(WpExhibitConfig::$WP_EXHIBIT_DB_VERSION_KEY,
                          WpExhibitConfig::$DB_VERSION);
        } else {
            add_option(WpExhibitConfig::$WP_EXHIBIT_DB_VERSION_KEY,
                       WpExhibitConfig::$DB_VERSION);
        }

		// Participate in usage study by default
		update_option( 'datapress_et_phone_home', "Y" );
    }

    static function deactivate_plugin() {
        // Make the DB schema version equal something different, so that
        // if we reactivate, we force the DB tables to be re-aligned to the
        // latest schema.  Not important for production, but helpful in
        // development.
        $key = get_option(WpExhibitConfig::$WP_EXHIBIT_DB_VERSION_KEY);
        if ($key) {
            update_option(WpExhibitConfig::$WP_EXHIBIT_DB_VERSION_KEY,
                          "-".$key);
        }
    }
    
    static function setup_exhibits_table() {
        $creation_sql = "  (
            id INT NOT NULL AUTO_INCREMENT,
            version INT,
            exhibit_config TEXT,
            PRIMARY KEY  (id)
            )";
        self::setup_table(WpExhibitConfig::$EXHIBITS_TABLE_KEY,
                          $creation_sql);
    }
    
    static function setup_datascrap_table() {
        $creation_sql = "  (
            id INT NOT NULL AUTO_INCREMENT,
            datascrap TEXT,
            kind varchar(255),
            PRIMARY KEY  (id)
            )";
        self::setup_table(WpExhibitConfig::$DATASCRAPS_TABLE_KEY,
                          $creation_sql);
    }

    static function setup_post_datascraps_table() {
        $creation_sql = "  (
            postid INT,
            datascrapid INT, 
            INDEX (postid, datascrapid)
            )";
        self::setup_table(WpExhibitConfig::$DATASCRAPS_ASSOC_TABLE_KEY,
                          $creation_sql);
    }
    
    
    static function setup_post_exhibits_table() {
        $creation_sql = "  (
            postid INT,
            exhibitid INT, 
            INDEX (postid, exhibitid)
            )";
        self::setup_table(WpExhibitConfig::$EXHIBITS_ASSOC_TABLE_KEY,
                          $creation_sql);
    }
    
    static function setup_parrotable_urls_table() {
        $creation_sql = "  (
            url VARCHAR(255) CHARACTER SET latin1 NOT NULL,
            PRIMARY KEY  (url)
            )";
        self::setup_table(WpExhibitConfig::$PARROTABLE_URLS_TABLE_KEY,
                          $creation_sql);
    }

    static function setup_table($table_name, $creation_sql) {
        $table_name = WpExhibitConfig::table_name($table_name);
        $sql = "CREATE TABLE $table_name $creation_sql";
        if (get_option(WpExhibitConfig::$WP_EXHIBIT_DB_VERSION_KEY) != 
            WpExhibitConfig::$DB_VERSION) {
           require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
           dbDelta($sql);
           echo "done building table $table_name";
        }
    }

}

?>
