<?php 

class Pictures()
{
	function uploadPicture($car_num, $picture, $number)
	{
		$letter = $this->numberCheck($number);						
		$picture_new = "images/" . $car_num . $letter;
		if(!file_exists($picture_new))
		{
			move_uploaded_file($_FILES[$picture]['tmp_name'], $picture_new);
		}
	}
		
	function numberCheck($number)
	{
		if($number > 26)
		{
			$num1 = floor($number/26);
			$num2 = $number % 26;
			$letter2 = $this->numberToLetter($num2);
			$letter1 = $this->numberCheck($num1);
			$letter = $letter1 . $letter2;
			return $letter;
		}
	
		else
		{
			$letter = $this->numberToLetter($number);
			return $letter;
		}
	}
				
	function numberToLetter($num)
	{
		switch($num)
		{
			case('0'):	return 'z';
			case('1'):	return 'a';
			case('2'):	return 'b';
			case('3'):	return 'c';
			case('4'):	return 'd';
			case('5'):	return 'e';
			case('6'):	return 'f'; 
			case('7'):	return 'g';
			case('8'):	return 'h';
			case('9'):	return 'i';
			case('10'):	return 'j';
			case('11'):	return 'k';
			case('12'):	return 'l'; 
			case('13'):	return 'm';
			case('14'):	return 'n';
			case('15'):	return 'o';
			case('16'):	return 'p';
			case('17'):	return 'q';
			case('18'):	return 'r'; 
			case('19'):	return 's';
			case('20'):	return 't';
			case('21'):	return 'u';
			case('22'):	return 'v';
			case('23'):	return 'w';
			case('24'):	return 'x'; 				
			case('25'):	return 'y';
			case('26'):	return 'z';
		}
	}
}
?>