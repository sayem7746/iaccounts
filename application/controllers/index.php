<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
		$this->load->library('layouts');
		$this->layouts->set_title('Change Management');
		$this->layouts->add_includes('js/jquery/jquery-2.0.0.min.js')
		->add_includes('js/jquery-ui-1.10.3.custom.min.js')
		->add_includes('js/actions.js')
		->add_includes('css/stylesheets.css');
		$default = false;
		$this->layouts->view('login', '', '', false);
	}
}

?>