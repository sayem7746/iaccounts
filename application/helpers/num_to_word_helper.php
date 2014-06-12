<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 /*****************************************************************************
 
 ******add this to controller(constractor)********
 	$this->lang->load("num_to_word",$this->session->userdata('language'));
	$this->load->helper('num_to_word');
 *
 *
 	Fetching dictionary for number to word conversiont. inside function
	$data['dictionary'] = $this->lang->line("dictionary");
 *
 *
 	Call num_to_word(number,$dictionary) in the view pages
 *****************************************************************************/
 
//Convert number to words
if ( ! function_exists('num_to_word')){
	
	function num_to_word($number,$dictionary) {		
		
		$hyphen      = $dictionary['seperator']['hyphen'];
		$conjunction = $dictionary['seperator']['and'];
		$separator   = $dictionary['seperator']['separator'];
		$negative    = $dictionary['seperator']['negative'];
		$decimal     = $dictionary['seperator']['decimal'];
		
		if (!is_numeric($number)) {
			return false;
		}
		
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . num_to_word(abs($number),$dictionary);
		}
		
		$string = $fraction = null;
		
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
		
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . num_to_word($remainder,$dictionary);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = num_to_word($numBaseUnits,$dictionary) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= num_to_word($remainder,$dictionary);
				}
				break;
		}
		
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
		
		return $string;
	}
}