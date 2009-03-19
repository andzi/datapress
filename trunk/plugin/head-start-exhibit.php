<?php
global $exhibits_to_show;
$exhibit_to_show = NULL;
if (isset($exhibits_to_show) && ($exhibits_to_show != NULL) && (count($exhibits_to_show) > 0)) {
   $exhibit_to_show = $exhibits_to_show[0];
}

if ($exhibit_to_show != NULL) {
print <<<EOF

<script type="text/javascript">

// Start Exhibit Manually

Exhibit.Functions["contains"] = {
    f: function(args) {
        var result = args[0].size > 0;
        var set = args[0].getSet();
        
        args[1].forEachValue(function(v) {
            if (!set.contains(v)) {
                result = false;
                return true;
            }
        });
        
        return new Exhibit.Expression._Collection([ result ? "true" : "false" ], "boolean");
    }
};

$(document).ready(function() { 
    window.database = Exhibit.Database.create(); 
    window.database.loadDataLinks(onDataLoaded); 
});

function onDataLoaded() { 
    window.exhibit = Exhibit.create();
    createCollections();
    window.exhibit.configureFromDOM(); 
};

function createCollections() {
    var auto_union = new Exhibit.Collection.create2("auto_union", {}, window.exhibit.getUIContext()); 
	window.exhibit.setCollection("auto_union", auto_union);
	
EOF;
    
    /*
     * Now we loop through the views we have and and create a collection
     * for any that specify a restricted class type 
     */
     $createdCollections = array();
     foreach ($exhibit_to_show->get('views') as $view) {
		if ($view->get('klass')) {
			$view_klass = $view->get('klass');
                
			if (! $createdCollections[$view_klass]) {
				echo("var collection_$view_klass = Exhibit.Collection.create2( 'collection_$view_klass', {  baseCollectionID: \"auto_union\", expression:\"filter(value, contains(.type, '$view_klass'))\" }, window.exhibit.getUIContext() ); \n");
				echo("window.exhibit.setCollection('collection_$view_klass', collection_$view_klass); \n");
				$createdCollections["collection_$view_klass"] = 1;
			}
		}		
	}
     

print <<<EOF

var collection_all = new Exhibit.Collection("collection_all", window.database);
collection_all._update = function() {
	this._items = new Exhibit.Set(auto_union.getRestrictedItems());
	this._onRootItemsChanged();
};
collection_all._listener = { onItemsChanged: function() { collection_all._update(); } };
        
EOF;

foreach (array_keys($createdCollections) as $collection) {
    echo("$collection.addListener(collection_all._listener);\n");
}

print <<<EOF

    collection_all._update(); 
    window.exhibit.setCollection("collection_all", collection_all); 
};

</script>
EOF;
}
?>