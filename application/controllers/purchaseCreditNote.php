<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseCreditNote extends CI_Controller {
	
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
		echo '<h1>Purchase Debit Note default page<h1><br>';
		echo '<div><a href="pdnList"><h3>List</h3></a></div>'; //call controller
	}
	
	/*private function getItemCodes(){
		$JsonRecords = '[';
		$i= 0;
		$this->load->model('item/itemSetup_model');
		//$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
		$default = $this->itemSetup_model->get_all();
		$n = sizeof($default);
		 foreach($default as $row){
			$JsonRecords .= '&quot;'.$row->itemCode.'&quot;';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		 $JsonRecords .= ']';
		 return $JsonRecords;
	}*/
	
	
	
	public function pdnList() {
		echo '<h1>Purchase Debit Note List</h1>';
	}
	
	
	
	public function editCreditNote ($id){
		$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			
			$this->lang->load("invoices",$this->session->userdata('language'));
			$this->load->model('companyChartAcct');
		
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			$this->load->library('layouts');
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			
			$this->lang->load("ap_edit",$this->session->userdata('language'));
			
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$data['itemCodes'] = $this->getItemCodes();
			
			$this->load->model('taxmaster');
			$data['taxmaster'] = $this->taxmaster->taxmaster_all();
			
			$this->load->model('accountPayable/accountPayable_model');
			$data['pInvoice']=$this->accountPayable_model->get_byID("comp_supplier_creditnote_detail",$id);
			$data['pdetails']=$this->accountPayable_model->getCrditNotDetailById($id);
			
			

			
			$this->layouts->view('accountPayable/ap_creditNoteEdit', '', $data);
	
	}
	function deleteCompanyDetail(){
			$this->load->model('accountPayable/accountPayable_model');
			echo $this->accountPayable_model->deleteCompanyDetail($this->input->post('detailsId'));
		}
		
	
	
	
	public function updateRowDetail(){
		$this->load->model('item/itemSetup_model');
		$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
		$itemId ="0";
		if($default){
		  foreach($default as $row)
		   $itemId =$row->ID;
		}
		$this->load->model('accountPayable/accountPayable_model');
		$data = array (
				'itemname' => $this->input->post('itemname'), 
				'itemID' => $itemId,
				'updatedBy' => element('userid', $this->session->userdata('logged_in')),
				'itemdescription' => $this->input->post('itemdescription'),
				'quantity' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxRate' => $this->input->post('taxRate'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax')
			);
	    echo $this->accountPayable_model->update_CreditNoteDetail($this->input->post('invDetailsId'), $data);
		
	}
	public function deleteCompanyDetails (){
		$this->load->model('accountPayable/accountPayable_model');
		$this->accountPayable_model->delete($this->input->post('invDetailsId'), 'comp_supplier_invoice_detail');
		echo "ok";
	}
	
	function checkformNumber(){
		$this->load->model('accountPayable/accountPayable_model');
		echo $this->accountPayable_model->checkformNumber_model("comp_supplier_creditnote", $this->input->post('code'));
		
	}
	
}//big end
?>