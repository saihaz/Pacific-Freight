<ul class="pagination">
<?php
$popu = ceil ($num_dsl/100);
			
if($num_dsl < 100){
	$popu = 1;
}
$max = 10;
if($_GET['mover']%10 != 0){
	$mov = floor($_GET['mover'] / $max);
}
else{
	$mov = ($_GET['mover'] / $max) - 1;
}
$num = $mov * $max;
if($_GET['mover'] > ($num + 10)){
$mov = $mov + 1;
$num = $mov * $max;
}
$quo = floor($popu / $max);
$rem = $popu % $max ;
$modu = $num % $max;
if(($num + $max) > $popu){
	$modu = $popu % $max;
}

if($mov > 0){
	echo "<li><a href ='?{$valle}mover=1'>First</a></li>";
}
if($_GET['mover'] > 1){
	$newdata = $_GET['mover'] - 1;
	echo "<li><a href ='?{$valle}mover={$newdata}'>Prev</a></li>";
}
if($modu >= 0){
	$tmpdsgn = "";
	$subnum = $num + 1;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($modu > 1 or $modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 2;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a><li>";
}
if($modu > 2 or $modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 3;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($modu > 3 or $modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 4;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($modu > 4 or $modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 5;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($modu > 5 or $modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 6;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($modu > 6 or $modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 7;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($modu > 7 or $modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 8;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($modu > 8 or $modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 9;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($modu == 0){
	$tmpdsgn = "";
	$subnum = $num + 10;
	if($_GET['mover']==$subnum)
		$tmpdsgn = "class='active'";
	echo "<li {$tmpdsgn}><a href='?{$valle}mover={$subnum}'>{$subnum}</a></li>";
}
if($_GET['mover'] < $popu){
	$newdata = $_GET['mover'] + 1;
	echo "<li><a href = '?{$valle}mover={$newdata}'>Next</a></li>";
}
if($mov < $quo){
	echo "<li><a href = '?{$valle}mover={$popu}'>Last</a></li>" ;
}
?>
</ul>
<p style="float:right;">Record Count: <?php echo $num_dsl;?></p>