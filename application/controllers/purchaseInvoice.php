<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseInvoice extends CI_Controller {
	
	public $data = array();
	

	public function __construct(){
		parent::__construct();
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('iAccount');

		$this->load->model('menu');
	}

	
	
	
	
	public function index() {
		//echo '<h1>Purchase Invoice default page<h1><br>';
		//echo '<div><a href="purchaseInvoice/piList"><h3>List</h3></a></div>'; //call controller
		

			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
//			$filter['formID']=41;
//			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 
			$this->lang->load("invoices",$this->session->userdata('language'));
			$this->load->model('companyChartAcct');
		
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();

			
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			
			$this->load->model('Supplier/supplier_model');
			$data['supplier'] = $this->supplier_model->suppliermaster_all();
			
			$this->load->model('Project/project_model');
			$data['project'] = $this->project_model->project_all();
			
			$this->load->model('address_model');
			$data['shipto'] = $this->address_model->getCompanyAdresses();
			
			$this->load->model('Terms/terms_model');
			$data['terms'] = $this->terms_model->terms_all();
			
			$this->load->model('location');
			$data['location'] = $this->location->location_all();
			
			$this->load->model('companyChartAcct');
			$data['chargeAccount'] = $this->companyChartAcct->chartAcct_all();
			
			
			$this->load->model('taxmaster');
			$data['taxmaster'] = $this->taxmaster->taxmaster_all();
			
			$data['itemCodes'] = $this->getItemCodes();
			
//			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=41;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 

			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$this->layouts->view('accountPayable/ap_purchaseinvoice', '', $data);
		//$this->load->view('accountPayable/ap_purchaseinvoice');
			
			
			
	}
	
	
	
	
	public function piList() {
		echo '<h1>Purchase and Direct Purchase Invoice List</h1>';
	}
	
		function deleteCompanyDetail(){
			$this->load->model('accountPayable/accountPayable_model');
			echo $this->accountPayable_model->deleteCompanyDetail($this->input->post('detailsId'));
		}
		
		
			
		function edit ($id) {
			
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=41;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 
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
			
			$this->load->model('companyChartAcct');
			$data['chargeAccount'] = $this->companyChartAcct->chartAcct_all();
			
			$this->load->model('taxmaster');
			$data['taxmaster'] = $this->taxmaster->taxmaster_all();
			
			$this->load->model('accountPayable/accountPayable_model');
			$data['pdetails']=$this->accountPayable_model->get_Detail_byID($id);
			$data['pInvoice']=$this->accountPayable_model->get_byID("comp_supplier_invoice",$id);

			$data['charge']=$this->accountPayable_model->getChargeByid($id);
			
			$this->layouts->view('accountPayable/ap_edit', '', $data);
	}
	
	
	
	

	
	


	
} //big end
?>