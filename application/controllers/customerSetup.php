<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CustomerSetup extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}

	public function index()
	{   		
		echo 'default index supplier controller';		
	}
	
	//--Customer New--\\
	public function CustomerNew()
	{
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newcustomer = array(
			  	'ID'		=> $this->input->post('ID'), 
			  	'companyID'		=> element('compID', $this->session->userdata('logged_in')), 
			  	'customerName'		=> $this->input->post('customerName'), 
			  	'accountCode'		=> $this->input->post('accountCode'),
				'line1'		=> $this->input->post('line1'),
				'line2'		=> $this->input->post('line2'),
				'city'		=> $this->input->post('city'),
				'customerPostCode'		=> $this->input->post('customerPostCode'),
				'customerStateID'		=> $this->input->post('customerStateID'),
				'customerCountryID'		=> $this->input->post('customerCountryID'),
				'attention'		=> $this->input->post('attention'),
				'website'		=> $this->input->post('website'),
				'phoneNumber1'		=> $this->input->post('phoneNumber1'),
				'phoneNumber2'		=> $this->input->post('phoneNumber2'),
				'fax'		=> $this->input->post('fax'),
				'email'		=> $this->input->post('email'),
				'position'		=> $this->input->post('position'),
				
		
		  	);
			$this->load->model('customer/customer_model');
		  	$insert_user = $this->customer_model->customermaster_insert($newcustomer);
			if($insert_user){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("customerlist");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }
		  else{
			$ID = $this->input->post('ID');
		  	$newcustomer = array(
				'ID'		=> $this->input->post('ID'), 
			  	'companyID'		=> element('compID', $this->session->userdata('logged_in')), 
			  	'customerName'		=> $this->input->post('customerName'), 
			  	'accountCode'		=> $this->input->post('accountCode'),
				'line1'		=> $this->input->post('line1'),
				'line2'		=> $this->input->post('line2'),
				'city'		=> $this->input->post('city'),
				'customerPostCode'		=> $this->input->post('customerPostCode'),
				'customerStateID'		=> $this->input->post('customerStateID'),
				'customerCountryID'		=> $this->input->post('customerCountryID'),
				'attention'		=> $this->input->post('attention'),
				'website'		=> $this->input->post('website'),
				'phoneNumber1'		=> $this->input->post('phoneNumber1'),
				'phoneNumber2'		=> $this->input->post('phoneNumber2'),
				'fax'		=> $this->input->post('fax'),
				'email'		=> $this->input->post('email'),
				'position'		=> $this->input->post('position'),
			
		  	);
			$this->load->model('customer/customer_model');
			$insert_user = $this->customer_model->customermaster_edit($newcustomer, $ID);
			if($insert_user){
				echo '<script>alert("Update Success..");
					window.location.replace("customerlist");
					</script>';
			}else{
				echo '<script>alert("Update Failed.");
				history.go(-1);</script>';
			}
		  }
		   } else {     
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->lang->load("customer",$this->session->userdata('language'));
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->model('customer/customer_model');
		$this->load->model('Country');
		$data['country'] = $this->Country->country_all();
		$this->load->model('State');
	
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			
		if($ID >= '0'){
			$dataum = $this->customer_model->customermaster_id($ID);
			$data['customermaster'] = $dataum[0];
			$data['state'] = $this->State->state_region($dataum[0]->customerCountryID);
			$this->layouts->view('customer/add_new', array('latest' => 'sidebar/latest'), $data);
		}else{
			$data['state'] = $this->State->state_region('458');
			$data['customermaster'] = '';
			$this->layouts->view('customer/add_new', array('latest' => 'sidebar/latest'), $data);
		}
						
			}
	}
	public function customermaster_delete(){
			$this->load->model('customer/customer_model');
		  	$deleteuser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$delete_user = $this->customer_model->customermaster_delete($deleteuser, $ID);
			if($delete_user){
				return TRUE;
			}else{
				return FALSE;
			}
	}

	public function customermaster_edit(){
			$this->load->model('customer/customer_model');
		  	$updateuser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$updateuser = $this->customer_model->customermaster_edit($updateuser,$ID);
			if($updateuser){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	public function customerList(){
		$this->load->library('layouts');
		$this->load->model('customer/customer_model');
		$data['datatbls'] = $this->customer_model->customermaster_all();
		$this->lang->load("customer",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('customer/list', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function customermaster_allopt(){
		$this->load->model('customer/customer_model');
		$query = $this->customer_model->customermaster_allopt();
		header('Content-Type: application/json');
        echo json_encode($query);		
		return TRUE;
	}
	
	// Shipto

	public function shiptolist(){
		$id = $this->uri->segment(3);
		$this->load->library('layouts');
		$this->lang->load("customershipto",$this->session->userdata('language'));
		$this->load->model('customer/customer_model');
		$this->load->model('customer/address_model');
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/datatables/jquery.dataTables.min.js');
		$dataum = $this->customer_model->customermaster_id($id);
		$data['customermaster'] = $dataum[0];
		$data['datatbls'] = $this->address_model->address_customer_all($id);
		$this->layouts->view('customer/shiptolist', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function shiptoNew(){
	  $this->load->model('customer/address_model');
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newaddress = array(
			  	'customerID' => $this->input->post('customerID'),
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
				window.location.replace("' . base_url() . 'CustomerSetup/shiptolist/' . $this->input->post('customerID') . '");
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
				window.location.replace("' . base_url() . 'CustomerSetup/shiptolist/' . $this->input->post('customerID') . '");
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
		$this->load->model('customer/customer_model');
		$data['customer'] = $this->customer_model->customermaster_all_state();
		$this->lang->load("customershipto",$this->session->userdata('language'));
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->load->model('Country');
		$data['country'] = $this->Country->country_all();
		$this->load->model('State');
		$dataum = $this->customer_model->customermaster_id($id);
		$data['customermaster'] = $dataum[0];
		if($shiptoid){
			$dataum1 = $this->address_model->address_id($shiptoid);
			$data['shiptomaster'] = $dataum1[0];
			$data['state'] = $this->State->state_region($dataum1[0]->countryID);
			$data['customerid'] = $id;
			$this->layouts->view('customer/shipto', array('latest' => 'sidebar/latest'), $data);
		}else{
			$data['shiptomaster'] = NULL;
			$data['state'] = $this->State->state_region('458');
			$data['customerid'] = $id;
			$this->layouts->view('customer/shipto', array('latest' => 'sidebar/latest'), $data);
	  	}
	  }
	}

	public function address_delete(){
		$this->lang->load("customershipto",$this->session->userdata('language'));
		$id = $this->input->post('ID');
	  	$this->load->model('customer/address_model');
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
//End Ship to	
	
}

/* End of file customerSetup.php */
/* Location: ./system/controller/customerSetup.php */
/* Created By Fadhirul 20/05/2014
				- Ship to */

	 