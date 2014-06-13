<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InventoryReport extends CI_Controller{
	
	
	public function __construct(){
		parent::__construct();
		
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		
		//loading number to word language pack
		$this->lang->load("num_to_word",$this->session->userdata('language'));
		$this->load->helper('num_to_word');
		
		$this->layouts->set_title('iAccount::Inventory Report');
		
		$this->load->model('master/masterCode_model');
		$this->load->model('Menu');
		$this->load->model('Inventory_report');		
		$this->load->library('layouts');
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			 		  ->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->lang->load("inventoryreport",$this->session->userdata('language'));	
	}
	
	public function planning(){
		//Retrive from predata
		$data = $this->Inventory_report->getPlanningData();
		
		//Fetching dictionary for number to word conversiont.
		$data['dictionary'] = $this->lang->line("dictionary");
		
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('item/count-adjust', array('latest' => 'sidebar/latest'),$data);
	}
	
	
	
}