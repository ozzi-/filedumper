<?php
	include("config.php");
	include("functions.php");
	
	echo("<a href=\"index.php\">Back to upload form</a><br><br>");
	$files = scandir("uploads");
	foreach($files as $file){
		if($file!=="." && $file!==".." && $file!==".htaccess"){
			echo("<a href=\"access.php?file=$file\">$file</a>&nbsp;&nbsp;&nbsp;");
			if(!DENY_DELETE){
				echo("<form action=\"del.php?file=$file\" method=\"POST\"> ");
				addCSRF();
				echo("<button>Delete</button></form>");
			}
			echo("<br>");
		}
	}
	echo("<br><a href=\"index.php\">Back to upload form</a>");
	echo("<hr>");
	echoQuota();
?>
