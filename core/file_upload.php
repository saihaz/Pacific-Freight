<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");
$docid = $_POST['ddata'];
include "file_inc.php";
$msg = "Error 100";
$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["dfile"]["name"]);
$plain_name = basename($_FILES["dfile"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["dfile"]["tmp_name"]);
    if($check !== false) {
        $msg = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $msg = "File is not an image.";
        $uploadOk = 0;
    }
}
/*
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
*/
/*
// Check file size
if ($_FILES["dfile"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an erro
*/
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	//read file

	$query = "";

	$tmpdata = file_upload($con,$_FILES["dfile"]["tmp_name"],$docid,$plain_name,$imageFileType);
	$newname = $target_dir.$tmpdata.".".$imageFileType;


    if (move_uploaded_file($_FILES["dfile"]["tmp_name"], $newname)) {
        $msg = "The file ". basename( $_FILES["dfile"]["name"]). " has been uploaded.";
    } else {
        $msg = "Sorry, there was an error uploading your file.";
    }
}


mysqli_close($con);
?>
<script>
	top.alert("<?php echo $msg; ?>");
	top.hideModal("myModal4");
</script>