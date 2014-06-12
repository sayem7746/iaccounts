<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ItemSetup extends CI_Controller {
	
	public $data = array();
	

	public function __construct(){
		parent::__construct();
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('iAccount');

		$this->load->model('menu');
	}

	public function __reset() {
		$data = array ('ID'=>0,'itemName'=>'');
	}
	
	public function index() {
	}

	
	
	public function itemView() {
	}
	
	//is used PO TRANS, DEBIT NOTE, CREDIT NOTE
	public function getItemDetails(){
		$JsonRecords = '{';
		$i= 0;
		$this->load->model('item/itemSetup_model');
		$default = $this->itemSetup_model->get_byCode($this->input->post('code'));
		//$default = $this->itemSetup_model->get_all();
		$n = sizeof($default);
		//print json_encode(array("status"=>"success", "message"=>$query));
		if($default){
		 foreach($default as $row){
			 
			 $tax="0";
			 $taxcode = "...";
			 $this->load->model('taxmaster');
		     $taxObj = $this->taxmaster->taxmaster_id($row->inputTaxID);
			 if($taxObj){
			  foreach($taxObj as $taxrow){
				   $tax=$taxrow->taxPercentage;
				   $taxcode = $taxrow->code;
			  }}
			$JsonRecords .= '"taxcode":"'.$taxcode.'","name":"'.$row->name.'","description":"' .$row->description.'", "tax":"'.$tax.'", "taxID":"' .$row->inputTaxID.'"';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		 $JsonRecords .= '}';
		 echo $JsonRecords;
		}else {
			echo "item Not found";
			}
	}
	


public function ad(){
	
	}
}

/* End of file itemSetup.php */
/* Location: ./application/controller/ */
