<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Useraccess extends CI_Model{
	
	public function useraccessA($id){
		$query = $this->db->get_where('user_module_access', array('userID'=>$id));		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function useraccess_id($id){
		$this->db->select('user_module_access.*');
		$this->db->select('module.description');
		$this->db->where('userID', $id);
		$this->db->from('user_module_access');
		$this->db->join('module', 'module.ID = user_module_access.moduleID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function useraccess_update($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('user_module_access', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function useraccess_id_module($module){
		$where = '(transaction = "1" OR reports = "1" OR setup = "1")';
		$id = element('role', $this->session->userdata('logged_in'));
		$this->db->where('userID', $id);
		$this->db->where('moduleID', $module);
		$this->db->where($where);
		$query = $this->db->get('user_module_access');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function useraccess_id_module2($module, $fields){
		$id = element('role', $this->session->userdata('logged_in'));
		$this->db->where('userID', $id);
		$this->db->where($fields, '1');
		$this->db->where('moduleID', $module);
		$query = $this->db->get('user_module_access');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
}