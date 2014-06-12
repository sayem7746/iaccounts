<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompanySetup extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}

	public function index() {
		echo 'Company_C:default page';
	}
	
	public function usermaster_allopt(){
		$this->load->model('Usermaster');
		$query = $this->Usermaster->usermaster_allopt();
		header('Content-Type: application/json');
        echo json_encode($query);		
		return TRUE;
	}
	

	// -- User Access --
	
	public function formSetup(){
//		if (!isset($id) || $id == '')
			$id = element('compID', $this->session->userdata('logged_in')); 
	//id=companyID. default to current companyID
/*	  if($this->input->post('mysubmit')){
	  }else{
		  $this->lang->load("company_formSetup",$this->session->userdata('language'));
		  $this->load->library('layouts');
		  $this->load->helper('form');
		  $this->layouts->set_title('i-Accounts');
 		  $this->load->model('form/formSetup_model');
		  $data['datatbls'] = $this->formSetup_model->formSetup_id($id);
		  $this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
		  	->add_includes('js/datatables/jquery.dataTables.min.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
		  $this->layouts->view('company/company_formSetup', array('latest' => 'sidebar/latest'), $data);
	  }
*/
		  $this->lang->load("company_formSetup",$this->session->userdata('language'));
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   		$data['module'] = 'Administration';
		  		$data['title'] = 'Form Setup List';
			$this->load->helper('menu');
			$this->load->model('company/formSetup_model');
			$data['datatbls'] = $this->formSetup_model->formSetup_id($id);
//			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('company/company_formSetup', array('latest' => 'sidebar/latest'), $data);

	}

    
	public function formSetup_save(){ //save record
			$this->load->model('company/formSetup_model');
			$id = $this->input->post('id');
			$dataupdate = array (
				'formYear' => $this->input->post('formYear'),
				'formMonth' => $this->input->post('formMonth'),
				'formDay' => $this->input->post('formDay'),
			);
		  	$query = $this->formSetup_model->formSetup_update($id, $dataupdate);
    		print json_encode(array("status"=>"success", "message"=>$query));
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function formSetup_update(){ //update field
			$this->load->model('company/formSetup_model');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->formSetup_model->formSetup_update($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
			echo "ok";
	}
	
	public function compRecPaymentList() {
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("compRecPaymentList",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('company/company_info_model');
		
		
//		$dateFrom = $this->input->post('selDateFrom');
//		$dateTo = $this->input->post('selDateTo');

		$data['mode'] = $mode; 
		
		$dateFrom = date("Y-m-d",strtotime($this->uri->segment(4)));
		$dateTo = date("Y-m-d",strtotime($this->uri->segment(5)));
		
		if ($this->uri->segment(4) == ""){
			$dateFrom = date("Y-m-01");
		}
		if($this->uri->segment(5) == ""){
			$dateTo = date("Y-m-t");
		}
		if($dateFrom > $dateTo){
			$dateTo = date("Y-m-t", strtotime($dateFrom));
		}
		
		$ID = $this->input->post('ID');
		$query = $this->company_info_model->updatePosting($ID);
		
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->company_info_model->compRecPaymentDate($dateFrom, $dateTo);
		
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('company/compRecPaymentList', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function compRecPaymentList_print() {
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("compRecPaymentList",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('company/company_info_model');
		
		
//		$dateFrom = $this->input->post('selDateFrom');
//		$dateTo = $this->input->post('selDateTo');

		$data['mode'] = $mode; 
		
		$dateFrom = date("Y-m-d",strtotime($this->uri->segment(4)));
		$dateTo = date("Y-m-d",strtotime($this->uri->segment(5)));
		
		if ($this->uri->segment(4) == ""){
			$dateFrom = date("Y-m-01");
		}
		if($this->uri->segment(5) == ""){
			$dateTo = date("Y-m-t");
		}
		if($dateFrom > $dateTo){
			$dateTo = date("Y-m-t", strtotime($dateFrom));
		}
		
		$ID = $this->input->post('ID');
		$query = $this->company_info_model->updatePosting($ID);
		
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->company_info_model->compRecPaymentDate($dateFrom, $dateTo);
		
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->load->view('company/compRecPaymentList_print', $data);
	}
	
	public function compRecPaymentList_excel() {
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->load->library('parser');
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("compRecPaymentList",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('company/company_info_model');
		
		
//		$dateFrom = $this->input->post('selDateFrom');
//		$dateTo = $this->input->post('selDateTo');

		$data['mode'] = $mode; 
		
		$dateFrom = date("Y-m-d",strtotime($this->uri->segment(4)));
		$dateTo = date("Y-m-d",strtotime($this->uri->segment(5)));
		
		if ($this->uri->segment(4) == ""){
			$dateFrom = date("Y-m-01");
		}
		if($this->uri->segment(5) == ""){
			$dateTo = date("Y-m-t");
		}
		if($dateFrom > $dateTo){
			$dateTo = date("Y-m-t", strtotime($dateFrom));
		}
		
		$ID = $this->input->post('ID');
		$query = $this->company_info_model->updatePosting($ID);
		
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->company_info_model->compRecPaymentDate($dateFrom, $dateTo);
		
		$myFile = "Company_Receive_Payment_List.xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('company/compRecPaymentList_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}
	
	/* download created excel file */
    function downloadExcel($myFile) {
        header("Content-Length: " . filesize($myFile));
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$myFile);
 
        readfile($myFile);
    }
	
}
/* End of file companySetup.php */
/* Location: ./system/controller/companySetup.php */


?>