<?php
	include("config.php"); include("functions.php");
	
	if(DENY_DELETE){
		die("Delete is denied.");
	}
	checkCSRF();
	
	if(isset($_GET['file']) && cleanFileName($_GET['file'])){
		$filepath="uploads/".$_GET['file'];
		if(file_exists($filepath)){
			echo(unlink($filepath)?"Deleted":"Error while deleting");
			echo("<br><button onclick=\"window.history.back()\">Go Back</button>");
		}
	}
?>