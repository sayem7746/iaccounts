<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journal extends CI_Model{
	
	public function journalNo(){
		if($this->input->post('fldid')){
		}else{
		}
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('moduleID', $module);
		$query = $this->db->get('comp_journal');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function journal_insert($newdata){
		$query = $this->db->insert('comp_journal', $newdata);
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function journal_update($journalNo, $data){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('journalID', $journalNo);
		$query = $this->db->update('comp_journal', $data);
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function journal_save($ID, $journalNo, $data){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_journal', $data); 
		if($query === TRUE){
			$this->db->flush_cache();
			$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
			$this->db->where('journalID', $journalNo);
			$query = $this->db->update('comp_journal_detail', $data);
			$this->db->flush_cache();
			$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
			$this->db->where('journalID', $journalNo);
			$this->db->from('comp_journal_detail');
			$querydetails = $this->db->get();
			if($querydetails->num_rows() >= 1){
				foreach($querydetails->result() as $row){
					$this->db->flush_cache();
					$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
					$this->db->where('acctID', $row->acctCode);
					$this->db->where('year', $row->year);
					$this->db->where('period', $row->period);
					$this->db->from('comp_acc_det');
					$queryacctdet = $this->db->get();
					if($queryacctdet->num_rows() >= 1){
						$this->db->flush_cache();
						$updatedata = array(
							'amountdr' => 'amountdr+'.$row->amount_dr,
							'amountcr' => 'amountcr'.$row->amount_cr,
							'total' => ('amountdr' + $row->amount_dr) - ('amountcr' + $row->amount_cr),
							'updatedBy' => element('userid', $this->session->userdata('logged_in')),
						);
						$this->db->set('amountdr','amountdr +'.$row->amount_dr, FALSE);
						$this->db->set('amountcr','amountcr +'.$row->amount_cr, FALSE);
						$this->db->set('total','amountdr - amountcr', FALSE);
						$this->db->set('updatedBy',element('role', $this->session->userdata('logged_in')));
						$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
						$this->db->where('acctID', $row->acctCode);
						$this->db->where('year', $row->year);
						$this->db->where('period', $row->period);
						$queryupdate = $this->db->update('comp_acc_det'); 
					}else{
						$this->db->flush_cache();
						$this->db->where('ID', $row->acctCode);
						$this->db->from('comp_chart_of_acct');
						$queryAcctChart = $this->db->get();
						$dataacctchart = $queryAcctChart->result();
						$this->db->flush_cache();
						$dataacctdet = array(
							'companyID'=>element('compID', $this->session->userdata('logged_in')),
							'acctGroupID'=>$dataacctchart[0]->acctGroupID,
							'acctID'=>$row->acctCode,
							'year'=>$row->year,
							'period'=>$row->period,
							'amountdr' => $row->amount_dr,
							'amountcr' => $row->amount_cr,
							'total' => $row->amount_dr - $row->amount_cr,
							'createdBy' => element('role', $this->session->userdata('logged_in')),
							'createdTS' => date("Y-m-d: H:m:s"),
						);
						$queryinsert = $this->db->insert('comp_acc_det', $dataacctdet);
					}
				}
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function journal_journalno($journalNo){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('journalID', $journalNo);
		$query = $this->db->get('comp_journal');
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function journal_ID($ID){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('ID', $ID);
		$query = $this->db->get('comp_journal');
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function journal_all(){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('comp_journal');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function journal_all_yearperiod($year, $period){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('year', $year);
		$this->db->where('period', $period);
		$query = $this->db->get('comp_journal');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function journal_unpost_yearperiod($year, $period){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('year', $year);
		$this->db->where('period', $period);
		$this->db->where('status', 0);
		$query = $this->db->get('comp_journal');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function journal_posted_yearperiod($year, $period){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('year', $year);
		$this->db->where('period', $period);
		$this->db->where('status', 1);
		$query = $this->db->get('comp_journal');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	// Journal Details
	public function journalDetails_journalno($journalNo){
		$this->db->select('comp_journal_detail.*');
		$this->db->select('comp_chart_of_acct.acctCode as acctcode');
		$this->db->select('comp_chart_of_acct.acctName as acctname');
		$this->db->where('comp_journal_detail.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('journalID', $journalNo);
		$this->db->order_by('sequence');
		$this->db->from('comp_journal_detail');
		$this->db->join('comp_chart_of_acct', 'comp_chart_of_acct.ID = comp_journal_detail.acctCode');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function journalDetails_acctCode($journalNo){
		$this->db->select('comp_journal_detail.*');
		$this->db->select('comp_chart_of_acct.acctCode as acctcode');
		$this->db->select('comp_chart_of_acct.acctName as acctname');
		$this->db->where('comp_journal_detail.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('journalID', $journalNo);
		$this->db->order_by('sequence');
		$this->db->from('comp_journal_detail');
		$this->db->join('comp_chart_of_acct', 'comp_chart_of_acct.ID = comp_journal_detail.acctCode');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function journalDetails_insert($newdata){
		$query = $this->db->insert('comp_journal_detail', $newdata);
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function journaldetails_copy($journalID){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('journalID', $this->input->post('journalNo'));
		$this->db->from('comp_journal_detail');
		$querydetails = $this->db->get(); 
		if($querydetails->num_rows() >= 1){
			foreach($querydetails->result() as $row){
				$newjldetails = array(
					'companyID' => element('compID', $this->session->userdata('logged_in')),
					'journalID' => $journalID,
					'sequence' => $row->sequence,
					'description' => $row->description,
					'acctCode' => $row->acctCode,
					'year' => $row->year,
					'period' => $row->period,
					'amount_cr' => $row->amount_cr,
					'amount_dr' => $row->amount_dr,
					'createdBy' => element('userid', $this->session->userdata('logged_in'))
				);
				$this->db->insert('comp_journal_detail', $newjldetails);
			}
		} else {
			return FALSE;
		}
	}
	
	public function journaldetails_reverse($journalID){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('journalID', $this->input->post('journalNo'));
		$this->db->from('comp_journal_detail');
		$querydetails = $this->db->get(); 
		if($querydetails->num_rows() >= 1){
			foreach($querydetails->result() as $row){
				$newjldetails = array(
					'companyID' => element('compID', $this->session->userdata('logged_in')),
					'journalID' => $journalID,
					'sequence' => $row->sequence,
					'description' => $row->description,
					'acctCode' => $row->acctCode,
					'year' => $row->year,
					'period' => $row->period,
					'amount_cr' => $row->amount_cr * -1,
					'amount_dr' => $row->amount_dr * -1,
					'createdBy' => element('userid', $this->session->userdata('logged_in'))
				);
				$this->db->insert('comp_journal_detail', $newjldetails);
			}
		} else {
			return FALSE;
		}
	}
	
	public function journalDetails_save($ID, $data){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_journal_detail', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function journalDetails_delete($ID){
		$this->db->where('ID', $ID);
		$query = $this->db->delete('comp_journal_detail'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function journalDetails_yearperiod($year, $period){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('year', $year);
		$this->db->where('period', $period);
		$this->db->from('comp_journal_detail');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function journalDetails_yearperiodacctNo($year, $period, $acctNo){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('year', $year);
		$this->db->where('period', $period);
		$this->db->where('acctCode', $acctNo);
		$this->db->from('comp_journal_detail');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function journalDetails_accountyearperiod($accountCode, $year, $period){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('acctCode', $accountCode);
		$this->db->where('year', $year);
		$this->db->where('period', $period);
		$this->db->from('comp_journal_detail');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function journalDetails_accountyear($accountCode, $year){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('acctCode', $accountCode);
		$this->db->where('year', $year);
		$this->db->from('comp_journal_detail');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
}

/* End of file journal.php */
/* Location: ./application/models/journal.php */
/* Created By : Yahaya Abdollah */
