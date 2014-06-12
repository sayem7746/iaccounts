<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Icsetting extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('4', 'setup');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->library('layouts');
		$this->load->model('menu');
	}

// Unit Of Measure

	public function unitmeasurelist(){
		$this->load->model('Sysum');
		$this->lang->load("um",$this->session->userdata('language'));
		$data['datatbls'] = $this->Sysum->sysum_all();
		$data['headertbl'] = $this->session->userdata('menuactive');
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('ic/setups/unitmeasure', array('latest' => 'sidebar/latest'), $data);
	}

	public function um_save(){
			$this->load->model('Sysum');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Sysum->sysum_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function um_insert(){
			$this->load->model('Sysum');
			$code = $this->input->post('code');
			$desc = $this->input->post('desc');
			$data = array(
				'code' => $code,
				'desc' => $desc
				);
		  	$query = $this->Sysum->sysum_insert($data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function um_delete(){
			$this->load->model('Sysum');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Sysum->sysum_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
// Unit Measure Conversion
	public function umconversion(){
	  if($this->input->post('mysubmit')){
		$this->load->model('Sysumconv');	
		  if($this->input->post('fldid')==NULL){
			  $newdata = array(
			  	'from_um'		=> $this->input->post('from_um'), 
			  	'to_um'		=> $this->input->post('to_um'), 
			  	'unitm'		=> $this->input->post('unitm'), 
			  	'factor'		=> $this->input->post('factor'), 
		  		'create_by'		=> element('userid', $this->session->userdata('logged_in')), 
		  	);
		  	$insert_data = $this->Sysumconv->sysumconv_insert($newdata);
			if($insert_data){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("umconversionlist");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }else{
			$fldid = $this->input->post('fldid');
		  	$update = array(
			  	'fldid'		=> $this->input->post('fldid'), 
			  	'from_um'		=> $this->input->post('from_um'), 
			  	'to_um'		=> $this->input->post('to_um'), 
			  	'unitm'		=> $this->input->post('unitm'), 
			  	'factor'		=> $this->input->post('factor'), 
			  	'modified_dt'		=> $this->input->post('order_time'), 
		  		'modified_by'		=> element('userid', $this->session->userdata('logged_in')), 
		 	);
		  	$update_data = $this->Sysumconv->sysumconv_edit($update, $fldid);
			if($update_data){
				echo '<script>alert("Update Success..");
					window.location.replace("suppliers_list");
					</script>';
			}else{
				echo '<script>alert("Update Failed.");
				history.go(-1);</script>';
			}
		  }
	  }else{
		  $id = $this->uri->segment(3);
		  $this->load->model('Sysum');
		  $this->lang->load("um",$this->session->userdata('language'));
		  $data['unitmeasure'] = $this->Sysum->sysum_all();
		  $this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
		  	->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/uniform/jquery.uniform.min.js');
		  $this->layouts->view('ic/setups/umconversion', array('latest' => 'sidebar/latest'), $data);
	  }
	}

	public function umconversionlist(){
			$this->load->model('Sysum');
			$data['datatblsum'] = $this->Sysum->sysum_all();
			$this->load->model('Sysumconv');
		    $this->lang->load("um",$this->session->userdata('language'));
			$data['datatbls'] = $this->Sysumconv->sysumconv_all();
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('purchasesetting/umconversionlist', array('latest' => 'sidebar/latest'), $data);
	}

	public function umconv_save(){
			$this->load->model('Sysumconv');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Sysumconv->sysumconv_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function umconv_insert(){
			$this->load->model('Sysumconv');
			$from_um = $this->input->post('from_um');
			$to_um = $this->input->post('to_um');
			$unitm = $this->input->post('unitm');
			$factor = $this->input->post('factor');
			$data = array(
				'from_um' => $from_um,
				'to_um' => $to_um,
				'unit' => $unit,
				'factor' => $factor
				);
		  	$query = $this->Sysumconv->sysumconv_insert($data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	public function umconv_delete(){
			$this->load->model('Sysumconv');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Sysumconv->sysumconv_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
// Item Master

	public function itemList() {
		$this->lang->load("item",$this->session->userdata('language'));
		$this->load->model('item/itemSetup_model');
		$listData['datatbls'] = $this->itemSetup_model->get_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('ic/setups/item_list', array('latest' => 'sidebar/latest'), $listData);
	}
	
	public function item_id(){
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']: $this->uri->segment(3);
		$this->lang->load("item",$this->session->userdata('language'));
		$this->load->model('master/masterCode_model');
		$data['rowStatus'] = $this->masterCode_model->get_all(array('masterID'=>1));
		$data['itemCategory'] = $this->masterCode_model->get_all(array('masterID'=>8));
		$data['itemType'] = $this->masterCode_model->get_all(array('masterID'=>9)); //default list all item_type
		$data['rowUnitOfMeasure'] = $this->masterCode_model->get_all(array('masterID'=>12)); //default list all unit of measure
		$this->load->model('chartofaccount');
		$data['rowIncome'] = $this->chartofaccount->chartofaccount_all();
		$data['rowCogs'] = $this->chartofaccount->chartofaccount_all();
		$data['rowInventories'] = $this->chartofaccount->chartofaccount_all();
		$this->load->model('taxmaster');
		$data['rowOutputTax'] = $this->taxmaster->taxmaster_saleOutput();
		$data['rowInputTax'] = $this->taxmaster->taxmaster_purchaseInput();
		$this->load->model('item/itemSetup_model');
		$rs=$this->itemSetup_model->get_byID($ID);
		$data['rs']=$rs[0];
		$data['ID']=$ID;
		$data['companyID']=element('compID', $this->session->userdata('logged_in')) ; 
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->layouts->view('ic/setups/itemForm', array('latest' => 'sidebar/latest'), $data); //send empty $data as new record
	
	}
	
	public function itemNew() {
//		$this->lang->load("namafile",$this->session->userdata('language'));
		$this->lang->load("item",$this->session->userdata('language'));
		$this->load->model('master/masterCode_model');
		$data['rowStatus'] = $this->masterCode_model->get_all(array('masterID'=>1));
		$data['itemCategory'] = $this->masterCode_model->get_all(array('masterID'=>8));
		$data['itemType'] = $this->masterCode_model->get_all(array('masterID'=>9)); //default list all item_type
		$data['rowUnitOfMeasure'] = $this->masterCode_model->get_all(array('masterID'=>12)); //default list all unit of measure
		$this->load->model('chartofaccount');
		$data['rowIncome'] = $this->chartofaccount->chartofaccount_all();
		$data['rowCogs'] = $this->chartofaccount->chartofaccount_all();
		$data['rowInventories'] = $this->chartofaccount->chartofaccount_all();
		$this->load->model('taxmaster');
		$data['rowOutputTax'] = $this->taxmaster->taxmaster_saleOutput();
		$data['rowInputTax'] = $this->taxmaster->taxmaster_purchaseInput();
		
		$data['ID']=0;
		$data['companyID']=element('compID', $this->session->userdata('logged_in')) ;  
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js')
			->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('ic/setups//itemForm', array('latest' => 'sidebar/latest'), $data); //send empty $data as new record
	}
	public function itemSave() { //save record
			$this->load->model('item/itemSetup_model');
			$ID = $this->input->post('ID');
			$companyID =  element('compID', $this->session->userdata('logged_in')) ;
			$dataupdate = array (
				'companyID' => $companyID, 
				'itemCode' => $this->input->post('itemCode'),
				'name' => $this->input->post('name'),
				'description' => $this->input->post('itemDescription'),
				'itemCategoryID' => $this->input->post('item_category'),
				'itemTypeID' => $this->input->post('item_type'),
				'unitOfMeasureID' => $this->input->post('unitOfMeasure'),
				'editDescription' => $this->input->post(''),
				'itemStatusID' => $this->input->post('itemStatus'),
				'reorderLevel' => $this->input->post('reorderLevel'),
				'incomeID' => $this->input->post('income'),
				'cogsID' => $this->input->post('cogs'),
				'inventoriesID' => $this->input->post('inventories'),
				'inputTaxID' => $this->input->post('inputTax'),
				'outputTaxID' => $this->input->post('ouputTax'),
				'supplierID' => 0,
			);

            if ($ID=='' || $ID==0)
			  	$query = $this->itemSetup_model->insert($dataupdate);
		  	else $query = $this->itemSetup_model->update_byID($ID, $dataupdate);
			if($query){
				echo '<script>alert("Save Success..");
						window.location.replace("itemList");
						</script>';
			}else{
				return FALSE;
			}
	}
	
	public function getItemList()
	{
		$itemCategoryID = $this->input->post('region');
    	$this->load->model('master/masterCode_model');
    	$data['statelist']=$this->State->state_region($region);
    	print json_encode(array("status"=>"success", "message"=>$data['statelist']));
	}
	
// Item Category
	public function itemCategoryList() {
			$this->lang->load("masterCode",$this->session->userdata('language'));
			$this->load->model('master/masterCode_model');
			$filter['masterID']=8; //masterID=8 for itemCategory
			$listData['datatbls'] = $this->masterCode_model->get_all($filter); 
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('ic/setups/masterCodeList', array('latest' => 'sidebar/latest'), $listData);
	}

// Item Type	
	public function itemTypeList() {
			$this->lang->load("masterCode",$this->session->userdata('language'));
			$this->load->helper('menu');
			$this->load->model('master/masterCode_model');
			$filter['masterID']=9; //masterID=9 for itemType
			//$listData = $this->masterCode_model->get_all($filter); 
			$listData['datatbls'] = $this->masterCode_model->get_all($filter); 
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('ic/setups/masterCodeList', array('latest' => 'sidebar/latest'), $listData);

			//echo json_encode(array("status"=>"success", "message"=>$listData));


	}
}
/* End of file icsetting.php */
/* Location: ./application/controller/icsetting.php */
