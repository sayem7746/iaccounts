<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}
	
	public function index()
	{
			$this->load->library('layouts');
			$this->load->library('menus');
			$this->layouts->set_title('i-Accounts');

			$data['our_company'] = 'this is my company';
		   	$data['module'] = 'Enterprise Advanced System';
		  	$data['title'] = 'Dashboard';
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
//			print_r($this->session->all_userdata());
//		$this->load->model('Usermaster');
//		$result = $this->Usermaster->getLogin($userid, $password);
			$this->layouts->add_includes('js/charts.js')
				->add_includes('js/charts/jquery.flot.js');
			$this->layouts->view('home', array('latest' => 'sidebar/latest'), $data);
		}
}

?>