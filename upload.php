<?php
	include("config.php");
	include("functions.php");
	
	if(DENY_UPLOAD){
		die("Uploading is set to denied.");
	}

	if(isset($_GET['type']) && $_SERVER['REQUEST_METHOD'] === "POST"){
		checkCSRF();
		$filename = date('Y-m-d_H-i-s')."_".time();
		if($_GET['type']==="text" && isset($_POST['txt']) ){
			$filename.=".txt";
			handleB64();
			$size = (int) $_SERVER['CONTENT_LENGTH'];
			if($size>MAX_UPLOAD_POST_SIZE){
				die("POST data too big");
			}
			dieOnDirectoryMaxSize("uploads",MAX_UPLOAD_DIRECTORY_SIZE,$size);
			writePOSTTxt($filename);
			echoSuccessLink($filename);
		}elseif($_GET['type']==="file" && isset($_FILES['filed'])){
			if($_FILES['filed']['name']===""){
				die("No file selected");
			}
			$ext = pathinfo($_FILES['filed']['name'], PATHINFO_EXTENSION);
			if(cleanExtension($ext)){
				$filename.="($ext).file";
				if ($_FILES['filed']['error'] !== UPLOAD_ERR_OK) {
					die("Error uploading (".$_FILES['filed']['error'].")");
				}
				$size=$_FILES["filed"]["size"];
				dieOnDirectoryMaxSize("uploads",MAX_UPLOAD_DIRECTORY_SIZE,$size);
			}			
			if((int)$size>(int)MAX_UPLOAD_FILE_SIZE){
				die("FILE data too big");
			}
			move_uploaded_file( $_FILES['filed']['tmp_name'], "uploads/".$filename);
			echoSuccessLink($filename);
		}
	}

?>
