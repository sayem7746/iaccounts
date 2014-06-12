<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//1. onForm Open - to check in table comp_acct_det, if accountID hs trnsctn, then disabled combobox and updateable = NO.
//2. onForm Open - to check in comp_acct_setup, if updateable = NO, then disabled combobox

class SystemGeneral extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}

	public function index()
	{   		
			
	}
	
	public function generalSetup() {
		$this->load->model('systemgeneral/systemgeneral_model');
		if($this->input->post('mysubmit')){
//			echo var_dump($this->input->post());
			//index 0 = acctCode, 1=updateable, 2=ID
			$post = $this->input->post();
	  //save record
			$i=0;
			foreach ($post as $key => $val) {
				//omit first 2 array
				if ($i > 1 && $i < sizeof($post) -1) 
					$this->systemgeneral_model->updateAccountCode($val);
				$i++;
			}
	
		} //end submit
			$this->lang->load("systemgeneral",$this->session->userdata('language'));
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->load->model('systemgeneral/systemgeneral_model');
			$dataum = $this->systemgeneral_model->sysgetall_bycompanyID();
			$data['generalsetup'] = $dataum;
//			echo $this->db->last_query();
			$data['sysgen'] = '';
			$this->load->model('Chartofaccount');
			$data['chartAccounts'] = $this->Chartofaccount->chartofaccount_all();
			$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('sysgen/genList', array('latest' => 'sidebar/latest'),$data);
		}


}