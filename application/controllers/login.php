<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
			$this->session->set_userdata('enter_uri', 'home');
	}
	
	public function index()
	{
		$this->load->library('layouts');
		$this->layouts->set_title('i-Accounts'); 
		$default = false;
		$data['prevurls'] = base_url() . $this->session->userdata('first_uri');
		$this->load->model('Company/Company_info_model');
		$data['companyList'] = $this->Company_info_model->company_all();
		$this->load->helper(array('form'));
		$this->layouts->view('login', array(), $data , false);
	}
	
	 public function verifylogin(){
		 $this->load->library('layouts');
		 $this->form_validation->set_rules('userid', 'User Id', 'required');
		 $this->form_validation->set_rules('password', 'Password', 'required|callback_check_database');
		 $this->form_validation->set_rules('compID', 'Company', 'required');
		 $urls_info = $this->input->post('prevurls');
		 if($this->form_validation->run() == FALSE) {
			 $this->load->library('layouts');
			 $this->layouts->set_title('i-Accounts');
		     $default = false;
			 $data['prevurls'] = base_url() . $this->session->userdata('first_uri');
			 $this->load->model('Company/Company_info_model');
			 $data['companyList'] = $this->Company_info_model->company_all();
			 $this->layouts->view('login', array(), $data , false);
		 } else {
			 if($urls_info){
				$urls = $this->session->userdata('first_uri');
			 	redirect( $urls, 'refresh');
			 }else{
			 	redirect('home', 'refresh');
			 }
		 }

	 }

 	public function check_database($password) {
		$userid = $this->input->post('userid');
		$compID = $this->input->post('compID');
		$this->load->model('company/company_info_model');
		$query = $this->company_info_model->company_id($compID);
		$this->load->model('Usermaster');
		$result = $this->Usermaster->getLogin($userid, $password);
		if($result)   {
			$sess_array = array();
			foreach($result as $row) {
				$sess_array = array(
					'userid' => $row->userid, 
					'username' => $row->username, 
					'compName' => $query[0]->companyName, 
					'compNo' => $query[0]->companyNo, 
					'compCurrency' => $query[0]->currencyID, 
					'compID' => $compID, 
					'email' => $row->email, 
					'language' => $row->language, 
					'role' => $row->fldid);
				$this->session->set_userdata('logged_in', $sess_array);
				$this->session->set_userdata('language', $row->language);
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			 return false;
		}
	}

}

?>