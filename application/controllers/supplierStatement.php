<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SupplierStatement extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
		
		//loading number to word language pack
		$this->lang->load("num_to_word",$this->session->userdata('language'));
		$this->load->helper('num_to_word');
	}

	public function index()
	{   		
		echo 'default index supplier statement controller';		
	}
	
	public function calendar()
    {
	}
	public function get_bySupplierID() 
	{
		$ID = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->load->helper('form');
	  	$data['title'] = 'Supplier Statement';
		$this->lang->load("supplierstatement",$this->session->userdata('language'));
		$this->load->model('accountpayable/accountPayable_model');
		$companyID=element('compID', $this->session->userdata('logged_in'));
		$data['supplierInvoice']=$this->accountPayable_model->get_bySupplierID($ID,$companyID);
		
		
		$this->load->model('supplier/supplier_model');
		$dtl =$this->supplier_model->suppliermaster_id($ID);
		//echo $this->db->last_query();
		$dtl2 =$this->supplier_model->supplierAging_byID($ID);
		//echo $this->db->last_query();
		$dtl3 =$this->supplier_model->supplierStatement_byID($ID);
		$data['supplierDetails']=$dtl[0];
		//echo $this->db->last_query();
		$data['supplierAging']=$dtl;
		//echo var_dump($dtl3);
		$data['supplierStatement']=$dtl3;
		
		$this->load->model('company/company_info_model');
		$dtlCompany =$this->company_info_model->company_id($companyID);
		$data['companyInfo']=$dtlCompany[0];
		
		//Fetching dictionary for number to word conversiont.
		$data['dictionary'] = $this->lang->line("dictionary");
		
		//echo var_dump($dtl3);
		$this->layouts->add_includes('js/charts.js')
			->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
	      
	$this->layouts->view('supplierstatement/supplierStatement', array('latest' => 'sidebar/latest'), $data);
	}

	public function suppstatelist()
	{
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->load->model('supplierstatement/supplierstatement_model');
		$data['datatbls'] = $this->supplierstatement_model->supplierstatement_all();
		$this->load->model('accountpayable/accountPayable_model');
		$this->load->model('company/company_info_model');
		$this->load->model('supplier/supplier_model');
		$this->lang->load("supplierstatement",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('supplierstatement/suppstatList', array('latest' => 'sidebar/latest'), $data);
	
	}
}

   
    