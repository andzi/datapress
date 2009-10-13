<?php
ob_start();
header("Content-type: text/javascript");
$callback = $_GET["jsoncallback"];
print <<<EOF
$callback(
 [
    {
        "name" : "Academic Paper",
        "identifier" : "academic_paper"
    },
    {
        "name" : "Academic Paper",
        "identifier" : "academic_paper"        
    },
    {
        "name" : "Academic Paper",
        "identifier" : "academic_paper"
    }    
 ]
);
EOF
?>
