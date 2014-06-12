<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OthersPayment extends CI_Controller {
	
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
	
		
// created by Eisa
// 20th may 2014

	public function newPayWithoutItem(){
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$this->lang->load("otherspayment",$this->session->userdata('language'));
			$this->load->model('companyChartAcct');
		
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$this->load->model('master/masterCode_model');
			$filter['masterID']=7;
			$data['paymentmethod'] = $this->masterCode_model->get_all($filter);
			
			
			$this->load->model('Project/project_model');
			$data['project'] = $this->project_model->project_all();
			
			$this->load->model('location');
			$data['location'] = $this->location->location_all();
			
			
			$this->load->model('taxmaster');
			$data['taxmaster'] = $this->taxmaster->taxmaster_all();
			
			$this->load->model('item/ItemSetup_model');
			$data['itemCodes'] = $this->getItemCodes();
			
			$this->load->model('companyChartAcct');
			$data['chargeAccount'] = $this->companyChartAcct->chartAcct_all();
			
//			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=55;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 

			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			$this->layouts->view('ap/othersPayment/ap_newPayWithoutItem', '', $data);
	}
	
	public function newPayWithItem(){
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$this->lang->load("otherspayment",$this->session->userdata('language'));
			$this->load->model('companyChartAcct');
		
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$this->load->model('master/masterCode_model');
			$filter['masterID']=7;
			$data['paymentmethod'] = $this->masterCode_model->get_all($filter);
			
			
			$this->load->model('Project/project_model');
			$data['project'] = $this->project_model->project_all();
			
			$this->load->model('location');
			$data['location'] = $this->location->location_all();
			
			
			$this->load->model('taxmaster');
			$data['taxmaster'] = $this->taxmaster->taxmaster_all();
			
			$this->load->model('item/ItemSetup_model');
			$data['itemCodes'] = $this->getItemCodes();
			
			$this->load->model('companyChartAcct');
			$data['chargeAccount'] = $this->companyChartAcct->chartAcct_all();
			
//			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=55;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter); 

			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			$this->layouts->view('ap/othersPayment/newotherpaymentwithitem', '', $data);
	}
	
	public function editPayWithItem($id){
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			
		
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			$this->load->library('layouts');
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			
			$this->lang->load("otherspayment",$this->session->userdata('language'));
			
			$this->load->model('Usermaster');
			$data['records'] = $this->Usermaster->usermaster_all();
			
			$data['itemCodes'] = $this->getItemCodes();
			
			$this->load->model('companyChartAcct');
			$data['chargeAccount'] = $this->companyChartAcct->chartAcct_all();
			
			$this->load->model('taxmaster');
			$data['taxmaster'] = $this->taxmaster->taxmaster_all();
			
			$this->load->model('accountPayable/othersPayment_model');
			$data['pdetails']=$this->othersPayment_model->getOthersPaymentDetail($id,"comp_payment_others_with_item");
			$data['otherPay']=$this->othersPayment_model->getOthersPayment($id);
			
			$this->layouts->view('ap/othersPayment/editotherpaymentwithitem', '', $data);
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
	
	function refreshPayMethod(){
		$this->load->model('master/masterCode_model');
		$filter['masterID']=7;
		$data = $this->masterCode_model->get_all($filter);
		
		$JsonRecords = '{"records":[';
		
		$i= 0;
		$n = sizeof($data);
		 foreach($data as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"id":"' . $row->ID.'",'.'"name":"'.$row->name.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';
		 echo $JsonRecords;

	}
	
	function savenewpaywithItemDetailOnly(){
			$this->load->model('accountPayable/othersPayment_model');
			$datinsertDetails = array (
			'otherPaymentID' => $this->input->post('otherPaymentID'),
			'createdBy' => element('role', $this->session->userdata('logged_in')),
			'itemID' => $this->input->post('itemID'),
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
		 $query = $this->othersPayment_model->insert('comp_payment_others_with_item',$datinsertDetails);
		 $detail=$this->othersPayment_model->getLasIdInsert("comp_payment_others_with_item");
		 echo '{"status":"success","detailID":"'.$detail.'"}';
	}
	
	function savenewpaywithoutItemDetailOnly(){
			$this->load->model('accountPayable/othersPayment_model');
			$datinsertDetails = array (
			'otherPaymentID' =>  $this->input->post('otherPaymentID'),
			'createdBy' => element('role', $this->session->userdata('logged_in')),
			'itemdescription' => $this->input->post('itemdescription'),
			'accountID' => $this->input->post('itemAccountID'),
			'amountIncludedTax' => $this->input->post('amountIncludedTax'),
			'amountExcludedTax' => $this->input->post('amountExcludedTax'),
			'taxID' => $this->input->post('taxID'),
			'taxRate' => $this->input->post('taxRate'),
			'taxAmount' => $this->input->post('amountIncludedTax'),
			'amountIncludedTax' => $this->input->post('amountIncludedTax')
		);
		 $query = $this->othersPayment_model->insert('comp_payment_others_without_item',$datinsertDetails);
		 $detail=$this->othersPayment_model->getLasIdInsert("comp_payment_others_without_item");
		 echo '{"status":"success","detailID":"'.$detail.'"}';
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
			$JsonRecords .= '"itemID":"'.$row->ID.'","taxcode":"'.$taxcode.'","name":"'.$row->name.'","description":"' .$row->description.'", "tax":"'.$tax.'", "taxID":"' .$row->inputTaxID.'"';
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
	
	function savenewpaywithOutItem(){
		$this->load->model('accountPayable/othersPayment_model');
		$ID = $this->input->post('ID');
		$companyID =  element('role', $this->session->userdata('logged_in')) ;
		$datinsert = array (
			'memo' => $this->input->post('memo'),
			'locationID' => $this->input->post('locationID'), 
			'companyID' => $companyID,
			'createdBy' => element('role', $this->session->userdata('logged_in')),
			'otherPaymentType' => 1,
			'paymentMethodID' => $this->input->post('paymentMethodID'), 
			'amountPaid' => $this->input->post('amountPaid'), 
			'formNo' => $this->input->post('formNo'),
			'paymentDate' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
			'referenceNo' => $this->input->post('referenceNo'),
			'payTo' => $this->input->post('payto'),
			'accountDescription' => $this->input->post('accountDescription'),
			'accountID' => $this->input->post('accountID'),
			'paymentDate' => $this->input->post('paymentDate'),
			'projectID' => $this->input->post('projectID')
		);

		 $otherPaymentID = $this->othersPayment_model->insert("comp_payment_others",$datinsert);
		
		if($otherPaymentID > 0){
			
			//$otherPaymentID=$this->othersPayment_model->getLasIdInsert("comp_payment_others");
			$datinsertDetails = array (
			'otherPaymentID' =>  $otherPaymentID,
			'createdBy' => element('role', $this->session->userdata('logged_in')),
			'itemdescription' => $this->input->post('itemdescription'),
			'accountID' => $this->input->post('itemAccountID'),
			'amountIncludedTax' => $this->input->post('amountIncludedTax'),
			'amountExcludedTax' => $this->input->post('amountExcludedTax'),
			'taxID' => $this->input->post('taxID'),
			'taxRate' => $this->input->post('taxRate'),
			'taxAmount' => $this->input->post('amountIncludedTax'),
			'amountIncludedTax' => $this->input->post('amountIncludedTax')
		);
		 $query = $this->othersPayment_model->insert('comp_payment_others_without_item',$datinsertDetails);
		 $detail=$this->othersPayment_model->getLasIdInsert("comp_payment_others_without_item");
		 echo '{"status":"success","paymentID":"'.$otherPaymentID.'","detailID":"'.$detail.'"}';
		}else{
			echo "false";
		}
	}
	
	function savenewpaywithItem(){
		$this->load->model('accountPayable/othersPayment_model');
		$ID = $this->input->post('ID');
		$companyID =  element('role', $this->session->userdata('logged_in')) ;
		$datinsert = array (
			'memo' => $this->input->post('memo'),
			'locationID' => $this->input->post('locationID'), 
			'companyID' => $companyID,
			'createdBy' => element('role', $this->session->userdata('logged_in')),
			'otherPaymentType' => 0,
			'paymentMethodID' => $this->input->post('paymentMethodID'), 
			'amountPaid' => $this->input->post('amountPaid'), 
			'formNo' => $this->input->post('formNo'),
			'paymentDate' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
			'referenceNo' => $this->input->post('referenceNo'),
			'payTo' => $this->input->post('payto'),
			'accountDescription' => $this->input->post('accountDescription'),
			'accountID' => $this->input->post('accountID'),
			'paymentDate' => $this->input->post('paymentDate'),
			'projectID' => $this->input->post('projectID')
		);


		
		 $query = $this->othersPayment_model->insert("comp_payment_others",$datinsert);
		
		
		if($query){
			
			$otherPaymentID=$this->othersPayment_model->getLasIdInsert("comp_payment_others");
			$datinsertDetails = array (
			'otherPaymentID' =>  $otherPaymentID,
			'createdBy' => element('role', $this->session->userdata('logged_in')),
			'itemID' => $this->input->post('itemID'),
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
		 $query = $this->othersPayment_model->insert('comp_payment_others_with_item',$datinsertDetails);
		 $detail=$this->othersPayment_model->getLasIdInsert("comp_payment_others_with_item");
		 echo '{"status":"success","paymentID":"'.$otherPaymentID.'","detailID":"'.$detail.'"}';
		}else{
			echo "false";
		}
	}
	
	function updatepayitemwithitem(){
	$this->load->model('accountPayable/othersPayment_model');
			$data = array (
			'updatedBy' => element('role', $this->session->userdata('logged_in')),
			'itemID' => $this->input->post('itemID'),
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
		echo $query = $this->othersPayment_model->updateByTname($this->input->post('invDetailsId'), $data,
		 'comp_payment_others_with_item');
	}
   
    
	public function otherpay_edit(){
			$this->load->model('accountPayable/othersPayment_model');
		  	$updateuser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$updateuser = $this->othersPayment_model->otherpay_edit($updateuser,$ID);
			if($updateuser){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	//Other Payment With Item List - Farhana
	public function otherpaywithList()
	{
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->lang->load("otherspayment",$this->session->userdata('language'));
		$this->load->model('accountPayable/othersPayment_model');
		$data['datatbls'] = $this->othersPayment_model->otherpayWithItem_all();
		$data['headertbl'] = $this->session->userdata('menuactive');
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('ap/othersPayment/newotherpaywithitemList', '', $data);
	}
   
    //Other Payment Without Item List - Farhana
	public function otherpaywithoutList()
	{
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->lang->load("otherspayment",$this->session->userdata('language'));
		$this->load->model('accountPayable/othersPayment_model');
		$data['datatbls'] = $this->othersPayment_model->otherpayWithoutItem_all();
		$data['headertbl'] = $this->session->userdata('menuactive');
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('ap/othersPayment/newotherpaywithoutitemList', '', $data);
	}

}
