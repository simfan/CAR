<?php
	$host = "192.168.10.129";
	$user = "postgres";
	$pass = "pass";
	$db = "inven";
	$conn = pg_connect ("host=$host dbname=$db user=$user password=$pass");
	if(!$conn)
	{
		die('Could not connect to database.');
	}
	$login = "login.php";
	$login_text = "Log In";
	$password_check = 0;
	if(isset($_COOKIE['ID_my_site']))
	{
		$username = $_COOKIE['ID_my_site'];
		$password = $_COOKIE['Key_my_site'];
		
		$check = "SELECT * FROM car_login WHERE car_username = '$username'";
		$check_results = pg_query($conn, $check) or die("Error in query: $query. " . pg_last_error($conn));
		$user_info = pg_fetch_array($check_results);
		
		$location_list['A'] = 'All Plants';
		$location_list['K'] = 'Atchison';
		$location_list['C'] = 'Components';
		$location_list['D'] = 'David City';
		$location_list['N'] = 'Norristown';
		$location_list['T'] = 'Reading';
		$location_list['R'] = 'Richland';		
		
		if($password == $user_info['car_password'])
		{
			$login = "logout.php?location=index";
			$login_text = "Log Out";
			$password_check = 1;
		}
	}
?>
<html>
<body>
	<div><?php print "<a href = $login>$login_text</a>";?></div>
	<h1 align = "center">CAR Home</h1>
	</br>
	<?php if($password_check == 0){?>
	<h3 align = "center">Please login to enter CAR or edit record</h3><?php }?>
	<table align = "center">
		<tr>
			<!--<?php if($password_check == 1){?><td><a href = "CAR.php?action=add">New CAR</a></td>&nbsp&nbsp&nbsp&nbsp <?php }?><td><a href = "location.php?status=open">View Open CAR Table</a></td>&nbsp&nbsp&nbsp&nbsp <td><a href = "location.php?status=archived">View Archived CAR Table</a></td>-->
			<?php if($password_check == 1){?><td><a href = "CAR.php?action=add">New CAR</a></td><?php if ($user_info['plant1'] == 'A'){?>&nbsp&nbsp&nbsp&nbsp <td><a href = "CAR_csv_upload.php">Upload CAR File</a></td><?php }}?><td><a href = "CAR_search.php">Search Records</a></td><!--<?php if ($password_check == 1){ print '<td><a href = "CAR_table.php'; if ($user_info["plant1"] <> 'A'){print '?plant=' . $user_info['plant1'];}  print '">View All Records for ' . $location_list[$user_info["plant1"]] . '</a></td>';}?>-->
		</tr>
	</table>
	<a href = "http://192.168.10.129/quality/">Back to Quality</a>
</body>
</html>