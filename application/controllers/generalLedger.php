<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GeneralLedger extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('9', 'transaction');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->library('layouts');
		$this->load->model('menu');
	}

	public function home()
	{
		$this->lang->load("gl",$this->session->userdata('language'));
		$this->load->library('menus');
		$this->layouts->add_includes('js/charts/excanvas.min.js')
			->add_includes('js/charts/jquery.flot.js')
			->add_includes('js/charts/jquery.flot.stack.js')
			->add_includes('js/charts/jquery.flot.pie.js')
			->add_includes('js/charts/jquery.flot.resize.js');
//		var_dump($query);
//		$data['expenses'] = $query;
		$this->layouts->view('gl/home', array('latest' => 'sidebar/latest'));
	}
	public function expensesPie(){
		$currentYear =  date("Y");
		$this->load->model('Glchart_model');
		$query = $this->Glchart_model->expenses($currentYear);
    	print json_encode(array("status"=>"success", "message"=>$query));
	}
	public function assetsPie(){
		$currentYear =  date("Y");
		$this->load->model('Glchart_model');
		$query = $this->Glchart_model->assets($currentYear);
    	print json_encode(array("status"=>"success", "message"=>$query));
	}
	public function actualbudgetExpenses(){
		$currentYear =  date("Y");
		$this->load->model('Glchart_model');
		$query = $this->Glchart_model->budget($currentYear);
    	print json_encode(array("status"=>"success", "message"=>$query));
	}
	public function accountbalance(){
		$currentYear =  date("Y");
		$this->load->model('Glchart_model');
		$query = $this->Glchart_model->accountbalance_type($currentYear);
    	print json_encode(array("status"=>"success", "message"=>$query));
	}
}

	
/* End of file generalLedger.php */
/* Location: ./application/controller/generalLedger.php */
