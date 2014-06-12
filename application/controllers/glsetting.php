<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glsetting extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('1', 'setup');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->model('menu');
	}

// - Accounts	
	public function accmasterlist(){
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->layouts->set_title('Change Management');
			$data['our_company'] = 'this is my company';
			$data['module'] = 'General Ledger';
			$data['title'] = 'Account Master List';
			$this->load->helper('menu');
			$this->load->model('Accmaster');
			$data['datatbls'] = $this->Accmaster->accmaster_all();
			$data['headertbl'] = $this->session->userdata('menuactive');
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('glsetting/accmasterlist', array('latest' => 'sidebar/latest'), $data);
	}

	public function accmaster_save(){
			$this->load->model('Accmaster');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Accmaster->accmaster_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function accmaster_delete(){
			$this->load->model('Accmaster');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Accmaster->accmaster_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}

// Financial Calendar
	public function financialCalendarCheck_yearperiod()
	{
		$this->load->model('Compfinancialyear');
		$query = $this->Compfinancialyear->financialYear_yearperiod($this->input->post('financialYear'),$this->input->post('period'));
		$startdate = date("d-m-Y", strtotime($query[0]->startDate));
		$enddate = date("d-m-Y", strtotime($query[0]->endDate));
		$ID = $query[0]->ID;
		
		if($query>0){
			print json_encode(array(
				"status"=>"false", 
				"message1"=>$query , 
				"startDate"=>$startdate,
				"endDate"=>$enddate,
				"ID"=>$ID
				));
		}
		else{
			print json_encode(array("status"=>"success", "message2"=>$query));
		}
	}
	
	public function calendar()
	{
	  		if($this->input->post('submit')){
				$this->load->model('Compfinancialyear');
		  	 if($this->input->post('fcID')==NULL){	
				$query=$this->Compfinancialyear->startEndDateCheck_startDateEndDate();
				if(!$query){
			  		$financialCalendar = array(
			  			'ID'		=> $this->input->post('ID'), 
			  			'companyID'		=> element('compID', $this->session->userdata('logged_in')), 
			  			'financialYear'		=> $this->input->post('financialYear'),
						'period'		=> $this->input->post('period'),
						'startDate'		=> date('Y-m-d', strtotime($this->input->post('startDate'))), 
			  			'endDate'		=> date('Y-m-d', strtotime($this->input->post('endDate'))),
//		  				'createdID'		=> element('userid', $this->session->userdata('logged_in')), 
		  			);
		  			$insert_calendar = $this->Compfinancialyear->financialCalendarInsert($financialCalendar);
					if($insert_calendar){
						echo '<script>alert("Insert Data Success..");
						window.location.replace("financialCalendarList");
						</script>';
					}else{
						echo '<script>alert("Insert Data Failed.");
						history.go(-1);</script>';
					}
				}
				else{
					echo '<script>alert("You enter the wrong period of date.");
						history.go(-1);</script>';
				} // if !$query
		  		}
				else
				{
					$ID = $this->input->post('fcID');
		  			$financialCalendar = array(
			  			'financialYear'		=> $this->input->post('financialYear'),
						'period'		=> $this->input->post('period'),
						'startDate'		=> date('Y-m-d', strtotime($this->input->post('startDate'))), 
			  			'endDate'		=> date('Y-m-d', strtotime($this->input->post('endDate'))),
//		  				'createdID'		=> element('userid', $this->session->userdata('logged_in')), 
		  			);
					//$this->load->model(company/Company_info_model);
					$this->load->model('Compfinancialyear');
		  			$update_calendar = $this->Compfinancialyear->financialCalendar_edit($financialCalendar, $ID);
					if($update_calendar){
						echo '<script>alert("Update Success..");
						window.location.replace("financialCalendarList");
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
				$this->lang->load("companyFinancialCalendar",$this->session->userdata('language'));
				$this->load->model('Compfinancialyear');
				if($id){
					$dataum = $this->Compfinancialyear->financialCalendar_id($id);
					$data['fycmaster'] = $dataum[0];
				}else{
					$data['fycmaster'] = NULL;
				}
				$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js');
					
				$this->layouts->view('gl/setups/companyFinancialCalendar', array('latest' => 'sidebar/latest'), $data);
			}
	}
	public function financialCalendarDelete(){
			$this->load->model('Compfinancialyear');
		  	$deleteuser = array('is_delete' => '1');
			$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
			
		  	$delete_user = $this->Compfinancialyear->financialCalendar_delete($deleteuser, $ID);
			if($delete_user){
						echo '<script>alert("Delete Success..");
						window.location.replace("financialCalendarList");
						</script>';
			}else{
				return FALSE;
			}
	}
	public function financialCalendarList(){
			$this->load->library('layouts');
			$this->lang->load("companyFinancialCalendar",$this->session->userdata('language'));
			$this->load->model('Compfinancialyear');
			$data['datatbls'] = $this->Compfinancialyear->financialCalendar_all();
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('gl/setups/companyFinancialCalendarlist', array('latest' => 'sidebar/latest'), $data);
	}
	
// Chart of accounts	
	public function chartOfAcct()
	{
		if($this->input->post('submit')){
			$this->load->model('CompanyChartAcct');
			if($this->input->post('acctCodeID')==NULL){
				$accountCode = array(
			  			'ID'		=> $this->input->post('ID'), 
			  			'companyID'		=> element('compID', $this->session->userdata('logged_in')), 
						'acctCode'		=> $this->input->post('acctCode'),
						'acctName'		=> $this->input->post('acctName'),
		  				'createdBy'		=> element('userid', $this->session->userdata('logged_in')), 
		  				'createdTS'		=> $this->input->post('order_time') 
		  			);
					
		  			$insert_acctCode = $this->CompanyChartAcct->chartAcctInsert($accountCode);
					if($insert_acctCode){
						echo '<script>alert("Insert Data Success..");
						window.location.replace("chartOfAcctList");
						</script>';
					}else{
						echo '<script>alert("Insert Data Failed.");
						history.go(-1);</script>';
					}
		 	}else{
					$ID = $this->input->post('acctCodeID');
		  			$accountCode = array(
			  			'companyID'		=> element('compID', $this->session->userdata('logged_in')),
						'acctCode'		=> $this->input->post('acctCode'),
						'acctName'		=> $this->input->post('acctName'),
		  				'updatedBy'		=> element('userid', $this->session->userdata('logged_in')), 
		  			);
					//$this->load->model(company/Company_info_model);
					$this->load->model('CompanyChartAcct');
		  			$update_acctCode = $this->CompanyChartAcct->chartAcct_edit($accountCode, $ID);
					if($update_acctCode){
						echo '<script>alert("Update Success..");
						window.location.replace("chartOfAcctList");
						</script>';
					}
					else{
						echo '<script>alert("Update Failed.");
						history.go(-1);</script>';
					}
		  		}
	  		} 
			else 
			{    //add default company id -akmal 20140605 
				$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
				//$id = element('compID', $this->session->userdata('logged_in'));
				$this->load->library('layouts');
				$this->lang->load("chartofaccount",$this->session->userdata('language'));
				$this->load->model('CompAcctGroup_model');
				$data['accGroup'] = $this->CompAcctGroup_model->companyacctgroup_all();
				
				
				$this->load->model('CompanyChartAcct');
				if($id){
					$dataum = $this->CompanyChartAcct->chartAcct_id($id);
					$data['acmaster'] = $dataum[0];
				}else{
					$data['acmaster'] = NULL;
				}
				echo $this->db->last_query(); 
				$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js');
					$this->layouts->view('gl/setups/companyChartAcct', array('latest' => 'sidebar/latest'), $data);
				
			}
	}
	
	public function chartOfAcctList(){
			$this->load->library('layouts');
			$this->load->model('CompanyChartAcct');
			$this->lang->load("chartofaccount",$this->session->userdata('language'));
			$data['datatbls'] = $this->CompanyChartAcct->chartAcct_all();
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('gl/setups/companyChartAcctList', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function acctCodeDelete(){
			$this->load->model('CompanyChartAcct');
		  	$deleteuser = array('is_delete' => '1');
			$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
			
		  	$delete_user = $this->CompanyChartAcct->chartAcctDelete($deleteuser, $ID);
			if($delete_user){
						echo '<script>alert("Delete Success..");
						window.location.replace("chartOfAcctList");
						</script>';
			}else{
				return FALSE;
			}
	}
	
// Budget Entry

	public function budgetEntry(){
		if($this->input->post('submit')){
		}else{
			$this->load->model('CompanyChartAcct');
			$this->load->library('layouts');
			$data['chartofaccount'] = $this->CompanyChartAcct->chartAcct_allexpenses();
			$this->lang->load("budget",$this->session->userdata('language'));
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js')
				->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('gl/setups/budget', array('latest' => 'sidebar/latest'), $data);
		}
	}
	
	public function budgetEdit(){
			$this->load->library('layouts');
		$this->lang->load("budget",$this->session->userdata('language'));
		$this->load->model('Budget');
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$data['selyear'] = $add_year;
		$data['budgetdetails'] = $this->Budget->budget_all_year($add_year);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/setups/budgetEdit', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function budget_insert(){
		$this->lang->load("budget",$this->session->userdata('language'));
		$this->load->model('Budget');
		$query = $this->Budget->budget_insert();
    	print json_encode(array("status"=>"success", "message"=>$this->lang->line('message7')));
	}
	
	public function budget_save(){
		$this->load->model('Budget');
		$query = $this->Budget->budget_update();
		if($query){
    		print json_encode(array("status"=>"success", "message"=>$this->lang->line('message7')));
		}else{
    		print json_encode(array("status"=>"failed", "message"=>$this->lang->line('message8')));
		}
	}
}

