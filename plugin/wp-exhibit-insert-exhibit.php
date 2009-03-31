<?php

class WpExhibitHtmlBuilder {
    static $datapress_statistics_logger = "http://projects.csail.mit.edu/datapress/logger/logger.php";

    static function insert_exhibit_lightbox($exhibit, $content) {
        $content = str_replace("{{Exhibit}}", self::get_exhibit_lightbox_link($exhibit), $content);
        $footnotes_string = self::get_data_footnotes_html($exhibit);
        $content = str_replace("{{Footnotes}}", $footnotes_string, $content);            
        return $content;
    }
	
    static function insert_exhibit($exhibit, $content) {
		global $wp_query;
		$exhibit_string = '';
		if ($exhibit->get('lightbox')) {
			$exhibit_string = self::get_exhibit_lightbox_link($exhibit);
		}
		else {
	        $exhibit_string = self::get_exhibit_html($exhibit, 'inline', $wp_query->post->ID);
		}	
        $content = str_replace("{{Exhibit}}", $exhibit_string, $content);
        $footnotes_string = self::get_data_footnotes_html($exhibit);
        $content = str_replace("{{Footnotes}}", $footnotes_string, $content);            
      
        return $content;
    }
    
    static function get_exhibit_lightbox_link($exhibit) {	
	    global $wp_query;
			if (!$guessurl = site_url())
		    	$guessurl = wp_guess_url();
		    $baseuri = $guessurl;
		    $exhibituri = $baseuri . '/wp-content/plugins/datapress';
		    $exhibitid = $exhibit->get('id');
		    $exhibit_html = self::statistics_html($exhibit, 'preview', $wp_query->post->ID);
                     $exhibit_html .= "<a href='$exhibituri/wp-exhibit-only.php?iframe&exhibitid=$exhibitid&postid=" . $wp_query->post->ID . "' class='exhibit_link_$exhibitid'>";
                        $exhibit_html .= "<div class='teaser' id='teaser_$exhibitid'>
                                          <iframe src='$exhibituri/wp-exhibit-only.php?iframe&exhibitid=$exhibitid&justview=true' width='100%' height='300' scrolling='no' frameborder='0'>
                                          <p>Your browser does not support iframes.</p>
                                          </iframe>
                                          </div>
                                          <div class='cover' id='cover_$exhibitid'>
                                          <p>Your browser does not support iframes.</p>
                                          </div>";
                                                             
            $exhibit_html .= "</a>";
			return $exhibit_html;
	}

    static function statistics_html($exhibit, $currentView, $postid) {
        $html = "";
        if (get_option('datapress_et_phone_home') == "Y") {
            $html .= "<script type='text/javascript'>\n";
	        $report = $exhibit->getStatisticReport($currentView, $postid);
            $html .= "$.get('" . self::$datapress_statistics_logger . "', $report, null, 'script');\n";
	        $html .= "</script>\n";
	    }
	    return $html;
    }

    static function get_view_html($exhibit, $only_first = false) {
        // add lenses
        $lens_html = "";
        foreach ($exhibit->get('lenses') as $lens) {
            $lens_html = $lens_html . $lens->htmlContent();
            $lens_html = $lens_html . "\n";
        }
        
        // add views
        $view_html = "";
        foreach ($exhibit->get('views') as $view) {
            $view_html = $view_html . $view->htmlContent();
            $view_html = $view_html . "\n";
            if ($only_first) {
                break;
            }
		}
	    
        if ($view_html == "") {
            $view_html = "<div ex:role=\"view\"></div>";
        }
        
        return "$lens_html $view_html";
	}

    static function get_exhibit_html($exhibit, $currentView, $postid) {	
        $view_html = self::get_view_html($exhibit);
        		
        $top_facet_html = self::facet_html($exhibit->get('facets'), 'top');
        $bottom_facet_html = self::facet_html($exhibit->get('facets'), 'bottom');
        $left_facet_html = self::facet_html($exhibit->get('facets'), 'left');
        $right_facet_html = self::facet_html($exhibit->get('facets'), 'right');
        if ($exhibit->get('lightbox')) {
	        $right_facet_html .= self::facet_html($exhibit->get('facets'), 'widget');	
		}
		    
        $exhibit_colspan = 3;
        if (strlen($left_facet_html) > 0) {
            $exhibit_colspan--;
            $left_facet_html = "<td width=\"15%\"> $left_facet_html </td>";
        }
        if (strlen($right_facet_html) > 0) {
            $exhibit_colspan--;
            $right_facet_html = "<td width=\"15%\"> $right_facet_html </td>";
        }

		$tracker = self::statistics_html($exhibit, $currentView, $postid);
		
        $exhibit_html = "
            <table width=\"100%\">
                <tr>
                    <td colspan='3'>
                        $top_facet_html
                    </td>
                </tr>
                <tr valign=\"top\">
                    $left_facet_html
                    <td colspan='$exhibit_colspan' ex:role=\"viewPanel\">$view_html</td>
                    $right_facet_html
                </tr>
                <tr>
                    <td colspan='3'>
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
