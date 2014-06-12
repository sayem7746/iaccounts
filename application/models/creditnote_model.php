<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CreditNote_model extends CI_Model{
	
	
	public function creditnote_all(){
		$this->db->where('comp_supplier_creditnote.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->select('comp_supplier_creditnote.*');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->from('comp_supplier_creditnote');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_creditnote.supplierID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function creditnote_Date($dateFrom, $dateTo){
/*		$this->db->where('comp_supplier_creditnote.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('comp_supplier_creditnote.invoiceDate between  "'.$dateFrom.'" and "'.$dateTo.'"');
		$this->db->select('comp_supplier_creditnote.*');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->from('comp_supplier_creditnote');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_creditnote.supplierID');
		$this->db->order_by('invoiceDate desc');
		
*/

		$sql1 = "SELECT comp_supplier_creditnote.*, if (comp_supplier_creditnote.updateAble=1, 'Yes', 'No' ) as confirm,    supplier.supplierName as supplierName";
		$sql2 = " FROM (comp_supplier_creditnote) JOIN supplier ON supplier.ID = comp_supplier_creditnote.supplierID";
		$sql3 = " WHERE comp_supplier_creditnote.companyID = '1' AND comp_supplier_creditnote.invoiceDate between '".$dateFrom."' and '".$dateTo."'";
		$sql4 = " ORDER BY invoiceDate desc"; 
		$query = $this->db->query($sql1.$sql2.$sql3.$sql4);
		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function creditnote_unpost($dateFrom, $dateTo){
		$this->db->select('comp_supplier_creditnote.*');
		$this->db->select('updateAble as Yes');
		$this->db->select('supplier.supplierName');
		$this->db->where('comp_supplier_creditnote.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('invoiceDate >=', $dateFrom);
		$this->db->where('invoiceDate <=', $dateTo);
		$this->db->where('updateAble', 1);
		$this->db->order_by('invoiceDate', 'desc');
		$this->db->from('comp_supplier_creditnote');
		$this->db->join('supplier', 'supplier.ID = comp_supplier_creditnote.supplierID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
     
	 public function creditNotepost($id, $data){
		$this->db->where('ID', $id);
		$this->db->where('updateAble', 1);
		$query = $this->db->update('comp_supplier_creditnote', $data);
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
	 
	 public function journaCreateHead($data, $module){
			$this->load->model('Glseq');
			$query = $this->Glseq->glSequence_jl();
			$newData = array(
				'companyID' => element('compID', $this->session->userdata('logged_in')),
				'journalID' => $query['seqNumber'],
				'description' => $this->input->post('description'),
				'module' => '1',
				'effective_date' => date("Y-m-d", strtotime($this->input->post('effdate'))),
				'year' => $query['financialYear'],
				'period' => $query['period'],
				'createdBy' => element('userid', $this->session->userdata('logged_in'))
			);
			$query2 = $this->Journal->journal_insert($newData);
	 }
}
	