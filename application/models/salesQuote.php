<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SalesQuote extends CI_Model{
	
	public function SalesQuote_all(){
		$this->db->select('a.*');
		$this->db->select('b.customerName');
		$this->db->where('a.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('a.companyID');
		$this->db->from('comp_quotation a');
		$this->db->join('customer b', 'b.ID = a.customerID');	
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function SalesOrder_Insert(){
		$newData = array(
			'companyID' => element('compID', $this->session->userdata('logged_in')),
			'customerID' => $this->input->post('customerID'),
			'OrderNo' => $this->input->post('OrderNo'),
			'currencyID' => $this->input->post('currencyID'),
			'salesOrderDate' => date("Y-m-d", strtotime($this->input->post('effdate'))),
			'exchangeRate' => $this->input->post('exchangeRate'),
			'salesPerson' => $this->input->post('salesPerson'),
			'deliveryToID' => $this->input->post('deliveryToID'),
			'totalAmount' => $this->input->post('totalAmount'),
			'memo' => $this->input->post('memo'),
			'status' => 1,
			'createdBy' => element('role', $this->session->userdata('logged_in'))
		);
		$query = $this->db->insert('comp_sales_order', $newData);
		if($query){
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
	}
	public function SalesOrder_Update($ID, $data){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_sales_order', $data); 
		if($query === TRUE){
			return $this->db->last_query();
		} else {
			return FALSE;
		}
	}
// Sales order details 
	public function SalesOrderDetails_Insert($salesID){
		$newData = array(
			'salesID' => $salesID,
			'itemID' => $this->input->post('itemID'),
			'amount' => $this->input->post('amount'),
			'unitmeasure' => $this->input->post('unitmeasure'),
			'unitPrice' => $this->input->post('unitPrice'),
			'quantityOrder' => $this->input->post('ordQty'),
			'description' => $this->input->post('description'),
			'requiredDate' => date("Y-m-d", strtotime($this->input->post('requiredDate'))),
			'createdBy' => element('role', $this->session->userdata('logged_in'))
		);
		$query = $this->db->insert('comp_sales_detail', $newData);
		if($query){
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
	}
	
// Sequence number
	public function seqNumber(){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('formID', 48);
		$this->db->from('comp_form_control');
		$seqFormat = $this->db->get();
		if($seqFormat->num_rows() >= 1){
			$temp = $seqFormat->result();
			
		}else{
			
		}
	}
	
}

/* End of file SalesOrder.php */
/* Location: ./application/models/SalesOrder.php */
/* Created By : Yahaya Abdollah */
