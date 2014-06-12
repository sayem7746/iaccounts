<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('9', 'transaction');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->model('menu');
	}

	public function index()
	{   		
		echo 'default index supplier controller';		
	}
	
	//SupplierNew
	public function SupplierNew()
	{
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newsupplier = array(
			  	'companyID'		=> element('compID', $this->session->userdata('logged_in')), 
			  	'supplierCode'		=> $this->input->post('supplierCode'),
			  	'supplierCompanyNo'		=> $this->input->post('supplierCompanyNo'),
			  	'supplierName'		=> $this->input->post('supplierName'), 
			  	'attention'		=> $this->input->post('attention'), 
			  	'line1'		=> $this->input->post('line1'), 
			  	'line2'		=> $this->input->post('line2'), 
			  	'line3'		=> $this->input->post('line3'), 
			  	'supplierPostCode'		=> $this->input->post('supplierPostCode'), 
			  	'email'		=> $this->input->post('email'), 
			  	'website'		=> $this->input->post('website'), 
			  	'phoneNumber1'		=> $this->input->post('phoneNumber1'),
				'phoneNumber2'		=> $this->input->post('phoneNumber2'), 
				'fax'		=> $this->input->post('fax'),
				'generalNote'		=> $this->input->post('generalNote'),
				'gstRegNo'		=> $this->input->post('gstRegNo'),
				'termsID' => $this->input->post('termsID'),
				'supplierCountryID' => $this->input->post('supplierCountryID'),
				'supplierStateID' => $this->input->post('supplierStateID'),
				'linkedAPAccountID' => $this->input->post('linkedAPAccountID'),
				'currencyID' => $this->input->post('currencyID'),
//createDate from mysql default date
//				'createdDate' => date("Y-m-d", strtotime($this->input->post('createdDate'))),
				'supplierStateID' => $this->input->post('supplierStateID'), 
		  		'supplierCountryID' => $this->input->post('supplierCountryID'),
		  	);
			$this->load->model('supplier/supplier_model');
		  	$insert_user = $this->supplier_model->suppliermaster_insert($newsupplier);
			if($insert_user){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("supplierList");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }
		  else{
			  
			$ID = $this->input->post('ID');
		  	$newsupplier = array(
			  	'supplierCode'		=> $this->input->post('supplierCode'),
			  	'supplierCompanyNo'		=> $this->input->post('supplierCompanyNo'),
			  	'supplierName'		=> $this->input->post('supplierName'), 
			  	'attention'		=> $this->input->post('attention'), 
			  	'line1'		=> $this->input->post('line1'), 
			  	'line2'		=> $this->input->post('line2'), 
			  	'line3'		=> $this->input->post('line3'), 
			  	'supplierPostCode'		=> $this->input->post('supplierPostCode'), 
			  	'email'		=> $this->input->post('email'), 
			  	'website'		=> $this->input->post('website'), 
			  	'phoneNumber1'		=> $this->input->post('phoneNumber1'),
				'phoneNumber2'		=> $this->input->post('phoneNumber2'), 
				'fax'		=> $this->input->post('fax'),
				'generalNote'		=> $this->input->post('generalNote'),
				'gstRegNo'		=> $this->input->post('gstRegNo'),
				'termsID' => $this->input->post('termsID'),
				'supplierCountryID' => $this->input->post('supplierCountryID'),
				'supplierStateID' => $this->input->post('supplierStateID'),
				'linkedAPAccountID' => $this->input->post('linkedAPAccountID'),
				'currencyID' => $this->input->post('currencyID'),
//createDate from mysql default date
//				'createdDate' => date("Y-m-d", strtotime($this->input->post('createdDate'))),
				'supplierStateID' => $this->input->post('supplierStateID'), 
		  		'supplierCountryID' => $this->input->post('supplierCountryID'),
		 	);
			$this->load->model('supplier/supplier_model');
			$insert_user = $this->supplier_model->suppliermaster_edit($newsupplier, $ID);
			echo $this->db->last_query();
			if($insert_user){
				echo '<script>alert("Update Success..");
					window.location.replace("supplierList");
					</script>';
			}else{
				echo '<script>alert("Update Failed.");
				history.go(-1);</script>';
			}
		  }
	  } else {     
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->lang->load("supplier",$this->session->userdata('language'));
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->model('supplier/supplier_model');
		$this->load->model('Currency');
		$data['currency'] = $this->Currency->currency_all();
		$this->load->model('Country');
		$data['country'] = $this->Country->country_all();
		$this->load->model('State');
		//$data['termstatus'] = $this->masterCode_model->get_all($filter);
		$this->load->model('master/masterCode_model');
		$filter['masterID']=1;
		$data['termstatus'] = $this->masterCode_model->get_all($filter);
		$this->load->model('Chartofaccount');
		$data['chartAccounts'] = $this->Chartofaccount->chartofaccount_all();
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
		if($ID >= '0'){
			$dataum = $this->supplier_model->suppliermaster_id($ID);
			$data['suppliermaster'] = $dataum[0];
			$data['state'] = $this->State->state_region($dataum[0]->supplierCountryID);
			$this->layouts->view('supplier/add_new', array('latest' => 'sidebar/latest'), $data);
		}else{
			$data['state'] = $this->State->state_region('458');
			$data['suppliermaster'] = '';
			$this->layouts->view('supplier/add_new', array('latest' => 'sidebar/latest'), $data);
		}
	}
	}
	public function suppliermaster_newform(){
	}

	public function suppliermaster_delete(){
			$this->load->model('supplier/supplier_model');
		  	$deleteuser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$delete_user = $this->supplier_model->suppliermaster_delete($deleteuser, $ID);
			if($delete_user){
				return TRUE;
			}else{
				return FALSE;
			}
	}

	public function suppliermaster_edit(){
			$this->load->model('supplier/supplier_model');
		  	$updateuser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$updateuser = $this->supplier_model->suppliermaster_edit($updateuser,$ID);
			if($updateuser){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	public function supplierList(){
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->load->model('supplier/supplier_model');
		$data['datatbls'] = $this->supplier_model->suppliermaster_all_state();
		$this->lang->load("supplier",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('supplier/list', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function suppliermaster_allopt(){
		$this->load->model('supplier/supplier_model');
		$query = $this->supplier_model->suppliermaster_allopt();
		header('Content-Type: application/json');
        echo json_encode($query);		
		return TRUE;
	}
	
// Shipto

	public function shiptolist(){
		$id = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("suppliershipto",$this->session->userdata('language'));
		$this->load->model('supplier/supplier_model');
		$this->load->model('supplier/address_model');
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/datatables/jquery.dataTables.min.js');
		$dataum = $this->supplier_model->suppliermaster_id($id);
		$data['suppliermaster'] = $dataum[0];
		$data['datatbls'] = $this->address_model->address_supplier_all($id);
		$this->layouts->view('supplier/shiptolist', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function shiptoNew(){
	  $this->load->model('supplier/address_model');
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newaddress = array(
			  	'supplierID' => $this->input->post('supplierID'),
			  	'addressCode' => $this->input->post('addressCode'),
			  	'line1' => $this->input->post('line1'),
			  	'line2' => $this->input->post('line2'),
			  	'line3' => $this->input->post('line3'),
			  	'city' => $this->input->post('city'),
			  	'postCode' => $this->input->post('postCode'),
			  	'stateID' => $this->input->post('stateID'),
			  	'countryID' => $this->input->post('countryID'),
			  	'createdBy' => element('userid', $this->session->userdata('logged_in')),
			  	'createdTS' => $this->input->post('order_time')
			  );
		  	$insert_address = $this->address_model->address_insert($newaddress);
			if($insert_address){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("' . base_url() . 'supplier/shiptolist/' . $this->input->post('supplierID') . '");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }else{
			  $updateaddress = array(
			  	'addressCode' => $this->input->post('addressCode'),
			  	'line1' => $this->input->post('line1'),
			  	'line2' => $this->input->post('line2'),
			  	'line3' => $this->input->post('line3'),
			  	'city' => $this->input->post('city'),
			  	'postCode' => $this->input->post('postCode'),
			  	'stateID' => $this->input->post('stateID'),
			  	'countryID' => $this->input->post('countryID'),
			  	'updatedBy' => element('userid', $this->session->userdata('logged_in')),
			  );
		  	$update_address = $this->address_model->address_edit($updateaddress, $this->input->post('ID'));
			if($update_address){
				echo '<script>alert("Update Data Success..");
				window.location.replace("' . base_url() . 'supplier/shiptolist/' . $this->input->post('supplierID') . '");
				</script>';
			}else{
				echo '<script>alert("Update Data Failed.");
				history.go(-1);</script>';
			}
		  }
	  }else{
		$id = $this->uri->segment(3);
		$shiptoid = $this->uri->segment(4);
		$this->load->library('layouts');
		$this->load->model('supplier/supplier_model');
		$data['supplier'] = $this->supplier_model->suppliermaster_all_state();
		$this->lang->load("suppliershipto",$this->session->userdata('language'));
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->load->model('Country');
		$data['country'] = $this->Country->country_all();
		$this->load->model('State');
		$dataum = $this->supplier_model->suppliermaster_id($id);
		$data['suppliermaster'] = $dataum[0];
		if($shiptoid){
			$dataum1 = $this->address_model->address_id($shiptoid);
			$data['shiptomaster'] = $dataum1[0];
			$data['state'] = $this->State->state_region($dataum1[0]->countryID);
			$data['supplierid'] = $id;
			$this->layouts->view('supplier/shipto', array('latest' => 'sidebar/latest'), $data);
		}else{
			$data['shiptomaster'] = NULL;
			$data['state'] = $this->State->state_region('458');
			$data['supplierid'] = $id;
			$this->layouts->view('supplier/shipto', array('latest' => 'sidebar/latest'), $data);
	  	}
	  }
	}
	
	//used in po trans, debitnote, credit note
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
	
	// USED IN PO TRANSACTION
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

	public function address_delete(){
		$this->lang->load("suppliershipto",$this->session->userdata('language'));
		$id = $this->input->post('ID');
	  	$this->load->model('supplier/address_model');
		$data = array(
			'is_delete'=> 1
		);
		$query = $this->address_model->address_delete($data, $id);
		if($query){
			print json_encode(array("status"=>"success", "message"=>$this->lang->line('success')));
		}else{
			print json_encode(array("status"=>"failed", "message"=>$this->lang->line('failed')));
		}
	}
}
	
/* End of file supplier.php */
/* Location: ./system/controller/supplier.php */

