<?
/* This file saves, or updates, an exhibit to the database (depending on whether an ID is present).
 * it returns (JSONP-style) a callback with the Exhibit ID in the database. 
 *
 *
 * TODO:
 *  - Protect so that only admins can load this page
 *  - Write the code to save it
 */

/* -------------------------------------------------
 * Load up Wordpress
 * -------------------------------------------------
 */
	ob_start();
      $root = dirname(dirname(dirname(dirname(__FILE__))));
      if (file_exists($root.'/wp-load.php')) {
          // WP 2.6
          require_once($root.'/wp-load.php');
      } else {
          // Before 2.6
          require_once($root.'/wp-config.php');
      }
	ob_end_clean(); //Ensure we don't have output from other plugins.
	header('Content-Type: text/html; charset='.get_option('blog_charset'));

global $wpdb;
$ex_id = $_POST['exhibitid'];
$ex_exhibit = new WpPostExhibit();
if ($ex_id != NULL) {
    $ex_success = DbMethods::loadFromDatabase($ex_exhibit, $ex_id);
}

// Loop through data sources contained, add them if necessary, then 
// add the association
$ex_next_datasource = new WpExhibitDatasource();		
$formIds = WpExhibitModel::findFormObjectsByPrefix($ex_next_datasource->getFormPrefix());
$datasources = array();
foreach ($formIds as $formId) {
	$ex_next_datasource = new WpExhibitDatasource(array('formid'=>$formId));
    array_push($datasources, $ex_next_datasource);
}
$ex_exhibit->set('datasources', $datasources);

// Load all the facets
$ex_next_facet = new WpExhibitFacet();
$formIds = WpExhibitModel::findFormObjectsByPrefix($ex_next_facet->getFormPrefix());
$facets = array();
foreach ($formIds as $formId) {
	$ex_next_facet = new WpExhibitFacet(array('formid'=>$formId));
    array_push($facets, $ex_next_facet);
}
$ex_exhibit->set('facets', $facets);

// Load all the lenses
$ex_next_lens = new WpExhibitLens();
$formIds = WpExhibitModel::findFormObjectsByPrefix($ex_next_lens->getFormPrefix());
$lenses = array();
foreach ($formIds as $formId) {
	$ex_next_lens = new WpExhibitLens(array('formid'=>$formId));
	array_push($lenses, $ex_next_lens);
}
$ex_exhibit->set('lenses', $lenses);

// Load all the views
$ex_next_view = new WpExhibitView();	
$formIds = WpExhibitModel::findFormObjectsByPrefix($ex_next_view->getFormPrefix());
$views = array();
foreach ($formIds as $formId) {
	$ex_next_view = new WpExhibitView(array('formid'=>$formId));
    array_push($views, $ex_next_view);
}
$ex_exhibit->set('views', $views);

// Save exhibit-level configuration options
$lightbox = (WpExhibitModel::findFormObjectValue('display-configuration-lightbox') == 'show-lightbox');
$css = WpExhibitModel::findFormObjectValue('display-configuration-css');
$custom_html = WpExhibitModel::findFormObjectValue('display-configuration-custom-html');

$ex_exhibit->set('lightbox', $lightbox);
if ($css) {
	$ex_exhibit->set('css', $css);				
}
if ($custom_html) {
	$ex_exhibit->set('custom_html', $custom_html);				
}

$ex_exhibit->save();
echo $ex_exhibit->get('id');
?>
