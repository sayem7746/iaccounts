<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sosetup extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('5', 'setup');
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
	
	public function SalesPrice(){
		$this->lang->load("salesprice",$this->session->userdata('language'));
		$this->load->model('Sysum');
		$this->load->model('Currency');
		$this->load->model('customer/customer_model');
		$this->load->model('employee/employee_model');
		$this->load->model('item/ItemSetup_model');
		$data['items'] = $this->ItemSetup_model->get_all();
		$data['employees'] = $this->employee_model->employeemaster_all();
		$data['um'] = $this->Sysum->sysum_all();
		$data['currency'] = $this->Currency->currency_all();
		$data['customers'] = $this->customer_model->customermaster_all();
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js')
				->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('so/setups/salesPrice', array('latest' => 'sidebar/latest'), $data);
	}
	
}

	
/* End of file artransaction.php */
/* Location: ./application/controller/artransaction.php */
