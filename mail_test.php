<?php
//mail funtion 1
	$cc = "";
	$bcc = "";
	$to = "Gee-Marielle.Manguera@schneider-electric.com";
	$subject = "ILOCOS TRAVEL Query";
	$message = "
Hi Myself,

Just a question,

Does the estimated cost include food?

Sagot agad!

Regards,
:)

	";
	$from = "Gee-Marielle.Manguera@schneider-electric.com";

	if(trim($cc)){
		$cc = "\r\nCC: {$cc}";
	}

	$headers = "From:" . $from . $cc . $bcc;
	//echo $headers."<br>";
	if(@mail($to,$subject,$message,$headers))
	{
	  echo "Mail Sent Successfully <br>";
	}else{
	  echo "Mail Not Sent <br>";
	}


?>