<?php
class Table
{
	var $host = "192.168.10.129";
	var $user = "postgres";
	var $pass = "pass";
	var $db = "inven";
	
	var $columns = array();
	var $db_names = array("plant" => "car_plant","carNo" => "car_no", "partNo" => "car_part_no", "rev" => "car_rev", "qty" => "car_qty", "dept" => "car_dept", "cust" => "car_cust", "reqDate" => "car_req_date", "rma" => "car_rma_no", "ncRef" => "car_cust_nc", "valid" => "car_fargo_sn", "prob" => "car_desc", "replySent" => "car_reply_sent", "replySentEnd" => "car_reply_sent", "reqDateEnd" => "car_req_date", "replyDue" => "car_reply_due", "replyDueEnd" => "car_reply_due", "team" => "car_team", "title" => "car_title", "archived" => "car_archived");
	var $plants = array("K" => "Atchison", "C" => "Components","D" => "David City", "N" => "Norristown", "R" => "Richland", "T" => "Reading");
	
	var $fields = array();
	var $conditions;
	var $size;
	var $select_db;	

	function setCondition($value, $name, $j)
	{
		switch($name)
		{
			case('plant'):
				if($value != "A")
				{
					if($j == 0)
					{
						$this->conditions .= "WHERE " .$this->getDBName($name) . " = '" . $value . "'";
					}
					else
					{
						$this->conditions .= " AND " . $this->getDBName($name) . " = '" . $value . "' ";
					}
				}
				break;
			case('dept'):
			case('cust'):
			case('prob'):
				if($value != "All")
				{
					if($j == 0)
					{
						$this->conditions .= "WHERE " .$this->getDBName($name) . " = '" . $value . "'";
					}
					else
					{
						$this->conditions .= " AND " . $this->getDBName($name) . " = '" . $value . "'";
					}
				}
				break;
			
			default:
				if($value != "" || $value != " ")
				{
					if($j == 0)
					{
						$this->conditions .= "WHERE " . $this->getDBName($name) ." LIKE '%" . $value . "%'";
					}
					else
					{
						$this->conditions .= " AND " . $this->getDBName($name) . " LIKE '%" . $value . "%'";
					}
				}
			break;
		}
	}
	
	function getConditions()
	{
		return $this->conditions;
	}
	
	function setSize($columns)
	{
		$this->size = count($columns);
	}
	
	function getSize()
	{
		return $this->size;
	}
	
	function setColumns($columns)
	{
		$col_size = $this->getSize();
		for($i = 0; $i < $col_size; $i++)
		{
			$this->columns[$i] = $columns[$i];
		}
	}
	
	function getColumns($match, $query, $plant, $count)
	{
		$column = array("car_plant", "car_no", "car_part_no", "car_rev", "car_qty", "car_dept", "car_cust", "car_req_date", "car_rma_no", "car_cust_nc", "car_fargo_sn", "car_desc");// "car_reply_sent", "car_reply_sent", "car_req_date", "car_reply_due", "replyDueEnd" => "car_reply_due", "team" => "car_team", "title" => "car_title", "archived" => "car_archived");
		$heading = "<tr class = 'columns'>";
		$query = str_replace("'", "|", $query);
		if($match)
		{
			$cols = 2;
		}
		else
		{
			$cols = 1;
		}
		$heading .= "<th colspan = $cols>&nbsp</th>";
		
		$col_size = $this->getSize();
		for($i = 0; $i < $col_size; $i++)
		{
			$heading .= "<th onclick=\"sortTable('". $plant ."', '" . $column[$i] . "', '" . $query . "', '" . $count . "', '" . 1 . "')\">" . $this->getColumn($i) . "</th>";
		}
		$heading .= "</tr>";
		return $heading;
	}
	
	function getColumn($i)
	{
		return $this->columns[$i];
	}
	
	function setDBNames($name, $i)
	{
		$this->db_names[$i] = $name;
	}
	
	function getDBName($name)
	{
		return $this->db_names[$name];
	}
	
	function getSelectFields()
	{
		$size = count($this->db_names);
		$i = 0;
		foreach($this->db_names as $html=>$db)
		{

				if($i > 0)
					$fields .= ", ";
				$fields .= $db;
				$i++;
		}
		return $fields;
	}
	
	function setRow($result)
	{
		$this->fields = pg_fetch_array($result);
	}
	
	function getWholeRow()
	{
		return $this->fields;
	}
	
	function getRow($i)
	{
		return $this->fields[$i];
	}
	
	function getRows($match)
	{
		$conn = pg_connect("host=$this->host dbname=$this->db user=$this->user password=$this->pass");
		$query = "SELECT " . $this->getSelectFields() . " FROM car " . $this->getConditions() . " ORDER BY car_plant, car_no";
		$result = pg_query($conn, $query) or die("Error in query: $query");
		$count = pg_num_rows($result);
		$col_size = $this->getSize();
		$row = "";
		$current_plant = "";
		$k = 0;
		for($i = 0; $i < $count; $i++)
		{
			$this->setRow($result);
			$car = $this->getWholeRow();
			switch($car['car_fargo_sn'])
			{
				case('Valid'):
					$validity = "valid";
					break;
				case('Invalid'):
					$validity = "invalid";
					break;
				case("Undecided"):
					$validity = "undecided";
					break;
			}
			if ($car['car_plant'] != $current_plant)
			{
				$k++;
				if($i > 0)
					$row .= "</table>";
				$row .= "<h3>" . $this->plants[$car['car_plant']] . "</h3><table class = 'plantResults' name = 'table" . $k ."' id = 'table" . $k . "'>" . $this->getColumns($match, $query, $car['car_plant'], $k);
				$current_plant = $car['car_plant'];
			}
			$row .= "<tr class = 'row " . $validity ."'>";
			$row .= "<td class = 'cells'><a href = 'car_pdf.php?carNo=" . $car['car_no'] . "'>View</a></td>";
			if($match)
			{
				$row .= "<td class = 'cells'><a href = 'car.php?action=edit&carNo=" . $car['car_no'] . "'>Edit</a></td>";
			}
			for($j = 1; $j < $col_size+1; $j++)
			{
				if($this->getRow($j) == '' || $this->getRow($j) == ' ')
					$field = "&nbsp;";
				else
					$field = $this->getRow($j);
				$row .= "<td class = 'cell" . $j . "'>" . $field . "</td>";
			}
			
			$row .= "</tr>";
		}
		pg_close($conn);
		return $row;
	}
}
?>