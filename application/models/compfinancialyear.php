<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compfinancialyear extends CI_Model{
	
	public function compfinancialyear_date($effdate){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('startDate <=', date("Y-m-d", strtotime($effdate)));
		$this->db->where('endDate >=', date("Y-m-d", strtotime($effdate)));
		$query = $this->db->get('comp_financial_year');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function compfinancialyear_date1($effdate){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('startDate <=', $effdate);
		$this->db->where('endDate >=', $effdate);
		$query = $this->db->get('comp_financial_year');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function financialCalendar_all(){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', '');
		$this->db->order_by('financialYear', 'desc');
		$this->db->order_by('period', 'desc');
		$query = $this->db->get('comp_financial_year');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function financialCalendarInsert($newCalendar){
		$sql = $this->db->insert_string('comp_financial_year', $newCalendar);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	
	public function startEndDateCheck_startDateEndDate(){
		$startdate = date("Y-m-d", strtotime($this->input->post('startDate')));
		$enddate = date("Y-m-d", strtotime($this->input->post('endDate')));
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('startDate >=', $startdate);
		$this->db->where('startDate <=', $enddate);
		$this->db->where('endDate >=', $startdate);
		$this->db->where('endDate <=', $enddate);
		$query = $this->db->get('comp_financial_year');
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function financialCalendar_edit($update_calendar, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_financial_year', $update_calendar); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function financialCalendar_id($id){
		$query = $this->db->get_where('comp_financial_year', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function financialCalendar_delete($deletuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_financial_year', $deletuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function financialYear_yearperiod($year, $period){
		
		
		$this->db->where('financialYear', $year);
		$this->db->where('period', $period);
		
		$query = $this->db->get('comp_financial_year');
			
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return true;
		}
	}

	public function financialYear_year($year){
		
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('financialYear', $year);
		$query = $this->db->get('comp_financial_year');
			
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	}
	
}