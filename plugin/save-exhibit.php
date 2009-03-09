<?
/* This file saves, or updates, an exhibit to the database (depending on whether an ID is present).
 * it returns (JSONP-style) a callback with the Exhibit ID in the database. 
 *
 *
 * TODO:
 *  - Protect so that only admins can load this page
 *  - Write the code to save it
 */

global $wpdb;		
$ex_id = $_POST['exhibitid'];
$callback = $_POST['callback'];
$ex_exhibit = new WpPostExhibit();
if ($exhibitID != NULL) {
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
echo $callback . "(" $ex_exhibit->get('id') . ");"
?>
