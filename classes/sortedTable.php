<?php 
	require "table.php";

class sortTable extends Table
{
	var $plant;
	var $column;
	var $column_name = array("car_no"=>"Car Number", "car_part_no"=>"Part Number", "car_rev"=>"Revision", "car_qty"=>"Qty", "car_dept"=>"Dept", "car_cust"=>"Customer", "car_req_date"=>"RMA Date", "car_rma_no"=>"RMA Number", "car_cust_nc"=>"NC Ref", "car_fargo_sn"=>"Validity", "car_desc"=>"Prob. Category");
	var $query;
	var $order;
	var $tableCount;
	
	function setCount($count)
	{
		$this->tableCount = $count;
	}
	
	function getCount()
	{
		return $this->tableCount;
	}
	
	function setPlant($plant)
	{
		$this->plant = $plant;
	}
	
	function getPlant()
	{
		return $this->plant;
	}
	
	function setColumn($column)
	{
		$this->column = $column;
	}
	
	function getColumn()
	{
		return $this->column;
	}
	
	function getColumnNames()
	{
		return $this->column_name;
	}

	function setQuery($query)
	{

		
		$query = str_replace("|", "'", $query);
		
		if(preg_match("/WHERE/i", $query))
		{	
			list($query_fields, $query_conditions) = explode("WHERE", $query);
			if(!preg_match("/car_plant =/i", $query_conditions))
			{
				$query .= " AND car_plant = '" . $this->getPlant() . "'";
			}
		}
		else
		{
			$query .= " WHERE car_plant = '" . $this->getPlant() . "'";
		}
	
		$query .= " ORDER BY " . $this->getColumn();

		if($this->getOrder() == 0)
		{
			$query .= " DESC";
		}

		$this->query = $query;
	}
	
	function getQuery()
	{
		return $this->query;
	}
	
	function setOrder($order)
	{
		$this->order = $order;
	}
	
	function getOrder()
	{
		return $this->order;
	}
	
	function getColumns($match)
	{
		$heading = "<tr class = 'columns'>";
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
		$i = 0;
		$column_name = $this->getColumnNames();
		foreach($column_name as $db_field=>$column_title)
		{
			$query = str_replace("'", "|", $this->getQuery());
			$new_order = 1;
			if($db_field == $this->getColumn() && $this->getOrder() == 1)
			{
				$new_order = 0;
			}
			$heading .= "<th onclick = \"sortTable('". $this->getPlant() ."', '" . $db_field . "', '" . $query . "', '" . $this->getCount() . "', '" . $new_order . "')\">" . $column_title . "</th>";
			$i++;
		}
		$heading .= "</tr>";
		return $heading;
	}
	function getRows($match)
	{
		$this->setSize($this->getColumnNames());
		$conn = pg_connect("host=$this->host dbname=$this->db user=$this->user password=$this->pass");
		$query = $this->getQuery();
		$result = pg_query($conn, $query) or die("Error in query: $query");
		$count = pg_num_rows($result);
		$col_size = $this->getSize();
		$row = "";
		$current_plant = "";
		
		$row .= $this->getColumns($match);
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