<?php

function file_upload($conn,$filePath,$doc,$nname,$ename){
	
	$id = -1;
	// Gather all required data
	$name = $nname;
	$mytmp = explode(".", $name);

	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $filePath);
	finfo_close($finfo);

	$size = filesize($filePath);
	$name = mysqli_real_escape_string($conn, $name);
	$mime = mysqli_real_escape_string($conn, $mime);
	$query = "	
	    INSERT INTO `file_data` (
	   	`orig_name`, `mime`, `extension`, `file_size`, `doc`, `uploaded`, `uploader`
	   	)
	    VALUES (
	    '{$name}', '{$mime}', '{$ename}', '{$size}', '{$doc}', Now(), '{$_SESSION['pfreight_userid']}'
	)";
	//echo $query;

	mysqli_query($conn,$query);	    
	$id = mysqli_insert_id($conn);

	return $id;
}



?>