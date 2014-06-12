<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aptransaction extends CI_Controller {
	
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
	

// Payment
	public function payment() {
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$supplierID = $this->uri->segment(3);
		$companyID = element('compID', $this->session->userdata('logged_in')) ;  

		$data['ID']= $ID;
		$data['supplierID']= $supplierID;
		$this->lang->load("appaymant",$this->session->userdata('language'));
		$this->load->model('supplier/supplierpayment_model');
		
		$this->load->model('Currency');
		$data['currency'] = $this->Currency->currency_all();
		
		$this->load->model('supplier/supplier_model');
		$data['supplier']=$this->supplier_model->suppliermaster_all();
		$rs = $this->supplier_model->suppliermaster_id($supplierID);
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
//		echo $this->db->last_query(); 
		$data['rsPendingInvoice'] = $rs;
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			$this->layouts->view('ap/transactions/payment', array('latest' => 'sidebar/latest'), $data);				
	}

// Debit note start
// Created By Eisa
// Updated By Farhana - Confirm & List


	public function newDebitNote (){
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=41;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 
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
			
			$this->load->model('location');
			$data['location'] = $this->location->location_all();
			
			
			$this->load->model('taxmaster');
			$data['taxmaster'] = $this->taxmaster->taxmaster_all();
			
			$data['itemCodes'] = $this->getItemCodes();
			
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=42;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 

			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$this->layouts->view('ap/transactions/ap_newDebitNote', '', $data);
	}
	function saveNewParchaseDebit (){
		   $this->load->model('accountPayable/accountPayable_model');
		   
			$ID = $this->input->post('ID');
			$companyID =  element('compID', $this->session->userdata('logged_in')) ;
			$datinsert = array ( 
				'companyID' => $companyID,
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'supplierID' => $this->input->post('supplierID'),
				'formNo' => $this->input->post('formNo'),
				'invoiceDate' => date('Y-m-d', strtotime($this->input->post('invoiceDate'))),
				'supplierInvoiceNo' => $this->input->post('supplierInvoiceNo'),
				'projectID' => $this->input->post('projectID'),
				'exchangeRate' => $this->input->post('exchangeRate')
			);

            
			 $invID = $this->accountPayable_model->insert("comp_supplier_debitnote",$datinsert);
		  	
			
			if($invID >0){
				$this->load->model('item/itemSetup_model');
				$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
				$itemId ="0";
				if($default){
		          foreach($default as $row)
				   $itemId =$row->ID;
				}
				
//				$invID=$this->accountPayable_model->getLasIdInsert("comp_supplier_debitnote");
				$datinsertDetails = array (
				'debitnoteID' =>  $invID,
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'itemID' => $itemId,
				'itemname' => $this->input->post('itemname'), 
				'itemdescription' => $this->input->post('itemdescription'),
				'quantity' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxRate' => $this->input->post('taxRate'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax')
			);
			 $query = $this->accountPayable_model->insert('comp_supplier_debitnote_detail',$datinsertDetails);
		     $detail=$this->accountPayable_model->getLasIdInsert("comp_supplier_debitnote_detail");
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
				
				$this->load->model('accountPayable/accountPayable_model');
				$datinsertDetails = array (
				'invoiceID' =>  $this->input->post('invoiceId'),
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'itemname' => $this->input->post('itemname'), 
				'itemID' => $itemId,
				'itemdescription' => $this->input->post('itemdescription'),
				'quantity' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxRate' => $this->input->post('taxRate'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax')
			);
			 $query = $this->accountPayable_model->insert('comp_supplier_invoice_detail',$datinsertDetails);
		     $detail=$this->accountPayable_model->getLasIdInsert("comp_supplier_invoice_detail");
			 echo '{"status":"success","detailID":"'.$detail.'"}';
		}
		
	function saveNewDebitDetail(){
				$this->load->model('item/itemSetup_model');
				$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
				$itemId ="0";
				if($default){
		          foreach($default as $row)
				   $itemId =$row->ID;
				}
				
				$this->load->model('accountPayable/accountPayable_model');
				$datinsertDetails = array (
				'debitnoteID' =>  $this->input->post('invoiceId'),
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'itemname' => $this->input->post('itemname'), 
				'itemID' => $itemId,
				'itemdescription' => $this->input->post('itemdescription'),
				'quantity' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxRate' => $this->input->post('taxRate'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax')
			);
			 $query = $this->accountPayable_model->insert('comp_supplier_debitnote_detail',$datinsertDetails);
		     $detail=$this->accountPayable_model->getLasIdInsert("comp_supplier_debitnote_detail");
			 echo '{"status":"success","detailID":"'.$detail.'"}';
		}
		
	public function deleteCompanyDetails (){
		$this->load->model('accountPayable/accountPayable_model');
		$this->accountPayable_model->delete($this->input->post('invDetailsId'), 'comp_supplier_invoice_detail');
		echo "ok";
	}
	
	public function deleteDebitNoteDetail (){
		$this->load->model('accountPayable/accountPayable_model');
		$this->accountPayable_model->delete($this->input->post('invDetailsId'), 'comp_supplier_debitnote_detail');
		echo "ok";
	}
	
	function checkformNumber(){
		$this->load->model('accountPayable/accountPayable_model');
		echo $this->accountPayable_model->checkformNumber_model("comp_supplier_debitnote", $this->input->post('code'));
		
	}
	public function updateRowDetailDebitNote(){
		$this->load->model('item/itemSetup_model');
		$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
		$itemId ="0";
		if($default){
		  foreach($default as $row)
		   $itemId =$row->ID;
		}
		$this->load->model('accountPayable/accountPayable_model');
		$data = array (
				'updatedBy' => element('role', $this->session->userdata('logged_in')),
				'itemname' => $this->input->post('itemname'), 
				'itemID' => $itemId,
				'itemdescription' => $this->input->post('itemdescription'),
				'quantity' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxRate' => $this->input->post('taxRate'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax')
			);
	    echo $this->accountPayable_model->update_debitNoteDetail($this->input->post('invDetailsId'), $data);
		
	}
	
	// edit of debit note
	public function editDebitNote ($id){
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
			$data['pdetails']=$this->accountPayable_model->get_DebitNoteDetail_byID($id);
			
			$data['pInvoice']=$this->accountPayable_model->get_byID("comp_supplier_debitnote",$id);

			
			$this->layouts->view('ap/transactions/ap_debitNoteEdit', '', $data);
	
	}
	
	public function printDebitNote ($id){
			$this->load->model('company/FormSetup_model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			
			
			$this->lang->load("debitNotePrint",$this->session->userdata('language'));
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
			$data['pdetails']=$this->accountPayable_model->get_DebitNoteDetail_byID($id);
			
			$this->load->model('company/Company_info_model');
			$query=$this->Company_info_model->companymaster_id(element('compID', $this->session->userdata('logged_in')));
			$data['companyInfo'] = $query[0];
			
			$query2=$this->accountPayable_model->get_byID("comp_supplier_debitnote",$id);
			$data['debitNote']=$query2[0];
			
			$query3=$this->accountPayable_model->get_byID("comp_supplier_invoice",$query2[0]->supplierInvoiceID);
			$data['pInvoice']=$query3[0];

			//var_dump($query3);
			$this->load->view('ap/reports/debitnote', $data);
	
	}
	
	
	function deleteCompanyDetail(){
			$this->load->model('accountPayable/accountPayable_model');
			echo $this->accountPayable_model->deleteCompanyDetail($this->input->post('detailsId'));
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

	public function debitnotePost(){
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
		$data['datatbls'] = $this->debitnote_model->debitnote_unpost($dateFrom, $dateTo);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('ap/transactions/debitnotePost', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function debitNotePosting(){
		$ID = $this->input->post('fldid');
		$effdate = date("Y-m-d", strtotime($this->input->post('effdate')));
		$data = array(
			'updateAble'=>'0'
		);
		$this->load->model('debitnote_model');
		$query = $this->debitnote_model->debitNotepost($ID, $data);
		var_dump($query);
		if($query){
			$this->load->model('Compfinancialyear');
			$query1 = $this->Compfinancialyear->compfinancialyear_date1($effdate);
			if($query1){
				$year = $query1[0]->financialYear;
				$period = $query1[0]->period;
				$description = $query[0]->supplierInvoiceNo;
			}else{
   				print json_encode(array("status"=>"failed", "message"=>$query1));
				return FALSE;
			}
 			$this->load->model('Glseq');
			$query = $this->Glseq->glSequence_sub('AP', $year, $period);
			$newData = array(
				'companyID' => element('compID', $this->session->userdata('logged_in')),
				'journalID' => $query['seqNumber'],
				'description' => $description,
				'module' => '3',
				'effective_date' => $effdate,
				'year' => $year,
				'period' => $period,
				'createdBy' => element('role', $this->session->userdata('logged_in'))
			);
			$this->load->model('Journal');
			$query2 = $this->Journal->journal_insert($newData);
  			print json_encode(array("status"=>"success", "message"=>$query2));
		}else{
			return FALSE;
		}
	}

// Debit Note List Print/Excel - Farhana

	public function dbnList_print() 
	{
		$mode=$this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("debitNote",$this->session->userdata('language'));
		$this->load->model('debitnote_model');
		$this->load->model('company/FormSetup_model');
		
		$data['mode'] = $mode;
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
		
		$ID = $this->input->post('ID');
		$query = $this->debitnote_model->updatePosting($ID);
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->debitnote_model->debitnote_Date($dateFrom, $dateTo);
		
		//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->load->view('ap/transactions/debitnoteList_print', $data);
	}
	
		
	public function dbnlist_excel()
	{
		$this->load->library('parser');
		$mode=$this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("debitNote",$this->session->userdata('language'));
		$this->load->model('debitnote_model');
		$this->load->model('company/FormSetup_model');
		
		$data['mode'] = $mode; 
		
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
		
		$ID = $this->input->post('ID');
		$query = $this->debitnote_model->updatePosting($ID);
		
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->debitnote_model->debitnote_Date($dateFrom, $dateTo);
		
		$myFile = "Debit_Note_List.xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('ap/transactions/debitnoteList_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
		
	}
// Debit Note end	
// Credit Note start	
// Created By Farhana
	public function creditnotePost(){
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
		$data['datatbls'] = $this->creditnote_model->creditnote_unpost($dateFrom, $dateTo);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('ap/transactions/creditnotePost', array('latest' => 'sidebar/latest'), $data);
	}

	public function creditNotePosting(){
		$ID = $this->input->post('fldid');
		$effdate = date("Y-m-d", strtotime($this->input->post('effdate')));
		$data = array(
			'updateAble'=>'0'
		);
		$this->load->model('creditnote_model');
		$query = $this->creditnote_model->creditNotepost($ID, $data);
		if($query){
			$this->load->model('Compfinancialyear');
			$query1 = $this->Compfinancialyear->compfinancialyear_date1($effdate);
			if($query1){
				$year = $query1[0]->financialYear;
				$period = $query1[0]->period;
				$description = $query[0]->supplierInvoiceNo;
			}else{
   				print json_encode(array("status"=>"failed", "message"=>$query1));
				return FALSE;
			}
 			$this->load->model('Glseq');
			$query = $this->Glseq->glSequence_sub('AP', $year, $period);
			$newData = array(
				'companyID' => element('compID', $this->session->userdata('logged_in')),
				'journalID' => $query['seqNumber'],
				'description' => $description,
				'module' => '3',
				'effective_date' => $effdate,
				'year' => $year,
				'period' => $period,
				'createdBy' => element('role', $this->session->userdata('logged_in'))
			);
			$this->load->model('Journal');
			$query2 = $this->Journal->journal_insert($newData);
  			print json_encode(array("status"=>"success", "message"=>$query));
		}else{
			return FALSE;
		}
	}
	
	//Added by Issa
	
	public function newCreditNote (){
		$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=41;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 
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
			
			$this->load->model('location');
			$data['location'] = $this->location->location_all();
			
			$this->load->model('companyChartAcct');
			$data['chargeAccount'] = $this->companyChartAcct->chartAcct_all();
			
			
			$this->load->model('taxmaster');
			$data['taxmaster'] = $this->taxmaster->taxmaster_all();
			
			$data['itemCodes'] = $this->getItemCodes();
			
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=43;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 

			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$this->layouts->view('ap/transactions/ap_newCreditNote', '', $data);
	}
	
	
	function saveNewParchaseCredit (){
		   $this->load->model('accountPayable/accountPayable_model');
		   
			$ID = $this->input->post('ID');
			$companyID =  element('compID', $this->session->userdata('logged_in')) ;
			$datinsert = array ( 
				'companyID' => $companyID,
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'supplierID' => $this->input->post('supplierID'),
				'formNo' => $this->input->post('formNo'),
				'invoiceDate' => date('Y-m-d', strtotime($this->input->post('invoiceDate'))),
				'supplierInvoiceNo' => $this->input->post('supplierInvoiceNo'),
				'projectID' => $this->input->post('projectID'),
				'exchangeRate' => $this->input->post('exchangeRate')
			);

            
			 $query = $this->accountPayable_model->insert("comp_supplier_creditnote",$datinsert);
		  	
			
			if($query){
				$this->load->model('item/itemSetup_model');
				$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
				$itemId ="0";
				if($default){
		          foreach($default as $row)
				   $itemId =$row->ID;
				}
				
				$invID=$this->accountPayable_model->getLasIdInsert("comp_supplier_creditnote");
				$datinsertDetails = array (
				'creditnoteID' =>  $invID,
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'itemID' => $itemId,
				'itemname' => $this->input->post('itemname'), 
				'itemdescription' => $this->input->post('itemdescription'),
				'quantity' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxRate' => $this->input->post('taxRate'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax')
			);
			 $query = $this->accountPayable_model->insert('comp_supplier_creditnote_detail',$datinsertDetails);
		     $detail=$this->accountPayable_model->getLasIdInsert("comp_supplier_creditnote_detail");
			 echo '{"status":"success","invoiceID":"'.$invID.'","detailID":"'.$detail.'"}';
			}else{
				echo "false";
			}
	}
	
	function saveParchaseCreditDetail(){
		  $this->load->model('item/itemSetup_model');
		  $default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
		  $itemId ="0";
		  if($default){
			foreach($default as $row)
			 $itemId =$row->ID;
		  }
		  
		  $this->load->model('accountPayable/accountPayable_model');
		  $datinsertDetails = array (
		  'creditnoteID' =>  $this->input->post('invoiceId'),
		  'createdBy' => element('role', $this->session->userdata('logged_in')),
		  'itemname' => $this->input->post('itemname'), 
		  'itemID' => $itemId,
		  'itemdescription' => $this->input->post('itemdescription'),
		  'quantity' => $this->input->post('quantity'),
		  'unitPrice' => $this->input->post('unitPrice'),
		  'amountExcludedTax' => $this->input->post('amountExcludedTax'),
		  'taxID' => $this->input->post('taxID'),
		  'taxRate' => $this->input->post('taxRate'),
		  'taxAmount' => $this->input->post('taxAmount'),
		  'amountIncludedTax' => $this->input->post('amountIncludedTax')
	  );
	   $query = $this->accountPayable_model->insert('comp_supplier_creditnote_detail',$datinsertDetails);
	   $detail=$this->accountPayable_model->getLasIdInsert("comp_supplier_creditnote_detail");
	   echo '{"status":"success","detailID":"'.$detail.'"}';
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


