<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Budget extends CI_Model{
	
	public function budget_insert(){
		$this->db->flush_cache();
		$this->db->where('ID', $this->input->post('acctID'));
		$this->db->from('comp_chart_of_acct');
		$queryAcctChart = $this->db->get();
		$dataacctchart = $queryAcctChart->result();
		$this->db->flush_cache();
		for($i=1; $i<=12;$i++){
			$newdata = array(
				'companyID'=>element('compID', $this->session->userdata('logged_in')),
				'acctGroupID'=>$dataacctchart[0]->acctGroupID,
				'acctID'=>$this->input->post('acctID'),
				'year'=>$this->input->post('fcy'),
				'period'=>$i,
//				'amountdr' => $row->amount_dr,
				'amountcr' => $this->input->post($i),
				'total' => $this->input->post($i),
				'createdBy' => element('role', $this->session->userdata('logged_in')),
				'createdTS' => date("Y-m-d: H:m:s"),
			);
		$query = $this->db->insert('comp_budget', $newdata);
		}
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function budget_update(){
		$dataupdate = array(
			'amountcr' => $this->input->post('content')
		);
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('acctID', $this->input->post('fldid'));
		$this->db->where('year', $this->input->post('budgetYear'));
		$this->db->where('period', $this->input->post('fieldname'));
		$query = $this->db->update('comp_budget', $dataupdate);
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function budget_all_year($year){
		$this->db->select('a.*');
		$this->db->select('b.acctName');
		$this->db->select('b.acctCode');
		$this->db->where('a.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('year', $year);
		$this->db->order_by('a.companyID');
		$this->db->order_by('a.acctID');
		$this->db->order_by('a.year');
		$this->db->order_by('a.period');
		$this->db->from('comp_budget a');
		$this->db->join('comp_chart_of_acct b', 'a.acctID = b.ID');
//		$this->db->join('comp_acc_det c', 'b.ID = c.acctID and c.year + c.period <= '.$year.sprintf('%02d', $period - 1), 'left outer');
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
