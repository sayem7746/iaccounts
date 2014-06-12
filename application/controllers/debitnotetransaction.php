<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debitnotetransaction extends CI_Controller {
	
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
	
	
// debitnote posting

}

	
/* End of file purchasetransaction.php */
/* Location: ./application/controller/purchasetransaction.php */
