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
	
// purchase invoices	
// created by Eisa
// 20th may 2014

	public function invoices(){
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$this->lang->load("invoices",$this->session->userdata('language'));
			$this->load->model('companyChartAcct');
		
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
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
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			$this->layouts->view('ap/transactions/ap_purchaseinvoice', '', $data);
	}

	public function loadSupplierDefaultValue(){
		$this->load->model('accountPayable/accountPayable_model');
		
		$JsonRecords = '{"records":[';
		
		$i= 0;
		$default = $this->accountPayable_model->loadSupplierDefaultValue($this->input->post('supplier'));
		$n = sizeof($default);
		 foreach($default as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"currency":"' . $row->currencyWord.'",'.'"exchangeRate":"'.$row->exchangeRate.'","currencyID":"'.$row->currencyID.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';
		 echo $JsonRecords;

	}

	public function refreshSupplier(){
		//for ajax call 
		$this->load->model('Supplier/supplier_model');
		$supllier = $this->supplier_model->suppliermaster_all();
		$JsonRecords = '{"records":[';
		
		$n = sizeof($supllier);
		$i= 0;
		 foreach($supllier as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"supplierName":"' . $row->supplierName . '","id":"'.$row->supplierName.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';
		
		//$resul= '{"supplier":['. json_encode($this->supplier_model->suppliermaster_all()).']}';
		 echo $JsonRecords;
	}
	
	public function getItemCodes(){
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
	public function refreshTerms(){
		//for ajax call 
		$this->load->model('Terms/terms_model');
			$terms = $this->terms_model->terms_all();
		
		//json_encode ($this->project_model->project_all());
		
		$JsonRecords = '{"records":[';
		$n = sizeof($terms);
		$i= 0;
		 foreach($terms as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"termName":"' . $row->termName.'","id":"'.$row->ID.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';

		//$resul= '{"supplier":['. json_encode($this->supplier_model->suppliermaster_all()).']}';
		 echo $JsonRecords;
	}
	
	public function refreshProject(){
		//for ajax call 
		$this->load->model('Project/project_model');
		$project = $this->project_model->project_all();
		
		//json_encode ($this->project_model->project_all());
		
		$JsonRecords = '{"records":[';
		$n = sizeof($project);
		$i= 0;
		 foreach($project as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"id":"'.$row->ID.'","projectName":"' . $row->project_name.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';

		//$resul= '{"supplier":['. json_encode($this->supplier_model->suppliermaster_all()).']}';
		 echo $JsonRecords;
	}
	function getTermDescription(){
		$this->load->model('terms/terms_model');	
		$JsonRecords = '';
		$default = $this->terms_model->terms_id($this->input->post('term'));
		if ($default!=false)
		{
			 foreach($default as $row)
				$JsonRecords =  $row->termDescription;
		     echo $JsonRecords;
		}else
			echo "Term not found";
	}
	
	function savePurchaseRow(){
			$this->load->model('accountPayable/accountPayable_model');
			$ID = $this->input->post('ID');
			$companyID =  element('compID', $this->session->userdata('logged_in')) ;
			$datinsert = array (
				'locationID' => $this->input->post('locationID'), 
				'companyID' => $companyID,
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
				'purchaseInvoiceCodeID' => 2,
				'supplierID' => $this->input->post('supplierID'), 
				'shipToID' => $this->input->post('shipToID'), 
				'formNo' => $this->input->post('formNo'),
				'invoiceDate' => date('Y-m-d', strtotime($this->input->post('invoiceDate'))),
				'supplierInvoiceNo' => $this->input->post('supplierInvoiceNo'),
				'projectID' => $this->input->post('projectID'),
				'termsID' => $this->input->post('termsID'),
				'exchangeRate' => $this->input->post('exchangeRate')
			);

            
			 $query = $this->accountPayable_model->insert("comp_supplier_invoice",$datinsert);
		  	
			
			if($query){
				$this->load->model('item/itemSetup_model');
				$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
				$itemId ="0";
				if($default){
		          foreach($default as $row)
				   $itemId =$row->ID;
				}
				
				$invID=$this->accountPayable_model->getLasIdInsert("comp_supplier_invoice");
				$datinsertDetails = array (
				'invoiceID' =>  $invID,
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
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
			 $query = $this->accountPayable_model->insert('comp_supplier_invoice_detail',$datinsertDetails);
		     $detail=$this->accountPayable_model->getLasIdInsert("comp_supplier_invoice_detail");
			 echo '{"status":"success","invoiceID":"'.$invID.'","detailID":"'.$detail.'"}';
			}else{
				echo "false";
			}
	}
	public function updateInvoice(){
		$this->load->model('accountPayable/accountPayable_model');
		 $invoiceUpdate = array (
		 		 'updatedBy' => element('userid', $this->session->userdata('logged_in')),
				 'totalTaxAmount' => $this->input->post('totalamount'), 
				 'totalPayable' => $this->input->post('totalPayable'),
			 );
	   $this->accountPayable_model->updateInvoice ($this->input->post('invoiceId'), $invoiceUpdate );
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
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
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
	public function deleteCompanyDetails (){
		$this->load->model('accountPayable/accountPayable_model');
		$this->accountPayable_model->delete($this->input->post('invDetailsId'), 'comp_supplier_invoice_detail');
		echo "ok";
	}
	
	function checkformNumber(){
		$this->load->model('accountPayable/accountPayable_model');
		echo $this->accountPayable_model->checkformNumber_model("comp_supplier_invoice",$this->input->post('code'));
		
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
				'updatedBy' => element('userid', $this->session->userdata('logged_in')),
				'itemname' => $this->input->post('itemname'), 
				'itemID' => $itemId,
				'itemdescription' => $this->input->post('itemdescription'),
				'quantity' => $this->input->post('quantity'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxRate' => $this->input->post('taxRate'),
				'taxID' => $this->input->post('taxID'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax')
			);
	    echo $this->accountPayable_model->update_byID($this->input->post('invDetailsId'), $data);
		
	}
	
	 
	public function saveCharge(){
			$this->load->model('accountPayable/accountPayable_model');
			$ID = $this->input->post('ID');
			$companyID =  element('compID', $this->session->userdata('logged_in')) ;
			$datinsert = array (
				'companyID' => $companyID,
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
				'purchaseInvoiceCodeID' => 2,
				'supplierID' => $this->input->post('supplierID'), 
				'formNo' => $this->input->post('formNo'),
				'shipToID' => $this->input->post('shipToID'),
				'invoiceDate' => date('Y-m-d', strtotime($this->input->post('invoiceDate'))),
				'supplierInvoiceNo' => $this->input->post('supplierInvoiceNo'),
				'projectID' => $this->input->post('projectID'),
				'termsID' => $this->input->post('termsID'),
				'exchangeRate' => $this->input->post('exchangeRate')
			);

            
			 $query = $this->accountPayable_model->insert("comp_supplier_invoice",$datinsert);
		  	
			
			if($query){
				
				$invID=$this->accountPayable_model->getLasIdInsert("comp_supplier_invoice");
				$datinsertDetails = array (
				'invoiceID' =>  $invID,
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
				'accountNoID' => $this->input->post('accountNoID'),
				'itemdescription' => $this->input->post('itemdescription'), 
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax'),
			);
			 $query = $this->accountPayable_model->insert('comp_supplier_invoice_charges',$datinsertDetails);
		     $detail=$this->accountPayable_model->getLasIdInsert("comp_supplier_invoice_charges");
			 echo '{"status":"success","invoiceID":"'.$invID.'","chargeId":"'.$detail.'"}';
			}else{
				echo "false";
			}
	}
	function deleteCharge(){
			$this->load->model('accountPayable/accountPayable_model');
		    echo $this->accountPayable_model->delete($this->input->post('chargeID'),"comp_supplier_invoice_charges");
			 
			}
	
	public function saveChargeDetailOnly(){
		
		$this->load->model('accountPayable/accountPayable_model');
				$datinsertDetails = array (
				'invoiceID' =>  $this->input->post('invoiceId'),
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
				'accountNoID' => $this->input->post('accountNoID'),
				'itemdescription' => $this->input->post('itemdescription'), 
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax'),
			);
	 	$query = $this->accountPayable_model->insert('comp_supplier_invoice_charges',$datinsertDetails);
	 	$detail=$this->accountPayable_model->getLasIdInsert("comp_supplier_invoice_charges");
			
	    echo '{"status":"success","chargeId":"'.$detail.'"}';
	}
	
	public function refreshLocation(){
		//for ajax call 
		$this->load->model('location');
		$location = $this->location->location_all();
		
		//json_encode ($this->project_model->project_all());
		
		$JsonRecords = '{"records":[';
		$n = sizeof($location);
		$i= 0;
		 foreach($location as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"id":"' . $row->fldid.'","location":"'.$row->code.' | '.$row->address.' | '.$row->city.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';

		//$resul= '{"supplier":['. json_encode($this->supplier_model->suppliermaster_all()).']}';
		 echo $JsonRecords;
	}
	
	public function updateCharge () {
				$update = array (
				'updatedBy' => element('userid', $this->session->userdata('logged_in')),
				'accountNoID' => $this->input->post('accountNoID'),
				'itemdescription' => $this->input->post('itemdescription'), 
				'amountExcludedTax' => $this->input->post('amountExcludedTax'),
				'taxID' => $this->input->post('taxID'),
				'taxAmount' => $this->input->post('taxAmount'),
				'amountIncludedTax' => $this->input->post('amountIncludedTax'),
			);
			$this->load->model('accountPayable/accountPayable_model');
		    echo $this->accountPayable_model->update_charge($this->input->post('chargeId'), $update);
	}
	
	function getItemDetails(){
		$JsonRecords = '{';
		$i= 0;
		$this->load->model('item/itemSetup_model');
		$default = $this->itemSetup_model->get_byCode($this->input->post('code'));
		//$default = $this->itemSetup_model->get_all();
		$n = sizeof($default);
		//print json_encode(array("status"=>"success", "message"=>$query));
		if($default){
		 foreach($default as $row){
			 
			 $tax="0";
			 $taxcode = "...";
			 $this->load->model('taxmaster');
		     $taxObj = $this->taxmaster->taxmaster_id($row->inputTaxID);
			 if($taxObj){
			  foreach($taxObj as $taxrow){
				   $tax=$taxrow->taxPercentage;
				   $taxcode = $taxrow->code;
			  }}
			$JsonRecords .= '"taxcode":"'.$taxcode.'","name":"'.$row->itemCode.'","description":"' .$row->description.'", "tax":"'.$tax.'", "taxID":"' .$row->inputTaxID.'"';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		 $JsonRecords .= '}';
		 echo $JsonRecords;
		}else {
			echo "item Not found";
			}
	}
	
	public function __reset() {
		$data = array ('ID'=>0,'itemName'=>'');
	}

// purchase invoice end

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
	
	
}

	
/* End of file gltransaction.php */
/* Location: ./application/controller/gltransaction.php */
