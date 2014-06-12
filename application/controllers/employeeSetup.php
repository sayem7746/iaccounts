<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EmployeeSetup extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}

	public function index()
	{   		
		echo 'default index supplier controller';		
	}
	
	//--Employee New--\\
	public function EmployeeNew()
	{
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newemployee = array(
			  	'ID'		=> $this->input->post('ID'),
				'companyID'		=> element('compID', $this->session->userdata('logged_in')), 
			  	'employeeCode'		=> $this->input->post('employeeCode'), 
			  	'employeeName'		=> $this->input->post('employeeName'), 
				'line1'		=> $this->input->post('line1'),
				'line2'		=> $this->input->post('line2'),
				'line3'		=> $this->input->post('line3'),
				'postCode'		=> $this->input->post('postCode'),
				'city'		=> $this->input->post('city'),
				'stateID'		=> $this->input->post('stateID'),
				'countryID'		=> $this->input->post('countryID'),
				'phoneNo'		=> $this->input->post('phoneNo'),
				'email'		=> $this->input->post('email'),
				'dateOfJoin'		=> $this->input->post('dateOfJoin'),
				'gender'		=> $this->input->post('gender'),
				'createdBy'		=> $this->input->post('createdBy'),
				'updatedBy'		=> $this->input->post('updatedBy'),
				
		
		  	);
			$this->load->model('employee/employee_model');
		  	$insert_user = $this->employee_model->employeemaster_insert($newemployee);
			if($insert_user){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("employeelist");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }
		  else{
			$ID = $this->input->post('ID');
		  	$newemployee = array(
				'ID'		=> $this->input->post('ID'), 
			  	'employeeCode'		=> $this->input->post('employeeCode'), 
			  	'employeeName'		=> $this->input->post('employeeName'), 
				'line1'		=> $this->input->post('line1'),
				'line2'		=> $this->input->post('line2'),
				'line3'		=> $this->input->post('line3'),
				'postCode'		=> $this->input->post('postCode'),
				'city'		=> $this->input->post('city'),
				'stateID'		=> $this->input->post('stateID'),
				'countryID'		=> $this->input->post('countryID'),
				'phoneNo'		=> $this->input->post('phoneNo'),
				'email'		=> $this->input->post('email'),
				'dateOfJoin'		=> $this->input->post('dateOfJoin'),
				'gender'		=> $this->input->post('gender'),
				'createdBy'		=> $this->input->post('createdBy'),
				'updatedBy'		=> $this->input->post('updatedBy'),
			
		  	);
			$this->load->model('employee/employee_model');
			$insert_user = $this->employee_model->employeemaster_edit($newemployee, $ID);
			if($insert_user){
				echo '<script>alert("Update Success..");
					window.location.replace("employeelist");
					</script>';
			}else{
				echo '<script>alert("Update Failed.");
				history.go(-1);</script>';
			}
		  }
		   } else {     
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->lang->load("employee",$this->session->userdata('language'));
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->model('employee/employee_model');
		$this->load->model('Country');
		$data['country'] = $this->Country->country_all();
		$this->load->model('State');
		$this->load->model('master/masterCode_model');
		$filter['masterID']=5;
		$data['gender'] = $this->masterCode_model->get_all($filter);;
	
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			
		if($ID >= '0'){
			$dataum = $this->employee_model->employeemaster_id($ID);
			$data['employeemaster'] = $dataum[0];
			$data['state'] = $this->State->state_region($dataum[0]->countryID);
			$this->layouts->view('employee/add_new', array('latest' => 'sidebar/latest'), $data);
		}else{
			$data['state'] = $this->State->state_region('458');
			$data['employeemaster'] = '';
			$this->layouts->view('employee/add_new', array('latest' => 'sidebar/latest'), $data);
		}
						
			}
	}
	public function employeemaster_delete(){
			$this->load->model('employee/employee_model');
		  	$deleteuser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$delete_user = $this->employee_model->employeemaster_delete($deleteuser, $ID);
			if($delete_user){
				return TRUE;
			}else{
				return FALSE;
			}
	}

	public function employeemaster_edit(){
			$this->load->model('employee/employee_model');
		  	$updateuser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$updateuser = $this->employee_model->employeemaster_edit($updateuser,$ID);
			if($updateuser){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	public function employeeList(){
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->load->model('employee/employee_model');
		$data['datatbls'] = $this->employee_model->employeemaster_all();
		$this->lang->load("employee",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('employee/list', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function employeemaster_allopt(){
		$this->load->model('employee/employee_model');
		$query = $this->employee_model->employeermaster_allopt();
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
//		$shiptoid = $this->uri->segment(4);
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

		//IS Used in PO Transaction
  	public function refreshEmployee(){
			//for ajax call 
		$this->load->model('employee/employee_model');
		$employee = $this->employee_model->employeemaster_allopt();
			
		$JsonRecords = '{"records":[';
		
		$n = sizeof($employee);
		$i= 0;
		 foreach($employee as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"employeeName":"' . $row->employeeName . '","id":"'.$row->ID.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';
		
		
		 echo $JsonRecords;	
	}

	
}

/* End of file customerSetup.php */
/* Location: ./system/controller/customerSetup.php */
/* Created By Fadhirul 20/05/2014
				- Ship to */

	 