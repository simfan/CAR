<?php
	require("../car_class.php");

	$my_car = new CAR_Process();
	
	$my_car->setPartNum($_POST['part']);
	$my_car->setQty($_POST['qty']);
	$my_car->setRev($_POST['rev']);
	$my_car->setPlant($_POST['plant']);
	$my_car->setDept($_POST['dept']);
	$my_car->setReqDate($_POST['reqDate']);
	$my_car->setRma($_POST['rma']);
	$my_car->setCustNc($_POST['custNc']);
	$my_car->setReplyDue($_POST['replyDue']);
	$my_car->setReplySent($_POST['replySent']);
	$my_car->setFargoSn($_POST['fargoSn']);
	$my_car->setItem($_POST['item']);
	$my_car->setSysAff($_POST['sysAff']);
	$my_car->setDesc($_POST['desc']);
	$my_car->setDescExt(htmlentities($_POST['descExt']));
	$my_car->setAct1($_POST['actBy1']);
	$my_car->setCorrective($_POST['corrective']);
	$my_car->setAct2($_POST['actBy2']);
	$my_car->setRootCause(htmlentities($_POST['rootCause']));
	$my_car->setAct3($_POST['actBy3']);
	$my_car->setCorrectAct(htmlentities($_POST['correctAct']));
	$my_car->setAct4($_POST['actBy4']);
	$my_car->setDateComplete($_POST['dateComplete']);
	$my_car->setTeam($_POST['team']);
	$my_car->setTitle($_POST['title']);
	
	if($_POST['action'] = 'add']
	{
		$my_car->maxCarNumber();
		$my_car->addRecord($my_car->car_array);
	}
	
	if($_POST['action'] = 'Edit']
	{	
		$my_car->setCarNum($_POST['carNum']);
		$my_car->setCloseDate($_POST['dateClosed']);
		$my_car->setReviewed($_POST['reviewed']);
		$my_car->setArchived($_POST['archived']);
		$my_car->setArchiveCheck();
		$my_car->updateRecord($my_car->car_array);
	}
	header("Location: index.php");
?>