<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SupplierPayment extends CI_Controller {
	
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
		echo '<h1>Supplier Payment default page<h1><br>';
		echo '<div><a href="supplierPayment/payList"><h3>List</h3></a></div>'; //call controller
	}
		
	public function supplierpayment_Address()
	{
		$this->load->model('supplier/address_model');
		$query = $this->address_model->address_id($this->input->post('supplieraddress'));
		
		if($query>0){
			print json_encode(array(
				"status"=>"false", 
				"message"=>$query,
				//"=>$query , 
				//"line1"=>$query , 
				//"line2"=>$query , 
				//"city"=>$query , 
				//"address"=>$query , 
				));
		}
		else{
			print json_encode(array("status"=>"success", "message2"=>$query));
		}
	}
	
	//Untuk dapatkan address
	public function getAddress()
	{
		$address = $this->input->post('address');
    	$this->load->model('supplier/address_model');
    	$addr = $this->address_model->address_supplierID($address);
    	$data['address']= $addr[0];
    	print json_encode(array("status"=>"success", "message"=>$data['address']));
	}
		
	public function newForm() {
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$supplierID = $this->uri->segment(3);
//		$supplierID2 = isset($_REQUEST['supplier'])?$_REQUEST['supplier']:"";
		$companyID = element('compID', $this->session->userdata('logged_in')) ;  

		$data['ID']= $ID;
		$data['supplierID']= $supplierID;
		$this->lang->load("supplierPaymentForm",$this->session->userdata('language'));
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('iAccounts');
		$data['our_company'] = 'this is my company';
	   	$data['module'] = 'Administration';
	  	$data['title'] = 'Supplier Payment';
		$this->load->model('supplier/supplierpayment_model');
		
		$this->load->model('Currency');
		$data['currency'] = $this->Currency->currency_all();
		
		$this->load->model('supplier/supplier_model');
		$data['supplier']=$this->supplier_model->suppliermaster_all(); //for combo box
		$rs = $this->supplier_model->suppliermaster_id($supplierID); //for selected supplier
	    $data['supplierInfo']=$rs[0];
		
		$this->load->model('supplier/address_model');
		$data['supplieraddress']=$this->address_model->address_all();
		
		$this->load->model('project/project_model');
		$data['project']=$this->project_model->project_all();
		
		$this->load->model('master/masterCode_model');
		$filter['masterID']=7;
		$data['paymentmethod'] = $this->masterCode_model->get_all($filter);
		
		$this->load->model('company/formSetup_model');
    	$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
		$filter['formID']=44;
		$data['formNo'] = $this->formSetup_model->getFormNo($filter);
		$data['formSerialNo']=($ID>0)?$this->formSetup_model->getFormSerialNo_zeroLeading($ID):'';

		$this->load->model('chartofaccount');
		$data['acctNo'] = $this->chartofaccount->chartofaccount_all();
		
		$this->load->model('accountPayable/AccountPayable_model');
		$rs =$this->AccountPayable_model->get_bySupplierID($data['supplierID'], element('compID', $this->session->userdata('logged_in')));
		//echo $this->db->last_query(); 
		$data['rsPendingInvoice'] = $rs;
		$this->layouts->add_includes('js/charts.js')
			->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			$this->layouts->view('supplierpayment/supplierpayment_form', array('latest' => 'sidebar/latest'), $data);				
	}

		
	public function editForm() {
//		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$ID = $this->uri->segment(3);
//		$supplierID2 = isset($_REQUEST['supplier'])?$_REQUEST['supplier']:"";
		$companyID = element('compID', $this->session->userdata('logged_in')) ;  

		$data['ID']= $ID;
//		$data['supplierID']= $supplierID;
		$this->lang->load("supplierPaymentForm",$this->session->userdata('language'));
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('iAccounts');
		$data['our_company'] = 'this is my company';
	   	$data['module'] = 'Administration';
	  	$data['title'] = 'Supplier Payment';
		$this->load->model('supplier/supplierpayment_model');
		$paymentInfo = $this->supplierpayment_model->supppayment_byID($ID);
		$data['paymentInfo'] = $paymentInfo;
		$this->load->model('Currency');
		$data['currency'] = $this->Currency->currency_all();
		
		$this->load->model('supplier/supplier_model');
//		$data['supplier']=$this->supplier_model->suppliermaster_all(); //for combo box
		$rs = $this->supplier_model->suppliermaster_id($paymentInfo->supplierID); //for selected supplier
	    $data['supplierInfo']=$rs[0];
		
//		$this->load->model('supplier/address_model');
//		$data['supplieraddress']=$this->address_model->address_all();
		
		$this->load->model('project/project_model');
		$data['project']=$this->project_model->project_all();
		
		$this->load->model('master/masterCode_model');
		$filter['masterID']=7;
		$data['paymentmethod'] = $this->masterCode_model->get_all($filter);
		
		$this->load->model('company/formSetup_model');
    	$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
		$filter['formID']=44;
		$data['formNo'] = $this->formSetup_model->getFormNo($filter);
		$data['formSerialNo']=($ID>0)?$this->formSetup_model->getFormSerialNo_zeroLeading($ID):'';

		$this->load->model('chartofaccount');
		$data['acctNo'] = $this->chartofaccount->chartofaccount_all();
		
		$this->load->model('accountPayable/AccountPayable_model');
		$rs =$this->AccountPayable_model->get_bySupplierID($data['supplierID'], element('compID', $this->session->userdata('logged_in')));
		//echo $this->db->last_query(); 
		$data['rsPendingInvoice'] = $rs;
		$this->layouts->add_includes('js/charts.js')
			->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			$this->layouts->view('supplierpayment/supplierpayment_form', array('latest' => 'sidebar/latest'), $data);				
	}

	public function updatePosting() {
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->load->model('supplier/supplierpayment_model');
		$updatePosting = $this->supplierpayment_model->updatePosting($ID); 
		if ($updatePosting)	return true;
		else return false; 
	}
	public function save() {
		$outOfBalance = $this->input->post('outOfBalance');
		$currentUser = element('role', $this->session->userdata('logged_in'));
		if ($outOfBalance <> 0 || $this->input->post('supplierID') =="0") 
			echo '<script>alert("Update Failed."); history.go(-1);</script>';
//		var_dump($this->input->post());
		$ID		= $this->input->post('ID');
		$paymentDate = substr($this->input->post('paymentDate'),6,4).'-'.substr($this->input->post('paymentDate'),3,2).'-'.substr($this->input->post('paymentDate'),0,2); 
		$newsupppayment = array(
			'companyID' => element('compID', $this->session->userdata('logged_in')),   
			'supplierID'		=> $this->input->post('supplierID'), 
			'projectID'		=> $this->input->post('projectID'),
			'amountPaid'		=> $this->input->post('amountPaid'),
			'paymentMethodID'  => $this->input->post('paymentMethodID'),
			//'supplierAddress' => $this->input->post('supplierAddress'),
			'formNo' => $this->input->post('formNo'),
			'currencyID' => $this->input->post('currencyID'), 
//			'paymentDate' => 'str_to_date('.$this->input->post('paymentDate').",'%d-%m-%Y')",
			'paymentDate' => $paymentDate,
			'referenceNo' => $this->input->post('referenceNo'),
			'accountDescription' => $this->input->post('accountDescription'),
			'totalDiscount' =>  $this->input->post('totalDiscount'),
			'bankCharges' => $this->input->post('BankCharges'),
			'totalOtherCharge' => $this->input->post('totalOtherCharges'),
			'totalPaid' => $this->input->post('totalPaid'),
			'totalApplied' => $this->input->post('totalApplied'),
			'outOfBalance' => $this->input->post('outOfBalance'),
			'memo' => $this->input->post('memo'),
			'createdBy' => $currentUser					
		   );	//end newsupppayment array
		   
		$this->load->model('supplier/supplierpayment_model');
		$saveMode = 0;
		$paymentID =0;
		if($this->input->post('ID')==NULL){
			$paymentID = $this->supplierpayment_model->suppPayment_insert($newsupppayment);
			$saveMode = 1; //insert
			//echo '<br>insert';
		} else{
			$paymentID = $this->supplierpayment_model->suppPayment_edit($newsupppayment, $ID);
			$saveMode = 2; //update
			//echo '<br>update';
		}
		//save detail payment
		$paymentDetail = array (
			'amountApplied' => $this->input->post('amountApplied'),
			'suppInvoiceID' => $this->input->post('suppInvoiceID'),
			'discount' => $this->input->post('discount'),
			'paymentID' => $paymentID);
		if ($saveMode == 1)
			$success = $this->supplierpayment_model->paymentDetail_insert($paymentDetail);
		else
			$success = $this->supplierpayment_model->paymentDetail_edit($paymentDetail);


		if($success){
			echo '<script>alert("Save Success..");
					window.location.replace("supplierpaymentlist");
					</script>';
		} else {
			echo '<script>alert("Update Failed:'.$success.'"); history.go(-1);</script>';
		}
			
} //end save

	public function supplierpaymentlist(){
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("supplierPaymentList",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('supplier/SupplierPayment_model');
		
		
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
		$query = $this->SupplierPayment_model->updatePosting($ID);
		
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->SupplierPayment_model->supplierPaymentDate($dateFrom, $dateTo);
		
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('supplierpayment/supplierPaymentList', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function supplierpaymentAdvice(){
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("supplierPaymentList",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('supplier/SupplierPayment_model');
		
		
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
		$query = $this->SupplierPayment_model->updatePosting($ID);
		
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->SupplierPayment_model->supplierPaymentDate($dateFrom, $dateTo);
		
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('supplierpayment/supplierPaymentAdvice', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function supplierpaymentlist_print(){
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("supplierPaymentList",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('supplier/SupplierPayment_model');
		
		
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
		$query = $this->SupplierPayment_model->updatePosting($ID);
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->SupplierPayment_model->supplierPaymentDate($dateFrom, $dateTo);
//		echo $this->db->last_query();
		$this->load->view('supplierpayment/supplierPaymentList_print', $data);
	}
	
	public function supplierpaymentlist_excel(){
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->load->library('parser');
		$mode = $this->uri->segment(3);
		$this->lang->load("supplierPaymentList",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('supplier/SupplierPayment_model');
		
		
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
		$query = $this->SupplierPayment_model->updatePosting($ID);
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->SupplierPayment_model->supplierPaymentDate($dateFrom, $dateTo);
//		echo $this->db->last_query();
		
		$myFile = "Supplier_Payment_List.xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('supplierpayment/supplierPaymentList_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}


		
	/*public function supplierpaymentlist1(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   	$data['module'] = 'supplierpaymentlist';
		  	$data['title'] = 'Supplier Payment List';
			$this->load->helper('menu');
			$this->load->model('supplier/supplierpayment_model');
			$data['datatbls'] = $this->supplierpayment_model->supppayment_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->load->model('supplier/supplierpayment_model');	
			$this->load->model('Currency');
			$data['currency'] = $this->Currency->currency_all();
			$this->load->model('supplier/supplier_model');
			$data['supplier']=$this->supplier_model->suppliermaster_all();
			$this->load->model('supplier/address_model');
			$data['supplieraddress']=$this->address_model->address_all();
			$this->load->model('project/project_model');
			$data['project']=$this->project_model->project_all();
			$this->load->model('master/masterCode_model');
			$filter['masterID']=2;
			$data['paymentmethod'] = $this->masterCode_model->get_all($filter);
			$this->load->model('company/formSetup_model');
    		$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=44;
			$data['formNo'] = $this->formSetup_model->getFormNo($filter);
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('supplierpayment/supplierpaymentlist', array('latest' => 'sidebar/latest'), $data);
		}
	}*/
	
		public function supppayment_edit(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('supplier/supplierpayment_model');
		  	$edituser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$edituser = $this->supplierpayment_model->supppayment_edit($edituser,$ID);
			if($edituser){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
		public function supppayment_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('supplier/supplierpayment_model');
		  	$deletepayment = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$delete_payment = $this->supplierpayment_model->supppayment_delete($deletepayment, $ID);
			if($delete_payment){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

/* download created excel file */
    function downloadExcel($myFile) {
        header("Content-Length: " . filesize($myFile));
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$myFile);
 
        readfile($myFile);
    }
}
?>