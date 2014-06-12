<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PurchaseInvoice_list extends CI_Model{
	
	/*public function purchaseInvoice_all1($id){
		$sql='SELECT sup.supplierName, 
		sui.formNo,
		sui.invoiceDate, 
		sui.supplierInvoiceNo 
		FROM supplier sup, 
		comp_supplier_invoice sui 
		WHERE sup.ID = sui.supplierID 
		AND sui.companyID = '.$id.' 
		ORDER BY invoiceDate DESC';
		
		$query = $this->db->query($sql);

		if($query->num_rows() >=1){
			return $query->result();
		}else{
			return FALSE;
		}
	}*/
	
	public function purchaseInvoice_all(){
		$this->db->where('comp_supplier_invoice.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->select('comp_supplier_invoice.*');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->from('comp_supplier_invoice');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_invoice.supplierID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function purchaseInvoiceDate($dateFrom, $dateTo){
		$this->db->where('comp_supplier_invoice.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('comp_supplier_invoice.invoiceDate between  "'.$dateFrom.'" and "'.$dateTo.'"');
		$this->db->select('comp_supplier_invoice.*');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->from('comp_supplier_invoice');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_invoice.supplierID');
		$this->db->order_by('invoiceDate desc');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
}