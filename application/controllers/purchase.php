<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}
		
//-- Purchase Order	
	public function new_po(){
		  $id = $this->uri->segment(3);
		  $this->load->library('layouts');
		  $this->load->helper('form');
		  $this->layouts->set_title('Change Management');
		  $data['our_company'] = 'this is my company';
		  $data['module'] = 'Purchasing';
		  $data['title'] = 'New Purchase Order';
 		  $this->load->model('Supplier');
		  $data['supplier'] = $this->Supplier->supplier_all();
 		  $this->load->model('Location');
		  $data['location'] = $this->Location->location_all();
 		  $this->load->model('Usermaster');
		  $data['usermaster'] = $this->Usermaster->usermaster_all();
		  $this->layouts->add_includes('js/charts.js')
			->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/maskedinput/jquery.maskedinput.min.js')
			->add_includes('js/uniform/jquery.uniform.min.js');
			
		  if($id != NULL ){
		  }else{
			  $this->layouts->view('purchase/new_po', array('latest' => 'sidebar/latest'), $data);
		  }
	}

}