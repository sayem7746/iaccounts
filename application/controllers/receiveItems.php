<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class receiveItems extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('8', 'transaction');
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

	
	public function purchaseInvoiceList(){
		$this->lang->load("purchaseInvoice",$this->session->userdata('language'));
		$this->load->model('purchaseInvoice_list');
		$this->load->model('company/FormSetup_model');
		
//		$dateFrom = $this->input->post('selDateFrom');
//		$dateTo = $this->input->post('selDateTo');
		$dateFrom = date("Y-m-d",strtotime($this->uri->segment(3)));
		$dateTo = date("Y-m-d",strtotime($this->uri->segment(4)));
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		if (($dateFrom == "") || ($dateTo == "")){
		$data['datatbls'] = $this->purchaseInvoice_list->purchaseInvoice_all();}
		else{
		$data['datatbls'] = $this->purchaseInvoice_list->purchaseInvoiceDate($dateFrom, $dateTo);
		}
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('purchase/transactions/purchaseInvoiceList', array('latest' => 'sidebar/latest'), $data);
	}

// purchase invoices	
// created by Eisa
// 20th may 2014

	public function newITemReceived(){
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$this->lang->load("invoices",$this->session->userdata('language'));
			$this->load->model('companyChartAcct');
		
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$this->load->model('Supplier/supplier_model');
			$data['supplier'] = $this->supplier_model->suppliermaster_all();
			
		
			$this->load->model('location');
			$data['location'] = $this->location->location_all();
			
			$data['itemCodes'] = $this->getItemCodes();
			
			$this->load->model('companyChartAcct');
			$data['chargeAccount'] = $this->companyChartAcct->chartAcct_all();
			
			$this->load->model('employee/employee_model');
			$data['purchaser'] = $this->employee_model->employeemaster_allopt();
			
			$this->load->model('purchase/purchase_model');
			$data['poList'] = $this->purchase_model->getPoList("null",element('compID', $this->session->userdata('logged_in')));

			
			$this->load->model('master/masterCode_model');
			$data['shippingmethod'] = $this->masterCode_model->get_all(array('masterID'=>2));
			
			
//			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=45; // for GRN 
			
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 

			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			$this->layouts->view('purchase/transactions/new_receive', '', $data);
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
	public function getPoList(){
		$this->load->model('purchase/purchase_model');
		$poL = $this->purchase_model->getPoList($this->input->post('supplier'),element('compID', $this->session->userdata('logged_in')));
		if ($poL){
			$JsonRecords = '{"records":[';	
			$n = sizeof($poL);
			$i= 0;
			 foreach($poL as $row){
				$JsonRecords .= '{';
				$JsonRecords .= '"id":"' . $row->ID . '","formNo":"'.$row->formNo.'"';
				$JsonRecords .= '}';
				if ($i < $n - 1)
					$JsonRecords .= ',';
				$i++;
			}
			$JsonRecords .= ']}';
			 echo $JsonRecords;
		}
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
			$JsonRecords .= '"supplierName":"' . $row->supplierName . '","id":"'.$row->ID.'"';
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
	
	
	
	function checkformNumber(){
		$this->load->model('accountPayable/accountPayable_model');
		echo $this->accountPayable_model->checkformNumber_model("comp_supplier_invoice",$this->input->post('code'));
		
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
	
	public function getPoItemList(){
		$this->load->model('purchase/purchase_model');
		echo $this->purchase_model->getPoItemList($this->input->post('poId'));
		
	}
	
	public function saveNewItemDetailOnly(){
		$this->load->model('item/itemSetup_model');
		
		$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
		$itemId ="0";
		if($default){
		  foreach($default as $row)
		   $itemId =$row->ID;
		}
		
		$datinsertDetails = array (
		'receiveID' =>  $this->input->post('receiveID'),
		'createdBy' => element('role', $this->session->userdata('logged_in')),
		'itemID' => $itemId,
		'poDetailID' => $this->input->post('poDetailID'), 
		'itemCode' => $this->input->post('itemCode'), 
		'itemname' => $this->input->post('itemname'), 
		'description' => $this->input->post('description'),
		'quantityOrder' => $this->input->post('quantityOrder'),
		'quantityReceived' => $this->input->post('quantityReceived'),
		'unitPrice' => $this->input->post('unitPrice'),
		'amount' => $this->input->post('amount')
	);
	
	 $this->load->model('purchase/Purchase_model');
	 $query = $this->Purchase_model->insert('comp_receive_item_detail',$datinsertDetails);
	 $detail=$this->Purchase_model->getLasIdInsert("comp_receive_item_detail");
	 
	 //update po detail 
	if ($this->input->post('poDetailID')>0) {
	 $dataUpdate = array ( 
		'quantityReceivedTotal' => $this->input->post('quantityReceivedTotal')+
		$this->input->post('quantityReceived')
	);
	 $query = $this->Purchase_model->updatePoDetail($this->input->post('poDetailID'),$dataUpdate);
	}
	
	 echo '{"status":"success","detailID":"'.$detail.'"}';
	 
	}
	
	
	public function saveNewItemReceived(){
			 $this->load->model('purchase/Purchase_model');
		   
			$ID = $this->input->post('ID');
			$companyID =  element('compID', $this->session->userdata('logged_in')) ;
			$datinsert = array ( 
				'companyID' => $companyID,
				'createdBy' => element('userid', $this->session->userdata('logged_in')),
				'supplierID' => $this->input->post('supplierID'),
				'employeeID' => $this->input->post('employeeID'),
				'memo' => $this->input->post('memo'),
				'formNo' => $this->input->post('formNo'),
				'deliveryDate' => date('Y-m-d', strtotime($this->input->post('deliveryDate'))),
				'shippingMethodID' => $this->input->post('shippingMethodID'),
				'supplierDoNo' => $this->input->post('supplierDoNo'),
				'purchaseOrderID' => $this->input->post('purchaseOrderID'),
				'locationID' => $this->input->post('locationID')
			);

            
			 $query = $this->Purchase_model->insert("comp_receive_item",$datinsert);
		  	
			
			if($query){
				$this->load->model('item/itemSetup_model');
				$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
				$itemId ="0";
				if($default){
		          foreach($default as $row)
				   $itemId =$row->ID;
				}
				
				$receivedID=$this->Purchase_model->getLasIdInsert("comp_receive_item");
				$datinsertDetails = array (
				'receiveID' =>  $receivedID,
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'itemID' => $itemId,
				'poDetailID' => $this->input->post('poDetailID'), 
				'itemCode' => $this->input->post('itemCode'), 
				'itemname' => $this->input->post('itemname'), 
				'description' => $this->input->post('description'),
				'quantityOrder' => $this->input->post('quantityOrder'),
				'quantityReceived' => $this->input->post('quantityReceived'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amount' => $this->input->post('amount')
			);
			 $query = $this->Purchase_model->insert('comp_receive_item_detail',$datinsertDetails);
		     $detail=$this->Purchase_model->getLasIdInsert("comp_receive_item_detail");
			 //update po detail 
			 if ($this->input->post('poDetailID')>0) {
			 $dataUpdate = array ( 
				'quantityReceivedTotal' => $this->input->post('quantityReceivedTotal')+
				$this->input->post('quantityReceived')
			);
			 $query = $this->Purchase_model->updatePoDetail($this->input->post('poDetailID'),$dataUpdate);
			 }
			 
			 
			 echo '{"status":"success","receivedID":"'.$receivedID.'","detailID":"'.$detail.'"}';
			}else{
				echo "false";
			}
	}

public function editReceiveItem($id){
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$this->lang->load("invoices",$this->session->userdata('language'));
			$this->load->model('companyChartAcct');
		
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
		
			
			$data['itemCodes'] = $this->getItemCodes();
			
			$this->load->model('purchase/purchase_model');
			$data['receiveItemsDetails'] = $this->purchase_model->getReceiveDetail($id);
			$data['receivItems'] = $this->purchase_model->getReceiveByID($id);
			
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			$this->layouts->view('purchase/transactions/edit_receiveItem', '', $data);
	}
	
// purchase invoice end

	public function updateReceiveItemDetail(){
		
	 if ($this->input->post('option')=="noPo"){
		$this->load->model('item/itemSetup_model');
		$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
		$itemId ="0";
		if($default){
		  foreach($default as $row)
		   $itemId =$row->ID;
		}
		$data = array (
				'updatedBy' => element('role', $this->session->userdata('logged_in')),
				'itemID' => $itemId, 
				'itemCode' => $this->input->post('itemCode'), 
				'itemname' => $this->input->post('itemname'), 
				'description' => $this->input->post('description'),
				'quantityOrder' => $this->input->post('quantityOrder'),
				'quantityReceived' => $this->input->post('quantityReceived'),
				'unitPrice' => $this->input->post('unitPrice'),
				'amount' => $this->input->post('amount')
		);
		$this->load->model('purchase/purchase_model');
		echo $this->purchase_model->updateByTname($this->input->post('itemReceivedID'), $data,"comp_receive_item_detail");
	 }else {
	  	$data = array (
				'updatedBy' => element('role', $this->session->userdata('logged_in')),
				'quantityReceived' => $this->input->post('quantityReceived')
		);
		$this->load->model('purchase/purchase_model');
	    $this->purchase_model->updateByTname($this->input->post('itemReceivedID'), $data,"comp_receive_item_detail");
		//update qty total received in PO detail
		$data1 = array (
				'quantityReceivedTotal' => $this->input->post('qtyPoUpdate') + $this->purchase_model->getPoItemTotal($this->input->post('poDetailID'))
		);
		
		$this->purchase_model->updateByTname($this->input->post('poDetailID'), $data1,"comp_purchase_order_detail");
	  }
	}

}

	
/* End of file purchasetransaction.php */
/* Location: ./application/controller/purchasetransaction.php */
