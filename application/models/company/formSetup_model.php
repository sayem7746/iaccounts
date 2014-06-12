<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FormSetup_model extends CI_Model{
	
	public function formAccess_all($id){
		$query = $this->db->get_where('comp_form_control', array('companyID'=>$id));		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function formSetup_id($id){
		//select b.* , a.* from master_code b left outer join comp_form_control a on b.ID = a.formID where a.masterID = 18 and a.companyid = $id order by b.orderNo
		//insert form no from master_code not in control table
		$this->db->query('insert into comp_form_control (companyID, formID, formCode,createdby, orderno)
select '.$id.', id, code, 1, orderno from master_code
where masterid=18 and id not in (select formid from comp_form_control where companyid='.$id.')');
		$this->db->select('master_code.ID as formID');
		$this->db->select('master_code.name');
		$this->db->select('comp_form_control.ID');
		$this->db->select('comp_form_control.formCode');
		$this->db->select('comp_form_control.formYear');
		$this->db->select('comp_form_control.formMonth');
		$this->db->select('comp_form_control.formDay');
		$this->db->select('comp_form_control.formInitial');
		$where = ' and comp_form_control.companyID ='.$id;
		//$this->db->where('comp_form_control.companyID', $id);
		$this->db->where('master_code.masterID',18); //18=list of form
		$this->db->from('master_code');
		$this->db->join('comp_form_control', 'master_code.ID = comp_form_control.formID '.$where,'left outer');
		$query = $this->db->get();

/*		$sql = '`master_code`.`ID` as formID, `master_code`.`name`, COALESCE(comp_form_control.formCode, master_code.code) as aaa, `comp_form_control`.* FROM (`master_code`) LEFT OUTER JOIN `comp_form_control` ON `master_code`.`ID` = `comp_form_control`.`formID` and comp_form_control.companyID =1 WHERE `master_code`.`masterID` = 18';
		$query = $this->db->get($sql);
		
*/		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function formSetup_update($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('comp_form_control', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function formSetup_id_form($form){
		$where = '(formYear = "1" OR formMonth = "1" OR formDay = "1")';
		$id = element('role', $this->session->userdata('logged_in'));
		$this->db->where('companyID', $id);
		$this->db->where('formID', $form);
		$this->db->where($where);
		$query = $this->db->get('comp_form_control');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function formSetup_id_form2($form, $fields){
		$id = element('role', $this->session->userdata('logged_in'));
		$this->db->where('companyID', $id);
		$this->db->where($fields, '1');
		$this->db->where('formID', $form);
		$query = $this->db->get('comp_form_control');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function getFormSerialNo_zeroLeading($number) {
		$maxLen = 14; //8characters zero leading ??why maxlen 14. not 8 -akmal
		for($i=0;$i < ($maxLen - strlen($number)); $i++)
			$number = '0'.$number;
		
		return $number; 
	}
	
	public function getFormNo($filter) {
		//SELECT concat(formcode,if(formyear=1,year(now()),''),if(formMonth=1,month(now()),''),if(formMonth=1,day(now()),''),forminitial) FROM `comp_form_control` where companyid = 1 
//$sql = "select concat(formcode,if(formyear=1,year(now()),''),if(formMonth=1,month(now()),''),if(formMonth=1,day(now()),''),forminitial)) as formno from comp_form_control where companyID=".'1'.' and fomID='.'41';
//echo $sql;
		$query = $this->db->query("select concat(formcode,if(formyear=1,year(now()),''),if(formMonth=1,date_format(now(),'%m'),''),if(formMonth=1,date_format(now(),'%d'),''),forminitial) as formno from comp_form_control where companyID=".$filter['companyID'].' and formID='.$filter['formID']);
//		$this->db->where('companyID', $filter['companyID']);
//		$this->db->where('formID', $filter['formID']);
//		$this->db->where($where);
//		$query = $this->db->get('comp_form_control');
		if($query->num_rows() >= 1){
			$result = $query->result();
//			echo 'akmal:'.$result[0]->formno;
			return $result[0]->formno;
		}else{
			return '';
		}
	}
	
}