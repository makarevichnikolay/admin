<?php

class Math {

	public static $romans = array(
   		1 => "I",
   		2 => "II",
   		3 => "III",
   		4 => "IV",
  		5 => "V",
  		6 => "VI",
   		7 => "VII",
   		8 => "VIII",
   		9 => "IX",
   		10 => "X",
   		11 => "XI",
   		12 => "XII",
   	);
     	
   	public static $ordinals = array(
   		'первый'	=> 1,
   		'второй'	=> 2,
   		'третий'	=> 3,
   		'четвертый'	=> 4,
   		'четвёртый'	=> 4,
   		'пятый'		=> 5,
   		'шестой'	=> 6,
   		'седьмой'	=> 7,
   		'восьмой'	=> 8,
  		'девятый'	=> 9,
   		'десятый'	=> 10,
   		'одиннадцатый'	=> 11,
   	);
     
   	static function decToRoman($number) {
   		return self::$romans[$number];
   	}
    	
   	static function romanToDec($number) {
   		return array_search($number, self::$romans);
   	}
     	
   	static function ordinalToDec($number) {
		$number = mb_strtolower($number, 'utf-8');
		return self::$ordinals[$number];
   	}
}

?>
