<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CreditNote extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('8', 'transaction');
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
	
	public function creditnoteList(){
		$this->lang->load("creditNote",$this->session->userdata('language'));
		$this->load->model('creditnote_model');
		$this->load->model('company/FormSetup_model');
		$dateFrom = date("Y-m-d",strtotime($this->uri->segment(3)));
		$dateTo = date("Y-m-d",strtotime($this->uri->segment(4)));
		if ($this->uri->segment(3) == ""){
			$dateFrom = date("Y-m-01");
		}
		if($this->uri->segment(4) == ""){
			$dateTo = date("Y-m-t");
		}
		if($dateFrom > $dateTo){
			$dateTo = date("Y-m-t", strtotime($dateFrom));
		}
		$data['dateFrom'] = $dateFrom;
		$data['dateTo'] = $dateTo;
		$data['datatbls'] = $this->creditnote_model->creditnote_Date($dateFrom, $dateTo);
//		echo $this->db->last_query();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('creditnote/creditnoteList', array('latest' => 'sidebar/latest'), $data);
	}

// debitnote posting

}



	
/* End of file purchasetransaction.php */
/* Location: ./application/controller/purchasetransaction.php */
