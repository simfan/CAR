<?php
	require("classes/car_class.php");
	$my_car = new CAR();
	$my_car->setCarNum($_GET['action'], $_GET['carNum']);
	$car_no = $my_car->getCarNum();
	if($car_no != '')
	{
		print $my_car->selectCAR($car_no);
	}
	else
	{
		$my_car->selectCAR("blank");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<script src = "car.js"></script>
  	<link rel = "stylesheet" type = "text/css" href = "css/car.css" />
</head>
<body>
	<!--...	-->
	<form>
		<div class = "row small">
			<div id = "logo" class = "cell medium">FARGO ASSEMBLY OF PA</div>
			<div id = "formType" class = "cell small">CORRECTIVE ACTION REQUEST</div>
			<div id = "part" class = "cell small">Part Number:<input type = "text" name = "partNum" id = "partNum" value = "<?php print $my_car->getPartNum();?>" /></div>
			<div id = "carNo" class = "cell small">CAR Number: <?php print $car_no; ?></div>
		</div>
		<div class = "row small">
			<div id = "carQty" class = "cell small">Qty: <input type = "text" name = "qty" id = "qty" size = 5 maxlength = 5 value = "<?php print $my_car->getQty();?>" /></div>
			<div id = "carRev" class = "cell small">Rev: <input type = "text" name = "rev" id = "rev" size = 5 maxlength = 5 value = "<?php print $my_car->getRev();?>" /></div>
			<div id = "carCust" class = "cell small">Customer: <select name = "cust" id = "cust"><?php print $my_car->getCustChoices()?></select></div>
			<div id = "carPlant" class = "cell small">Plant: <select name = "plant" id = "plant"><?php print $my_car->getPlantChoices()?></select></div>
			<div id = "carDept" class = "cell small" >Dept: <select name = "dept" id = "dept"><?php print $my_car->getDeptChoices()?></select><!-- value = "<?php print $my_car->getDept();?>" />--></div>
		</div>
		<div class = "row medium">
			<div id = "carRowDate" class = "cell medium">RMA Request Date: <input type = "text" name = "rmaDate" id = "rmaDate" size = 10 maxlength = 10 value = "<?php print $my_car->getReqDate(); ?>" /></div>
			<div id = "carRma" class = "cell medium">RMA #: <input type = "text" name = "rma" id = "rma" size = 10 maxlength = 10 value = "<?php print $my_car->getRmaNum(); ?>" /></div>
			<div id = "carNcRef" class = "cell medium">Customer NC Ref #: <input type = "text" name = "ncRef" id = "ncRef" size = 25 maxlength = 25 value = "<?php print $my_car->getCustNc(); ?>" /></div>
			<div id = "carDateDue" class = "cell small">Date Reply Due: <input type = "text" name = "dateDue" id = "dateDue" size = 10 maxlength = 10 value = "<?php print $my_car->getReplyDue(); ?>" /></div>
			<div id = "carDateSent" class = "cell small">Date Reply Sent: <input type = "text" name = "dateSent" id = "dateSent" size = 10 maxlength = 10 value = "<?php print $my_car->getReplySent(); ?>" /></div>
		</div>
		<div class = "row small">
			<div id = "carClaim" class = "cell small">Claim Validity: <input type = "text" name = "validity" id = "validity" value = "<?php print $my_car->getFargoSn(); ?>" /></div>
			<div id = "carItem" class = "cell small">Item: <input type = "text" name = "item" id = "item" value = "<?php print $my_car->getItem(); ?>" /></div>
		</div>
		<div class = "row small border" style = "padding-left: 5px; width: 99.5%;">Quality System Affected: <input type = "text" name = "sysAffected" id = "sysAffected" value = "<?php print $my_car->getSysAff(); ?>" /></div>
		<div class = "row small border">Description of Nonconformance <select name = "desc" id = "desc" ><?php print $my_car->getDescChoices()?></select></div>
		<div class = "row large border"><span class = "padded">Extended Description of Problem <textarea name = "extDesc" id = "extDesc" rows = 10 cols = 80><?php print $my_car->getDescExt(); ?> </textarea></span></div>
		<div class = "row small border">Action Taken By: <input type = "text" name = "action1" id = "action1" value = "<?php print $my_car->getAct1(); ?>" /></div>
		<div class = "row large border"><span class = "padded">Interim Corrective Action: <textarea name = "interim" id = "interim" rows = 10 cols = 80><?php print $my_car->getCorrective(); ?> </textarea></span></div>
		<div class = "row small border">Action Taken By: <input type = "text" name = "action2" id = "action2" value = "<?php print $my_car->getAct2(); ?>" /></div>
		<div class = "row large border"><span class = "padded">Root Cause Analysis: <textarea name = "rootCause" id = "rootCause" rows = 10 cols = 80><?php print $my_car->getRootCause(); ?></textarea></span></div>
		<div class = "row small border">Action Taken By: <input type = "text" name = "action3" id = "action3" value = "<?php print $my_car->getAct3(); ?>" /></div>
		<div class = "row small border-top"><span class = "padded">Permanent Corrective Action to Prevent the Re-occurance of the Nonconformance</span></div>
		<div class = "row large border-bottom"><span class = "padded"><textarea name = "permanent" id = "permanent" rows = 10 cols = 110><?php print $my_car->getCorrectAct(); ?></textarea></span></div>
		<div class = "row small border">Action Taken By: <input type = "text" name = "action4" id = "action4" value = "<?php print $my_car->getAct4(); ?>" /></div>
		<div class = "row small border">Date Corrective Action Completed: <input type = "text" name = "dateCompleted" id = "dateCompleted" value = "<?php print $my_car->getDateComplete(); ?>" /></div>
		<div class = "row small border">Team: <input type = "text" name = "team" id = "team" value = "<?php print $my_car->getTeam(); ?>" /></div>
		<?php if($_GET['action'] == 'add') {?>
		<div class = "pictures">
			<input type = "file" name = "image1" id = "image1" /><br/>
			<input type = "file" name = "image2" id = "image2" /><br/>
			<input type = "file" name = "image3" id = "image3" />
		</div>
		<?php } ?>
		<?php if($_GET['action'] == 'Edit')	{?>
		<div class = "row small border">
			<div class = "cell small" id = "carCloseDate" ><span>Close Date: <input type = "text" name = "dateClosed" id = "dateClosed" value = "<?php print $my_car->getCloseDate(); ?>" /></span></div>
			<div class = "cell small" id = "carArchive"><span>Archived? <input type = "checkbox" name = "archived" id = "archived" /></span></div>
		</div>
		<div class = "row small">
			<div id = "carReview" class = "cell small">Reviewed By <input type = "text" name = "reviewedBy" id = "reviewedBy" value = "<?php print $my_car->getReview(); ?>" /></div>
			<div id = "carTitle" class = "cell small">Title <input type = "text" name = "title" id = "title" value = "<?php print $my_car->getTitle(); ?>" /></div>
			<div id = "carInit" class = "cell small">Mgr Initials <input type = "text" name = "init" id = "init" value = "<?php print $my_car->getInit(); ?>" /></div>
		</div>
		<?php } ?>
		<div class = "row"><input type = "submit" name = "submit" id = "submit" value = "Submit" /></div>
			
	</form>
</body>
</html>