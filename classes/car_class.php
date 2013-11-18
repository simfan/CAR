<?php
	class CAR
	{
		var $car_num;
		var $car_array = array();
		
		var $host = "192.168.10.129";
		var $user = "postgres";
		var $pass = "pass";
		var $db = "inven";
		
		//*********SET and GET methods*****************/
		 function setCarNum($action, $car_num)
		{
			if ($action == 'Edit')
			{
				$this->car_num = $car_num;
			}
			else
			{
				$this->car_num = "Not Assigned";
			}
		}
		
		function getCarNum()
		{
			return $this->car_num;
		}

		function setPartNum($part)
		{
			$this->car_array['car_part_no'] = $part;
		}
		
		function getPartNum()
		{
			return $this->car_array['car_part_no'];
		}
			
		 function setQty($qty)
		{
			$this->car_array['car_qty'] = $qty;
		}
		
		 function getQty()
		{
			return $this->car_array['car_qty'];
		}
		
		 function setRev($rev)
		{
			$this->car_array['car_rev'] = $rev;
		}
		
		 function getRev()
		{
			return $this->car_array['car_rev'];
		}
		
		 function setCust($cust)
		{
			$this->car_array['car_cust'] = $cust;
		}
		
		 function getCust()
		{
			return $this->car_array['car_cust'];
		}
		
		function getCustChoices()
		{
			//read Customer Files
			$fh = fopen('files/customer_list.txt', 'rb');
			$options = '';
			for($line = fgets($fh); ! feof($fh); $line = fgets($fh))
			{
				$cust = trim($line);
				$is_selected = '';
				if($cust == $this->getCust())
					$is_selected = "selected";
				$options .= "<option value = $cust $is_selected>$cust</option>";
			}
			fclose($fh);
			return $options;
		}
		
		function setPlant($plant)
		{
			$this->car_array['car_plant'] = $plant;
		}
		
		function getPlant()
		{
			return $this->car_array['car_plant'];
		}
		
		function getPlantChoices()
		{
			$fh = fopen('files/plant.txt', 'rb');
			$options = '';
			$plant_name = array("K"=>"Atchison", "C"=>"Components", "D"=>"David City", "N"=>"Norristown", "R"=>"Richland", "T"=>"Reading");
			for($line = fgets($fh); ! feof($fh); $line = fgets($fh))
			{
				$plant = trim($line);
				$is_selected = '';
				if($plant == $this->getPlant())
					$is_selected = "selected";
				$options .= "<option value = $plant $is_selected>$plant_name[$plant]</option>";
			}
			fclose($fh);
			return $options;
		}
						
		function setDept($dept)
		{
			$this->car_array['car_dept'] = $dept;
		}
		
		function getDept()
		{
			return $this->car_array['car_dept'];
		}
		
		function getDeptChoices()
		{
			$fh = fopen('files/department_list.txt', 'rb');
			$options = '';
			for($line = fgets($fh); ! feof($fh); $line = fgets($fh))
			{
				$dept = trim($line);
				$is_selected = '';
				if($cust == $this->getDept())
					$is_selected = "selected";
				$options .= "<option value = $dept $is_selected>$dept</option>";
			}
			fclose($fh);
			return $options;
		}			
		
		function formatDate($date)
		{
			if($date != '')
				$date = str_replace('/', '-', $date);
			return $date;
		}
		
		function setReqDate($date)
		{
			$date = $this->formatDate($date);
			$this->car_array['car_req_date'] = $date;
		}
		
		function getReqDate()
		{
			return $this->car_array['car_req_date'];
		}
		
		function setRmaNum($num)
		{
			$this->car_array['car_rma_no'] = $num;
		}
		
		function getRmaNum()
		{
			return $this->car_array['car_rma_no'];
		}
		
		function setCustNc($cust_nc)
		{
			$this->car_array['car_cust_nc'] = $cust_nc;
		}
		
		function getCustNc()
		{
			return $this->car_array['car_cust_nc'];
		}
		
		function setReplyDue($date)
		{
			$date = $this->formatDate($date);
			$this->car_array['car_reply_due'] = $date;
		}
		
		function getReplyDue()
		{
			return $this->car_array['car_reply_due'];
		}
		
		function setReplySent($date)
		{
			$date = $this->formatDate($date);
			$this->car_array['car_reply_sent'] = $date;
		}
		
		function getReplySent()
		{
			return $this->car_array['car_reply_sent'];
		}
		
		function setFargoSn($sn)
		{
			$this->car_array['car_fargo_sn'] = $sn;
		}
		
		function getFargoSn()
		{
			return $this->car_array['car_fargo_sn'];
		}
		
		function setItem($item)
		{
			$this->car_array['car_item'] = $item;
		}
		
		function getItem()
		{
			return $this->car_array['car_item'];
		}
		
		function setSysAff($sys)
		{
			$this->car_array['car_sys_aff'] = $sys;
		}
		
		function getSysAff()
		{
			return $this->car_array['car_sys_aff'];
		}
		
		function setDesc($desc)
		{
			$this->car_array['car_desc'] = $desc;
		}
		
		function getDesc()
		{
			return $this->car_array['car_desc'];
		}
		
		function getDescChoices()
		{
			$fh = fopen('files/defect_code_list.txt', 'rb');
			$options = "";
			for($line = fgets($fh); ! feof($fh); $line = fgets($fh))
			{
				$line = trim($line);
				list($code, $desc) = explode("|", $line);
				$is_selected = '';
				if($code == $this->getDesc())
					$is_selected = "selected";
				$options .= "<option value = $code $is_selected>$code - $desc</option>";
			}
			fclose($fh);
			return $options;
		}

		function setDescExt($desc)
		{
			$this->car_array['car_desc_ext'] = $desc;
		}
		
		function getDescExt()
		{
			return $this->car_array['car_desc_ext'];
		}
		
		function setAct1($act)
		{
			$this->car_array['car_act_by1'] = $act;
		}
		
		function getAct1()
		{
			return $this->car_array['car_act_by1'];
		}
		
		function setCorrective($corrective)
		{
			$this->car_array['car_corrective'] = $corrective;
		}
		
		function getCorrective()
		{
			return $this->car_array['car_corrective'];
		}
		
		function setAct2($act)
		{
			$this->car_array['car_act_by2'] = $act;
		}

		function getAct2()
		{
			return $this->car_array['car_act_by2'];
		}

		function setRootCause($root)
		{
			$this->car_array['car_root_cause'] = $root;
		}
		
		function getRootCause()
		{
			return $this->car_array['car_root_cause'];
		}
		
		function setAct3($act)
		{
			$this->car_array['car_act_by3'] = $act;
		}
		
		function getAct3()
		{
			return $this->car_array['car_act_by3'];
		}		
		
		function setCorrectAct($correct)
		{
			$this->car_array['car_correct_act'] = $correct;
		}
		
		function getCorrectAct()
		{
			return $this->car_array['car_correct_act'];
		}
		
		function setAct4($act)
		{
			$this->car_array['car_act_by4'] = $act;
		}
		
		function getAct4()
		{
			return $this->car_array['car_act_by4'];
		}
		
		function setDateComplete($date)
		{		
			$date = $this->formatDate($date);
			$this->car_array['car_date_complete'] = $date;
		}
		
		function getDateComplete()
		{
			return $this->car_array['car_date_complete'];
		}
		
		function setTeam($team)
		{
			$this->car_array['car_team'] = $team;
		}
		
		function getTeam()
		{
			return $this->car_array['car_team'];
		}
		
		function setTitle($title)
		{
			$this->car_array['car_title'] = $title;
		}
		
		function getTitle()
		{
			return $this->car_array['car_title'];
		}
		
		function setCloseDate($date)
		{
			$date = $this->formatDate($date);
			$this->car_array['car_close_date'];
		}
		
		function getCloseDate()
		{
			return  $this->car_array['car_close_date'];
		}
		
		function setInit($init)
		{
			$this->car_array['car_init'] = $init;
		}
		
		function getInit()
		{
			return $this->car_array['car_init'];
		}
		
		function setReview($review)
		{
			$this->car_array['car_review'] = $review;
		}
		
		function getReview()
		{
			return $this->car_array['car_review'];
		}
		
		function setArchive($archive)
		{
			$this->car_array['car_archived'] = $archive;
		}
		
		function getArchive()
		{
			return $this->car_array['car_archived'];
		}
		
		function setArchiveCheck()
		{
			if($this->car_array['car_close_date'] != '' && $this->car_array['car_init'] != '' && $this->car_array['car_archived'] == 1)
			{
				$this->car_array['car_archive_check'] = true;
			}
			else
			{
				$this->car_array['car_archive_check'] = false;
			}
		}
		
		function getArchiveCheck()
		{
			return $this->car_array['car_archive_check'];
		}
		/********************************************************************/
		
		//DB Methods*********************************************************/
		function sanitize($value)
		{
			return htmlentities($value);
		}
		
		function addCAR()
		{

			$conn = pg_connect("host=$this->host dbname=$this->db user=$this->user password=$this->pass");
			$query = "INSERT INTO car(car_no, car_part_no, car_qty, car_rev, car_cust, car_plant,car_dept, car_req_date, car_rma_no, car_cust_nc, car_reply_due, car_reply_sent, car_fargo_sn, car_item, car_sys_aff, car_desc, car_desc_ext, car_act_by1, car_corrective, car_act_by2, car_root_cause, car_act_by3, car_correct_act, car_act_by4, car_date_complete, car_team, car_title) VALUES($this->car['car_no'], $this->car['car_part_no'], $this->car['car_qty'], $this->car['car_rev'], $this->car['car_cust'], $this->car['car_plant'], $this->car['car_dept'], $this->car['car_req_date'], $this->car['car_rma_no'], $this->car['car_cust_nc'], $this->car['car_reply_due'], $this->car_['car_reply_sent'], $this->car['car_fargo_sn'], $this->car['car_item'], $this->car['car_sys_aff'], $this->car['car_desc'], $this->car['car_desc_ext'], $this->car['car_act_by1'], $this->car['car_corrective'], $this->car[car_act_by2'],$this->car['car_root_cause'], $this->car['car_act_by3'], $this->car['car_correct_act'], $this->car['car_act_by4'],$this->car['car_date_complete'], $this->car['car_team'], $this->car['car_title'])";
			$result = pg_query($conn, $query) or die ("Error in query: $query " . pg_last_error($conn));
			$query = "COMMIT";
			$result = pg_query($conn, $query) or die ("Error in query: $query " . pg_last_error($conn));
			pg_close($conn);		
		}
		
		function updateCAR($car_num)
		{
			$conn = pg_connect("host=$this->host dbname=$this->db user=$this->user password=$this->pass");
			$query = "UPDATE car SET car_part_no = $this->car['car_part_no'], car_qty = $this->car['car_qty'], car_rev = $this->car['car_rev'], car_cust = $this->car['car_cust'], car_plant = $this->car['car_plant'], car_dept = $this->car['car_dept'], car_req_date = $this->car['car_req_date'], car_rma_no = $this->car['car_rma_no'], car_cust_nc = $this->car['car_cust_nc'], car_reply_due = $this->car['car_reply_due'], car_reply_sent = $this->car['car_reply_sent'], car_fargo_sn = $this->car['car_fargo_sn'], car_item = $this->car['car_item'], car_sys_aff = $this->car['car_sys_aff'], car_desc = $this->car['car_desc'], car_desc_ext = $this->car['car_desc_ext'], car_act_by1 = $this->car['car_act_by1'],car_corrective = $this->car['car_corrective'], car_act_by2 = $this->car['car_act_by2'], car_root_cause = $this->car['car_root_cause'], car_act_by3 = $this->car['car_act_by3'], car_correct_act = $this->car['car_correct_act'], car_act_by4 = $this->car['car_act_by4'], car_date_complete = $this->car['car_date_complete'], car_team = $this->car['car_team'], car_title = $this->car['car_title'] WHERE car_no = $this->car['car_no']";
			$result = pg_query($conn, $query) or die ("Error in query: $query " . pg_last_error($conn));
			$query = "COMMIT";
			$result = pg_query($conn, $query) or die ("Error in query: $query " . pg_last_error($conn));
			pg_close($conn);
		}
		
		function selectCAR($car_num)
		{
			if($car_num != 'blank')
			{	
				$conn = pg_connect("host=$this->host dbname=$this->db user=$this->user password=$this->pass");
				$car_num = $this->sanitize($car_num);
				$query = "SELECT car_no, car_part_no, car_qty, car_rev, car_cust, car_plant,car_dept, car_req_date, car_rma_no, car_cust_nc, car_reply_due, car_reply_sent, car_fargo_sn, car_item, car_sys_aff, car_desc, car_desc_ext, car_act_by1, car_corrective, car_act_by2, car_root_cause, car_act_by3, car_correct_act, car_act_by4, car_date_complete, car_team, car_title FROM car WHERE car_no = '" . $car_num . "'";
				$result = pg_query($conn, $query) or die("Error in query: $query " . pg_last_error($conn));
				$this->car_array = pg_fetch_array($result);
				pg_close($conn);
			}
			else
			{
				$this->setPartNum('');
				$this->setQty('');
				$this->setRev('');
				$this->setCust('');
				$this->setPlant('');
				$this->setDept('');
				$this->setReqDate('');
				$this->setRmaNum('');
				$this->setCustNc('');
				$this->setReplyDue('');
				$this->setReplySent('');
				$this->setFargoSn('');
				$this->setItem('');
				$this->setSysAff('');
				$this->setDesc('');
				$this->setDescExt('');
				$this->setAct1('');
				$this->setCorrective('');
				$this->setAct2('');
				$this->setRootCause('');
				$this->setAct3('');
				$this->setCorrectAct('');
				$this->setAct4('');
				$this->setDateComplete('');
				$this->setTeam('');
				$this->setTitle('');
				$this->setCloseDate('');
				$this->setInit('');
				$this->setReview('');
				$this->setArchive('');
				$this->setArchiveCheck();
			}
		}
		
		function maxCarNum()
		{
			$conn = pg_connect("host=$this->host dbname=$this->db user=$this->user password=$this->pass");
			$query = "SELECT * FROM car ORDER BY car_no * DESC LIMIT 1";
			$result = pg_query($conn, $query) or die("Error in query: $query " . pg_last_error($conn));
			$row_count = pg_num_rows($result);
			if($row_count > 0)
			{
				$max = $pg_fetch_array($result);
				$car_num = $max['car_no'] + 1;
			}
			else
				$car_no = 1;
			
			$num_length = strlen($car_no);
			for($i = 0; $i < 6 - $num_length; $i++)
			{
				$car_no = '0' . $car_no;
			}
			pg_close($conn);
			$this->car_num = $car_no;
		}
		
		function getCar()
		{
			$size = strlen($this->car_array);
			$car_string = "";
			for($i = 0; $i < $size; $i++)
			{
				$car_string .= "Field $i " .$this->car_array[$i];
			}
			return $car_string;
		}
	}
	
	class CAR_Process extends CAR
	{
		function setCarNum($car_num)
		{
			$this->car_num = $car_num;
		}
	}
?>