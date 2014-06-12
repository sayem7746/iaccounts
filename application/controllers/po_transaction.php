<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PO_Transaction extends CI_Controller {
	
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
		echo '<h1>Purchase order default page<h1><br>';
		echo '<div><a href="purchaseOrder/poList"><h3>List</h3></a></div>'; //call controller
	}
	public function poList() {
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("purchaseOrder",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('purchase/purchase_model');
		
		
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
		$query = $this->purchase_model->updatePosting($ID);
		
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->purchase_model->purchaseOrderDate($dateFrom, $dateTo);
		
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('purchase/transactions/purchaseOrderList', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function poList_print() {
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("purchaseOrder",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('purchase/purchase_model');
		
		
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
		$query = $this->purchase_model->updatePosting($ID);
		
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->purchase_model->purchaseOrderDate($dateFrom, $dateTo);
		
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->load->view('purchase/transactions/purchaseOrderList_print', $data);
	}
	
	public function poList_excel() {
		//$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		
		$this->load->library('parser');
		
		$mode = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("purchaseOrder",$this->session->userdata('language'));
		$this->load->model('company/FormSetup_model');
		$this->load->model('purchase/purchase_model');
		
		
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
		$query = $this->purchase_model->updatePosting($ID);
		
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->purchase_model->purchaseOrderDate($dateFrom, $dateTo);
		
		$myFile = "Purchase_Order_List.xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('purchase/transactions/purchaseOrderList_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}
	
	function checkformNumber(){
		$this->load->model('accountPayable/accountPayable_model');
		echo $this->accountPayable_model->checkformNumber_model("comp_purchase_order",$this->input->post('code'));
		
	}
	
	private function getItemCodes(){
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
	}
	
	public function newPo(){
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
			
			
			$this->load->model('Terms/terms_model');
			$data['terms'] = $this->terms_model->terms_all();
			
			
			$this->load->model('employee/employee_model');
			$data['purchaser'] = $this->employee_model->employeemaster_allopt();
			
			
			
			$data['itemCodes'] = $this->getItemCodes();
			
//			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=41;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 

			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			//$this->layouts->view('accountPayable/ap_purchaseinvoice', '', $data);
		//$this->load->view('accountPayable/ap_purchaseinvoice');
			
			
		    $this->layouts->view('purchase/transactions/new_po', '', $data);
		//$this->load->view('accountPayable/ap_purchaseinvoice');
			
			
			
		//$this->load->view('accountPayable/ap_purchaseinvoice');
			
	}
	
	function saveParchaseRow(){
			//echo element('userid', $this->session->userdata('logged_in'));
			
			$this->load->model('purchase/purchase_model');
			$ID = $this->input->post('ID');
			$companyID =  element('compID', $this->session->userdata('logged_in')) ;
			$datinsert = array ( 
				'companyID' => $companyID,
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'supplierID' => $this->input->post('supplierID'), 
				'formNo' => $this->input->post('formNo'),
				'poDate' => date('Y-m-d', strtotime($this->input->post('invoiceDate'))),
				'termAndConditionID' => $this->input->post('termsID'),
				'memo' => $this->input->post('memo'),
				'purchaserID' => $this->input->post('purchaserID'),
				'exchangeRate' => $this->input->post('exchangeRate')
			);

            
			 $query = $this->purchase_model->insert("comp_purchase_order",$datinsert);
		  	
			
			if($query){
				$this->load->model('item/itemSetup_model');
				$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
				$itemId ="0";
				if($default){
		          foreach($default as $row)
				   $itemId =$row->ID;
				}
				
				$invID=$this->purchase_model->getLasIdInsert("comp_purchase_order");
				$datinsertDetails = array (
				'purchaseOrderID' =>  $invID,
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
				'itemID' => $itemId,
				'itemname' => $this->input->post('itemname'), 
				'description' => $this->input->post('itemdescription'),
				'quantityOrder' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice')
			);
			 $query = $this->purchase_model->insert('comp_purchase_order_detail',$datinsertDetails);
		     $detail=$this->purchase_model->getLasIdInsert("comp_purchase_order_detail");
			 echo '{"status":"success","invoiceID":"'.$invID.'","detailID":"'.$detail.'"}';
			}else{
				echo "false";
			}
	}
	
		function saveParchaseDetail(){
				$this->load->model('item/itemSetup_model');
				$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
				$itemId ="0";
				if($default){
		          foreach($default as $row)
				   $itemId =$row->ID;
				}
				
				$this->load->model('purchase/purchase_model');
				$datinsertDetails = array (
				'purchaseOrderID' =>  $this->input->post('invoiceId'),
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
				'itemname' => $this->input->post('itemname'), 
				'itemID' => $itemId,
				'description' => $this->input->post('itemdescription'),
				'quantityOrder' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice')
			);
			 $query = $this->purchase_model->insert('comp_purchase_order_detail',$datinsertDetails);
		     $detail=$this->purchase_model->getLasIdInsert("comp_purchase_order_detail");
			 
			 
			 echo '{"status":"success","detailID":"'.$detail.'"}';
		}
		
		function deletePoRow(){
			$this->load->model('purchase/purchase_model');
			echo $this->purchase_model->delete($this->input->post('detailsId'));
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
			
			
			$this->load->model('purchase/purchase_model');
			$data['pdetails']=$this->purchase_model->get_Detail_byID($id);
			$data['pInvoice']=$this->purchase_model->get_byID("comp_purchase_order",$id);

			$this->layouts->view('/purchase/transactions/edit_po', '', $data);
	}
	
	/* download created excel file */
    function downloadExcel($myFile) {
        header("Content-Length: " . filesize($myFile));
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$myFile);
 
        readfile($myFile);
    }
	
} //big end
?>