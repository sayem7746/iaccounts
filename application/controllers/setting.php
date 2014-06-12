<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('10', 'setup');
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

//Company setup -> chart of accounts by Sayem
	public function chartOfAccountsSetup(){
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->layouts->set_title('iAccount::Chart of Accounts');
		$this->load->model('Chartofaccount');
		
		//Check wheather show dropdown or not
		$data['isShowDropdown'] = $this->Chartofaccount->isShowDropdown(element('compID', $this->session->userdata('logged_in')));
		$data['balance'] = $this->Chartofaccount->getInfo(element('compID', $this->session->userdata('logged_in')),0);
		$data['profitNloss'] = $this->Chartofaccount->getInfo(element('compID', $this->session->userdata('logged_in')),1);
		if($data['isShowDropdown']){
			//Gether data for industry in business selector
			$data['industryInfo'] = $this->Chartofaccount->getdata(element('compID', $this->session->userdata('logged_in')));
		}
		
		
		
		$this->lang->load("comp_chartofaccount",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('masterfile/chartofaccount', array('latest' => 'sidebar/latest'), $data);
	}
//Gather information regarding business type
	public function getTypeInfo(){
		$this->load->model('Chartofaccount');
		echo json_encode($this->Chartofaccount->getTypedata($this->input->post('ID'),$this->input->post('acctClass')));
		exit();
	}
// Company
	public function companysetup()
	{
		if($this->input->post('submit')){
			if($this->input->post('ID')==NULL){
				$companyinfo = array(
			  		'ID'		=> $this->input->post('ID'),
			  		'companyName'		=> $this->input->post('companyName'), 
			  		'companyNo'		=> $this->input->post('companyNo'), 
			  		'incorporateDate'		=> date('Y-m-d', strtotime($this->input->post('incorporateDate'))), 
			  		'phoneNo'		=> $this->input->post('phoneNo'), 
			  		'faxNo'		=> $this->input->post('faxNo'), 
			  		'email'		=> $this->input->post('email'), 
			  		'website'		=> $this->input->post('website'), 
			  		'uploadLogo'		=> $this->input->post('uploadLogo'), 
			  		'currencyID'		=> $this->input->post('currencyID'), 
	  				'createdBy'		=> element('userid', $this->session->userdata('logged_in')), 
	  				'createdTS'		=> $this->input->post('order_time') 
		  		);
				$this->load->model('gallery');
				$this->gallery->do_upload();
				$this->load->model('company/Company_info_model');
		  		$new_companyID = $this->Company_info_model->companyInsert($companyinfo);
				if($new_companyID){
					//on success create default company chart of account
					$this->createCompanyChartOfAccount($new_companyID);
					//createCompanyChartOfAccount($new_companyID);
					echo '<script>alert("Chart of account already exist.'.$result.' "); </script>';

					echo '<script> window.location.replace("'.base_url().'systemGeneral/generalSetup");</script>';
					echo '<script> window.location.replace("'.base_url().'companySetup/formSetup");</script>';
					echo '<script>alert("Insert Data Success..");
						window.location.replace("companyList");
						</script>';
				}else{
					echo '<script>alert("Insert Data Failed.");
						history.go(-1);</script>';
				}
		 	}else{
					$ID = $this->input->post('ID');
		  			$companyinfo = array(
			  			'companyName'		=> $this->input->post('companyName'), 
			  			'companyNo'		=> $this->input->post('companyNo'), 
			  			'incorporateDate'		=> date('Y-m-d', strtotime($this->input->post('incorporateDate'))), 
			  			'phoneNo'		=> $this->input->post('phoneNo'), 
			  			'faxNo'		=> $this->input->post('faxNo'), 
			  			'email'		=> $this->input->post('email'), 
			  			'website'		=> $this->input->post('website'), 
			  			'uploadLogo'		=> $this->input->post('uploadLogo'), 
			  			'currencyID'		=> $this->input->post('currencyID'), 
	  					'updatedBy'		=> element('userid', $this->session->userdata('logged_in')), 
		 			);
					//$this->load->model(company/Company_info_model);
					$this->load->model('/company/Company_info_model');
		  			$update_user = $this->Company_info_model->company_edit($companyinfo, $ID);
					if($update_user){
						echo '<script>alert("Update Success..");
						window.location.replace("companyList");
						</script>';
					}
					else{
						echo '<script>alert("Update Failed.");
						history.go(-1);</script>';
					}
		  		}
	  		} 
			else 
			{     
				$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
				$this->load->library('layouts');
				$this->load->helper('form');
				$this->lang->load("companyInfo",$this->session->userdata('language'));
				$this->load->model('Department');
				$data['deptrec'] = $this->Department->department_all();
				$this->load->model('Section');
				$data['secrec'] = $this->Section->section_all();
				$this->load->model('/company/Company_info_model');
//				$dataum = $this->Company_info_model->companyView($id);
				$this->load->model('Currency');
				$data['currency'] = $this->Currency->currency_all();
				$dataum = $this->Company_info_model->company_id($id);
				$data['umaster'] = $dataum[0];
				$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js');
					
				if($id >= '0')
				{
					$this->layouts->view('masterfile/company_edit', array('latest' => 'sidebar/latest'), $data);
				}
				else
				{
					$this->layouts->view('masterfile/company', array('latest' => 'sidebar/latest'), $data);
				}
			}
	}

//added by akmal 20140530
//to add default chart of account on creating new company
//create groupChart of acct
//insert into table comp_chart_of_acct and get the id
public function createCompanyChartOfAccount () {
	$companyID =  $this->input->post('companyID'); 
	$businessTypeID =  $this->input->post('businessTypeID'); 
	if ($companyID =='' || $companyID ==0 || $businessTypeID=='' || $businessTypeID == 0) {
		echo '<script> alert("Invalid Company and/or Business Type.");
				history.go(-1);
				</script>';
		return;
	}
	$this->load->model('company/Company_info_model');
	$result = $this->createCompanyGroupChartOfAccount($companyID,0,0);
	if ($result) {
		$this->Company_info_model->company_new_ChartOfAccount_insert($companyID, $businessTypeID);
	} else {
		echo '<script> 
		history.go(-1);
		</script>';
}
}


public	 function createCompanyGroupChartOfAccount($companyID,$newParent=0,$parent=0) {
//	public function createCompanyChartOfAccount($companyID=15,$newParent=0,$parent=0) {
		//check if companyid exist = return
		$this->load->model('company/Company_info_model');
		static $checkCompany=0;
		if ($checkCompany ==0){
			$result = $this->Company_info_model->company_groupChartOfAccount_byCompanyID($companyID);
			if($result > 0) {
				echo '<script>alert("Chart of account already exist.'.$result.' "); </script>';
				return false; 
			}
			$checkCompany ++;
		}
		//look for child
		$row = $this->Company_info_model->company_ref_groupChartOfAccount_byParentID($parent);
//		var_dump($row);
		if ($row) {
			foreach ($row as $result) {
				//insert into table group and get the id 
				$data = array('companyID'=>$companyID,
					'acctTypeID'=>$result->acctTypeID,
					'acctGroupName'=>$result->acctGroupName,
					'acctCode'=>$result->acctCode,
					'orderNo'=>$result->orderNo,
					'parentID'=>$newParent,
					'createdBy'=>element('role', $this->session->userdata('logged_in')),
					);
				$newID = $this->Company_info_model->company_new_groupChartOfAccount_insert($data);
				$parent = $result->ID;
				//recursive check parent
				//$this->createCompanyChartOfAccount(
				$this->createCompanyGroupChartOfAccount($companyID,$newID,$parent);
			}
		}
		return true; 
}
//end of create company chart of acct by akmal 20140530 

	public function companyList(){
		$this->lang->load("company",$this->session->userdata('language'));
		$this->load->model('company/Company_info_model');
		$data['datatbls'] = $this->Company_info_model->company_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('masterfile/companylist', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function companydelete(){
		$this->load->model('/company/Company_info_model');
		$deleteuser = array('is_delete' => '1');
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$delete_user = $this->Company_info_model->company_delete($deleteuser, $ID);
		if($delete_user){
			echo '<script>alert("Delete Success..");
			window.location.replace("companyList");
			</script>';
		}else{
			return FALSE;
		}
	}
	
//-- Country

	public function countrylist(){
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
	
	public function country_save(){
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
	
	public function country_delete(){
			$this->load->model('Country');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Country->country_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}

//-- State

	public function statelist(){
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
	
	public function state_save(){
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
	
	public function state_delete(){
			$this->load->model('State');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->State->state_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function getState()
	{
		$region = $this->input->post('region');
    	$this->load->model('State');
    	$data['statelist']=$this->State->state_region($region);
    	print json_encode(array("status"=>"success", "message"=>$data['statelist']));
	}

//-- Location

	public function location(){
			$this->load->model('Location');	
			$this->lang->load("location",$this->session->userdata('language'));
			$data['screenname'] = 'Location Master';
	  		if($this->input->post('mysubmit')){
		  		$newloc = array(
		  				'fldid'	   => $this->input->post('fldid'), 
		  				'code'		=> $this->input->post('code'), 
		  				'desc' => $this->input->post('desc'), 
		  				'address' => $this->input->post('address'), 
		  				'postcode' => $this->input->post('postcode'), 
		  				'city' => $this->input->post('city'), 
		  				'state' => $this->input->post('state'), 
		  				'country' => $this->input->post('country'), 
		  				'phone_no' => $this->input->post('phone_no'), 
		  				'fax_no' => $this->input->post('fax_no'), 
			  			'create_date'		=> $this->input->post('order_time'), 
		  				'create_by'		=> element('userid', $this->session->userdata('logged_in')), 
		  			);
		  		if($this->input->post('fldid')==NULL){
		  			$insert_loc = $this->Location->location_insert($newloc);
					if($insert_loc){
						echo '<script>alert("Insert Data Success..");
						window.location.replace("locationlist");
						</script>';
					}else{
						echo '<script>alert("Insert Data Failed.");
						history.go(-1);</script>';
					}
		 		}else{
					$fldid = $this->input->post('fldid');
		  			$update_loc = $this->Location->location_edit($newloc, $fldid);
					if($update_loc){
						echo '<script>alert("Update Success..");
						window.location.replace("locationlist");
						</script>';
					}else{
						echo '<script>alert("Update Failed.");
						history.go(-1);</script>';
					}
		  		}
			}else{
				$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
				$this->load->library('layouts');
				$this->lang->load("location",$this->session->userdata('language'));
				$this->layouts->set_title('Change Management');
				$data['our_company'] = 'this is my company';
		   		$data['module'] = 'Master File';
		  		$data['title'] = 'Location Master';
				$this->load->model('Country');
				$data['country'] = $this->Country->country_all();
				$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js');
				if($id != NULL){
					$this->load->model('Location');
					$dataloc = $this->Location->location_id($id);
					$data['locmaster'] = $dataloc[0];
					$this->load->model('State');
					$data['state'] = $this->State->state_region($dataloc[0]->country);
					$this->layouts->view('masterfile/location_edit', array('latest' => 'sidebar/latest'), $data);
				}else{
					$this->load->model('State');
					$data['state'] = $this->State->state_region('458');
					$this->layouts->view('masterfile/location', array('latest' => 'sidebar/latest'), $data);
				}
			}
	}

	public function locationlist(){
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->lang->load("location",$this->session->userdata('language'));
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   	$data['module'] = 'Master File';
		  	$data['title'] = 'Location Master List';
			$this->load->helper('menu');
			$this->load->model('Location');
			$data['datatbls'] = $this->Location->location_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('masterfile/locationlist', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function location_save(){
			$this->load->model('Location');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Location->location_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function location_delete(){
			$this->load->model('Location');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Location->location_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}

// Mastercode
	public function masterCodeSetup()
	{
		if($this->input->post('submit')){
			$this->load->model('master/MasterCode_model');
			if($this->input->post('masterCodeSetupID')==NULL){
				$masterCodeSetup = array( 
						'masterID'		=> $this->input->post('masterID'),
						'parentFilterID'		=> $this->input->post('masterCode'),
						'code'		=> $this->input->post('code'),
						'name'		=> $this->input->post('name'),
						'shortName'		=> $this->input->post('shortName'),
						'description'		=> $this->input->post('description'),
						'orderNo'		=> $this->input->post('orderNo'),
		  				'createdBy'		=> element('userid', $this->session->userdata('logged_in')), 
		  				'createdTS'		=> $this->input->post('order_time') 
		  			);
					
		  			$insert_masterCodeSetup = $this->MasterCode_model->masterCodeSetupInsert($masterCodeSetup);
					if($insert_masterCodeSetup){
						echo '<script>alert("Insert Data Success..");
						window.location.replace("masterCodeSetupList");
						</script>';
					}else{
						echo '<script>alert("Insert Data Failed.");
						history.go(-1);</script>';
					}
		 	}else{
					$ID = $this->input->post('masterCodeSetupID');
		  			$masterCodeSetup = array(
						'masterID'		=> $this->input->post('masterID'),
						'parentFilterID'		=> $this->input->post('masterCode'),
						'code'		=> $this->input->post('code'),
						'name'		=> $this->input->post('name'),
						'shortName'		=> $this->input->post('shortName'),
						'description'		=> $this->input->post('description'),
						'orderNo'		=> $this->input->post('orderNo'),
		  				'updateBy'		=> element('role', $this->session->userdata('logged_in')), 
		  			);
					//$this->load->model(company/Company_info_model);
					$this->load->model('master/MasterCode_model');
		  			$update_masterCodeSetup = $this->MasterCode_model->masterCodeSetup_edit($masterCodeSetup, $ID);
					if($update_masterCodeSetup){
						echo '<script>alert("Update Success..");
						window.location.replace("masterCodeSetupList");
						</script>';
					}
					else{
						echo '<script>alert("Update Failed.");
						history.go(-1);</script>';
					}
		  		}
	  		} 
			else 
			{     
				$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
				$this->load->library('layouts');
				$this->load->model('master/MasterCode_model');
				$data['masterName'] = $this->MasterCode_model->master_all();
				if($id){
					$dataum = $this->MasterCode_model->masterCodeSetup_id($id);
					$data['mcmaster'] = $dataum[0];
					$data['masterParent'] = $this->MasterCode_model->mastercode_all_id($dataum[0]->masterID);
				}else{
					$data['mcmaster'] = NULL;
				}
			$this->lang->load("masterCodeSetupList",$this->session->userdata('language'));
				$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js')
					->add_includes('js/datatables/jquery.dataTables.min.js');
					
					$this->layouts->view('admin/masterCodeSetup', array('latest' => 'sidebar/latest'), $data);
				
			}
	}

	public function masterCodeSetupList(){
			$id = $this->input->post('id');
			$this->load->library('layouts');
			$this->lang->load("masterCodeSetupList",$this->session->userdata('language'));
			$this->load->model('master/MasterCode_model');
			$data['datatbls'] = $this->MasterCode_model->mastercode_all();
			
			$data['masterName'] = $this->MasterCode_model->master_all();
			
					$data['ID'] = '';
					$data['mcmaster'] = NULL;
			
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('admin/masterCodeSetupList', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function masterCodeDelete(){
			$this->load->model('master/MasterCode_model');
		  	$deleteuser = array('is_delete' => '1');
			//$ID = $this->input->post('ID');
			//$ID2 = $this->input->get('ID');
			$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
			
		  	$delete_user = $this->MasterCode_model->masterCodeSetupDelete($deleteuser, $ID);
			if($delete_user){
						echo '<script>alert("Delete Success..");
						window.location.replace("masterCodeSetupList");
						</script>';
			}else{
				return FALSE;
			}
	}
	public function mastercode_id(){
		$id = $this->input->post('id');
		$this->load->model('master/MasterCode_model');
		$query = $data['masterName'] = $this->MasterCode_model->masterCodeSetup_masterid($id);
		if($query){
			print json_encode(array(
				"status"=>"success",
				"message"=>$query
				));
		}else{
			print json_encode(array(
				"status"=>"failed",
				"message"=>''
				));
		}
	}
	// Shipto

	public function shiptolist(){
		$id =  element('compID', $this->session->userdata('logged_in'));
		$this->load->library('layouts');
		$this->lang->load("companyshipto",$this->session->userdata('language'));
		$this->load->model('company/company_info_model');
		$this->load->model('company/address_model');
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/datatables/jquery.dataTables.min.js');
		$dataum = $this->company_info_model->companymaster_id($id);
		echo $this->db->last_query(); 
		$data['companymaster'] = $dataum[0];
		$data['datatbls'] = $this->address_model->address_company_all($id);
		$this->layouts->view('company/shiptolist', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function shiptoNew(){
	  $this->load->model('company/address_model');
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newaddress = array(
//			  	'ID' => $this->input->post('ID'),
			  	'companyID' => element('compID', $this->session->userdata('logged_in')),
			  	'line1' => $this->input->post('line1'),
			  	'line2' => $this->input->post('line2'),
			  	'line3' => $this->input->post('line3'),
			  	'city' => $this->input->post('city'),
			  	'postCode' => $this->input->post('postCode'),
			  	'stateID' => $this->input->post('stateID'),
			  	'countryID' => $this->input->post('countryID'),
			  	'createdBy' => element('userid', $this->session->userdata('logged_in')),
//			  	'createdTS' => $this->input->post('order_time')
			  );
		  	$insert_address = $this->address_model->address_insert($newaddress);
			if($insert_address){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("' . base_url() . 'setting/shiptolist/' . $this->input->post('companyID') . '");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }else{
			  $updateaddress = array(
			  	'companyID' => element('compID', $this->session->userdata('logged_in')),
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
				window.location.replace("' . base_url() . 'setting/shiptolist/' . $this->input->post('ID') . '");
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
		$this->load->model('company/company_info_model');
		$this->lang->load("companyshipto",$this->session->userdata('language'));
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->load->model('Country');
		$data['country'] = $this->Country->country_all();
		$this->load->model('State');
		$dataum = $this->company_info_model->companymaster_id($id);
		//echo $this->db->last_query();
		$data['companymaster'] = $dataum[0];
		if($shiptoid){
			$dataum1 = $this->address_model->address_id($shiptoid);
			$data['shiptomaster'] = $dataum1[0];
			$data['state'] = $this->State->state_region($dataum1[0]->countryID);
			$data['id'] = $id;
			$this->layouts->view('company/shipto', array('latest' => 'sidebar/latest'), $data);
		}else{
			$data['shiptomaster'] = NULL;
			$data['state'] = $this->State->state_region('458');
			$data['id'] = $id;
			$this->layouts->view('company/shipto', array('latest' => 'sidebar/latest'), $data);
	  	}
	  }
	}

	public function address_delete(){
		$this->lang->load("companyshipto",$this->session->userdata('language'));
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
	  	$this->load->model('company/address_model');
		$data = array(
			'is_delete'=> 1
		);
		$query = $this->address_model->addressShipToList_delete($data, $ID);
		if($query){
			print json_encode(array("status"=>"success", "message"=>$this->lang->line('success')));
		}else{
			print json_encode(array("status"=>"failed", "message"=>$this->lang->line('failed')));
		}
	}
	
	
	public function refreshShippingMethod(){
		//for ajax call 
		$this->load->model('master/masterCode_model');
		$shippingmethod = $this->masterCode_model->get_all(array('masterID'=>2));
		
		$JsonRecords = '{"records":[';
		
		$n = sizeof($shippingmethod);
		$i= 0;
		if($shippingmethod)
		 foreach($shippingmethod as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"name":"' . $row->name . '","id":"'.$row->ID.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';
		
		//$resul= '{"supplier":['. json_encode($this->supplier_model->suppliermaster_all()).']}';
		 echo $JsonRecords;
	}
	
//End Shipto

}	
/* End of file setting.php */
/* Location: ./application/controller/setting.php */
/* Created By Fadhirul 20/5/2014
				-Shipto  */
