<?php

class Layouts {
	// Hold CI Instance
	private $CI;
	
	// Layout title
	private $layout_title = null;
	
	// Layout description
	private $layout_description = null;

	
	// hold includes  like css and js
	private $includes = array();
	
	public function __construct(){
		$this->CI =& get_instance();
	}
	
	
	public function set_title($title){
		$this->layout_title = $title;
	}
	
	public function set_description($description){
		$this->layout_description = $description;
	}
	
	public function add_includes($path, $prepend_base_url = true){
		if($prepend_base_url){
			$this->CI->load->helper('url');
			$this->includes[] = base_url() . $path;
		}else{
			$this->includes[] = $path;
		}
		
		return $this;
	}
	
	public function print_includes(){
		$final_includes = '';
		
		foreach($this->includes as $include){
			if(preg_match('/js$/', $include)){
				$final_includes .= '<script type="text/javascript" src="' . $include . '"></script>';
			}elseif(preg_match('/css$/', $include)){
				$final_includes .= '<link type="text/css" href="' . $include . '" rel="stylesheet" />';
			}
		}
		return $final_includes;
	}
	
	public function view($view_name, $layouts = array(), $params = array(), $default = true){
		
			if(is_array($layouts) && count($layouts) >= 1){
				foreach ($layouts as $layouts_key => $layout) {
					$params[$layouts_key] = $this->CI->load->view($layout, $params, true);
				}
			}
		
			if($default){
				$header_params['layout_title'] = 'i-Accounts';
				$header_params['layout_description'] = $this->layout_description;
			

				$this->CI->load->view('layouts/header', $header_params);
				$this->CI->load->view('layouts/sidebar', $header_params);
				$this->CI->load->view($view_name, $params);
				//$this->CI->load->view('layouts/footer');
			
			} else {
				$params['layout_title'] = 'i-Accounts';
				$params['layout_description'] = $this->layout_description;
				$this->CI->load->view($view_name, $params);
			}
	}
}
?>