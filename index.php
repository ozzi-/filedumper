<html>
<?php 
	include("config.php"); include("functions.php");
	if(DENY_UPLOAD){
		echo("Uploading is set to denied.");
	}else{
?>
	<script>
		function sendTxt(){
			var chkBox = document.getElementById('b64');
			if (chkBox.checked){
				var encoded = btoa(document.getElementById('txt').value);
				document.getElementById('txt').value = encoded;	
			}
			document.getElementById("textform").submit();
		}
		function sendFile(){
			document.getElementById("fileform").submit();
		}
	</script>
	<form action="upload.php?type=text" method="POST" id="textform">
		<textarea rows="4" cols="50" name="txt" id="txt" form="textform"></textarea>
		<br>
		<input type="checkbox" name="b64" id="b64"> Transmit as Base64?
		<?php addCSRF(); ?>
		<br><br>
		<button onclick="sendTxt()">Send</button>
		(max <?= MAX_UPLOAD_POST_SIZE ?>bytes)
	</form>
	<hr>
	<form action="upload.php?type=file" method="POST" id="fileform" name="fileform" enctype="multipart/form-data">
		<input type="file" name="filed" id="filed ">
		<?php addCSRF(); ?>
	</form>
	<button onclick="sendFile()">Send</button>
	(max <?= MAX_UPLOAD_FILE_SIZE ?>bytes)
<?php 
	}
?>
	<hr>
	<?php echoQuota(); ?>
	<hr>
	<a href="dir.php">Show uploads</a>
</html>

