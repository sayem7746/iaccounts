<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchasesetting extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}
		
//-- Supplier	
	public function supplier(){
	  if($this->input->post('mysubmit')){
		$this->load->model('Supplier');	
		  if($this->input->post('fldid')==NULL){
			  $newasset = array(
			  	'fldid'		=> $this->input->post('fldid'), 
			  	'fldsupp_code'		=> $this->input->post('fldsupp_code'), 
			  	'fldsupp_name'		=> $this->input->post('fldsupp_name'), 
			  	'fldsupp_addr'		=> $this->input->post('fldsupp_addr'), 
			  	'fldsupp_addr1'		=> $this->input->post('fldsupp_addr1'), 
			  	'fldsupp_addr2'		=> $this->input->post('fldsupp_addr2'), 
			  	'fldsupp_city'		=> $this->input->post('fldsupp_city'), 
			  	'fldsupp_postcode'		=> $this->input->post('fldsupp_postcode'), 
			  	'fldsupp_state'		=> $this->input->post('fldsupp_state'), 
			  	'fldsupp_country'		=> $this->input->post('fldsupp_country'), 
			  	'fldsupp_phone'		=> $this->input->post('fldsupp_phone'), 
			  	'fldsupp_mobile'		=> $this->input->post('fldsupp_mobile'), 
			  	'fldsupp_fax'		=> $this->input->post('fldsupp_fax'), 
			  	'fldsupp_contactperson'		=> $this->input->post('fldsupp_contactperson'), 
			  	'fldsupp_email'		=> $this->input->post('fldsupp_email'), 
			  	'fldsupp_ap_acc'		=> $this->input->post('fldsupp_ap_acc'), 
			  	'fldsupp_ap_cc'		=> $this->input->post('fldsupp_ap_cc'), 
			  	'fldsupp_create_dt'		=> $this->input->post('order_time'), 
		  		'fldsupp_create_by'		=> element('userid', $this->session->userdata('logged_in')), 
		  	);
		  	$insert_asset = $this->Supplier->supplier_insert($newasset);
			if($insert_asset){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("suppliers_list");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }else{
			$fldid = $this->input->post('fldid');
		  	$update = array(
			  	'fldid'		=> $this->input->post('fldid'), 
			  	'fldsupp_code'		=> $this->input->post('fldsupp_code'), 
			  	'fldsupp_name'		=> $this->input->post('fldsupp_name'), 
			  	'fldsupp_addr'		=> $this->input->post('fldsupp_addr'), 
			  	'fldsupp_addr1'		=> $this->input->post('fldsupp_addr1'), 
			  	'fldsupp_addr2'		=> $this->input->post('fldsupp_addr2'), 
			  	'fldsupp_city'		=> $this->input->post('fldsupp_city'), 
			  	'fldsupp_postcode'		=> $this->input->post('fldsupp_postcode'), 
			  	'fldsupp_state'		=> $this->input->post('fldsupp_state'), 
			  	'fldsupp_country'		=> $this->input->post('fldsupp_country'), 
			  	'fldsupp_phone'		=> $this->input->post('fldsupp_phone'), 
			  	'fldsupp_mobile'		=> $this->input->post('fldsupp_mobile'), 
			  	'fldsupp_fax'		=> $this->input->post('fldsupp_fax'), 
			  	'fldsupp_contactperson'		=> $this->input->post('fldsupp_contactperson'), 
			  	'fldsupp_email'		=> $this->input->post('fldsupp_email'), 
			  	'fldsupp_ap_acc'		=> $this->input->post('fldsupp_ap_acc'), 
			  	'fldsupp_ap_cc'		=> $this->input->post('fldsupp_ap_cc'), 
			  	'fldsupp_modified_dt'		=> $this->input->post('order_time'), 
		  		'fldsupp_modified_by'		=> element('userid', $this->session->userdata('logged_in')), 
		 	);
		  	$update_data = $this->Supplier->supplier_edit($update, $fldid);
			if($update_data){
				echo '<script>alert("Update Success..");
					window.location.replace("suppliers_list");
					</script>';
			}else{
				echo '<script>alert("Update Failed.");
				history.go(-1);</script>';
			}
		  }
	  }else{
		  $id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
		  $this->load->library('layouts');
		  $this->load->helper('form');
		  $this->layouts->set_title('Change Management');
		  $data['our_company'] = 'this is my company';
		  $data['module'] = 'Purchasing';
		  $data['title'] = 'Supplier Master';
 		  $this->load->model('Accmaster');
		  $data['accmaster'] = $this->Accmaster->accmaster_all();
 		  $this->load->model('Subaccmaster');
		  $data['subacc'] = $this->Subaccmaster->subaccmaster_all();
		  $this->load->model('Country');
		  $data['country'] = $this->Country->country_all();
		  $this->layouts->add_includes('js/charts.js')
			->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/maskedinput/jquery.maskedinput.min.js')
			->add_includes('js/uniform/jquery.uniform.min.js');
			
		  if($id != NULL ){
			  $this->load->model('Supplier');
			  $dataloc = $this->Supplier->supplier_id($id);
			  $data['suppmaster'] = $dataloc[0];
			  $this->load->model('State');
			  $data['state'] = $this->State->state_region($dataloc[0]->fldsupp_country);
			  $this->layouts->view('purchasesetting/supplier_edit', array('latest' => 'sidebar/latest'), $data);
		  }else{
			  $this->load->model('State');
			  $data['state'] = $this->State->state_region('458');
			  $this->layouts->view('purchasesetting/supplier', array('latest' => 'sidebar/latest'), $data);
		  }
	  }
	}

	public function suppliers_list(){
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   	$data['module'] = 'Purchasing';
		  	$data['title'] = 'Suppliers Master List';
			$this->load->helper('menu');
			$this->load->model('Supplier');
			$data['datatbls'] = $this->Supplier->supplier_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('purchasesetting/suppliers_list', array('latest' => 'sidebar/latest'), $data);
	}

	public function supplier_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Supplier');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Supplier->supplier_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
	}
// Unit Measure
	public function unitmeasurelist(){
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		 	$data['module'] = 'Purchasing';
		  	$data['title'] = 'Unit Measure List';
			$this->load->helper('menu');
			$this->load->model('Sysum');
			$data['datatbls'] = $this->Sysum->sysum_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('purchasesetting/unitmeasure', array('latest' => 'sidebar/latest'), $data);
	}

	public function um_save(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Sysum');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Sysum->sysum_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	public function um_insert(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Sysum');
			$code = $this->input->post('code');
			$desc = $this->input->post('desc');
			$data = array(
				'code' => $code,
				'desc' => $desc
				);
		  	$query = $this->Sysum->sysum_insert($data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	public function um_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Sysum');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Sysum->sysum_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
	}
	
// Unit Measure Conversion
	public function umconversion(){
	  if($this->input->post('mysubmit')){
		$this->load->model('Sysumconv');	
		  if($this->input->post('fldid')==NULL){
			  $newdata = array(
			  	'from_um'		=> $this->input->post('from_um'), 
			  	'to_um'		=> $this->input->post('to_um'), 
			  	'unitm'		=> $this->input->post('unitm'), 
			  	'factor'		=> $this->input->post('factor'), 
		  		'create_by'		=> element('userid', $this->session->userdata('logged_in')), 
		  	);
		  	$insert_data = $this->Sysumconv->sysumconv_insert($newdata);
			if($insert_data){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("umconversionlist");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }else{
			$fldid = $this->input->post('fldid');
		  	$update = array(
			  	'fldid'		=> $this->input->post('fldid'), 
			  	'from_um'		=> $this->input->post('from_um'), 
			  	'to_um'		=> $this->input->post('to_um'), 
			  	'unitm'		=> $this->input->post('unitm'), 
			  	'factor'		=> $this->input->post('factor'), 
			  	'modified_dt'		=> $this->input->post('order_time'), 
		  		'modified_by'		=> element('userid', $this->session->userdata('logged_in')), 
		 	);
		  	$update_data = $this->Sysumconv->sysumconv_edit($update, $fldid);
			if($update_data){
				echo '<script>alert("Update Success..");
					window.location.replace("suppliers_list");
					</script>';
			}else{
				echo '<script>alert("Update Failed.");
				history.go(-1);</script>';
			}
		  }
	  }else{
		  $id = $this->uri->segment(3);
		  $this->load->library('layouts');
		  $this->load->helper('form');
		  $this->layouts->set_title('Change Management');
		  $data['our_company'] = 'this is my company';
		  $data['module'] = 'Purchasing';
		  $this->load->model('Sysum');
		  $data['unitmeasure'] = $this->Sysum->sysum_all();
		  $this->layouts->add_includes('js/charts.js')
			->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/maskedinput/jquery.maskedinput.min.js')
			->add_includes('js/uniform/jquery.uniform.min.js');
		  if($id != NULL ){
		  	  $data['title'] = 'Unit Conversion Update';
			  $this->load->model('Sysumconv');
			  $dataloc = $this->Sysumconv->sysumconv_id($id);
			  $data['umconv'] = $dataloc[0];
			  $this->layouts->view('purchasesetting/umconversion_edit', array('latest' => 'sidebar/latest'), $data);
		  }else{
		  	  $data['title'] = 'New Unit Conversion';
			  $this->layouts->view('purchasesetting/umconversion', array('latest' => 'sidebar/latest'), $data);
		  }
	  }
	}

	public function umconversionlist(){
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		 	$data['module'] = 'Purchasing';
		  	$data['title'] = 'Unit Measure Conversion List';
			$this->load->helper('menu');
			$this->load->model('Sysum');
			$data['datatblsum'] = $this->Sysum->sysum_all();
			$this->load->model('Sysumconv');
			$data['datatbls'] = $this->Sysumconv->sysumconv_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('purchasesetting/umconversionlist', array('latest' => 'sidebar/latest'), $data);
	}

	public function umconv_save(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Sysumconv');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Sysumconv->sysumconv_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	public function umconv_insert(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Sysumconv');
			$from_um = $this->input->post('from_um');
			$to_um = $this->input->post('to_um');
			$unitm = $this->input->post('unitm');
			$factor = $this->input->post('factor');
			$data = array(
				'from_um' => $from_um,
				'to_um' => $to_um,
				'unit' => $unit,
				'factor' => $factor
				);
		  	$query = $this->Sysumconv->sysumconv_insert($data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	public function umconv_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Sysumconv');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Sysumconv->sysumconv_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
	}
}