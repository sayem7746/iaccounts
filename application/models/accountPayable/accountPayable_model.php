<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountPayable_model extends CI_Model{
	
	public function loadSupplierDefaultValue($id){
		/*$this->db->select('cu.currencyWord, cu.exchangeRate, su.currencyID');		
		$this->db->where('su.ID', $id);
		$this->db->where('su.currencyID', 'cu.ID');
		$query = $this->db->get('supplier su, currency cu');*/
		$sql='SELECT cu.currencyWord, cu.exchangeRate, su.currencyID FROM supplier su, currency cu WHERE su.ID = '.$id.' AND su.currencyID = cu.ID ';
		$query = $this->db->query($sql);

		if($query->num_rows() >=1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	
	
	public function insert($tname, $newData){
		$sql = $this->db->insert_string($tname, $newData);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return $this->db->insert_id();
		} else {
	//		$last_query = $this->db->last_query();
	//		return $last_query;
			return 0;
		}
	}
	public function delete($id,$tname){
		$this->db->where('ID', $id);
		$query = $this->db->delete($tname); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function getCrditNotDetailById($id){
		$sql='SELECT comp_supplier_creditnote_detail.*, tax_master.code, item.itemCode,comp_supplier_creditnote_detail.itemname as name, comp_supplier_creditnote_detail.itemdescription as description
			FROM (comp_supplier_creditnote_detail LEFT OUTER JOIN tax_master ON tax_master.ID = comp_supplier_creditnote_detail.taxID)
			LEFT JOIN item
			ON comp_supplier_creditnote_detail.itemID=item.ID
			where invoiceID ='.$id;
			$query = $this->db->query($sql);

		if($query->num_rows() >=1){
			return $query->result();
		}else{
			return FALSE;
		}
	} // to be combined with get_detail_byid using tname as paramater
	
	public function get_DebitNoteDetail_byID($id){
		$sql='SELECT comp_supplier_debitnote_detail.*, tax_master.code, tax_master.taxPercentage, item.itemCode,comp_supplier_debitnote_detail.itemname as name, comp_supplier_debitnote_detail.itemdescription as description
			FROM (comp_supplier_debitnote_detail LEFT OUTER JOIN tax_master ON tax_master.ID = comp_supplier_debitnote_detail.taxID)
			LEFT JOIN item
			ON comp_supplier_debitnote_detail.itemID=item.ID
			where debitnoteID ='.$id;
			$query = $this->db->query($sql);

		if($query->num_rows() >=1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	
	public function get_Detail_byID($id){
		$sql='SELECT comp_supplier_invoice_detail.*, tax_master.code, item.itemCode,comp_supplier_invoice_detail.itemname as name, comp_supplier_invoice_detail.itemdescription as description
			FROM (comp_supplier_invoice_detail LEFT OUTER JOIN tax_master ON tax_master.ID = comp_supplier_invoice_detail.taxID)
			LEFT JOIN item
			ON comp_supplier_invoice_detail.itemID=item.ID
			where invoiceID ='.$id;
			$query = $this->db->query($sql);

		if($query->num_rows() >=1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function get_byID($tname, $id){
		$sql ="";
		switch ($tname) {
    		case "comp_supplier_invoice":
       			 $sql='SELECT comp_supplier_invoice.*, comp_supplier_invoice.ID as InvID,tbl_location.*, comp_address.*, supplier.supplierName, comp_project.project_name, terms.termName, terms.termDescription, currency.currencyWord FROM ((((comp_supplier_invoice left outer join comp_project on comp_supplier_invoice.projectID=comp_project.ID) left outer join terms on comp_supplier_invoice.termsID = terms.ID)) LEFT OUTER JOIN tbl_location on comp_supplier_invoice.locationID=tbl_location.fldid ) LEFT OUTER JOIN comp_address ON comp_address.ID=comp_supplier_invoice.shipToID, currency , supplier where comp_supplier_invoice.updateAble = TRUE AND supplier.ID=comp_supplier_invoice.supplierID AND currency.ID=supplier.currencyID AND comp_supplier_invoice.ID =  '.$id;
      		 	 break;
			case "comp_supplier_debitnote" :
				$sql='SELECT comp_supplier_debitnote.*,  supplier.supplierName, supplier.line1, supplier.line2, supplier.line3, supplier.city, supplier.supplierPostCode, comp_project.project_name, currency.currencyWord FROM (comp_supplier_debitnote left outer join comp_project on comp_supplier_debitnote.projectID=comp_project.ID), currency , supplier where comp_supplier_debitnote.updateAble = TRUE AND supplier.ID=comp_supplier_debitnote.supplierID AND currency.ID=supplier.currencyID AND comp_supplier_debitnote.ID =  '.$id;
			   break;
			  case "comp_supplier_creditnote_detail" :
			  	 $sql='SELECT comp_supplier_creditnote.*,  supplier.supplierName, comp_project.project_name, currency.currencyWord FROM (comp_supplier_creditnote left outer join comp_project on comp_supplier_creditnote.projectID=comp_project.ID), currency , supplier where comp_supplier_creditnote.updateAble = TRUE AND supplier.ID=comp_supplier_creditnote.supplierID AND currency.ID=supplier.currencyID AND comp_supplier_creditnote.ID =  '.$id;
			 	 break;
  	 		
		   }
		
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			return $query->result();
		}else{
			return FALSE;
		}

	}
	
		public function get_bySupplierID($id,$companyID=0){
		if ($companyID > 0)
		    $this->db->where('companyID',$companyID); 
		$this->db->select('comp_supplier_invoice.*');
		$this->db->select('comp_supplier_invoice.ID as suppInvoiceID');
		$this->db->where('supplierID', $id);
		$this->db->where('totalPayable >', 0);
		$query = $this->db->get('comp_supplier_invoice');
		if($query->num_rows() >0 ){
			return $query->result();
		}else{
			return false;
		}

	}
	
	
	
	public function getChargeByid($id){
		
		$sql='SELECT  comp_supplier_invoice_charges.*, comp_supplier_invoice_charges.ID as myid, tax_master.ID as taxId,  tax_master.code, tax_master.taxPercentage,
		comp_chart_of_acct.* From comp_supplier_invoice_charges, tax_master, comp_chart_of_acct
		Where comp_supplier_invoice_charges.taxID = tax_master.ID and  comp_supplier_invoice_charges.accountNoID = 
		comp_chart_of_acct.ID AND 
		 comp_supplier_invoice_charges.invoiceID =  '.$id;
		$query = $this->db->query($sql);
		$return = NULL;
 
		if($query->num_rows() >0 ){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function checkformNumber_model($t, $fN){
		$sql='SELECT id from '.$t.' where formNo = "'.$fN.'"';
		$query = $this->db->query($sql);

		if($query->num_rows() >= 1){
			return "yes";
		}else{
			return "no";
		}
		}
	
	public function deleteCharge($idCharge){
		$sql='Delete from comp_supplier_invoice_charges where ID = '.$idCharge;
		$query = $this->db->query($sql);
		$return = NULL;
 
		if($query->num_rows() >= 1){
			$return = "true";
		}
		
		return $return;
	}
	
	public function deleteCompanyDetail($id){
		$sql='Delete from comp_supplier_invoice_detail where ID = '.$id;
		$query = $this->db->query($sql);
		$return = NULL;
 
		if($query->num_rows() >= 1){
			$return = "true";
		}
		
		return $return;
	}
	
	public function  getLasIdInsert($tname){
		$sql='SELECT LAST_INSERT_ID() as myId from '.$tname;
		$query = $this->db->query($sql);
		$return = NULL;
 
		if($query->num_rows() >= 1){
			foreach($query->result() as $row)
				$return =  $row->myId;
		}
		
		return $return;
	}

	public function update_charge ($id, $data) {
		$this->db->where('ID', $id);
		$query = $this->db->update('comp_supplier_invoice_charges', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
		}
	
	public function update_byID($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('comp_supplier_invoice_detail', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
		public function update_debitNoteDetail($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('comp_supplier_debitnote_detail', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function update_CreditNoteDetail($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('comp_supplier_creditnote_detail', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function updateInvoice($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('comp_supplier_invoice', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}