<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glseq extends CI_Model{
	
	public function glSequence_jl(){
		$this->load->model('Compfinancialyear');
		$query = $this->Compfinancialyear->compfinancialyear_date($this->input->post('effdate'));
		$datafcal = $query[0];
		$data['financialYear'] = $datafcal->financialYear;
		$data['period'] = $datafcal->period;
		
		$this->load->model('Compjlseq');
		$query = $this->Compjlseq->compjlseq_yearperiod( '1', 'JL', $datafcal->financialYear, $datafcal->period );
		if($query){
			$oldseq = $query[0];
			$updatedata = array(
				'seqNo' => $oldseq->seqNo + 1
			);
			$this->Compjlseq->compjlseq_update($updatedata, $oldseq->ID);
			$data['seqNumber'] = $oldseq->initial . $oldseq->year . sprintf('%02d', $oldseq->period) . sprintf('%08d', ($oldseq->seqNo + 1));
			return $data;
//    		print json_encode(array("status"=>"success", "message"=>$data['seqNumber']));
		}else{
			$newdata = array(
				'compID' => element('compID', $this->session->userdata('logged_in')),
				'moduleID' => '1',
				'year' => $datafcal->financialYear,
				'period' => $datafcal->period,
				'initial' => 'JL',
				'seqNo' => 1
			);
			$sql = $this->Compjlseq->compjlseq_insert($newdata);
			$data['seqNumber'] = 'JL' . $datafcal->financialYear . sprintf('%02d', $datafcal->period) . sprintf('%08d', (1));
			return $data;
		}
	}
	
	public function glSequence_rv(){
		$this->load->model('Compfinancialyear');
		$query = $this->Compfinancialyear->compfinancialyear_date($this->input->post('effdate'));
		$datafcal = $query[0];
		$data['financialYear'] = $datafcal->financialYear;
		$data['period'] = $datafcal->period;
		
		$this->load->model('Compjlseq');
		$query = $this->Compjlseq->compjlseq_yearperiod( '1', 'RV', $datafcal->financialYear, $datafcal->period );
		if($query){
			$oldseq = $query[0];
			$updatedata = array(
				'seqNo' => $oldseq->seqNo + 1
			);
			$this->Compjlseq->compjlseq_update($updatedata, $oldseq->ID);
			$data['seqNumber'] = $oldseq->initial . $oldseq->year . sprintf('%02d', $oldseq->period) . sprintf('%08d', ($oldseq->seqNo + 1));
			return $data;
//    		print json_encode(array("status"=>"success", "message"=>$data['seqNumber']));
		}else{
			$newdata = array(
				'compID' => element('compID', $this->session->userdata('logged_in')),
				'moduleID' => '1',
				'year' => $datafcal->financialYear,
				'period' => $datafcal->period,
				'initial' => 'RV',
				'seqNo' => 1
			);
			$sql = $this->Compjlseq->compjlseq_insert($newdata);
			$data['seqNumber'] = 'RV' . $datafcal->financialYear . sprintf('%02d', $datafcal->period) . sprintf('%08d', (1));
			return $data;
		}
	}
	
	public function glSequence_sub($module, $year, $period){
		$this->load->model('Compjlseq');
		$query = $this->Compjlseq->compjlseq_yearperiod( '1', $module, $year, $period );
		if($query){
			$oldseq = $query[0];
			$updatedata = array(
				'seqNo' => $oldseq->seqNo + 1
			);
			$this->Compjlseq->compjlseq_update($updatedata, $oldseq->ID);
			$data['seqNumber'] = $oldseq->initial . $oldseq->year . sprintf('%02d', $oldseq->period) . sprintf('%08d', ($oldseq->seqNo + 1));
			return $data;
//    		print json_encode(array("status"=>"success", "message"=>$data['seqNumber']));
		}else{
			$newdata = array(
				'compID' => element('compID', $this->session->userdata('logged_in')),
				'moduleID' => '1',
				'year' => $year,
				'period' => $period,
				'initial' => $module,
				'seqNo' => 1
			);
			$sql = $this->Compjlseq->compjlseq_insert($newdata);
			$data['seqNumber'] = $module . $datafcal->financialYear . sprintf('%02d', $datafcal->period) . sprintf('%08d', (1));
			return $data;
		}
	}
}

