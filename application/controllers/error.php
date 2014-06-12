<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	function index(){
		$this->load->library('layouts');
		$this->layouts->set_title('Change Management');
		$data['our_company'] = 'this is my company';
		$default = false;
		$data['prevurls'] = base_url() . $this->session->userdata('first_uri');
		$this->load->helper(array('form'));
		$this->layouts->view('error403', array(), $data , false);
	}

}
/* End of file error.php */
/* Location: ./application/controller/error.php */
