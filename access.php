<?php
	include("config.php"); include("functions.php");

	if(DENY_DOWNLOAD){
		die("Downloads are denied.");
	}
	
	if(isset($_GET['file'])){
		$file="uploads/".$_GET['file'];
		if(cleanFileName($_GET['file'])&&file_exists($file)){
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
			header('Pragma: no-cache');
			header('X-Content-Type-Options: nosniff');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		}
	}
?>
