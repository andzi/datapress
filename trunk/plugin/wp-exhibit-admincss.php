<style>

div.outer-tabs-panel {
	margin: 0 5px 0 120px;
	padding: .5em .9em;
	height: 40em;
	overflow: auto;
	border-width: 4px;
	border-style: solid;
}

div.outer-tabs-panel-header {
	height: 15em;
}

div.inner-tabs-panel {
	margin: 0 5px 0 0px;
	padding: .5em .9em;
	overflow: auto;
	height: 20em;
	border-width: 2px;
	border-style: solid;
	border-color: #99CC66;
}

div.outer-tabs-panel-header div.current {
	height: 8em;
	overflow: auto;
	border-top: 2px solid #ccc;
	border-bottom: 2px solid #ccc;	
}

ul.outer-tabs {
	list-style: none;
	padding: 0;
	float: left;
	width: 120px;
	text-align: right;
	/* Negative margin for the sake of those without JS: all tabs display */
	margin: 0 -120px 0 0;
	padding: 0;
}

ul.inner-tabs {
	list-style: none;
	margin: 0;
	display: block;
    content: " ";
	clear: both;
}

.inner-tabs:after { /* clearing without presentational markup, IE gets extra treatment */
    display: block;
    clear: both;
    content: " ";
}

ul.outer-tabs li {
	padding: 8px;
}

ul.inner-tabs li {
	display: inline;
	float: left;
    margin: 0 0 0 2px;
	padding: 0.4em;
	border-top: 1px solid #99CC66 !important;
	border-left: 1px solid #99CC66 !important;
	border-right: 1px solid #99CC66 !important;	
}

ul.inner-tabs li a {
	color: #519e2d; 
	
}

ul.outer-tabs li.ui-tabs-selected {
	-moz-border-radius-topleft: 3px;
	-khtml-border-top-left-radius: 3px;
	-webkit-border-top-left-radius: 3px;
	border-top-left-radius: 3px;
	-moz-border-radius-bottomleft: 3px;
	-khtml-border-bottom-left-radius: 3px;
	-webkit-border-bottom-left-radius: 3px;
	border-bottom-left-radius: 3px;
}

ul.inner-tabs li {
	-moz-border-radius-topleft: 3px;
	-khtml-border-top-left-radius: 3px;
	-webkit-border-top-left-radius: 3px;
	border-top-left-radius: 3px;
	-moz-border-radius-topright: 3px;
	-khtml-border-top-right-radius: 3px;
	-webkit-border-top-right-radius: 3px;
	border-top-right-radius: 3px;
}

ul.outer-tabs li.ui-tabs-selected a {
	color: #333;
	font-weight: bold;
	text-decoration: none;
}

ul.inner-tabs li.ui-tabs-selected  {
	background-color: #99CC66 !important;
}

ul.inner-tabs li.ui-tabs-selected a {
    position: relative;
    top: 1px;
    z-index: 2;
    margin-top: 0;
	font-weight: bold;
	text-decoration: none;
	color: #333;
}

ul.outer-tabs li.ui-tabs-selected {
	background-color: #cee1ef !important;
}

/* Additional IE specific bug fixes... */
* html .inner-tabs-nav { /* auto clear @ IE 6 & IE 7 Quirks Mode */
    display: inline-block;
}
*:first-child+html .inner-tabs-nav  { /* auto clear @ IE 7 Standards Mode - do not group selectors, otherwise IE 6 will ignore complete rule (because of the unknown + combinator)... */
    display: inline-block;
}

a.addlink {
	line-height:1.5em;
	padding: 6px 4px;
	border: 1px solid #464646;
	background-color: #E5E5E5;
	color: #224466;
	font-weight: bold;
	text-decoration: none;
	-moz-border-radius-bottomleft:3px;
	-moz-border-radius-bottomright:3px;
	-moz-border-radius-topleft:3px;
	-moz-border-radius-topright:3px;
	font-family:"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;
	font-size:12px;
}

a.addlink:hover {
	color:#D54E21;
}

#exhibit-input-container select {
	vertical-align: middle;
}

</style>