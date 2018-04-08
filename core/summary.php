<?php
$con=mysqli_connect("localhost","root","","pacific_freight");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This extraction should only be run from a Web Browser');

require_once '../Classes/PHPExcel.php';


$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Freight")
							 ->setLastModifiedBy("Freight")
							 ->setTitle("Freight Report")
							 ->setSubject("Freight Report")
							 ->setDescription("Freight Report")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Freight Report");

$objPHPExcel->setActiveSheetIndex(0);
// color --
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FF0A7ED1');//--



//$tmpq = "and date_format(t5.rd5,'%Y-%m')='2014-07' ";

$tmpq = "";
$wh = "";
$range = "";
if(isset($_POST['date1']) and trim($_POST['date1'])){
	$tmpq = "and date_format(uploaded,'%Y-%m-%d')='{$_POST['date1']}' ";
	$range = $_POST['date1'];
	//echo $range;
}

if(isset($_POST['date2']) and trim($_POST['date2'])){
	if(trim($_POST['date1'])){
		$tmpq = "and date_format(uploaded,'%Y-%m-%d')>='{$_POST['date1']}' and date_format(uploaded,'%Y-%m-%d')<='{$_POST['date2']}' ";
		$range = $range."_to_".$_POST['date2'];
	}
	else{
		$tmpq = "and date_format(uploaded,'%Y-%m-%d')='{$_POST['date2']}' ";
		$range = $_POST['date2'];
	}
}


if(isset($_POST['approver']) and trim($_POST['approver'])){
	$tmpq = $tmpq."and approver = '{$_POST['approver']}' ";
}
if(isset($_POST['rfstt']) and trim($_POST['rfstt'])){
	$tmpq = $tmpq."and approval like '{$_POST['rfstt']}' ";
}

if(trim($tmpq)){
	$wh = "where ".substr($tmpq, 3);
}

if(trim($range)){
	$range = "_".$range;
}


//header ------------------------------------
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('Vendor No');
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue('Vendor Name');
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue('Count');
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue('Net Sum');
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue('Gross Sum');

//---------------- data
$query = "SELECT vendor_no as vno, 
		vendor_details as vd, Count(*) as cnt,
 		Sum(net_amount) as ntamt, Sum(Gross) as grs 
 		from final_data {$wh} group by vendor_no";
 
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$count = 2;
	while($answer=mysqli_fetch_array($result)){
		$objPHPExcel->getActiveSheet()->getCell('A'.$count)->setValue($answer['vno']);
		$objPHPExcel->getActiveSheet()->getCell('B'.$count)->setValue($answer['vd']);
		$objPHPExcel->getActiveSheet()->getCell('C'.$count)->setValue($answer['cnt']);
		$objPHPExcel->getActiveSheet()->getCell('D'.$count)->setValue($answer['ntamt']);
		$objPHPExcel->getActiveSheet()->getCell('E'.$count)->setValue($answer['grs']);
		$count++;
	}
}
mysqli_free_result($result);
//mysqli_close($con);

//--------------- end data

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('View Summary');

// new sheet -------------------------------------------------------------------------------------------------------------------------------------

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);

// color --
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('FF0AD139');//--

//header ------------------------------------
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('Vendor No');
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue('Vendor Name');
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue('Due');
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue('Due Amount');
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue('Not Due');
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue('Not Due Amount');

//---------------- data
$query = "SELECT vendor_no as vno, vendor_details as vd,
			 Sum(case when DATEDIFF(duedate,Now())<0 then 1 else 0 end) as due,
			 Sum(case when DATEDIFF(duedate,Now())<0 then Gross else 0 end) as grsd, 
			 Sum(case when DATEDIFF(duedate,Now())>-1 then 1 else 0 end) as notdue,
			 Sum(case when DATEDIFF(duedate,Now())>-1 then Gross else 0 end) as grsn 
			 from final_data where clearing_date IS NULL {$tmpq} group by vendor_no";
 
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$count = 2;
	while($answer=mysqli_fetch_array($result)){
		$objPHPExcel->getActiveSheet()->getCell('A'.$count)->setValue($answer['vno']);
		$objPHPExcel->getActiveSheet()->getCell('B'.$count)->setValue($answer['vd']);
		$objPHPExcel->getActiveSheet()->getCell('C'.$count)->setValue($answer['due']);
		$objPHPExcel->getActiveSheet()->getCell('D'.$count)->setValue($answer['grsd']);
		$objPHPExcel->getActiveSheet()->getCell('E'.$count)->setValue($answer['notdue']);
		$objPHPExcel->getActiveSheet()->getCell('F'.$count)->setValue($answer['grsn']);
		$count++;
	}
}
mysqli_free_result($result);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Unpaid Summary');
//-----------------------------------------


// new sheet -------------------------------------------------------------------------------------------------------------------------------------

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(2);

// color --
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('FF0AD139');//--

//header ------------------------------------
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('Vendor No');
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue('Vendor Name');
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue('Due');
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue('Due Amount');
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue('Not Due');
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue('Not Due Amount');

//---------------- data
$query = "SELECT vendor_no as vno, vendor_details as vd,
			 Sum(case when DATEDIFF(duedate,clearing_date)<0 then 1 else 0 end) as due,
			 Sum(case when DATEDIFF(duedate,clearing_date)<0 then Gross else 0 end) as grsd, 
			 Sum(case when DATEDIFF(duedate,clearing_date)>-1 then 1 else 0 end) as notdue,
			 Sum(case when DATEDIFF(duedate,clearing_date)>-1 then Gross else 0 end) as grsn 
			 from final_data where clearing_date IS NOT NULL {$tmpq} group by vendor_no";
 
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$count = 2;
	while($answer=mysqli_fetch_array($result)){
		$objPHPExcel->getActiveSheet()->getCell('A'.$count)->setValue($answer['vno']);
		$objPHPExcel->getActiveSheet()->getCell('B'.$count)->setValue($answer['vd']);
		$objPHPExcel->getActiveSheet()->getCell('C'.$count)->setValue($answer['due']);
		$objPHPExcel->getActiveSheet()->getCell('D'.$count)->setValue($answer['grsd']);
		$objPHPExcel->getActiveSheet()->getCell('E'.$count)->setValue($answer['notdue']);
		$objPHPExcel->getActiveSheet()->getCell('F'.$count)->setValue($answer['grsn']);
		$count++;
	}
}
mysqli_free_result($result);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Paid Summary');
//-----------------------------------------

// new sheet -------------------------------------------------------------------------------------------------------------------------------------

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(3);

// color --
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('FFCFD479');//--
//header ------------------------------------
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('Vendor No');
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue('Vendor Name');
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue('Air');
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue('Air Amount');
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue('Sea');
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue('Sea Amount');
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue('Road');
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue('Road Amount');

//---------------- data
$query = "SELECT vendor_no as vno, vendor_details as vd,
			 Sum(case when air_sea like '%air%' then 1 else 0 end) as air,
			 Sum(case when air_sea like '%air%' then Gross else 0 end) as aird, 
			 Sum(case when air_sea like '%sea%' then 1 else 0 end) as sea,
			 Sum(case when air_sea like '%sea%' then Gross else 0 end) as sean,
			 Sum(case when air_sea like '%road%' then 1 else 0 end) as road,
			 Sum(case when air_sea like '%road%' then Gross else 0 end) as roadn  
			 from final_data {$wh} group by vendor_no";
 
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$count = 2;
	while($answer=mysqli_fetch_array($result)){
		$objPHPExcel->getActiveSheet()->getCell('A'.$count)->setValue($answer['vno']);
		$objPHPExcel->getActiveSheet()->getCell('B'.$count)->setValue($answer['vd']);
		$objPHPExcel->getActiveSheet()->getCell('C'.$count)->setValue($answer['air']);
		$objPHPExcel->getActiveSheet()->getCell('D'.$count)->setValue($answer['aird']);
		$objPHPExcel->getActiveSheet()->getCell('E'.$count)->setValue($answer['sea']);
		$objPHPExcel->getActiveSheet()->getCell('F'.$count)->setValue($answer['sean']);
		$objPHPExcel->getActiveSheet()->getCell('G'.$count)->setValue($answer['road']);
		$objPHPExcel->getActiveSheet()->getCell('H'.$count)->setValue($answer['roadn']);
		$count++;
	}
}
mysqli_free_result($result);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle('Mode of Shipment Summary');
//-----------------------------------------


$objPHPExcel->setActiveSheetIndex(0);
mysqli_close($con);
// Redirect output to a client’s web browser (Excel2007)

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Summary.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


//$tmpname1 = "Freight_Report".$range.".xlsx";
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
//$objWriter->save("../extracted/".$tmpname1);
?>

<script language="javascript" type="text/javascript">
	window.top.changeBodyVal("Download: <a href='extracted/<?php echo $tmpname1;?>'><?php echo $tmpname1; ?></a>");
</script>