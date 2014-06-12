<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SalesPricing extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
		$this->load->library('layouts');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->layouts->set_title('iAccount::Sales Pricing');
		
		$this->load->model('master/masterCode_model');
		$this->load->model('Menu');
		$this->load->model('Sales_pricing');		
		$this->lang->load("salespricing",$this->session->userdata('language'));	
	}
	
	public function index(){
		//Retrive from predata
		$data = $this->Sales_pricing->getFormData();
				
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('salespricing/allsalesprice', array('latest' => 'sidebar/latest'),$data);
	}
	
	//Add price to database
	public function add(){
		if($this->input->post('currencyID') && $this->input->post('itemPrice')){
			//Insert Location Transfer informations
			$itemPrice = array(
				'salesPrice'				=> $this->input->post('itemPrice'),
				'currencyID'		=> $this->input->post('currencyID'),
				'updatedTS'	   		=> date('Y-m-d G:i:s',time()),
			
			);
			
		  	$itemPriceID = $this->Sales_pricing->update($this->input->post('itemID'),$itemPrice);	
			
			if($itemPriceID){		
				$this->session->set_flashdata('msg', 'Successfully Updated');
				echo 'Success';
			}else{
				
				$this->session->set_flashdata('msg', 'Unsuccessfull');
				echo 'unsuccessfull';
			}
		}
		
		exit();	
	}
	
	//Get individual item price
	public function get(){
		$data = $this->Sales_pricing->getPrice($this->input->post('ID'));
		
		echo json_encode((array)$data[0]);
		exit();
	}
	
	//Delete item price
	public function delete(){
		$data = explode(',',$this->input->post('data'));
		$error = false;
		foreach($data as &$v){
			$v = $this->Sales_pricing->delete($v);
		}
		echo "Successfully Deleted";	
		exit();
	}
}