<?php
echo __DIR__ . "<br><br>";


$location = "../";
$user = "jarcilla";
$pass = "H@nds0m3";
$letter = "Z";
system("net use ".$letter.": \"".$location."\" ".$pass." /user:".$user." /persistent:no>nul 2>&1");

$dir = "../../../";

// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            echo " $file " . "<br>";
        }
        closedir($dh);
    }
}
else{
	echo $dir;
}
?>