<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zakatsetup extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('7', 'setup');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->library('layouts');
		$this->load->model('menu');
	}
	
	public function nisab(){
		$this->lang->load("nisab",$this->session->userdata('language'));
		$data = "";
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->layouts->view('zakat/setups/nisab', array('latest' => 'sidebar/latest'), $data);
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
			{     
				$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
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
				
				$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
					->add_includes('js/validationengine/jquery.validationEngine.js');
					$this->layouts->view('gl/setups/companyChartAcct', array('latest' => 'sidebar/latest'), $data);
				
			}
	}
	
	public function chartOfAcctList(){
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
}