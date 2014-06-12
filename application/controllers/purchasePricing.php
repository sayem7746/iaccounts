<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchasePricing extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->layouts->set_title('iAccount::Purchase Pricing');
		
		$this->load->model('master/masterCode_model');
		$this->load->model('Menu');
		$this->load->model('Purchase_pricing');		
		$this->lang->load("purchasepricing",$this->session->userdata('language'));	
	}
	
	public function index(){
		//Retrive from predata
		$data = $this->Purchase_pricing->getFormData();
				
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('purchase/pricing/allpurchaseprice', array('latest' => 'sidebar/latest'),$data);
	}
	
	//Add price to database
	public function add(){
		if($this->input->post('supplierID') && $this->input->post('itemID')){
			//Insert Location Transfer informations
			$itemPrice = array( 
				'companyID'  		=> element('compID', $this->session->userdata('logged_in')),
				'itemID'  			=> $this->input->post('itemID'),
				'price'				=> $this->input->post('itemPrice'),
				'supplierID'		=> $this->input->post('supplierID'),
				'updatedBy'			=> element('userid', $this->session->userdata('logged_in')),
				'updatedTS'	   		=> date('Y-m-d G:i:s',time())
			);			
		  	$status = $this->Purchase_pricing->insert($itemPrice);	
			if($status){
				$this->session->set_flashdata('msg', $status.'purchase price Successfully');
				echo 'Updated';
			}else{
				$this->session->set_flashdata('msg', 'Unsuccessful');
				echo 'unsuccessfull';
			}
		}
		
		exit();	
	}
	
	//Get individual item price
	public function get(){
		$data = $this->Purchase_pricing->getPrice($this->input->post('ID'));
		
		echo json_encode((array)$data[0]);
		exit();
	}
	
	//Delete item price
	public function delete(){
		$data = explode(',',$this->input->post('data'));
		$error = false;
		foreach($data as &$v){
			$v = $this->Purchase_pricing->delete($v);
		}
		$this->session->set_flashdata('danger-msg', 'Purchase Price removed successfully');
		echo "Successfully Deleted";	
		exit();
	}
}