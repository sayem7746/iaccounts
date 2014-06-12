<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DebitNote_model extends CI_Model{
	
	
	public function debitnote_all(){
		$this->db->where('comp_supplier_debitnote.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->select('comp_supplier_debitnote.*');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->from('comp_supplier_debitnote');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_debitnote.supplierID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	/*public function debitnote_id($ID){
		$this->db->where('ID', $ID);
		$this->db->where('comp_supplier_debitnote.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->select('comp_supplier_debitnote.*');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->select('supplier.gstRegNo as gstRegNo');
		$this->db->from('comp_supplier_debitnote');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_debitnote.supplierID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}*/
	
	public function debitnote_id($ID){
		$this->db->select('a.*');
		$this->db->select('a.ID', $ID);
		$this->db->select('b.*');
		$this->db->where('a.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->from('comp_supplier_debitnote a');
		$this->db->join('supplier b', 'b.ID = a.supplierID');
	}
	
	public function debitnote_Date($dateFrom, $dateTo){
		
/*		$this->db->where('comp_supplier_debitnote.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('comp_supplier_debitnote.invoiceDate between  "'.$dateFrom.'" and "'.$dateTo.'"');
		$this->db->select('comp_supplier_debitnote.*');
		$this->db->select('if (comp_supplier_debitnote.updateAble=0, "Yes", "No" ) as confirm');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->from('comp_supplier_debitnote');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_debitnote.supplierID');
		$this->db->order_by('invoiceDate desc');
		$query = $this->db->get('comp_supplier_debitnote');

*/
		$sql1 = "SELECT comp_supplier_debitnote.*, if (comp_supplier_debitnote.updateAble=1, 'Yes', 'No' ) as confirm, supplier.supplierName as supplierName, comp_supplier_invoice.supplierInvoiceNo";
		$sql2 = " FROM (comp_supplier_debitnote JOIN supplier ON supplier.ID = comp_supplier_debitnote.supplierID) JOIN comp_supplier_invoice ON comp_supplier_invoice.ID = comp_supplier_debitnote.supplierInvoiceID";
		$sql3 = " WHERE comp_supplier_debitnote.companyID = '1' AND comp_supplier_debitnote.debitNoteDate between '".$dateFrom."' and '".$dateTo."'";
		$sql4 = " ORDER BY debitNoteDate desc"; 
		$query = $this->db->query($sql1.$sql2.$sql3.$sql4);
		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function debitnote_unpost($dateFrom, $dateTo){
		$this->db->select('comp_supplier_debitnote.*');
		$this->db->select('updateAble as Yes');
		$this->db->select('supplier.supplierName');
		$this->db->where('comp_supplier_debitnote.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('invoiceDate >=', $dateFrom);
		$this->db->where('invoiceDate <=', $dateTo);
		$this->db->where('updateAble', 1);
		$this->db->order_by('invoiceDate', 'desc');
		$this->db->from('comp_supplier_debitnote');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_debitnote.supplierID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function updatePosting($ID){
		$this->db->where('ID', $ID);
		$updatepayment = array('updateAble'=>0);
		$query = $this->db->update('comp_supplier_debitnote', $updatepayment); 
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	 public function debitNotepost($id, $data){
		$this->db->where('ID', $id);
//		$this->db->where('updateAble', 1);
		$query = $this->db->update('comp_supplier_creditnot1e', $data);
		if($query){
			$this->db->flush_cache();
			$this->db->where('ID', $id);
			$this->db->from('comp_supplier_creditnote');
			$query1 = $this->db->get();
			return $query1->result();
		}else{
			return false;
		}
	 }
	 
}
/* End of file debitNote_model.php */
/* Location: ./application/model/debitNote_model.php */

