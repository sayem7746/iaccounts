<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailt extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}

	public function index()
	{
		
	}
	
	// -- Mail --
	public function newmail(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Mailmaster');	
	  		if($this->input->post('mysubmit')){
		  		if($this->input->post('fldid')==NULL){
		  			$newmail = array(
		  				'ref_no'		=> $this->input->post('ref_no'), 
		  				'title' => $this->input->post('title'), 
		  				'mailt_from' => $this->input->post('mailt_from'), 
		  				'mailt_dt' => date("Y-m-d", strtotime($this->input->post('mailt_dt'))), 
		  				'desc' => $this->input->post('desc'), 
		  				'mailt_rvcdate' => date("Y-m-d", strtotime($this->input->post('mailt_rvcdate'))), 
		  				'mailt_rcv_by' => $this->input->post('mailt_rcv_by'), 
		  				'mailt_type' => $this->input->post('mailt_type'), 
		  			);
		  			$insert_mail = $this->Mailmaster->mail_insert($newmail);
					if($insert_mail){
						echo '<script>alert("Insert Data Success..");
						window.location.replace("maillist");
						</script>';
					}else{
						echo '<script>alert("Insert Data Failed.");
						history.go(-1);</script>';
					}
		 		}else{
		  			$newmail = array(
		  				'ref_no'		=> $this->input->post('ref_no'), 
		  				'title' => $this->input->post('title'), 
		  				'mailt_from' => $this->input->post('mailt_from'), 
		  				'mailt_dt' => date("Y-m-d", strtotime($this->input->post('mailt_dt'))), 
		  				'desc' => $this->input->post('desc'), 
		  				'mailt_rvcdate' => date("Y-m-d", strtotime($this->input->post('mailt_rvcdate'))), 
		  				'mailt_rcv_by' => $this->input->post('mailt_rcv_by'), 
		  				'mailt_type' => $this->input->post('mailt_type'), 
		  			);
					$fldid = $this->input->post('fldid');
		  			$insert_mail = $this->Mailmaster->mail_edit($newmail, $fldid);
					if($insert_mail){
						echo '<script>alert("Update Success..");
						window.location.replace("maillist");
						</script>';
					}else{
						echo '<script>alert("Update Failed.");
						history.go(-1);</script>';
					}
		  		}
	  		}else{
				$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
				$this->load->library('layouts');
				$this->layouts->set_title('Change Management');
				$data['our_company'] = 'this is my company';
	   			$data['module'] = 'Mails Management';
	  			$data['title'] = 'New Mail';
				$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js');
				$this->load->model('Usermaster');
				$data['usermaster'] = $this->Usermaster->usermaster_all();
				$this->load->model('Mailtype');
				$data['mailtype'] = $this->Mailtype->mailtype_all();
				if($id >= '0'){
					$datamail = $this->Mailmaster->mail_id($id);
					$data['mailmaster'] = $datamail[0];
					$this->layouts->view('mail/mailedit', array('latest' => 'sidebar/latest'), $data);
				}else{
					$this->layouts->view('mail/newmail', array('latest' => 'sidebar/latest'), $data);
				}
			}

		}
	}
	
	public function maildetails(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Mailmaster');	
	  		if($this->input->post('mysubmit')){
		  		if($this->input->post('fldid')==NULL){
		  			$newmail = array(
		  				'ref_no'		=> $this->input->post('ref_no'), 
		  				'title' => $this->input->post('title'), 
		  				'mailt_from' => $this->input->post('mailt_from'), 
		  				'mailt_dt' => date("Y-m-d", strtotime($this->input->post('mailt_dt'))), 
		  				'desc' => $this->input->post('desc'), 
		  				'mailt_rvcdate' => date("Y-m-d", strtotime($this->input->post('mailt_rvcdate'))), 
		  				'mailt_rcv_by' => $this->input->post('mailt_rcv_by'), 
		  				'mailt_type' => $this->input->post('mailt_type'), 
		  			);
		  			$insert_mail = $this->Mailmaster->mail_insert($newmail);
					if($insert_mail){
						echo '<script>alert("Insert Data Success..");
						window.location.replace("maillist");
						</script>';
					}else{
						echo '<script>alert("Insert Data Failed.");
						history.go(-1);</script>';
					}
		 		}else{
		  			$newmail = array(
		  				'ref_no'		=> $this->input->post('ref_no'), 
		  				'title' => $this->input->post('title'), 
		  				'mailt_from' => $this->input->post('mailt_from'), 
		  				'mailt_dt' => date("Y-m-d", strtotime($this->input->post('mailt_dt'))), 
		  				'desc' => $this->input->post('desc'), 
		  				'mailt_rvcdate' => date("Y-m-d", strtotime($this->input->post('mailt_rvcdate'))), 
		  				'mailt_rcv_by' => $this->input->post('mailt_rcv_by'), 
		  				'mailt_type' => $this->input->post('mailt_type'), 
		  			);
					$fldid = $this->input->post('fldid');
		  			$insert_mail = $this->Mailmaster->mail_edit($newmail, $fldid);
					if($insert_mail){
						echo '<script>alert("Update Success..");
						window.location.replace("maillist");
						</script>';
					}else{
						echo '<script>alert("Update Failed.");
						history.go(-1);</script>';
					}
		  		}
	  		}else{
				$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
				$this->load->library('layouts');
				$this->layouts->set_title('Change Management');
				$data['our_company'] = 'this is my company';
	   			$data['module'] = 'Mails Management';
	  			$data['title'] = 'Mail Details';
				$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js');
				$this->load->model('Usermaster');
				$data['usermaster'] = $this->Usermaster->usermaster_all();
				$this->load->model('Mailtype');
				$data['mailtype'] = $this->Mailtype->mailtype_all();
				if($id >= '0'){
					$datamail = $this->Mailmaster->mail_id($id);
					$data['mailmaster'] = $datamail[0];
					$this->layouts->view('mail/maildetails', array('latest' => 'sidebar/latest'), $data);
				}else{
					echo '<script>alert("Update Failed."); history.go(-1);</script>';				
				}
			}

		}
	}

	public function maillist(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
	   		$data['module'] = 'Mails Management';
	  		$data['title'] = 'Mails List';
			$this->load->model('Mailmaster');
			$data['datatbls'] = $this->Mailmaster->mail_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('mail/maillist', array('latest' => 'sidebar/latest'), $data);
		}
	}

	public function mail_save(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Mailmaster');
			$code = isset($_REQUEST['code'])?$_REQUEST['code']:"";
			$fieldname = isset($_REQUEST['fieldname'])?$_REQUEST['fieldname']:"";
			$value = isset($_REQUEST['content'])?$_REQUEST['content']:"";
			
			$data = array($fieldname=>$value);
		  	$query = $this->Mailtype->mailtype_edit($data, $code);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	public function mail_delete(){
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		} else {
			$this->load->model('Mailmaster');
			$fldid = isset($_REQUEST['id'])?$_REQUEST['id']:"";
		  	$delete_menu = $this->Mailmaster->menumaster_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
	}
	
}	
?>