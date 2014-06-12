<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//by en hilmi 20140519
class Address extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
			$this->load->library('layouts');
		$this->load->model('menu');
	}

	public function index()
	{   		
		echo 'default index address controller';		
	}
	//-- Country

	public function countrylist(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   	$data['module'] = 'Master File';
		  	$data['title'] = 'Country Master List';
			$this->load->helper('menu');
			$this->load->model('Country');
			$data['datatbls'] = $this->Country->country_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('masterfile/countrylist', array('latest' => 'sidebar/latest'), $data);
		}
	}
	
	public function country_save(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Country');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Country->country_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	public function country_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Country');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Country->country_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
	}

//-- State

	public function statelist(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   	$data['module'] = 'Master File';
		  	$data['title'] = 'State Master List';
			$this->load->helper('menu');
			$this->load->model('State');
			$data['datatbls'] = $this->State->state_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('masterfile/statelist', array('latest' => 'sidebar/latest'), $data);
		}
	}
	
	public function state_save(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('State');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->State->state_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	public function state_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('State');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->State->state_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
	}
	
	public function getState()
	{
		$region = $this->input->post('region');
    	$this->load->model('State');
    	$data['statelist']=$this->State->state_region($region);
    	print json_encode(array("status"=>"success", "message"=>$data['statelist']));
	}

    //Address Setup
	public function AddressSetup()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newaddress = array(
				'ID'=> $this->input->post('ID'), 
			  	'supplierID'=> $this->input->post('supplierID'), 
			  	'addressName'=> $this->input->post('addressName'), 
			  	'line1'=> $this->input->post('line1'),
				'line2'=> $this->input->post('line2'),
				'line3'=> $this->input->post('line2'),
			  	'city'=> $this->input->post('city'), 
			  	'postCode'=> $this->input->post('postCode'),
				'stateID' => $this->input->post('stateID'), 
		  		'countryID' => $this->input->post('countryID'),
				'createdBy'=> $this->input->post('createdBy'),
				'updatedBy'=> $this->input->post('updatedBy'),
				 
		  	);
			$this->load->model('supplier/address_model');
		  	$insert_address = $this->address_model->address_insert($newaddress);
			if($insert_address){
				echo '<script>alert("Insert Address Success..");
				window.location.replace("addressmasterlist");
				</script>';
			}else{
				echo '<script>alert("Insert Address Failed.");
				history.go(-1);</script>';
			}
		  }
		  else{
			  
			$ID = $this->input->post('ID');
		  	$newaddress = array(
			  	'ID'=> $this->input->post('ID'), 
			  	'supplierID'=> $this->input->post('supplierID'), 
			  	'addressName'=> $this->input->post('addressName'), 
			  	'line1'=> $this->input->post('line1'),
				'line2'=> $this->input->post('line2'),
				'line3'=> $this->input->post('line3'),
			  	'city'=> $this->input->post('city'), 
			  	'postCode'=> $this->input->post('postCode'),
				'stateID' => $this->input->post('stateID'), 
		  		'countryID' => $this->input->post('countryID'),
				'createdBy'=> $this->input->post('createdBy'),
				'updatedBy'=> $this->input->post('updatedBy'),
		  	);  
			$this->load->model('supplier/address_model');
			$insert_address = $this->address_model->address_edit($newaddress, $ID);
			if($insert_address){
				echo '<script>alert("Update Address Success..");
					window.location.replace("addressmasterlist");
					</script>';
			}else{
				echo '<script>alert("Update Adrress Failed.");
				history.go(-1);</script>';
			}
		  }
	  } else {     
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->lang->load("customer",$this->session->userdata('language'));
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$data['our_company'] = 'this is my company';
	   	$data['module'] = 'Administration';
	  	$data['title'] = 'Address Master';
		$this->load->model('supplier/address_model');
		$this->load->model('Country');
		$data['country'] = $this->Country->country_all();
		$this->load->model('State');
		$data['state'] = $this->State->state_region('458');
		$dataum = $this->address_model->address_id($ID);
		$data['umaster'] = $dataum[0];
		$this->layouts->add_includes('js/charts.js')
			->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/maskedinput/jquery.maskedinput.min.js')
			->add_includes('js/noty/jquery.noty.js')
			->add_includes('js/noty/layouts/topCenter.js')
			->add_includes('js/noty/layouts/topLeft.js')
			->add_includes('js/noty/layouts/topRight.js')
			->add_includes('js/noty/themes/default.js')
			->add_includes('js/charts/jquery.flot.js');
	
		echo "ini user master";
			
		if($ID >= '0'){
			$this->layouts->view('address/addressmaster_edit', array('latest' => 'sidebar/latest'), $data);				
		}else{
			$this->layouts->view('address/addressmaster', array('latest' => 'sidebar/latest'), $data);
		}
	}
	  }
	}
	public function address_newform(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('supplier/address_model');
			
		}
	}

	public function address_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('supplier/address_model');
		  	$deleteuser = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$delete_user = $this->address_model->address_delete($deleteuser, $ID);
			if($delete_user){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	public function address_edit(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('supplier/address_model');
		  	$editaddress = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$editaddress = $this->address_model->address_edit($editaddress,$ID);
			if($editaddress){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	public function addressmasterlist(){
			//$addressCategory = $this->input->post('addressCategory');
		$this->load->helper('form');
			$addressCategory = $this->uri->segment(3);
			$this->lang->load("address",$this->session->userdata('language'));
			$tableName = $this->getTableName($addressCategory);	
			$this->load->model('address_model');
			$data['addressCategory']= $addressCategory;
			$data['datatbls'] = $this->address_model->get_all($tableName);
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('address/addressmasterlist', array('latest' => 'sidebar/latest'), $data);
	}

	public function getTableName($type) {
			switch ($type) {
				case 2 : return 'customer_address';
					break;
				case 3 : return 'supplier_address';
					break;
				default : return 'comp_address';
			}
	}
}

	
?>