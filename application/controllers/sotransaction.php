<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sotransaction extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('5', 'transaction');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->library('layouts');
		$this->load->model('menu');
	}

	public function index()
	{
		
	}
	
	public function soList(){
		$this->lang->load("salesorder",$this->session->userdata('language'));
		$this->load->model('SalesOrder');
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		$this->load->model('Compfinancialyear');
		$query = $this->Compfinancialyear->financialYear_year($add_year);
		if($query){
			$data['period'] = $query;
		}else{
			$data['period'] = NULL;
		}
		$data['yrs'] = range(date('Y'), 1900);
		$data['selyear'] = $add_year;
		$data['selper'] = $add_period;
		$data['datatbls'] = $this->SalesOrder->SalesOrder_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('so/transactions/soList', array('latest' => 'sidebar/latest'), $data);
	}
	public function salesOrder(){
		$ID = $this->uri->segment(3);
		$this->lang->load("salesorder",$this->session->userdata('language'));
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js')
				->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->load->model('Sysum');
		$this->load->model('Currency');
		$this->load->model('customer/customer_model');
		$this->load->model('employee/employee_model');
		$data['employees'] = $this->employee_model->employeemaster_all();
		$data['um'] = $this->Sysum->sysum_all();
		$data['currency'] = $this->Currency->currency_all();
		$data['customers'] = $this->customer_model->customermaster_all();
		if($ID != ''){
			$this->layouts->view('so/transactions/salesOrderEdit', array('latest' => 'sidebar/latest'), $data);
		}else{
			$this->layouts->view('so/transactions/salesOrder', array('latest' => 'sidebar/latest'), $data);
		}
	}
	public function shipto(){
		$this->load->model('customer/customer_model');
		$this->load->model('customer/address_model');
		$query = $this->address_model->address_customer_all($this->input->post('customerID'));
		$query1 = $this->customer_model->customermaster_id($this->input->post('customerID'));
		if($query1[0]->currencyID == element('compCurrency', $this->session->userdata('logged_in'))){
			$exchangeRate = 1;
		}else{
			$this->load->model('currency');
			$querycurrency = $this->currency->currencyConv_id($query1[0]->currencyID);
			if($querycurrency){
				$exchangeRate = $querycurrency[0]->rateConv;
			}else{
				$exchangeRate = 1;
			}
		}
		if($query){
			print json_encode(array(
				"status"=>"success", 
				"message"=>$query, 
				"message1"=>$query1[0], 
				'exchangeRate'=>$exchangeRate 
				));
		}else{
			print json_encode(array("status"=>"false", "message"=>'',"message1"=>$query1[0], 'exchangeRate'=>$exchangeRate));
		}
	}
	public function itemSearch(){
		$this->load->model('item/ItemSetup_model');
		$query = $this->ItemSetup_model->get_all();
		if($query){
   			print json_encode(array("status"=>"success", "message"=>$query));
		}else{
   			print json_encode(array("status"=>"failed", "message"=>'Journal details saved..'));
		}
	}
	public function itemSearch2(){
		$this->load->model('item/ItemSetup_model');
		$query = $this->ItemSetup_model->get_byID($this->input->post('ID'));
		if($query){
   			print json_encode(array("status"=>"success", "message"=>$query[0]));
		}else{
   			print json_encode(array("status"=>"failed", "message"=>'Journal details saved..'));
		}
	}
	public function umSearch(){
		$this->load->model('Sysum');
		$query = $this->Sysum->sysum_all();
		if($query){
   			print json_encode(array("status"=>"success", "message"=>$query));
		}else{
   			print json_encode(array("status"=>"failed", "message"=>'Journal details saved..'));
		}
	}
	public function employeeSearch(){
		$this->load->model('employee/employee_model');
		$query = $this->employee_model->employeemaster_all();
		if($query){
   			print json_encode(array("status"=>"success", "message"=>$query));
		}else{
   			print json_encode(array("status"=>"failed", "message"=>'Journal details saved..'));
		}
	}
	public function sodetails_delete(){
		$this->lang->load("salesorder",$this->session->userdata('language'));
		$this->load->model('SalesOrder');
		$query = $this->SalesOrder->SalesOrderDetails_Delete($this->input->post('ID'));
		if($query){
   			print json_encode(array("status"=>"success", "message"=>$this->lang->line('message6')));
		}else{
   			print json_encode(array("status"=>"failed", "message"=>$this->lang->line('message8')));
		}
	}
	public function sodetails_save(){
		$this->lang->load("salesorder",$this->session->userdata('language'));
		$this->load->model('SalesOrder');
		$this->load->model('Sysum');
		$this->load->model('item/ItemSetup_model');
		if($this->input->post('ID') == '' ){
			$salesID = $this->SalesOrder->SalesOrder_Insert();
			
			if($salesID){
//				$query = $this->SalesOrder->seqNumber();
				$dataUpdate =  array(
					'OrderNo' => 'salesID'
				);
//				$query = $this->SalesOrder->SalesOrder_Update($salesID);
				$query = $this->SalesOrder->SalesOrderDetails_Insert($salesID);
				$queryum = $this->Sysum->sysum_id($this->input->post('unitmeasure'));
				$queryitems = $this->ItemSetup_model->get_byID($this->input->post('itemID'));
   				print json_encode(array("status"=>"success", "message"=>$this->lang->line('message2'), "salesID"=>$salesID, "message1"=>$query, "um"=>$queryum[0]->code, "items"=>$queryitems[0]->itemCode));
			}else{
   				print json_encode(array("status"=>"failed", "message"=>'Journal details saved..'));
			}
		}else{
			$query = $this->SalesOrder->SalesOrderDetails_Insert($this->input->post('ID'));
			$queryum = $this->Sysum->sysum_id($this->input->post('unitmeasure'));
			$queryitems = $this->ItemSetup_model->get_byID($this->input->post('itemID'));
   			print json_encode(array(
				"status"=>"success", 
				"message"=>$this->lang->line('message2'), 
				"salesID"=>$this->input->post('itemID'), 
				"message1"=>$query, 
				"um"=>$queryum[0]->code, 
				"items"=>$queryitems[0]->itemCode));
		}
	}
	
// Sales Quotation

	public function SalesQuotation(){
		$ID = $this->uri->segment(3);
		$this->lang->load("salesquote",$this->session->userdata('language'));
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js')
				->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->load->model('Sysum');
		$this->load->model('Currency');
		$this->load->model('customer/customer_model');
		$this->load->model('employee/employee_model');
		$data['employees'] = $this->employee_model->employeemaster_all();
		$data['um'] = $this->Sysum->sysum_all();
		$data['currency'] = $this->Currency->currency_all();
		$data['customers'] = $this->customer_model->customermaster_all();
		if($ID != ''){
			$this->layouts->view('so/transactions/salesQuoteEdit', array('latest' => 'sidebar/latest'), $data);
		}else{
			$this->layouts->view('so/transactions/salesQuote', array('latest' => 'sidebar/latest'), $data);
		}
	}
	public function SalesQuotationList(){
		$this->lang->load("salesquote",$this->session->userdata('language'));
		$this->load->model('SalesQuote');
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		$this->load->model('Compfinancialyear');
		$query = $this->Compfinancialyear->financialYear_year($add_year);
		if($query){
			$data['period'] = $query;
		}else{
			$data['period'] = NULL;
		}
		$data['yrs'] = range(date('Y'), 1900);
		$data['selyear'] = $add_year;
		$data['selper'] = $add_period;
		$data['datatbls'] = $this->SalesQuote->SalesQuote_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('so/transactions/soquoteList', array('latest' => 'sidebar/latest'), $data);
	}
}

	
/* End of file artransaction.php */
/* Location: ./application/controller/artransaction.php */
