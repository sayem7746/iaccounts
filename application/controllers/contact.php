<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
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

    //Supplier Contact Setup
	public function ContactSetup()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newcontact = array(
			  	'ID'=> $this->input->post('ID'), 
			  	'supplierID'=> $this->input->post('supplierID'), 
			  	'personID'=> $this->input->post('personID'), 
			  	'position'=> $this->input->post('position'),
			 
		  	);
			$this->load->model('supplier/contact_model');
		  	$insert_contact= $this->contact_model->contact_insert($newcontact);
			if($insert_contact){
				echo '<script>alert("Insert Contact Success..");
				window.location.replace("contactmasterlist");
				</script>';
			}else{
				echo '<script>alert("Insert Contact Failed.");
				history.go(-1);</script>';
			}
		  }
		  else{
			  
			$ID = $this->input->post('ID');
		  	$newcontact = array(
			  	'ID'=> $this->input->post('ID'), 
			  	'supplier'=> $this->input->post('supplierID'), 
			  	'person'=> $this->input->post('personID'), 
			  	'position'=> $this->input->post('position'),
		  	);  
			$this->load->model('supplier/contact_model');
			$insert_address = $this->contact_model->contact_edit($newcontact, $ID);
			if($insert_contact){
				echo '<script>alert("Update Contact Success..");
					window.location.replace("contactmasterlist");
					</script>';
			}else{
				echo '<script>alert("Update Contact Failed.");
				history.go(-1);</script>';
			}
		  }
	  } else {     
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$data['our_company'] = 'this is my company';
	   	$data['module'] = 'Administration';
	  	$data['title'] = 'Contact Master';
		$this->load->model('supplier/contact_model');
		$this->load->model('Country');
		$data['country'] = $this->Country->country_all();
		$this->load->model('State');
		$data['state']=$this->State->state_all();
		$dataum = $this->contact_model->contact_id($ID);
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
			$this->layouts->view('supplier/contactmaster_edit', array('latest' => 'sidebar/latest'), $data);				
		}else{
			$this->layouts->view('supplier/contactmaster', array('latest' => 'sidebar/latest'), $data);
		}
	}
	  }
	}
	//public function address_newform(){
		//if(!$this->session->userdata('logged_in')){
			//redirect('login');
		//} else {
			//$this->load->model('supplier/address_model');
			
		//}
	//}

	public function contact_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('supplier/contact_model');
		  	$deletecontact = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$delete_user = $this->contact_model->contact_delete($deletecontact, $ID);
			if($delete_contact){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	public function contact_edit(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('supplier/contact_model');
		  	$updatecontact = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$updatecontact = $this->contact_model->contact_edit($updatecontact,$ID);
			if($updatecontact){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	public function contactmasterlist(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   	$data['module'] = 'contactmasterlist';
		  	$data['title'] = 'Contact Master List';
			$this->load->helper('menu');
			$this->load->model('supplier/contact_model');
			$data['datatbls'] = $this->contact_model->contact_all();
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('supplier/contactmasterlist', array('latest' => 'sidebar/latest'), $data);
		}
	}
	
	public function search(){
		$ID = $this->input->post('search_text');
		$length = strlen($ID);
		$searchdata = substr($ID,1,$length);
		switch ($id[0]){
			case 'A':
				echo '<script>window.location.replace("'.base_url().'assetmanagement/asset_details2/'.$searchdata.'")</script>';
			break;
			case 'M':
				$this->load->model('SysMenu');
		  		$query = $this->SysMenu->menuMaster_menu($searchdata);
				echo '<script>window.location.replace("'.base_url().''.$query[0]->urls.'")</script>';
			break;
		}
	}


}
    
	
?>