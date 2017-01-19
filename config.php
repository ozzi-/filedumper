<?php
	$mb = 1000000;
	// If you wan't bigger POST/FILE uploads than 100mb, edit the .htaccess file.
	define("MAX_UPLOAD_DIRECTORY_SIZE",	30*$mb); 
	define("MAX_UPLOAD_POST_SIZE",		$mb);
	define("MAX_UPLOAD_FILE_SIZE",		30*$mb);
	define("FORCE_HTTPS",				false);
	define("DENY_DOWNLOAD",				false);
	define("DENY_DELETE",				false);
	define("DENY_UPLOAD",				false);
	define("REQUIRED_PW",				"changeme"); // either "yourpassword" or false
?>