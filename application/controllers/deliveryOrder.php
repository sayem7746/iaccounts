<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DeliveryOrder extends CI_Controller {
	
	public $data = array();
	

	public function __construct(){
		parent::__construct();
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('iAccount');

		$this->load->model('menu');
	}

	public function __reset() {
		$data = array ('ID'=>0,'itemName'=>'');
	}
	public function index() {
		echo '<h1>Delivery Order default page<h1><br>';
		echo '<div><a href="doList"><h3>List</h3></a></div>'; //call controller
	}
	public function doList() {
		echo '<h1>Customer List</h1>';
	}
}
?>