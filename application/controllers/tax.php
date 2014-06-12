<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('9', 'transaction');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->model('menu');
	}

	public function index()
	{
		
	}
	
// Tax Table	
	public function setup(){
	  if($this->input->post('mysubmit')){
		$this->load->model('Taxmaster');
		  if($this->input->post('ID')==NULL){
			  $newdata = array(
			  	'companyID' => element('compID', $this->session->userdata('logged_in')),
			  	'code' => $this->input->post('code'),
			  	'name' => $this->input->post('name'),
			  	'taxType' => $this->input->post('taxType'),
			  	'taxPercentage' => $this->input->post('taxPercentage'),
			  	'taxClass' => $this->input->post('taxClass'),
			  	'taxGroup' => $this->input->post('taxGroup'),
			  	'description' => $this->input->post('description'),
			  	'taxAccount' => $this->input->post('taxAccount'),
			  	'status' => 0,
			  	'createdBy' => element('userid', $this->session->userdata('logged_in')),
			  	'createdTS' => $this->input->post('order_time'),
			  );
			  $query = $this->Taxmaster->taxmaster_insert($newdata);
			  if($query){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("taxtableList");
				</script>';
			  }else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			  }
		  }else{
			  $updatedata = array(
			  	'companyID' => element('compID', $this->session->userdata('logged_in')),
			  	'code' => $this->input->post('code'),
			  	'name' => $this->input->post('name'),
			  	'taxType' => $this->input->post('taxType'),
			  	'taxPercentage' => $this->input->post('taxPercentage'),
			  	'taxClass' => $this->input->post('taxClass'),
			  	'taxGroup' => $this->input->post('taxGroup'),
			  	'description' => $this->input->post('description'),
			  	'taxAccount' => $this->input->post('taxAccount'),
			  	'updatedBy' => element('userid', $this->session->userdata('logged_in')),
			  );
			  $query = $this->Taxmaster->taxmaster_save($this->input->post('ID'), $updatedata);
			  if($query){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("taxtableList");
				</script>';
			  }else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			  }
		  }
	  }else{
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$this->lang->load("tax",$this->session->userdata('language'));
		$this->load->model('Taxclass');
		$data['class'] = $this->Taxclass->taxclass_all();
		$this->load->model('Taxgroup');
		$data['group'] = $this->Taxgroup->taxgroup_all();
		$this->load->model('Taxtype');
		$data['taxtype'] = $this->Taxtype->taxtype_all();
		$this->load->model('Chartofaccount');
		$data['accounts'] = $this->Chartofaccount->chartofaccount_all();
//		$this->load->model('Usermaster');
//		$dataum = $this->Usermaster->usermaster_id($id);
//		$data['umaster'] = $dataum[0];
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->layouts->view('tax/setups/taxmaster', array('latest' => 'sidebar/latest'), $data);
	  }
	}
	public function loadTaxType() {
		$taxGroupID = $this->uri->segment(3);
		$this->load->model('Taxtype');
		//$query = $this->Taxtype->taxtype_byTaxGroup($taxGroupID);
		//$query = $this->taxtype->suppliermaster_allopt();
		//header('Content-Type: application/json');
/*		$region = $this->input->post('region');
    	$this->load->model('State');*/
    	$data['taxType']=$this->Taxtype->taxtype_byTaxGroup($taxGroupID);
    	print json_encode(array("status"=>"success", "message"=>$data['taxType']));

        //echo json_encode($query);		
		return TRUE;
	}
	public function taxtableList(){
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->lang->load("tax",$this->session->userdata('language'));
		$this->load->model('Taxmaster');
		$data['datatbls'] = $this->Taxmaster->useraccess_full();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('tax/setups/taxtablelist', array('latest' => 'sidebar/latest'), $data);
	}
	
// Tax Class	
	public function taxClass(){
	  if($this->input->post('mysubmit')){
		$this->load->model('Taxclass');
		  if($this->input->post('ID')==NULL){
			  $newdata = array(
			  	'code' => $this->input->post('code'),
			  	'shortName' => $this->input->post('shortName'),
			  	'description' => $this->input->post('description'),
			  	'taxAccount' => $this->input->post('taxAccount'),
			  	'createdBy' => element('userid', $this->session->userdata('logged_in')),
			  	'createdTS' => $this->input->post('order_time'),
			  );
			  $query = $this->Taxclass->taxclass_insert($newdata);
			  if($query){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("classList");
				</script>';
			  }else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			  }
		  }else{
			  $updatedata = array(
			  	'code' => $this->input->post('code'),
			  	'shortName' => $this->input->post('shortName'),
			  	'description' => $this->input->post('description'),
			  	'taxAccount' => $this->input->post('taxAccount'),
			  	'updatedBy' => element('userid', $this->session->userdata('logged_in')),
			  );
			  $query = $this->Taxclass->taxclass_save($this->input->post('ID'),$updatedata);
			  if($query){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("classList");
				</script>';
			  }else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			  }
		  }
	  }else{
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$this->lang->load("taxclass",$this->session->userdata('language'));
		$this->load->model('Chartofaccount');
		$data['accounts'] = $this->Chartofaccount->chartofaccount_all();
//		$this->load->model('Usermaster');
//		$dataum = $this->Usermaster->usermaster_id($id);
//		$data['umaster'] = $dataum[0];
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->layouts->view('tax/setups/taxclass', array('latest' => 'sidebar/latest'), $data);
	  }
	}
	
	public function classList(){
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$this->lang->load("taxclass",$this->session->userdata('language'));
		$this->load->model('Taxclass');
		$data['datatbls'] = $this->Taxclass->taxclass_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('tax/setups/classlist', array('latest' => 'sidebar/latest'), $data);
	}
	public function class_save(){
			$this->load->model('Taxclass');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Taxclass->taxclass_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	public function class_delete(){
			$this->load->model('Taxclass');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Taxclass->taxclass_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
// Tax Group	
	public function taxGroup(){
	  if($this->input->post('mysubmit')){
		$this->load->model('Taxgroup');
		  if($this->input->post('ID')==NULL){
			  $newdata = array(
			  	'code' => $this->input->post('code'),
			  	'description' => $this->input->post('description'),
			  	'taxAccount' => $this->input->post('taxAccount'),
			  	'createdBy' => element('userid', $this->session->userdata('logged_in')),
			  	'createdTS' => $this->input->post('order_time'),
			  );
			  $query = $this->Taxgroup->taxgroup_insert($newdata);
			  if($query){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("groupList");
				</script>';
			  }else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			  }
		  }else{
			  $updatedata = array(
			  	'code' => $this->input->post('code'),
			  	'description' => $this->input->post('description'),
			  	'taxAccount' => $this->input->post('taxAccount'),
			  	'updatedBy' => element('userid', $this->session->userdata('logged_in')),
			  );
			  $query = $this->Taxgroup->taxgroup_save($this->input->post('ID'),$updatedata);
			  if($query){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("groupList");
				</script>';
			  }else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			  }
		  }
	  }else{
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$this->lang->load("taxgroup",$this->session->userdata('language'));
		$this->load->model('Chartofaccount');
		$data['accounts'] = $this->Chartofaccount->chartofaccount_all();
//		$this->load->model('Usermaster');
//		$dataum = $this->Usermaster->usermaster_id($id);
//		$data['umaster'] = $dataum[0];
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->layouts->view('tax/setups/taxgroup', array('latest' => 'sidebar/latest'), $data);
	  }
	}

	public function groupList(){
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$this->lang->load("taxgroup",$this->session->userdata('language'));
		$this->load->model('Taxgroup');
		$data['datatbls'] = $this->Taxgroup->taxgroup_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('tax/setups/grouplist', array('latest' => 'sidebar/latest'), $data);
	}
	public function group_save(){
			$this->load->model('Taxgroup');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Taxgroup->taxgroup_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	public function group_delete(){
			$this->load->model('Taxgroup');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Taxgroup->taxgroup_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
// Tax Type	
	public function taxType(){
	  if($this->input->post('mysubmit')){
		$this->load->model('Taxtype');
		  if($this->input->post('ID')==NULL){
			  $newdata = array(
			  	'code' => $this->input->post('code'),
			  	'description' => $this->input->post('description'),
			  	'taxAccount' => $this->input->post('taxAccount'),
			  	'createdBy' => element('userid', $this->session->userdata('logged_in')),
			  	'createdTS' => $this->input->post('order_time'),
			  );
			  $query = $this->Taxtype->taxtype_insert($newdata);
			  if($query){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("typeList");
				</script>';
			  }else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			  }
		  }else{
			  $updatedata = array(
			  	'code' => $this->input->post('code'),
			  	'description' => $this->input->post('description'),
			  	'taxAccount' => $this->input->post('taxAccount'),
			  	'updatedBy' => element('userid', $this->session->userdata('logged_in')),
			  );
			  $query = $this->Taxgroup->taxgroup_save($this->input->post('ID'),$updatedata);
			  if($query){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("typeList");
				</script>';
			  }else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			  }
		  }
	  }else{
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$this->lang->load("taxtype",$this->session->userdata('language'));
		$this->load->model('Chartofaccount');
		$data['accounts'] = $this->Chartofaccount->chartofaccount_all();
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
				->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->layouts->view('tax/setups/taxtype', array('latest' => 'sidebar/latest'), $data);
	  }
	}
	
	public function typeList(){
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
		$this->lang->load("taxtype",$this->session->userdata('language'));
		$this->load->model('Taxtype');
		$data['datatbls'] = $this->Taxtype->taxtype_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('tax/setups/typelist', array('latest' => 'sidebar/latest'), $data);
	}
	public function type_save(){
			$this->load->model('Taxtype');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Taxtype->taxtype_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	public function type_delete(){
			$this->load->model('Taxtype');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Taxtype->taxtype_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}
}

	
/* End of file tax.php */
/* Location: ./application/controller/tax.php */
