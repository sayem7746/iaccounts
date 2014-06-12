<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SysMenu extends CI_Model{
	
	public function sysMenu_all(){
		$this->db->where('parents', 0);
		$this->db->order_by('seq');
		$query = $this->db->get('_sys_menu');
			return $query->result();
	}
	public function sysMenu_alls(){
		$query = $this->db->query('SELECT * FROM _sys_menu WHERE submenu = 1 ORDER BY name');
			return $query->result();
	}
	public function sysMenu_sub($parents){
		$this->db->where('parents', $parents);
		$this->db->order_by('seq');
		$query = $this->db->get('_sys_menu');
			return $query->result();
	}
	public function sysMenu_sub2($fldid){
		$query = $this->db->query('SELECT * FROM _sys_menu WHERE fldid = ' . $fldid . ' ORDER BY seq');
			return $query->result();
	}
	public function sysMenu_active($urls){
		$query = $this->db->query('SELECT * FROM _sys_menu WHERE urls = "' . $urls . '"');
			return $query->result();
	}
	public function menuMaster(){
		$query = $this->db->get('_sys_menu');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
				
	}
	
	public function menuMaster_menu($data){
		$this->db->like('urls',$data);
		$query = $this->db->get('_sys_menu',1);
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function menuMaster_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_sys_menu', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function menuMaster_new($newmenu){
		$sql = $this->db->insert_string('_sys_menu', $newmenu);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	
	public function menuMaster_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('_sys_menu'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
