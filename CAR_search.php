<?php
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
	
	$fh = fopen('files/department_list.txt', 'rb');
	$i = 0;
	for ($line = fgets($fh); ! feof($fh); $line = fgets($fh))
	{
		$dept_name[$i] = trim($line);
		$i++;
	}
	fclose($fh);
	$dept_count = $i;	
	//$fh = fopen('/u/in.dt/co/info/cust.dt', 'rb');
	$fh = fopen('files/customer_list.txt', 'rb');
	$i = 0;
	for ($line = fgets($fh); ! feof($fh); $line = fgets($fh))
	{
		$line = trim($line);
		//list($cust_code[$i], $cust_name[$i], $rest[$i]) = explode("\t", $line, 3);
		//$cust_code[$i] = trim($cust_code[$i]);
		$cust_name[$i] = trim($line);
		//print $cust_code[$i] . "\n";
		$i++;
		//print $cust_code[$i];
	}
	//array_multisort($cust_code, $cust_name); 
	$cust_count = $i;
	fclose($fh);	
?>
<html>
<body>
	<h1 align = center>CAR Search</h1>
	<p align = center>Please enter the field or fields you wish to search by</p>
	<form name = 'carSearch' action = 'car_table2.php' method = 'post' >
	<!--onsubmit = 'this.partno.required = true; this.qty.numeric = true; this.requestDate.dateCheck = true; this.replyDue.dateCheck = true; this.replySent.dateCheck = true; this.completeDate.dateCheck = true; return verify(this, $fields)'>-->
	<table align = center style = "margin-left: auto; margin-right: auto;">
		<tr>
			<td align = "right">CAR #</td><td><input type = "text" name = "carNo" id = "carNo" size = 6 maxlength = 6 /></td>
		</tr>
		<tr>
			<td align = "right">Part #</td><td><input type = "text" name = "partNo" id = "partNo" size = 24 maxlength = 24 /></td>
		</tr>
		<tr>
			<td align = "right">Rev</td><td><input type = "text" name = "rev" id = "rev" size = 4 maxlength = 4 /></td>
		</tr>
		<tr>
			<td align = "right">Qty</td><td><input type = "text" name = "qty" id = "qty" size = 4 maxlength = 4 /></td>
		</tr>
		<tr>
			<td align = "right">Plant</td>
			<td>
				<select name = "plant" id = "plant">
					<option value = "A">All Plants</option>
					<option value = "K">Atchison</option>
					<option value = "C">Components</option>
					<option value = "D">David City</option>
					<option value = "N">Norristown</option>
					<option value = "T">Reading</option>
					<option value = "R">Richland</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align = "right">Dept.</td>
			<td>
				<select name = "dept" id = "dept">
					<?php 
						print "<option value = 'All'>All Departments</option>";
						for ($i = 0; $i < $dept_count; $i++)
						{
							print "<option value = $dept_name[$i]>$dept_name[$i]</option>";
						}
					?>	
				</select>
			</td>
		<tr>
			<td align = "right">Customer</td><td><select name = "cust" id = "cust"><!--<input type = "text" name = "cust" id = "cust" size = 3 maxlength = 3 />-->
			<?php print "<option value = 'All'>All Customers</option>";
					for($i = 0; $i < $cust_count; $i++)
						print "<option value = '" . $cust_name[$i] . "'>" . $cust_name[$i] . "</option>";
					?></td>
		</tr>
		<tr>
			<td align = "right">RMA Request Date (MM-DD-YYYY)</td><td><input type = "text" name = "reqDate" id = "reqDate" size = 10 maxlength = 10 /> - <input type = "text" name = "reqDateEnd" id = "reqDateEnd" size = 10 maxlength = 10 /></td>
		</tr>
		<tr>
			<td align = "right">RMA</td><td><input type = "text" name = "rma" id = "rma" size = 10 maxlength = 10 /></td>			
		</tr>
		<tr>
			<td align = "right">Customer NC Ref #</td><td><input type = "text" name = "ncRef" id = "ncRef" size = 10 maxlength = 10 /></td>
		</tr>
		<tr>
			<td align = "right">Validity</td>
			<td><select name = "valid" id = "valid">
					<option value = "All">All</option>
					<option value = "Valid">Valid</option>
					<option value = "Invalid">Invalid</option>
					<option value = "Undecided">Undecided</option>
				</select>
			</td>
		<tr>
			<td align = "right">Date Reply Sent</td><td><input type = "text" name = "replySent" id = "replySent" size = 10 maxlength = 10 /></td>
		</tr>
		<tr>
			<td align = "right">Date Reply Due</td><td><input type = "text" name = "replyDue" id = "replyDue" size = 10 maxlength = 10 /></td>
		</tr>		
		<!--<tr>
			<td align = "right">Fargo Serial Number</td><td><input type = "text" name = "fargoSN" id = "fargoSN" size = 10 maxlength = 10 /></td>
		</tr>
		<tr>
			<td align = "right">Item</td><td><input type = "text" name = "item" id = "item" size = 25 maxlength = 25 /></td>
		</tr>
		<tr>
			<td align = "right">Quality System Affected</td><td><input type = "text" name = "sysAff" id = "sysAff" size = 50 maxlength = 50/></td>
		</tr>		-->
		<tr>
			<td align = "right">Problem Category</td>
			<td>
				<select name = "prob" id = "prob">
					<?php 
						print "<option value = 'All'>All Categories</option>";
						for($i = 0; $i < $desc_count; $i++)
						{
							print "<option value = $code[$i]>$code[$i] - $code_desc[$i]</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td align = "right">Team</td><td><input = "text" name = "team" id = "team" size = 25 maxlength = 25 /></td>
		</tr>
		<tr>
			<td align = "right">Title</td><td><input = "text" name = "title" id = "title" size = 25 maxlength = 25 /></td>
		</tr>		
		<tr>
			<td align = "right">Date Closed (MM-DD-YYYY)</td><td><input type = "text" name = "dateClosed" id = "dateClosed" size = 10 maxlength = 10 /></td>
		</tr>
		<tr>
			<td align = "right">Initials</td><td><input type = "text" name = "init" id = "init" size = 3 maxlength = 3 /></td>
		</tr>
		<tr>
			<td align = "right">Archived?</td>
			<td>
				<select name = "archived" id = "archived">
					<option value = "All">All</option>
					<option value = '0'>Active</option>
					<option value = '1'>Archived</option>
				</select>
			</td>
	</table>
	<input type = "submit" name = "submit" id = "submit" value = "Submit"/>
	</form>
	<a href = "index.php">Return to Index</a>
</body>
</html>
			