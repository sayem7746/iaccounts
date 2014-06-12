<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ApTransactionReport extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('3', 'transaction');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->library('layouts');
		$this->load->model('menu');
	}
	

	public function printPaymentAdviceRpt(){
			
			
			$id = $this->uri->segment(3); 
			$data['id'] = $id;
			$this->load->model('company/company_info_model');
			$data['company'] = $this->company_info_model->companyById(element('compID', $this->session->userdata('logged_in')));
			$this->load->model('purchase/purchase_model');
			$data['rptData'] = $this->purchase_model->rptGetPaymentAdvice($id);
			$data['rptDataDetail'] = $this->purchase_model->rptGetPaymentAdviceDetail($id);
			
			$this->lang->load("aptransactionreport",$this->session->userdata('language'));
	
			$this->load->view('ap/reports/paymentAdviceRpt', $data);
			
	}
	public function printPaymentAdviceRptExel(){
	 //place where the excel file is created
        $this->load->library('parser');
 		
		$id = $this->uri->segment(3); 
			$data['id'] = $id;
		$this->load->model('company/company_info_model');
		$data['company'] = $this->company_info_model->companyById(element('compID', $this->session->userdata('logged_in')));
		$this->load->model('purchase/purchase_model');
		$data['rptData'] = $this->purchase_model->rptGetPaymentAdvice($id);
		$data['rptDataDetail'] = $this->purchase_model->rptGetPaymentAdviceDetail($id);
		
		$this->lang->load("aptransactionreport",$this->session->userdata('language'));
       
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('ap/reports/paymentAdviceExcel', $data, true);
 
        //open excel and write string into excel
		
		 $myFile = "paymentAdviceExcel.xls";
         $fh = fopen($myFile, 'w') or die("can't open file");
         fwrite($fh, $stringData);
		 fclose($fh);
 		$this->downloadExcel("paymentAdviceExcel.xls");
       
        //download excel file
        
		
	}
	
		
/* download created excel file */
    function downloadExcel($myFile) {
        header("Content-Length: " . filesize($myFile));
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$myFile);
		readfile($myFile);
}
	// edit of debit note
	
	public function printPaymentAdvice ($id){
			$this->load->model('company/formSetup_Model');
			
			$this->lang->load("invoices",$this->session->userdata('language'));
	
			$this->load->library('layouts');
			
			$this->lang->load("aptransactionreport",$this->session->userdata('language'));
			
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$this->load->model('company/company_info_model');
			$data['company'] = $this->company_info_model->companyById(element('compID', $this->session->userdata('logged_in')));
			
			$data['id'] = $id;
			$this->load->model('purchase/purchase_model');
			$data['rptData'] = $this->purchase_model->rptGetPaymentAdvice($id);
			$data['rptDataDetail'] = $this->purchase_model->rptGetPaymentAdviceDetail($id);
		
			$this->layouts->view('ap/reports/paymentAdvice', '', $data);
	
	}
	
	
}

	
/* End of file gltransaction.php */
/* Location: ./application/controller/gltransaction.php */
