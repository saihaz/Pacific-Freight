<?php
	header("Content-Disposition: attachment;filename=w1.xls "); // à¹à¸¥à¹‰à¸§à¸™à¸µà¹ˆà¸à¹‡à¸Šà¸·à¹ˆà¸­à¹„à¸Ÿà¸¥à¹Œ
	header("Content-Transfer-Encoding: binary ");
include "core/createxls.php";
xlsBOF();
xlsWriteLabel(0,0,"CoCd");
xlsWriteLabel(0,1,"Date");
xlsWriteLabel(0,2,"DocNo");
xlsWriteLabel(0,3,"Doc. Date");
xlsWriteLabel(0,4,"Vendor");
xlsWriteLabel(0,5,"Vendor details");
xlsWriteLabel(0,6,"Invoice");
xlsWriteLabel(0,7,"Reference");
xlsWriteLabel(0,8,"Crcy");
xlsWriteLabel(0,9,"Gross");
xlsWriteLabel(0,10,"Net amount");
xlsWriteLabel(0,11,"Text");
xlsWriteLabel(0,12,"Text");
xlsWriteLabel(0,13,"No");
xlsWriteLabel(0,14,"Usual Charge");
xlsWriteLabel(0,15,"G/L");
xlsWriteLabel(0,16,"BPO");
xlsWriteLabel(0,17,"Cost Centre");
xlsWriteLabel(0,18,"Profit Centre");
xlsWriteLabel(0,19,"Profit Per Material");
xlsWriteLabel(0,20,"Procurer");
xlsWriteLabel(0,21,"AP Comments");
xlsWriteLabel(0,22,"Approval");
xlsWriteLabel(0,23,"APPROVER NAME");
xlsWriteLabel(0,24,"Approver Comments");
xlsWriteLabel(0,25,"Type");
xlsWriteLabel(0,26,"Date of file Creation");
xlsWriteLabel(0,27,"Customer #");
xlsWriteLabel(0,28,"Vendor");
xlsWriteLabel(0,29,"Vendor details");
xlsWriteLabel(0,30,"Doc. Date");
xlsWriteLabel(0,31,"Invoice #");
xlsWriteLabel(0,32,"Crcy");
xlsWriteLabel(0,33,"Gross");
xlsWriteLabel(0,34,"Net amount");
xlsWriteLabel(0,35,"Charges");
xlsWriteLabel(0,36,"Charge amount");
xlsWriteLabel(0,37,"HAWB");
xlsWriteLabel(0,38,"OBL");
xlsWriteLabel(0,39,"Vessel");
xlsWriteLabel(0,40,"Shipper");
xlsWriteLabel(0,41,"Gross Weight (K)");
xlsWriteLabel(0,42,"Departure");
xlsWriteLabel(0,43,"Departure Port/Airport");
xlsWriteLabel(0,44,"Destination");
xlsWriteLabel(0,45,"Destination Port/Airport");
xlsWriteLabel(0,46,"PO REF");
xlsWriteLabel(0,47,"CONSIGNEE");
xlsWriteLabel(0,48,"AP - POSTED");
xlsWriteLabel(0,49,"POSTED DATE");
$con=mysqli_connect("localhost","root","","pacific_freight");
$query = "Select * from cockpit left join (Select ctry as c1, vendor as v1, bpo as b1 from all_charges1) as t1 on t1.v1=cockpit.Vendor and t1.c1=cockpit.ctry
 left join (Select ctry as c2, purchdoc as p2, Material as m2, Purchasinggroup as pg2 from po_data) as t2 on t2.p2=cockpit.Text2 and t2.c2=cockpit.ctry
 left join (Select ctry as c3, Material as m3, ProfitCenter as p3, PurchasingGroup2 as pg3 from mvp) as t3 on t3.m3=t2.m2 and t3.c3=cockpit.ctry
 where ctry = 'AU'";
$result = mysqli_query($con,$query);
if(mysqli_num_rows($result)>0){
	$ctr1 = 1;
	while($answer = mysqli_fetch_array($result)){
		xlsWriteLabel($ctr1,0,$answer['CCode']);
		xlsWriteLabel($ctr1,1,$answer['Scandate']);
		xlsWriteLabel($ctr1,2,$answer['DocNo']);
		xlsWriteLabel($ctr1,3,$answer['DocDate']);
		xlsWriteLabel($ctr1,4,$answer['Vendor']);
		xlsWriteLabel($ctr1,5,$answer['Vendordetails']);
		xlsWriteLabel($ctr1,6,$answer['Invoice']);
		xlsWriteLabel($ctr1,7,$answer['Reference']);
		xlsWriteLabel($ctr1,8,$answer['Currency']);
		xlsWriteNumber($ctr1,9,$answer['Grossamount']);
		xlsWriteNumber($ctr1,10,$answer['Netamount']);
		xlsWriteLabel($ctr1,11,$answer['Text1']);
		xlsWriteLabel($ctr1,12,$answer['Text2']);
		//-------
		xlsWriteLabel($ctr1,16,$answer['b1']);
		//-------
		if(trim($answer['p3'])){
			xlsWriteLabel($ctr1,19,$answer['p3']);
		}
		else{
			if(trim($answer['Text2'])){
				xlsWriteLabel($ctr1,19,"LIFESPACE");
			}
			else{
				xlsWriteLabel($ctr1,19,"PrG Name");
			}
		}
		if(trim($answer['pg3'])){
			xlsWriteLabel($ctr1,20,$answer['pg3']);
		}
		else{
			if(trim($answer['Text2'])){
				xlsWriteLabel($ctr1,20,"Not a Valid SEAU PO");
			}
			else{
				xlsWriteLabel($ctr1,20,"PC Not Found Due to Invalid PO");
			}
		}
		//-------
		if(trim($answer['Invoice'])){
			if($answer['Invoice']=="true"){
				xlsWriteLabel($ctr1,25,"Debit");
			}
			else{
				xlsWriteLabel($ctr1,25,"Credit");
			}
		}
		//-------
		xlsWriteLabel($ctr1,28,$answer['Vendor']);
		xlsWriteLabel($ctr1,29,$answer['Vendordetails']);
		xlsWriteLabel($ctr1,30,$answer['DocDate']);
		xlsWriteLabel($ctr1,31,$answer['Reference']);
		xlsWriteLabel($ctr1,32,$answer['Currency']);
		xlsWriteLabel($ctr1,33,$answer['Grossamount']);
		xlsWriteLabel($ctr1,34,$answer['Netamount']);
		//-------
		if(trim($answer['Text2'])){
			xlsWriteLabel($ctr1,46,$answer['Text2']);
		}
		else{
			xlsWriteLabel($ctr1,46,"No PO Found on Invoice");
		}
		
		$ctr1++;
	}
}
mysqli_free_result($result);
mysqli_close($con);
xlsEOF();
exit();
?>