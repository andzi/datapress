<?php
global $exhibits_to_show;

if (isset($exhibits_to_show) && (count($exhibits_to_show) > 0)) {
    foreach ($exhibits_to_show as $exhibit_to_show) {
        foreach($exhibit_to_show->get('datasources') as $datasource) {
            echo($datasource->htmlContent() . "\n");
        }
    }
}
?>