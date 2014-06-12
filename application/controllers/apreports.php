<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apreports extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('3', 'reports');
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
	
// Account Debit Note List
	public function debitnoteList(){
		$this->lang->load("debitNote",$this->session->userdata('language'));
		$this->load->model('debitnote_model');
		$this->load->model('company/FormSetup_model');
		$dateFrom = date("Y-m-d",strtotime($this->uri->segment(3)));
		$dateTo = date("Y-m-d",strtotime($this->uri->segment(4)));
		if ($this->uri->segment(3) == ""){
			$dateFrom = date("Y-m-01");
		}
		if($this->uri->segment(4) == ""){
			$dateTo = date("Y-m-t");
		}
		if($dateFrom > $dateTo){
			$dateTo = date("Y-m-t", strtotime($dateFrom));
		}
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->debitnote_model->debitnote_Date($dateFrom, $dateTo);
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('ap/reports/debitnoteList', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function debitnote(){    
		//$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
		$ID = $this->uri->segment(3);
		$this->lang->load("debitNote",$this->session->userdata('language'));
		$this->load->model('debitnote_model');
		$this->load->model('company/FormSetup_model');
		//$dataum = $this->Company_info_model->company_id($id);
		$dataum = $this->debitnote_model->debitnote_id($ID);
		$data['umaster'] = $dataum[0];
		//if($id >= '0')
		//{
			$this->load->view('ap/reports/debitnote', array('latest' => 'sidebar/latest'), $data);
		//}
		//else
		//{
			//$this->layouts->view('masterfile/company', array('latest' => 'sidebar/latest'), $data);
		//}
	}
	
// Account Credit Note List
        public function creditnoteList(){
		$this->lang->load("creditNote",$this->session->userdata('language'));
		$this->load->model('creditnote_model');
		$this->load->model('company/FormSetup_model');
		$dateFrom = date("Y-m-d",strtotime($this->uri->segment(3)));
		$dateTo = date("Y-m-d",strtotime($this->uri->segment(4)));
		if ($this->uri->segment(3) == ""){
			$dateFrom = date("Y-m-01");
		}
		if($this->uri->segment(4) == ""){
			$dateTo = date("Y-m-t");
		}
		if($dateFrom > $dateTo){
			$dateTo = date("Y-m-t", strtotime($dateFrom));
		}
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->creditnote_model->creditnote_Date($dateFrom, $dateTo);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('creditnote/creditnoteList', array('latest' => 'sidebar/latest'), $data);
	}
	
	// Account Supplier Payment List
		public function supplierpaymentlist(){
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("supplierPaymentList",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('supplier/SupplierPayment_model');
		
		$dateFrom = date("Y-m-d",strtotime($this->uri->segment(3)));
		$dateTo = date("Y-m-d",strtotime($this->uri->segment(4)));
		
		$data['mode'] = $mode;
		
		if ($this->uri->segment(4) == ""){
			$dateFrom = date("Y-m-01");
		}
		if($this->uri->segment(5) == ""){
			$dateTo = date("Y-m-t");
		}
		if($dateFrom > $dateTo){
			$dateTo = date("Y-m-t", strtotime($dateFrom));
		}
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->SupplierPayment_model->supplierPaymentDate($dateFrom, $dateTo);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('supplierpayment/supplierPaymentList', array('latest' => 'sidebar/latest'), $data);
	}
}

	
/* End of file gltransaction.php */
/* Location: ./application/controller/gltransaction.php */
/* Farhana : add creditnotelist and supplierpaymentlist */
