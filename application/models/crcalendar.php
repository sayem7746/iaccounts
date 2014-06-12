<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crcalendar extends CI_Model{
	
	public function crcalendar_all($year, $month){
		$conf = array(
			"start_day" => 'monday',
			'show_nex_prev' => true,
			);
		$this->load->library('calendar', $conf);
		return $this->calendar->generate($year, $month);
	}

}