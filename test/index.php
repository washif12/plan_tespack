<?php
error_reporting(0);

$msg = "";


/* 
 * php delete function that deals with directories recursively
 */
function delete_files($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
        
        foreach( $files as $file ){
            delete_files( $file );      
        }
      
        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}
if (isset($_POST['upload'])) {

	$filename = $_FILES["uploadfile"]["name"];
	$tempname = $_FILES["uploadfile"]["tmp_name"];
	$folder = "./uploads/aa/";
	if (is_dir($folder)) {
			// array_map('unlink', array_filter(glob("./uploads/aa/*"), 'is_file'));
			// unlink($folder);
			delete_files('/uploads/aa/');
			echo "<h3> okk!</h3>";
	}else{
		echo "<h3> Failed to delete!</h3>";
	}
	$folder = "./uploads/aa/" . $filename;

	// if (move_uploaded_file($tempname, $folder)) {
	// 	echo "<h3> Image uploaded successfully!</h3>";
	// } else {
	// 	echo "<h3> Failed to upload image!</h3>";
	// }
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Image Upload</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
	<div id="content">
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="form-group">
				<input class="form-control" type="file" name="uploadfile" value="" />
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
			</div>
		</form>
	</div>
	
</body>

</html>
