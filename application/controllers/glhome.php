<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glhome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('layouts');
		$this->load->model('menu');
	}
	
	public function index()
	{
		$this->lang->load("gl",$this->session->userdata('language'));
		$this->layouts->add_includes('js/charts/excanvas.min.js')
			->add_includes('js/charts/jquery.flot.resize.js')
			->add_includes('js/jvectormap/jquery-jvectormap-1.2.2.min.js')
			;
		$this->layouts->view('gl/home', array('latest' => 'sidebar/latest'));
		}
//			->add_includes('js/charts/jquery.flot.pie.js')
//			->add_includes('js/charts/jquery.flot.js')
//			->add_includes('js/charts/jquery.flot.stack.js')
}

?>
