<?php

class WpExhibitHtmlBuilder {
    static function get_associated_exhibit($id) {
	 	$post_exhibit = new WpPostExhibit();
		if (DbMethods::loadFromDatabase($post_exhibit, $id, 'postid')) {
/*			$sample_facet = new WpExhibitFacet();
			$exhibitId = $post_exhibit->getId();
	        $post_exhibit->setFacets(WpExhibitModel::loadManyFromDatabase($sample_facet,
                                                       $exhibitId,
	                                                       'exhibitid'));  
      
	        $sample_view = new WpExhibitView();
	        $post_exhibit->setViews(WpExhibitModel::loadManyFromDatabase($sample_view,
	                                                      $exhibitId,
	                                                      'exhibitid'));

			$sample_lens = new WpExhibitLens();
			$lenses = $post_exhibit->setLenses(WpExhibitModel::loadManyFromDatabase($sample_lens, $exhibitId, 'exhibitid'));
	*/		
			return $post_exhibit;
		}
		return NULL;
	}

    static function insert_exhibit_lightbox($exhibit, $content) {
        $content = str_replace("{{Exhibit}}", self::get_exhibit_lightbox_link($exhibit), $content);
        $footnotes_string = self::get_data_footnotes_html($exhibit);
        $content = str_replace("{{Footnotes}}", $footnotes_string, $content);            
        return $content;
    }

    static function insert_exhibit_callout($exhibit, $content) {
        $content = str_replace("{{Exhibit}}", "<b>View full post to see Exhibit.</b>", $content);
        $footnotes_string = self::get_data_footnotes_html($exhibit);
        $content = str_replace("{{Footnotes}}", $footnotes_string, $content);            
        return $content;
    }
		
    static function insert_exhibit($exhibit, $content) {
		$exhibit_string = '';
		if ($exhibit->get('lightbox')) {
			$exhibit_string = self::get_exhibit_lightbox_link($exhibit);
		}
		else {
	        $exhibit_string = self::get_exhibit_html($exhibit);			
		}	
        $content = str_replace("{{Exhibit}}", $exhibit_string, $content);
        $footnotes_string = self::get_data_footnotes_html($exhibit);
        $content = str_replace("{{Footnotes}}", $footnotes_string, $content);            
      
        return $content;
    }
    
    static function get_exhibit_lightbox_link($exhibit) {	
			if (!$guessurl = site_url())
		    	$guessurl = wp_guess_url();
		    $baseuri = $guessurl;
		    $exhibituri = $baseuri . '/wp-content/plugins/datapress';
		    $exhibitid = $exhibit->get('id');
        	$exhibit_html = "<a href='$exhibituri/wp-exhibit-only.php?iframe&exhibitid=" . $exhibitid . "' class='exhibit_link_$exhibitid'>";	
			// Check for usage study
			if (get_option('datapress_et_phone_home') == "Y") {
	        	$exhibit_html .= "<img src='http://projects.csail.mit.edu/datapress/static/exhibit_lightbox.png?" . $exhibit->getStatisticReport() . "' />";
			}
			else {
	        	$exhibit_html .= "<img src='$exhibituri/images/exhibit_lightbox.png' />";				
			}
					
			$exhibit_html .= "</a>";
			return $exhibit_html;
	}

    static function get_exhibit_html($exhibit) {	
        $view_html = "";
        foreach ($exhibit->get('views') as $view) {
            $view_html = $view_html . $view->htmlContent();
            $view_html = $view_html . "\n";
		}
		
        $lens_html = "";
        foreach ($exhibit->get('lenses') as $lens) {
            $lens_html = $lens_html . $lens->htmlContent();
            $lens_html = $lens_html . "\n";
        }

        
        if ($view_html == "") {
            $view_html = "<div ex:role=\"view\"></div>";
        }
        
        $top_facet_html = self::facet_html($exhibit->get('facets'), 'top');
        $bottom_facet_html = self::facet_html($exhibit->get('facets'), 'bottom');
        $left_facet_html = self::facet_html($exhibit->get('facets'), 'left');
        $right_facet_html = self::facet_html($exhibit->get('facets'), 'right');
        if ($exhibit->get('lightbox')) {
	        $right_facet_html .= self::facet_html($exhibit->get('facets'), 'widget');	
		}
		    
        $colspan = 1;
        if (strlen($left_facet_html) > 0) {
            $colspan++;
            $left_facet_html = "<td width=\"15%\"> $left_facet_html </td>";
        }
        if (strlen($right_facet_html) > 0) {
            $colspan++;
            $right_facet_html = "<td width=\"15%\"> $right_facet_html </td>";
        }

		$tracker = "";
		// Check for usage study
		if (get_option('datapress_et_phone_home') == "Y") {
        	$tracker = "<img src='http://projects.csail.mit.edu/datapress/static/tiny.png?" . $exhibit->getStatisticReport() . "' />";
		}
		
        $exhibit_html = "
			$lens_html
            <table width=\"100%\">
                <tr>
                    <td colspan=3>
                        $top_facet_html
                    </td>
                </tr>
                <tr valign=\"top\">
                    $left_facet_html
                    <td ex:role=\"viewPanel\">
                        $view_html
                    </td>
                    $right_facet_html
                </tr>
                <tr>
                    <td colspan=3>
                        $bottom_facet_html
                    	$tracker
					</td>
                </tr>
            </table>";


        return $exhibit_html;
    }

    static function facet_html($facets, $location) {
        $facet_html = "";
        foreach ($facets as $facet) {
            if ($facet->get('location') == $location) {
                $facet_html = $facet_html . $facet->htmlContent();
                $facet_html = $facet_html . "\n";
            }
        }
        return $facet_html;
    }
    
    static function get_data_footnotes_html($exhibit) {
        $html = "<ul>";
        $ex_datasources = $exhibit->get('datasources');
		foreach($ex_datasources as $ex_datasource) {
			$sourcename = $ex_datasource->get('sourcename');
			$uri = $ex_datasource->get('uri');
    		$html .= "<li> <a href='$uri'>$sourcename</a>\n";
		}
		$html .= "</ul>";
		return $html;
    }
}
