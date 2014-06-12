<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PaymentDetailsModel extends CI_Model{
	
	 
	 public function payment_details_all(){
	     $this->db->where('is_delete', 0);
		$query = $this->db->get('comp_supplier_invoice');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function payment_details_insert($paymentdetails){
		$sql=$this->db->insert_string('comp_supplier_invoice', $paymentdetails);
		$query = $this->db->query($sql);
			if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
		public function payment_details_edit($pdetails,$ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_supplier_invoice', $pdetails); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
        public function payment_details_delete($dpayment, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_supplier_invoice', $dpayment); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}