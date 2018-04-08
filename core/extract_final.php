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

$objPHPExcel->getProperties()->setCreator("DAMASO")
							 ->setLastModifiedBy("DAMASO")
							 ->setTitle("Freight Report")
							 ->setSubject("Freight Report")
							 ->setDescription("Freight Report")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Freight Report");

$objPHPExcel->setActiveSheetIndex(0);
// color --
$objPHPExcel->getActiveSheet()->getStyle('A1:AK2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
$objPHPExcel->getActiveSheet()->getStyle('A1:AK2')->getFill()->getStartColor()->setARGB('FFFFA600');//--

//merge
$objPHPExcel->getActiveSheet()->mergeCells('A1:AK1');

//header ------------------------------------
$objPHPExcel->getActiveSheet()->getCell('A2')->setValue('CoCd');
$objPHPExcel->getActiveSheet()->getCell('B2')->setValue('Doc No');
$objPHPExcel->getActiveSheet()->getCell('C2')->setValue('Doc Date');
$objPHPExcel->getActiveSheet()->getCell('D2')->setValue('Vendor No');
$objPHPExcel->getActiveSheet()->getCell('E2')->setValue('Vendor Details');
$objPHPExcel->getActiveSheet()->getCell('F2')->setValue('Invoice');
$objPHPExcel->getActiveSheet()->getCell('G2')->setValue('Reference');
$objPHPExcel->getActiveSheet()->getCell('H2')->setValue('Currency');
$objPHPExcel->getActiveSheet()->getCell('I2')->setValue('Gross');
$objPHPExcel->getActiveSheet()->getCell('J2')->setValue('Net Amount');
$objPHPExcel->getActiveSheet()->getCell('K2')->setValue('Charges');
$objPHPExcel->getActiveSheet()->getCell('L2')->setValue('Charges Amount');
$objPHPExcel->getActiveSheet()->getCell('M2')->setValue('Text1');
$objPHPExcel->getActiveSheet()->getCell('N2')->setValue('Text2');
$objPHPExcel->getActiveSheet()->getCell('O2')->setValue('Usual Charge');
$objPHPExcel->getActiveSheet()->getCell('P2')->setValue('G/L');
$objPHPExcel->getActiveSheet()->getCell('Q2')->setValue('BPO');
$objPHPExcel->getActiveSheet()->getCell('R2')->setValue('Cost Centre');
$objPHPExcel->getActiveSheet()->getCell('S2')->setValue('Profit Centre');
$objPHPExcel->getActiveSheet()->getCell('T2')->setValue('Profit Per Material');
$objPHPExcel->getActiveSheet()->getCell('U2')->setValue('Procurer');
$objPHPExcel->getActiveSheet()->getCell('V2')->setValue('AP Comments');
$objPHPExcel->getActiveSheet()->getCell('W2')->setValue('Approval');
$objPHPExcel->getActiveSheet()->getCell('X2')->setValue('Approver');
$objPHPExcel->getActiveSheet()->getCell('Y2')->setValue('Approver Comment');
$objPHPExcel->getActiveSheet()->getCell('Z2')->setValue('Type');
$objPHPExcel->getActiveSheet()->getCell('AA2')->setValue('Customer #');
$objPHPExcel->getActiveSheet()->getCell('AB2')->setValue('Mode of Shipment');
$objPHPExcel->getActiveSheet()->getCell('AC2')->setValue('HAWB/BL Reference');
$objPHPExcel->getActiveSheet()->getCell('AD2')->setValue('Shipper');
$objPHPExcel->getActiveSheet()->getCell('AE2')->setValue('Gross Weight');
$objPHPExcel->getActiveSheet()->getCell('AF2')->setValue('Departure');
$objPHPExcel->getActiveSheet()->getCell('AG2')->setValue('Destination');
$objPHPExcel->getActiveSheet()->getCell('AH2')->setValue('PO Ref');
$objPHPExcel->getActiveSheet()->getCell('AI2')->setValue('Consignee');
$objPHPExcel->getActiveSheet()->getCell('AJ2')->setValue('AP Posted');
$objPHPExcel->getActiveSheet()->getCell('AK2')->setValue('Posted Date');

//---------------- data
//$tmpq = "and date_format(t5.rd5,'%Y-%m')='2014-07' ";
$tmpq = "";
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
if(trim($range)){
	$range = "_".$range;
}

$query1 = "Update final_data set lock_edit='1' where approval='Approved' {$tmpq} ";
mysqli_query($con,$query1);

if(trim($tmpq)){
	$tmpq = "where ".substr($tmpq, 4);
}

$query = "Select * from final_data {$tmpq}";
 
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
$count = 3;
	while($answer=mysqli_fetch_array($result)){
		$tmpnet = $answer['net_amount'] * -1;
		$objPHPExcel->getActiveSheet()->getCell('A'.$count)->setValue($answer['cocd']);
		$objPHPExcel->getActiveSheet()->getCell('B'.$count)->setValue($answer['docno']);
		$objPHPExcel->getActiveSheet()->getCell('C'.$count)->setValue($answer['docdate']);
		$objPHPExcel->getActiveSheet()->getCell('D'.$count)->setValue($answer['vendor_no']);
		$objPHPExcel->getActiveSheet()->getCell('E'.$count)->setValue($answer['vendor_details']);
		$objPHPExcel->getActiveSheet()->getCell('F'.$count)->setValue($answer['invoice']);
		$objPHPExcel->getActiveSheet()->getCell('G'.$count)->setValue($answer['Reference']);
		$objPHPExcel->getActiveSheet()->getCell('H'.$count)->setValue($answer['Currency']);
		$objPHPExcel->getActiveSheet()->getCell('I'.$count)->setValue($answer['Gross']);
		$objPHPExcel->getActiveSheet()->getCell('J'.$count)->setValue($answer['net_amount']);
		$objPHPExcel->getActiveSheet()->getCell('K'.$count)->setValue("Charges");
		$objPHPExcel->getActiveSheet()->getCell('L'.$count)->setValue($tmpnet);
		$objPHPExcel->getActiveSheet()->getCell('M'.$count)->setValue($answer['Text1']);
		$objPHPExcel->getActiveSheet()->getCell('N'.$count)->setValue($answer['text2']);
		$objPHPExcel->getActiveSheet()->getCell('O'.$count)->setValue("Usual Charge");
		$objPHPExcel->getActiveSheet()->getCell('P'.$count)->setValue("50311000");
		$objPHPExcel->getActiveSheet()->getCell('Q'.$count)->setValue($answer['BPO']);
		$objPHPExcel->getActiveSheet()->getCell('R'.$count)->setValue($answer['cost_centre']);
		$objPHPExcel->getActiveSheet()->getCell('S'.$count)->setValue($answer['profit_centre']);
		$objPHPExcel->getActiveSheet()->getCell('T'.$count)->setValue($answer['profit_per_material']);
		$objPHPExcel->getActiveSheet()->getCell('U'.$count)->setValue($answer['procurer']);
		$objPHPExcel->getActiveSheet()->getCell('V'.$count)->setValue($answer['ap_comments']);
		$objPHPExcel->getActiveSheet()->getCell('W'.$count)->setValue($answer['approval']);
		$objPHPExcel->getActiveSheet()->getCell('X'.$count)->setValue($answer['approver']);
		$objPHPExcel->getActiveSheet()->getCell('Y'.$count)->setValue($answer['approval_comment']);
		$objPHPExcel->getActiveSheet()->getCell('Z'.$count)->setValue($answer['dc_type']);
		$objPHPExcel->getActiveSheet()->getCell('AA'.$count)->setValue($answer['costumer_no']);
		$objPHPExcel->getActiveSheet()->getCell('AB'.$count)->setValue($answer['air_sea']);
		$objPHPExcel->getActiveSheet()->getCell('AC'.$count)->setValue($answer['hawb']);
		$objPHPExcel->getActiveSheet()->getCell('AD'.$count)->setValue($answer['shipper']);
		$objPHPExcel->getActiveSheet()->getCell('AE'.$count)->setValue($answer['gross_weight']);
		$objPHPExcel->getActiveSheet()->getCell('AF'.$count)->setValue($answer['departure']);
		$objPHPExcel->getActiveSheet()->getCell('AG'.$count)->setValue($answer['destination']);
		$objPHPExcel->getActiveSheet()->getCell('AH'.$count)->setValue($answer['po_ref']);
		$objPHPExcel->getActiveSheet()->getCell('AI'.$count)->setValue($answer['Consignee']);
		$objPHPExcel->getActiveSheet()->getCell('AJ'.$count)->setValue($answer['ap_posted']);
		$objPHPExcel->getActiveSheet()->getCell('AK'.$count)->setValue($answer['posted_date']);

		// A Space to put color to the main item

		$objPHPExcel->getActiveSheet()->getStyle('A'.$count.':AK'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
		$objPHPExcel->getActiveSheet()->getStyle('A'.$count.':AK'.$count)->getFill()->getStartColor()->setARGB('FFFAF1B1');//--

		$objPHPExcel->getActiveSheet()->getStyle('L'.$count.':L'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
		$objPHPExcel->getActiveSheet()->getStyle('L'.$count.':L'.$count)->getFill()->getStartColor()->setARGB('FFC3F7EC');//--

		//End of Space

		$count++;
		$subquery = "Select charge, amount, gl, value2 from charges where doc = '{$answer['cockpit_data']}'";
		$subresult = mysqli_query($con,$subquery);
		if(mysqli_num_rows($subresult)>0){
			while($subanswer=mysqli_fetch_array($subresult)){
				$objPHPExcel->getActiveSheet()->getCell('K'.$count)->setValue($subanswer['charge']);
				$objPHPExcel->getActiveSheet()->getCell('L'.$count)->setValue($subanswer['amount']);
				$objPHPExcel->getActiveSheet()->getCell('O'.$count)->setValue($subanswer['value2']);
				$objPHPExcel->getActiveSheet()->getCell('P'.$count)->setValue($subanswer['gl']);
				
				// A Space to put color to the main item

				$objPHPExcel->getActiveSheet()->getStyle('O'.$count.':P'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
				$objPHPExcel->getActiveSheet()->getStyle('O'.$count.':P'.$count)->getFill()->getStartColor()->setARGB('FFFAF1B1');//--
				$objPHPExcel->getActiveSheet()->getStyle('K'.$count.':K'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
				$objPHPExcel->getActiveSheet()->getStyle('K'.$count.':K'.$count)->getFill()->getStartColor()->setARGB('FFFAF1B1');//--
				$objPHPExcel->getActiveSheet()->getStyle('L'.$count.':L'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); //--
				$objPHPExcel->getActiveSheet()->getStyle('L'.$count.':L'.$count)->getFill()->getStartColor()->setARGB('FFC3F7EC');//--

				//End of Space

				$count++;
			}
		}
		mysqli_free_result($subresult);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Final Report');

// new sheet -------------------------------------------------------------------------------------------------------------------------------------


$objPHPExcel->setActiveSheetIndex(0);
mysqli_close($con);
// Redirect output to a client’s web browser (Excel2007)
/*
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Freight_Report.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
*/

$tmpname1 = "Freight_Report".$range.".xlsx";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$objWriter->save("../extracted/".$tmpname1);
?>

<script language="javascript" type="text/javascript">
	window.top.changeBodyVal("Download: <a href='extracted/<?php echo $tmpname1;?>'><?php echo $tmpname1; ?></a>");
</script>