<?php
	startSession();

	function getFolderSize($directory) {
		$size = 0;
		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
			$size+=$file->getSize();
		}
		return $size;
	} 
	
	function writePOSTTxt($filename){
		$handle = fopen("uploads/".$filename, "w");
		fwrite($handle, $_POST['txt']);
		fclose($handle);
	}

	function echoQuota(){
		echo("Upload Quota: ".(getFolderSize("uploads")/100000)." MB / ".(MAX_UPLOAD_DIRECTORY_SIZE/100000)." MB");
	}
	
	function handleB64(){
		if(isset($_POST['b64'])){
			$_POST['txt']=base64_decode($_POST['txt'],true);
		}
	}
	
	function cleanFileName($filename){
		$matchText = preg_match('/^[0-9-_]+[.]{1}(txt)$/', $filename, $hits);
		$matchFile = preg_match('/^[0-9-_]+[(][A-Za-z0-9-_]{1,5}[)][.]{1}(file)$/', $filename, $hits);
		return ($matchText===1||$matchFile===1);
	}
	
	function cleanExtension($ext){
		$matchExt = preg_match('/^[0-9a-zA-Z]{1,5}$/', $ext, $hits);
		return($matchExt===1);
	}
	
	function echoSuccessLink($filename){
		echo("Success: <a href=\"access.php?file=$filename\">$filename</a>");
		echo("<br><br><a href=\"dir.php\">Show all</a>");
	}
	
	function dieOnDirectoryMaxSize($directory,$maxSize,$additionalSize=0) {
		$size = $additionalSize;
		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
			$size+=$file->getSize();
			if($size>$maxSize){
				die("The current upload and the already existing uploads exceed the quota ($size/$maxSize).");
			}
		}
		return $size;
	} 
	
	function checkCSRF(){
		if(!isset($_SESSION['CSRF']) ||!isset($_POST['CSRF']) || $_POST['CSRF']!==$_SESSION['CSRF']){
			die("CSRF token invalid or stale.");
		}
	}
	
	function correctPassword($sentPassword){
		return hash_equals(REQUIRED_PW, $sentPassword);
		
	}
	
	function startSession(){
		// Security
		if( FORCE_HTTPS && !(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')) {
			die("HTTPS is enforced");
		}
		header('X-XSS-Protection: 1; mode=block');
		header('X-Frame-Options: DENY');
		if(FORCE_HTTPS){
			ini_set('session.cookie_secure', 1 );	
			header('Strict-Transport-Security: max-age=31536000;includeSubDomains;preload');
		}
		
		ini_set('session.use_only_cookies', 1);
		ini_set('session.gc_maxlifetime', 60*60); 
		
		session_start();
		if(!isset($_SESSION['CSRF'])){
			$_SESSION['CSRF']= base64_encode( openssl_random_pseudo_bytes(32));
		}
		passwordHandler();
	}
	
	function passwordHandler(){
		if(REQUIRED_PW && (!isset($_SESSION['LOGIN']) || $_SESSION['LOGIN']!==true)){
			if(isset($_POST['password'])){
				checkCSRF();
				if(!correctPassword($_POST['password'])){
					die("Wrong password.<br><button onclick=\"window.history.back()\">Go Back</button>");
				}else{
					$_SESSION['LOGIN']=true;
				}
			}else{
				?>
				<html>
					<form method="POST">
						Password required:<br>
						<input type="password" name="password">
						<?php addCSRF() ?>
						<input type="submit" value="Submit">
					</form>
				</html>
				<?php
				die();
			}
		}
	}
	
	function addCSRF(){
		echo('<input class="form-control" type="hidden" name="CSRF" value="'.$_SESSION['CSRF'].'"/>');
	}

?>
