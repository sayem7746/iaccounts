<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ItemCountAdjust extends CI_Controller{
	
	
	public function __construct(){
		parent::__construct();
		
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		//loading number to word language pack
		$this->lang->load("num_to_word",$this->session->userdata('language'));
		$this->load->helper('num_to_word');
		
		$this->layouts->set_title('iAccount::Item Count and Adjust Pricing');
		
		$this->load->model('master/masterCode_model');
		$this->load->model('Menu');
		$this->load->model('Item_count_adjust');		
		$this->load->library('layouts');
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			 		  ->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->lang->load("itemcountadjust",$this->session->userdata('language'));	
	}
	
	public function index(){
		//Retrive from predata
		$data = $this->Item_count_adjust->getData();
		
		//Fetching dictionary for number to word conversiont.
		$data['dictionary'] = $this->lang->line("dictionary");
		
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('item/count-adjust', array('latest' => 'sidebar/latest'),$data);
	}
	
	//Item adjust
	public function adjust(){
		$flag = true;
		$data = json_decode($this->input->post("data"));
		
		foreach($data as $row){
			
			//Update balance Item in comp_receive_item_detail table
			$updtBlnc = $this->Item_count_adjust->updateBlnc($row[0],$row[1]);
			
			//Update Item table quantity by the newly counted amount
			$newData = array(
				'quantity'	=> $row[1], 
			);
			$isUpdate = $this->Item_count_adjust->updateQty($row[0],$newData);
			
			if(!$isUpdate && $flag)
				$flag = false;
		}
		
		if($flag){
			$this->session->set_flashdata('msg', 'Successfully Updated');
			echo 'Success';	
		}else{
			$this->session->set_flashdata('danger-msg', 'Unsuccessfull');
			echo 'unsuccessfull';	
		}
		exit();
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
				'updatedBy'			=> element('role', $this->session->userdata('logged_in')),
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