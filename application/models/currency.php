<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency extends CI_Model{
	
	public function currency_all(){
		$this->db->order_by('fldcurr_code');
		$query = $this->db->get('_ref_currency');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function currency_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_ref_currency', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function currency_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('_ref_currency'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
// currency conversion	
	public function currencyConv_id($ID){
		$this->db->where('currencyFrom', $ID);
		$this->db->where('startDate <=', date("Y-m-d", strtotime($this->input->post('effdate'))));
		$this->db->where('endDate >=', date("Y-m-d", strtotime($this->input->post('effdate'))));
		$this->db->where('currencyTo', element('compCurrency', $this->session->userdata('logged_in')));
		$query = $this->db->get('comp_currency_conv'); 
		if($query->num_rows() >= 1){
			return $query->result();
		} else {
			return FALSE;
		}
	}
}