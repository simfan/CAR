<?php
	class Login
	{
		var $host = "192.168.10.129";
		var $db_user = "postgres";
		var $pass = "pass";
		var $db = "inven";
		
		var $username;
		var $password;
		var $user = array();
		
		
		function setUserName($username)
		{
			$this->username = $username;
		}
		
		function getUserName()
		{
			return $this->username;
		}
		
		function setPassword($password)
		{
			$this->password = $password;
		}
		
		function getPassword()
		{
			return $this->password;
		}
		
		function setUser()
		{
			$conn = pg_connect("host=$this->host dbname=$this->db user=$this->db_user password=$this->pass");
			$query = "SELECT * FROM car_login WHERE car_username = '" . $this->getUserName() . "'";
			$result = pg_query($conn, $query) or die("Error in query: $query " . pg_last_error($conn));
			$this->user = pg_fetch_array($result);
			pg_close($conn);
		}
			
		function getUserField($field)
		{
			return $this->user[$field];
		}
		

		
		function validateLogin($plant)
		{
			if($this->getPassword() == $this->getUserField('car_password'))
			{
				if($this->getUserField('plant1') == 'A')
				{
					return true;
				}
				else
				{
					for($i = 0; $i < 4; $i++)
					{
						$j = ++$i;
						$plant_name = "plant" . $j;
						if($this->getUserField($plant_name) == $plant)
						{
							return true;
						}
					}
					return false;
				}
			}
			else
			{
				return false;
			}
		}
	}
?>