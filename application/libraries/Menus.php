<?php

class Menus {
	// Hold CI Instance
	private $CI;
	
	// hold includes  like css and js
	private $includes = array();
	
	public function __construct(){
		$this->CI =& get_instance();
	}
	
	public function add_includes($name){
		$this->includes[] = $name;
		return $this;
	}
	
	public function print_includes(){
		$final_includes = '';
		
		foreach($this->includes as $include){
//			$final_includes .= '<li class="' . $include . '">';
			$final_includes .= $include;
		}
		return $final_includes;
	}
}
?>