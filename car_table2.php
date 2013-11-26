<?php

	//Required Classes for this file
	require "classes/table.php";
	require "classes/login.php";
	$car_table = new Table();
	$login = new Login();
	
	//Check to see if there is a username cookie that s set.  If there is, set class variables and determine if the 
	//requested plant is a match to the user's plant.  Otherwise, set $match to false.
	if(isset($_COOKIE['ID_my_site']))
	{
		$login->setUserName($_COOKIE['ID_my_site']);
		$login->setPassword($_COOKIE['Key_my_site']);
		$login->setUser();
		$match = $login->validateLogin($_POST['plant']);
	}
	else
	{
		$match = false;
	}
	//*******************************************************************************************************//
	
	//Prepare column names
	$columns = array("Car Number", "Part Number", "Revision", "Qty", "Dept", "Customer", "RMA Date", "RMA Number", "NC Ref", "Validity", "Prob. Category");
	$car_table->setSize($columns);
	$car_table->setColumns($columns);
	
	$j = 0;

	$size = count($db_names);

	$db_names = array("car_no", "car_part_no", "car_rev", "car_dept", "car_cust", "car_req_date", "car_rma_no", "car_cust_nc", "car_sys_aff", "car_desc");

	//$post_size = count($_POST);
	
	//set the conditions for the query based on the values given on the search page.
	foreach($_POST as $name=>$value)
	{
		if(($value != '' && $value != "All") && $name != "submit")
		{
			$j = $car_table->setCondition($value, $name, $j);
			//$j++;
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<script src = "scripts/sortTable.js"></script>
	<link rel = "stylesheet" type = "text/css" href = "css/table.css" />
</head>
<body>
	<h2>CAR Table</h2>
	<!--<table class = "plantResults" name = "table1" id = "table1">-->
	<?php
	/*for($i = 0; $i < $size; $i++)
	{
		$table->setDBNames($db_names[$i], $i);
	}*/
	print $car_table->getRows($match);
	?>
	</table>
</body>