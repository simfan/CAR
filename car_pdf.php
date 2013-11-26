<?php 
	ob_start();
	require('fpdf153/fpdf.php');

	$host = "192.168.10.129";
	$user = "postgres";
	$pass = "pass";
	$db = "inven";
	$conn = pg_connect ("host=$host dbname=$db user=$user password=$pass");
	if(!$conn)
	{
		die('Could not connect to database.');
	}
	
	$special_chars = array("\n", "\r", "\t");
	$fh = fopen('files/defect_code_list.txt', 'rb');
	$i = 0;
	for ($line = fgets($fh); ! feof($fh); $line = fgets($fh))
	{
		$line = trim($line);
		list($code[$i], $code_desc[$i]) = explode('|', $line);
		$i++;
	}
	
	$desc_count = $i;
	fclose($fh);
	//Run the query and assign all needed values to variables
	$car_no = $_GET['carNo'];
	$query = "SELECT * FROM car WHERE car_no = '" . $car_no . "'";
	$result = pg_query($conn, $query) or die("Error in query: $query");
	$car = pg_fetch_array($result);
	
	$part_no = $car['car_part_no'];
	$car_no = $car['car_no'];
	$qty = $car['car_qty'];
	$rev = $car['car_rev'];
	$cust = $car['car_cust'];
	$plant = $car['car_plant'];
	$plant_list = array("C" => "Components", "K" => "Atchison", "D" => "David City", "N" => "Norristown", "T" => "Reading", "R" => "Richland");
	$dept = $car['car_dept'];
	$req_date = $car['car_req_date'];
	$rma = $car['car_rma_no'];
	$nc_ref = $car['car_cust_nc'];
	$reply_due = $car['car_reply_due'];
	$reply_sent = $car['car_reply_sent'];
	$claim_validity = $car['car_fargo_sn'];
	$item = $car['car_item'];
	$sys_affected = $car['car_sys_aff'];
	$desc = $car['car_desc'];
	$ext_desc = $car['car_desc_ext'];
	$action_by_1 = $car['car_act_by1'];
	$corrective = $car['car_corrective'];
	$action_by_2 = $car['car_act_by2'];
	$root_cause = $car['car_root_cause'];
	$corrective_action = $car['car_correct_act'];
	$action_by_3 = $car['car_act_by3'];
	$date_completed = $car['car_date_complete'];
	$team = $car['car_team'];
	$titles = $car['car_title'];
	$date_closed = $car['car_close_date'];
	$init = $car['car_init'];
	$action_by_4 = $car['car_act_by4'];
	$reviewed = $car['car_review'];
	
	//calculations so the multiple line fields to fit in allocated space
	$multi_width = 135/83;
	$max_lines = 8;
	$ext_desc_length = strlen($ext_desc);
	$ext_desc_lines = ceil($ext_desc_length/83);
	//$ext_desc_h_width = $multi_width * $ext_desc_length;
	
	$corrective_length = strlen($corrective);
	$corrective_lines = ceil($corrective_length/83);
	
	$root_cause_length = strlen($root_cause);
	$root_cause_lines = ceil($root_cause_length/83);
	
	$corrective_action_length = strlen($corrective_action);
	$corrective_action_lines = ceil($corrective_action_length/83);
	
	
	/****************************************/
	//Set up the PDF default values, header, and footer
	class PDF extends FPDF
	{
		var $x;
		var $y;
	}
	/****************************************/
	
	//Create the PDF
	$pdf = new PDF();
	$title = "CAR";
	$pdf->SetTitle($title);
	$pdf->SetFont('Arial', '', 10);
	$pdf->AddPage();
	$pdf->Rect(10, 10, 190, 270);
	$pdf->SetFontSize(11);
	$pdf->SetLeftMargin(10);
	$pdf->SetXY(10, 15);
	//Set the Name of the Form
	$pdf->MultiCell(40, 5, "FARGO ASSEMBLY OF PA", 0, 'C');
	
	//set the margin for the first two rows
	$pdf->SetFontSize(8);
	$pdf->SetLeftMargin(50);	
	$pdf->SetXY(50, 10);
	$pdf->x = $pdf->GetX();
	$pdf->y = $pdf->GetY();
	//ROW 1: Part Number and CAR Number
	
	$pdf->Cell(60, 10, "CORRECTIVE ACTION REQUEST");
	$pdf->Cell(60, 10, "PART NO(s): $part_no");
	$pdf->Cell(30, 10, "CAR NO: $car_no", 0, 1);
	$pdf->y = $pdf->GetY();
	$pdf->Line(50, 20, 200, 20);
	$pdf->Line(110, 10, 110, 20);
	
	//ROW 2: Qty, Rev, Customer, Plant, and Department
	$pdf->Cell(20, 10, "QTY: $qty");
	$pdf->Cell(30, 10, "REV: $rev");
	$pdf->Cell(40, 10, "CUSTOMER: $cust");
	$pdf->Cell(40, 10, "PLANT: $plant_list[$plant]");
	$pdf->Cell(30, 5, "DEPT:", 0, 1);
	$pdf->SetX(180);
	$pdf->Cell(30, 5, $dept, 0, 1);
	$pdf->Line(10, 30, 200, 30);
	//Set the Margin for the remaining rows
	$pdf->SetLeftMargin(10);
	$pdf->SetX(10);
	
	//ROW 3A: RMA Request Date, RMA #, Customer NC Ref(Titles), Reply Due
	$pdf->SetFontSize(10);
	$pdf->Cell(60, 10, "RMA REQUEST DATE:");
	$pdf->Cell(20, 10, "RMA #:");
	$pdf->Cell(50, 10, "CUSTOMER NC REF #:");
	//$pdf->Cell(50, 10, "DATE REPLY DUE: ", 0, 1);
	$pdf->Cell(50, 10, "DATE REPLY DUE: $reply_due", 0, 1);
	
	//ROW 3B: RMA Request Date, RMA #, Customer NC Ref, Reply Sent
	$pdf->Cell(60, 5, $req_date, 0, 0 ,'C');
	$pdf->Cell(20, 5, $rma, 0, 0, 'C');
	$pdf->Cell(50, 5, $nc_ref, 0, 0, 'C');
	$pdf->Cell(50, 5, "DATE REPLY SENT: $reply_sent", 0, 1);
	
	//Draw Lines for the first 3 rows
	$pdf->Line(10, 50, 200, 50);
	$pdf->Line(50, 10, 50, 30);
	$pdf->Line(70, 20, 70, 50);
	$pdf->Line(170, 10, 170, 20);
	$pdf->Line(100, 20, 100, 30);
	$pdf->Line(180, 20, 180, 30);
	$pdf->Line(90, 30, 90, 50);
	$pdf->Line(140, 20, 140, 50);
	$pdf->Line(140, 40, 200, 40);
	//ROW 4: Claim Validity & Item
	$pdf->Cell(95, 15, "Claim Validity: $claim_validity");
	$pdf->Cell(95, 15, "ITEM: $item", 0, 1);
	$pdf->Line(10, 60, 200, 60);
	$pdf->Line(105, 50, 105, 60);
	
	//ROW 5: Quality Systems Affected
	$pdf->Cell(180, 5, "QUALITY SYSTEM AFFECTED: $sys_affected", 0, 1);
	$pdf->Line(10, 65, 200, 65);
	
	//ROW 6: Description of Nonconformance
	for($i = 0; $i < $desc_count; $i++)
	{
		if($code[$i] == $desc)
		{
			$j = $i;
			break;
		}
	}
	$pdf->SetFontSize(9);
	$pdf->Cell(180, 5, "DESCRIPTION OF NONCONFORMANCE: $code_desc[$j]", 0, 1);
	$pdf->SetFontSize(10);
	$pdf->Line(10, 70, 200, 70);
	
	//ROW 7: Extended Description
	$pdf->Cell(55, 25, "Extended Description of Problem");
	//$pdf->SetY($pdf->GetY()-40);
	if($ext_desc_lines > 6)
		$pdf->SetFontSize(9);
	$pdf->MultiCell(135, 5, $ext_desc);
	$pdf->SetFontSize(10);
	$pdf->Line(10, 102, 200, 102);
	$pdf->SetY(102);
	//$pdf->Ln(20);
	//$pdf->Ln(30 - ($ext_desc_lines * 6));
	
	//ROW 8: Action Taken By
	$pdf->Cell(180, 10, "ACTION TAKEN BY: $action_by_1", 0, 1);
	$pdf->Line(10, 110, 200, 110);
	//ROW 9: Recipient Header (With gray background)
	$pdf->SetFillColor(155);
	$pdf->Cell(190, 10, "This section is to be completed by the IN HOUSE FARGO Recipient", 0, 1, 'C', true);
	
	//ROW 10: Interim Corrective Action
	$pdf->Cell(55, 25, "INTERIM CORRECTIVE ACTION:");
	//$pdf->SetY($pdf->GetY()-40);
	$pdf->MultiCell(135, 5, $corrective);
	$pdf->Line(10, 152, 200, 152);
	$pdf->SetY(150);

	
	//ROW 11: Action Taken By
	$pdf->Cell(180, 10, "ACTION TAKEN BY: $action_by_2", 0, 1);
	$pdf->Line(10, 160, 200, 160);

	//ROW 12: Root Cause Analysis
	$pdf->Cell(55, 25, "ROOT CAUSE ANALYSIS:");
	$pdf->Line(10, 192, 200, 192);
	
	//$pdf->SetY($pdf->GetY()-40);
	if($root_cause_lines > 8)
		$pdf->SetFontSize(9);
	$pdf->MultiCell(135, 4, $root_cause);
	$pdf->SetY(190);
	$pdf->SetFontSize(10);
	$pdf->Line(10, 200, 200, 200);
	//$pdf->Ln(25);

	//ROW 13: Action Taken By
	$pdf->Cell(180, 10, "ACTION TAKEN BY: $action_by_3", 0, 1);
	$pdf->Line(10, 237, 200, 237);
	
	//ROWS 14 & 15:
	$pdf->Cell(190, 10, "PERMANENT CORRECTIVE ACTION TO PREVENT THE RE-OCCURANCE OF THE NONCONFORMANCE", 0, 1);
	$pdf->SetX(20);
	if($corrective_action_lines > 5)
	{
		$pdf->SetFontSize(9);
	}
	$pdf->MultiCell(170, 5, $corrective_action);
	$pdf->SetFontSize(10);
	$pdf->Line(10, 245, 200, 245);
	$pdf->SetY(235);
	//$pdf->Ln(25 - ($corrective_action_lines * 5));
	//$pdf->Ln(20);
	
	//ROW 16: Action Taken By
	$pdf->Cell(180, 10, "ACTION TAKEN BY: $action_by_4", 0, 1);
	$pdf->Line(10, 255, 200, 255);
	
	//ROW 17: Date Corrective Action Completed
	$pdf->Cell(180, 10, "DATE CORRECTIVE ACTION COMPLETED: $date_completed", 0, 1);
	
	//ROW 18: Team
	$pdf->Cell(180, 10, "Team: $team", 0, 1);
	$pdf->Line(10, 262, 200, 262);

	$pdf->Cell(90, 5, "Close Date: $date_closed", 0, 1);
	$pdf->Line(10, 270, 200, 270);
	
	$pdf->Cell(70, 6, "Reviewed By: $reviewed");
	$pdf->Cell(70, 6, "Title: $titles");
	$pdf->Cell(50, 6, "Mgr. Initials: $init");
	
	$pdf->SetY(285);
	/*if(file_exists("images/" . $car_no . "a.jpg"))
	{
		$pdf->AddPage();
		$pdf->Image("images/" . $car_no . "a.jpg", 10, 10, 67, 50);
	}

	if(file_exists("images/" . $car_no . "b.jpg"))
	{
		$pdf->Image("images/" . $car_no . "b.jpg", 10, 70, 67, 50);
	}

	if(file_exists("images/" . $car_no . "c.jpg"))
	{
		$pdf->Image("images/" . $car_no . "c.jpg", 10, 130, 67, 50);
	}
	if(file_exists("images/" . $car_no . "a.JPEG"))
	{
		$pdf->Image("images/" . $car_no . "a.JPEG");
	}
	$pdf->Image($car_no . "b.jpeg");
	$pdf->Image($car_no . "c.jpeg");*/
	$pdf->Output();?>