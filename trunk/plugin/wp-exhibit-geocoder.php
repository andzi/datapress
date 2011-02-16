<?php

class WpExhibitGeocoder {

    // Note: to get the google map API key, do this:
    // $google_map_api_key = get_option( 'google_map_api_key' );
    
    // If you need a separate key, other than this one, grep the project for google_map_api_key to see 
    // how we created an option form to add it
    
    // Perform the geocoding for a batch of items
    static function batch_add($exhibit_id, $datum_ids, $addresses) {
    }
    
    // Perform the geocoding for a single item
    static function doesExhibitContainGeocodedData($exhibit_id) {
        // Returns BOOL
    }

    static function lookup($exhibit_id, $datum_id, $address) {
        /*
         * If in database, reutrn lat,lng from database
         * Else, geocode; save to db, lookup from db
         */
	}

    static function geocode($address) {
    }

    static function save($exhibit_id, $datum_id, $address) {
    }
    
    // Pring out a data file for an exhibit
    static function json_for($exhibit_id) {
        // look up all points for the exhibit
        // write out tuples <datum_id, latlng>
    }
    
    static function say_hello() {
    }
}

WpExhibitGeocoder::say_hello()

?>