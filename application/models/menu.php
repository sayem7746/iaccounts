<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends CI_Model{
	
	function menu(){
		if(!$this->session->userdata('logged_in')){
			$this->session->set_userdata('first_uri', uri_string());
			redirect('login');
		}
		$this->lang->load("menu",$this->session->userdata('language'));
		$this->load->library('menus');
		$this->load->model('sysMenu');
		$this->load->model('Useraccess');
		$controller = $this->uri->segment(1);
		$function = $this->uri->segment(2);
		$act = $controller;
		if($function != ''){ $act = $act . '/' . $function; };
		$active = $this->sysMenu->sysMenu_active($act);
//		echo $act;
		$sub_par = "";
		$sub_par2 = "";
		if($active){
			foreach($active as $aktif){
					$sub_par = $aktif->parents;
			}
				if($sub_par != 0){
					$active2 = $this->sysMenu->sysMenu_sub2($sub_par);
					foreach($active2 as $aktif2){
						$sub_par2 = $aktif2->parents;
					}
				}else{
					$sub2 = NULL;
				}
		}
		$result = $this->sysMenu->sysMenu_all();
		if($result)   {
			$menu_array = array();
			$parent = 0;
			$line = '';
			foreach($result as $row) {
				$close = '';
				if($act == $row->urls){
					$urlss = "active";
					$line = $close . '<li class="'. $urlss .'"><a href="'. base_url() . $row->urls . '">' . $this->lang->line($row->name) . '</a></li>';
					$this->menus->add_includes($line);
				} else {
					if($row->submenu == 1){
					  $query = $this->Useraccess->useraccess_id_module($row->module);
					  if($query){
						if($row->fldid == $sub_par || $row->fldid == $sub_par2) {
							$urlss = "openable open";
						} else {
							$urlss = "openable";
						}
						$line = '<li class="'. $urlss .'"><a href="'. base_url() . $row->urls . '">' . $this->lang->line($row->name) . '</a><ul>';
						$this->menus->add_includes($line);
						$sub = $this->sysMenu->sysMenu_sub($row->fldid);
						foreach($sub as $row1) {
							if($act == $row1->urls){
								$urlss = "active";
								$line = $close . '<li class="'. $urlss .'"><a href="'. base_url() . $row1->urls . '">' . $this->lang->line($row1->name) . '</a></li>';						
								$this->session->set_userdata('menuactive', $this->lang->line($row1->name));
								$this->menus->add_includes($line);							
							} else {
								if($row1->submenu == 1){
					  			  if($row1->module == '10' || $row1 == '9'){
								  	$query1 = $this->Useraccess->useraccess_id_module($row1->module);
								  }else{
								  	$query1 = $this->Useraccess->useraccess_id_module2($row1->module, $row1->name);
								  }
					  			  if($query1){
									if($row1->fldid == $sub_par || $row1->fldid == $sub_par2) {
										$urlss = "openable open";
									} else {
										$urlss = "openable";
									}
									$line = '<li class="'. $urlss .'"><a href="'. base_url() . $row1->urls . '">' . $this->lang->line($row1->name) . '</a><ul>';
									$this->menus->add_includes($line);
									$sub2 = $this->sysMenu->sysMenu_sub($row1->fldid);
									foreach($sub2 as $row2) {
										if($act == $row2->urls){
											$urlss = "active";
											$line = $close . '<li class="'. $urlss .'"><a href="'. base_url() . $row2->urls . '">' . $this->lang->line($row2->name) . '</a></li>';						
											$this->session->set_userdata('menuactive', $this->lang->line($row2->name));
											$this->menus->add_includes($line);							
										} else {
											$urlss = '';
											$line = '<li class="'. $urlss .'"><a href="'. base_url() . $row2->urls . '">' . $this->lang->line($row2->name) . '</a></li>';
											$this->menus->add_includes($line);
										}
									}
									$line = '</ul>';
									$this->menus->add_includes($line);
								  }
								}else{
									$urlss = '';
									$line = '<li class="'. $urlss .'"><a href="'. base_url() . $row1->urls . '">' . $this->lang->line($row1->name) . '</a></li>';
									$this->menus->add_includes($line);
								}
							}
						}
						$line = '</ul>';
						$this->menus->add_includes($line);							
					  }
					} else {						
						$urlss = '';
						$line = '<li class="'. $urlss .'"><a href="'. base_url() . $row->urls . '">' . $this->lang->line($row->name) . '</a></li>';
						$this->menus->add_includes($line);
					}
				}
			}
		}
	}
}