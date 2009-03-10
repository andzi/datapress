<?php
class WpExhibitView extends WpExhibitModel {
	
	protected $fields = array(
		'kind' => NULL,
		'klass' => NULL,
		'field'  => NULL,
		'label' => NULL,
		'caption' => NULL,
		'end' => NULL,
		'locationtype' => NULL,
		'coderfield' => NULL,
		'exhibitid' => NULL,
		'xField' => NULL,
		'yField' => NULL,
		'xLabel' => NULL,
		'yLabel' => NULL,
		'yScale' => NULL,
		'xScale' => NULL,
		'color' => NULL,
		'sortby' => NULL,
		'proxy' => NULL,
		'icon' => NULL,
		'bubblewidth' => NULL,
		'bubbleheight' => NULL,		
		'markerwidth' => NULL,
		'markerheight' => NULL,		
		'extra_attributes' => NULL
	);
	
	function WpExhibitView($opts = NULL) {
		parent::WpExhibitModel($opts);		
	}

	function getTableName() {
		return WpExhibitConfig::table_name(WpExhibitConfig::$VIEWS_TABLE_KEY);
	}
	
	function getFormPrefix() {
		return WpExhibitConfig::$VIEW_FORM_PREFIX;
	}
	
	function getShortKind() {
		switch($this->get('kind')) {
			case 'view-table':
				return "Table";
			case 'view-timeline':
				return "Timeline";
			case 'view-map':
				return "Map";
			case 'view-tile':
				return "List";
			case 'view-scatter':
				return "Scatter Plot";
			case 'view-bar':
				return "Bar Chart";
			default:
				return "UnknownView";
		}
	}
	
	function getLinkCaption() {
		return $this->getShortKind() . ": " . $this->get('label');
	}	
	
	function htmlContent() {
		$kind = $this->get('kind');
		$label = $this->get('label');
		
		if ($kind == "view-tile") {
			// Todo: add the actual date and time stuff
			return "<div ex:role=\"exhibit-view\" ex:viewClass=\"Exhibit.TileView\" ex:label=\"$label\"></div>";
		}		
		
		
		if ($kind == "view-timeline") {
			// Todo: add the actual date and time stuff
			$start = $this->get('field');
			
			$proxy = $this->get('proxy');
			$inner = "";
			if ($proxy != NULL) {
				$inner .= " ex:proxy='.$proxy' ";
			}
						
			$ret =  "<div ex:role=\"view\" ex:viewClass=\"Timeline\" ex:bubbleWidth='320' ex:topBandPixelsPerUnit='400' $inner ex:timelineHeight='170' ex:label=\"$label\" ex:start=\".$start\"";
			if ($this->get('end') != null) {
				$end = $this->get('end');
				$ret = $ret . " ex:end=\".$end\"";
			}
			$ret = $ret . "></div>";        
			return $ret;
		}
		else if ($kind == "view-map") {		
			// Todo: add the actual location stuff
			$field = $this->get('field');
			$locationtype = $this->get('locationtype');
			$where = "ex:latlng='.$field'";
			$icon = $this->get('icon');
			$proxy = $this->get('proxy');
			$bw = $this->get('bubblewidth');
			$bh = $this->get('bubbleheight');
			$mw = $this->get('markerwidth');
			$mh = $this->get('markerheight');
			
			$after = "";
			$inner = "";

			if ($icon != NULL) {
				$inner .= " ex:icon='.$icon' ";
			}
			if ($proxy != NULL) {
				$inner .= " ex:proxy='.$proxy' ";
			}

			// NOTE: There is currently no nocderfeld thing being put in here.
			$ret = "<div ex:role='view' ex:viewClass='Map' ex:label='$label' ex:latlng='.$field' ex:bubbleWidth='$bw' ex:bubbleHeight='$bh' ex:shapeWidth='$mw' ex:shapeHeight='$mh' $inner ></div>";   
			return $ret;
		}
		else if ($kind == "view-table") {
			$columns = $this->get('field');
			$columnlabels = $this->get('caption');
			$klass = $this->get('klass');
			
			// Todo: add the actual location stuff
			$ret = "<div ex:role=\"view\" ex:viewClass=\"Exhibit.TabularView\" ex:itemType=\"$klass\" ex:label=\"$label\" ex:columns=\"$columns\" ex:columnLabels=\"$columnlabels\">";
			$ret .= "<table style=\"display: none;\"><tr>";			
			$columns_arr = explode(",", $columns);
			foreach($columns_arr as $column) {
				$ret .= "<td><span ex:content=\"$column\"></span></td>";			 
			}
			$ret .= "</tr></table></div>";
			return $ret;
		}  
		if ($kind == "view-scatter") {
			// Todo: add the actual date and time stuff
			$field_x = $this->get("xField");
			$field_y = $this->get("yField");
			$field_xLabel = $this->get("xLabel");
			$field_yLabel = $this->get("yLabel");
			$field_xAxisType = $this->get("xScale");
			$field_yAxisType = $this->get("yScale");			
			$ret =  "<div ex:role=\"view\" ex:viewClass=\"Exhibit.ScatterPlotView\" ex:label=\"$label\" ex:x=\".$field_x\" ex:y=\".$field_y\" ex:xLabel=\"$field_xLabel\" ex:yLabel=\"$field_yLabel\" ex:xAxisType=\"$field_xAxisType\" ex:yAxisType=\"$field_yAxisType\"";
			$ret = $ret . "></div>";        
			return $ret;
		}		      
		if ($kind == "view-bar") {
			// Todo: add the actual date and time stuff
			$field_x = $this->get("xField");
			$field_y = $this->get("yField");
			$field_xLabel = $this->get("xLabel");
			$field_yLabel = $this->get("yLabel");
			$field_xAxisType = $this->get("xScale");
			$field_yAxisType = $this->get("yScale");			
			$ret =  "<div ex:role=\"view\" ex:viewClass=\"Exhibit.BarChartView\" ex:label=\"$label\" ex:x=\".$field_x\" ex:y=\".$field_y\" ex:xLabel=\"$field_xLabel\" ex:yLabel=\"$field_yLabel\" ex:xAxisType=\"$field_xAxisType\" ex:yAxisType=\"$field_yAxisType\"";
			$ret = $ret . "></div>";        
			return $ret;
		}		      
	}
	
}
?>