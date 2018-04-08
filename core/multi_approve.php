<?php
session_start();
$con=mysqli_connect("localhost","root","","pacific_freight");
$data = explode(",", $_POST['datalist']);
$max = count($data);
if($max > 1){
	for($i=1;$i<$max;$i++){
		$reason1 = $_POST['declined'];
		$reason2 = $_POST['hold'];
		$comment = $_POST['addcomment'];
		if(trim($reason1)){
			$comment = $reason1 . " - " . $comment;
		}
		else if(trim($reason2)){
			$comment = $reason2 . " - " . $comment;
		}
		$option_app = $_POST['option_app'];
		$exist_comment ="";
		$addcomm = "";
		$orapproval = "";
		$orapprovec = "";
		$orapprover = "";
		
		$querya = "Select approval_comment, approval, approver from final_data where fd_id='{$data[$i]}'";
		//echo $query . "<br>";
		$resulta = mysqli_query($con,$querya);
		if(mysqli_num_rows($resulta)>0){
			$answera = mysqli_fetch_row($resulta);
			//$exist_comment = $answera[0];
			//history
			$orapproval = $answera[0];
			$orapprovec = $answera[1];
			$orapprover = $answera[2];
		}
		mysqli_free_result($resulta);
/*
		if(trim($exist_comment)){
			if(trim($comment)){
				$exist_comment = $exist_comment.", ".$comment;
			}
		}
		else if(trim($comment)){
			$exist_comment = $comment;
		}
*/

		//compare
		if($_SESSION['pfreight_userid']==$orapprover){
			$action = "";
			$old_value = "";
			if($option_app != $orapproval){
				$action = $action . "|Approval";
				if(trim($orapprover)){
					$old_value = $old_value . "|{$orapproval}";
				}
				else{
					$old_value = $old_value . "|<blank approval>";
				}
			}
			if($comment != $orapprovec){
				$action = $action . "|Approver Comments";
				if(trim($orapprover)){
					$old_value = $old_value . "|{$orapprovec}";
				}
				else{
					$old_value = $old_value . "|<blank approver comment>";
				}
			}

			if(trim($action) or trim($old_value)){
				if(trim($action)){
					$action = substr($action, 1);
				}
				if(trim($old_value)){
					$old_value = substr($old_value, 1);
				}
				$histquery = "INSERT INTO data_history (user,action,avalue,created,doc) VALUES ('{$_SESSION['pfreight_userid']}','{$action}','{$old_value}',Now(),'{$data[$i]}') ";
				echo $histquery;
				mysqli_query($con,$histquery);
			}
		}
		

		$exist_comment = $comment;
		$exist_comment = mysqli_real_escape_string($con, $exist_comment);

		if(trim($exist_comment)){
			$addcomm = "approval_comment='{$exist_comment}',";
		}

		if(trim($option_app)){
			$option_app = "approval='{$option_app}',";
		}

		$queryu = "Update final_data set {$addcomm} {$option_app} updated=Now(), updated_by='{$_SESSION['pfreight_userid']}' where fd_id='{$data[$i]}' and lock_edit is null and approver='{$_SESSION['pfreight_userid']}' limit 1";
		mysqli_query($con,$queryu);
		echo $queryu."<br>";
	}
}
mysqli_close($con);
?>
<script language="javascript" type="text/javascript">
	top.updateAlert("Data Changed If You Are The Approver");
</script>