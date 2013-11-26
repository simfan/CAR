<?php
	require "../classes/sortedTable.php";
	require "../classes/login.php";
	$car_table = new sortTable;
	$login = new Login;

	if(isset($_COOKIE['ID_my_site']))
	{
		$login->setUserName($_COOKIE['ID_my_site']);
		$login->setPassword($_COOKIE['Key_my_site']);
		$login->setUser();
		$match = $login->validateLogin($_GET['plant']);
	}
	else
	{
		$match = false;
	}
	$car_table->setPlant($_GET['plant']);
	$car_table->setColumn($_GET['field']);
	$car_table->setOrder($_GET['sort']);
	$car_table->setQuery($_GET['query']);
	
	$car_table->getColumns($match);
	print $car_table->getRows();	
	
?>