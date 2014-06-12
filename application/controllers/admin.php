<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
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
		
	}
	
	public function Usermaster()
	{
	  if($this->input->post('mysubmit')){
		  if($this->input->post('fldid')==NULL){
			  $newusermaster = array(
			  	'fldid'		=> $this->input->post('fldid'), 
			  	'userid'		=> $this->input->post('userid'), 
			  	'password'		=> $this->input->post('password'), 
			  	'username'		=> $this->input->post('username'), 
			  	'position'		=> $this->input->post('position'), 
			  	'email'		=> $this->input->post('email'), 
			  	'phone_off'		=> $this->input->post('phone_off'), 
			  	'Phone_mobile'		=> $this->input->post('phone_mobile'), 
			  	'department'		=> $this->input->post('department'), 
			  	'section'		=> $this->input->post('section'), 
			  	'create_dt'		=> $this->input->post('order_time'), 
		  		'create_user'		=> element('userid', $this->session->userdata('logged_in')), 
		  	);
		  	$insert_user = $this->Usermaster->usermaster_insert($newusermaster);
			if($insert_user){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("usermasterlist");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }else{
			$fldid = $this->input->post('fldid');
		  	$newusermaster = array(
		  		'fldid'		=> $this->input->post('fldid'), 
		  		'userid'		=> $this->input->post('userid'), 
		  		'password'		=> $this->input->post('password'), 
		  		'username'		=> $this->input->post('username'), 
		  		'position'		=> $this->input->post('position'), 
		  		'email'		=> $this->input->post('email'), 
		  		'phone_off'		=> $this->input->post('phone_off'), 
		  		'Phone_mobile'		=> $this->input->post('phone_mobile'), 
		  		'department'		=> $this->input->post('department'), 
		  		'section'		=> $this->input->post('section'), 
		  		'modified_dt'		=> $this->input->post('order_time'), 
		  		'modified_user'		=> element('userid', $this->session->userdata('logged_in')), 
		 	);
		  	$insert_user = $this->Usermaster->usermaster_edit($newusermaster, $fldid);
			if($insert_user){
				echo '<script>alert("Update Success..");
					window.location.replace("usermasterlist");
					</script>';
			}else{
				echo '<script>alert("Update Failed.");
				history.go(-1);</script>';
			}
		  }
	  } else {     
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$this->lang->load("usermaster",$this->session->userdata('language'));
		$data['our_company'] = 'this is my company';
	   	$data['module'] = 'Administration';
	  	$data['title'] = 'User Master';
		$this->load->model('Department');
		$data['deptrec'] = $this->Department->department_all();
		$this->load->model('Section');
		$data['secrec'] = $this->Section->section_all();
		$this->load->model('Usermaster');
		$dataum = $this->Usermaster->usermaster_id($id);
		$data['umaster'] = $dataum[0];
		if($this->session->userdata('language') == 'english')
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
		if($this->session->userdata('language') == 'malay')
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-ms.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
		if($id >= '0'){
			$this->layouts->view('admin/usermaster_edit', array('latest' => 'sidebar/latest'), $data);				
		}else{
			$this->layouts->view('admin/usermaster', array('latest' => 'sidebar/latest'), $data);
		}
	}
	}

	public function usermaster_newform(){
			$this->load->model('Usermaster');
	}

	public function usermaster_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Usermaster');
		  	$deleteuser = array('is_delete' => '1');
			$fldid = $this->input->post('fldid');
		  	$delete_user = $this->Usermaster->usermaster_delete($deleteuser, $fldid);
			if($delete_user){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	public function usermasterlist(){
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   	$data['module'] = 'Administration';
		  	$data['title'] = 'User Master List';
			$this->load->helper('menu');
			$this->load->model('Usermaster');
			$data['datatbls'] = $this->Usermaster->usermaster_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('admin/usermasterlist', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function usermaster_allopt(){
		$this->load->model('Usermaster');
		$query = $this->Usermaster->usermaster_allopt();
		header('Content-Type: application/json');
        echo json_encode($query);		
		return TRUE;
	}
	// -- User Access --
	
	public function user_access($id){
	  if($this->input->post('mysubmit')){
	  }else{
		  $this->lang->load("useraccess",$this->session->userdata('language'));
		  $this->load->library('layouts');
		  $this->load->helper('form');
		  $this->layouts->set_title('i-Accounts');
 		  $this->load->model('Useraccess');
		  $data['datatbls'] = $this->Useraccess->useraccess_id($id);
		  $this->load->model('Usermaster');
		  $dataum = $this->Usermaster->usermaster_id($id);
		  $data['umaster'] = $dataum[0];
		  $this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
		  	->add_includes('js/datatables/jquery.dataTables.min.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
		  $this->layouts->view('admin/useraccess', array('latest' => 'sidebar/latest'), $data);
	  }
	}
	
	public function useraccess_update(){
			$this->load->model('Useraccess');
			$fldid = $this->input->post('fldid');
			$dataupdate = array (
				'transaction' => $this->input->post('transaction'),
				'reports' => $this->input->post('reports'),
				'setup' => $this->input->post('setup'),
			);
		  	$query = $this->Useraccess->useraccess_update($fldid, $dataupdate);
    		print json_encode(array("status"=>"success", "message"=>$query));
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	// -- Menu --
	public function menumaster(){
	  		if($this->input->post('mysubmit')){
		  		$newmenu = array(
		  			'code'		=> $this->input->post('code'), 
		  			'name'		=> $this->input->post('name'), 
		  			'parents'		=> $this->input->post('parents'), 
		  			'module'		=> $this->input->post('module'), 
		  			'submenu'		=> $this->input->post('submenu'), 
		  			'urls'		=> $this->input->post('urls'), 
		  			'access'		=> $this->input->post('access'), 
		  			'seq'		=> $this->input->post('seq'), 
		  			'language'		=> 'EN', 
		  		);
				$this->load->model('SysMenu');
		  		$insert_menu = $this->SysMenu->menuMaster_new($newmenu);
				if($insert_menu){
					echo '<script>alert("Insert Data Success..");
					window.location.replace("menumasterlist");
					</script>';
				}else{
					echo '<script>alert("Insert Data Failed.");
					history.go(-1);</script>';
			}
			}else{
				$this->load->library('layouts');
				$this->load->helper('form');
				$this->layouts->set_title('Change Management');
				$data['our_company'] = 'this is my company';
		   		$data['module'] = 'Administration';
		  		$data['title'] = 'Menu Master';
				$this->load->model('SysMenu');
				$data['menupar'] = $this->SysMenu->sysMenu_alls();
				$this->layouts->add_includes('js/charts.js')
					->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js')
					->add_includes('js/maskedinput/jquery.maskedinput.min.js')
					->add_includes('js/charts/jquery.flot.js');
				$this->layouts->view('admin/menumaster', array('latest' => 'sidebar/latest'), $data);
			}
	}

	public function menumasterlist(){
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
		   		$data['module'] = 'Administration';
		  		$data['title'] = 'Menu Master List';
			$this->load->helper('menu');
			$this->load->model('SysMenu');
			$data['datatbls'] = $this->SysMenu->menuMaster();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('admin/menumasterlist', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function menu_save(){
			$this->load->model('SysMenu');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->SysMenu->menuMaster_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function menu_delete(){
			$this->load->model('SysMenu');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->SysMenu->menumaster_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function search(){
		$id = $this->input->post('search_text');
		$length = strlen($id);
		$searchdata = substr($id,1,$length);
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
    function session($langs){
		echo '<script>alert("dd")</script>';
		$this->session->set_userdata('language', $langs);
	}

}

	
/* End of file admin.php */
/* Location: ./application/controller/admin.php */
