<script>
jQuery(document).ready(function() {
	jQuery("#content").find("input").keyup(function() {
		if (jQuery(this).attr('id') == "role") {
			jQuery(this).val(jQuery(this).val().toUpperCase());
		}
	});
});

	function changeList(obj){
		var itemType = obj.value;
		if (itemType == 23) //code for itemtype services
		{
			$('#reorderLevel').attr('disabled','disabled');
			$('#inventories').attr('disabled','disabled');			
		}else {
			$('#reorderLevel').removeAttr('disabled'); 
			$('#inventories').removeAttr('disabled');		}
/*		$('#item_type').empty();
		//return confirm(obj.value);
		var id = obj.value;
		$.ajax({
			type: "POST",
			url: "<?php echo base_url()?>icsetting/itemTypeList",
			data: "itemCategoryID="+id,
			dataType:"json",
			success: function(content){
				if(content.status == "success") {
					var items = [];
					items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].ID+'">['
						+ content.message[i].code +']'+ content.message[i].name + '</option>');
					}
					jQuery("#item_type").empty();
					jQuery("#item_type").append(items.join('</br>'));
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				}
///				
			}//end success
		}); //end ajax
*/		//return false;
	}

</script>

<div id="content">                        
<div class="wrap">
                  
<div class="head">
	<div class="info">
			<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
			<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href='<?php echo base_url()."item/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('title') ?></li>
            </ul>
	</div>
                        
	<div class="search">
		<form action="<?php echo base_url() ?>admin/search" method="post">
			<input name="search_text" type="text" placeholder="search..."/>                                
            <button type="submit"><span class="i-magnifier"></span></button>
		</form>
	</div>                        
</div>  <!-- Head -->                                                                  

	
<!--form action="iaccounts/itemSetup/itemSave" method="post"-->                    
<div class="content">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				$hidden = array('order_time' => date('Y-m-d H-i-s'),
				'ID' => $ID,
				'companyID' =>$companyID );
				$attrib = array('id'=>'validate'); 
				echo form_open('icsetting/itemSave', $attrib, $hidden); //onclick submit, data will be saved by controller itemSave ?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('itemSetup');?></h2>
                    </div>
				<div class="content np">    
                	<div class="controls-row">
                    	<div class="span2"><?php echo form_label($this->lang->line('itemCode'),'itemCode');?></div>
                   	<div class="span10">
                            	<?php 
								//echo var_dump($rs);
								$data = array(
									'name'=>'itemCode', 
									'id'=>'itemCode', 
									'value'=> (isset($rs->itemCode))?$rs->itemCode:'',
									'class'=>'span5 validate[required,maxSize[16]]',); 
								echo form_input($data, set_value('itemCode')); ?>
                                <span class="help-inline">Required, max size = 16</span>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('itemName'),'itemName');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'name', 
									'id'=>'name', 
									'value'=>(isset($rs->name))?$rs->name:'',
									'class'=>'span10 validate[required,maxSize[64]]',); 
							echo form_input($data, set_value('itemName')); ?>                       
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('itemDescription'),'itemDescription');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'itemDescription',
									'id'=>'itemDescription',
									'value'=>(isset($rs->description))?$rs->description:'',
									'class'=>'span10 validate[maxSize[150]]',); 
							echo form_input($data, set_value('password')); ?>                       
                        <span class="help-inline"></span>
                  </div>                            
                  </div> <!-- row control -->                           
                  <div class="controls-row">
                   	<div class="span2"><?php echo form_label($this->lang->line('itemCategory'),'category');?></div>
                   	<div class="span4">
						<?php
							$preseldept = (isset($rs->itemCategoryID))?$rs->itemCategoryID:0;
							$options[NULL] = $this->lang->line('pleaseselect');
							foreach($itemCategory as $row){
								$options[$row->ID] = '['.$row->code.'] '.$row->name;
							}
							//$js = 'title="Category" onChange="changeList(this)"';
							echo form_dropdown('item_category', $options, $preseldept);
	
						?>       
                     </div>                
                  	 <div class="span2 "><?php echo form_label($this->lang->line('itemType'),'itemType');?></div>
                   		<div class="span4">
						<?php
							$preselsec = (isset($rs->itemTypeID))?$rs->itemTypeID:0;
							$optionItemType[NULL] = $this->lang->line('pleaseselect');
							foreach($itemType as $rowItemType){
								$optionItemType[$rowItemType->ID] = '['.$rowItemType->code.'] '.$rowItemType->name;
							}
							//$js = 'id=item_type';
							$js = 'id="item_type" title="item Type" onChange="changeList(this)"';
							echo form_dropdown('item_type', $optionItemType, $preselsec, $js);
						?>                       
                    </div>                        
                   	 </div><!-- row control -->
                  <div class="controls-row">
                  	 <div class="span2"><?php echo form_label($this->lang->line('unitOfMeasure'),'unitOfMeasure');?></div>
                   		<div class="span4">
						<?php
							$preselsec = (isset($rs->unitOfMeasureID))?$rs->unitOfMeasureID:0;
							$optionUnitOfMeasure[NULL] = $this->lang->line('pleaseselect');
							foreach($rowUnitOfMeasure as $row){
								$optionUnitOfMeasure[$row->ID] = '['.$row->code.'] '.$row->name;
							}
							$js = 'id=unitOfMeasure';
							echo form_dropdown('unitOfMeasure', $optionUnitOfMeasure, $preselsec, $js);
						?>                       
                    </div>                        
                  	 <div class="span2 TAR"><?php echo form_label($this->lang->line('itemStatus'),'itemStatus');?></div>
                   		<div class="span4">
						<?php
							$preselsec = (isset($rs->itemStatusID))?$rs->itemStatusID:0;
							$optionStatus[NULL] = $this->lang->line('pleaseselect');
							foreach($rowStatus as $row){
								$optionStatus[$row->ID] = '['.$row->code.'] '.$row->name;
							}
							$js = 'id=itemStatus';
							echo form_dropdown('itemStatus', $optionStatus, $preselsec, $js);
						?>                       
                    </div>                       
                  </div><!-- row control -->
                  <div class="controls-row">
                  	 <div class="span2"><?php echo form_label($this->lang->line('reorderLevel'),'reorderLevel');?></div>
                   	<div class="span4">
                            	<?php 								
								$data = array(
									'name'=>'reorderLevel', 
									'id'=>'reorderLevel', 
									'value'=> (isset($rs->reorderLevel))?$rs->reorderLevel:0,
									'class'=>'span5 validate[custom[number]',); 
								echo form_input($data, set_value('reorderLevel')); ?>
                  </div>
                  	 <div class="span2 TAR"><?php echo form_label($this->lang->line('income'),'income');?></div>
                   		<div class="span3">
						<?php
							$preselsec = (isset($rs->incomeID))?$rs->incomeID:0;
							$optionIncome[NULL] = $this->lang->line('pleaseselect');
							foreach($rowIncome as $row){
								$optionIncome[$row->ID] = '['.$row->acctCode.'] '.$row->acctName;
							}
							$js = 'id=income';
							echo form_dropdown('income', $optionIncome, $preselsec, $js);
						?>                       
                    </div>                        
                    </div>  <!-- row control -->                      
                  <div class="controls-row">
                  	 <div class="span2"><?php echo form_label($this->lang->line('cogs'),'cogs');?></div>
                   		<div class="span4">
						<?php
							$preselsec = (isset($rs->cogsID))?$rs->cogsID:0;
							$optionCogs[NULL] = $this->lang->line('pleaseselect');
							foreach($rowCogs as $row){
								$optionCogs[$row->ID] = '['.$row->acctCode.'] '.$row->acctName;
							}
							$js = 'id=cogs';
							echo form_dropdown('cogs', $optionCogs, $preselsec, $js);
						?>                       
                  </div>
                  	 <div class="span2 TAR"><?php echo form_label($this->lang->line('inventories'),'inventories');?></div>
                   		<div class="span3">
						<?php
							$preselsec = (isset($rs->inventoriesID))?$rs->inventoriesID:0;
							$optionInventories[NULL] = $this->lang->line('pleaseselect');
							foreach($rowInventories as $row){
								$optionInventories[$row->ID] = '['.$row->acctCode.'] '.$row->acctName;
							}
							$js = 'id=inventories';
							echo form_dropdown('inventories', $optionInventories, $preselsec, $js);
						?>                       
                    </div>                        
                    </div>  <!-- row control -->                      
                  <div class="controls-row">
                  	 <div class="span2"><?php echo form_label($this->lang->line('inputTax'),'inputTax');?></div>
                   		<div class="span4">
						<?php
							$preselsec = (isset($rs->inputTaxID))?$rs->inputTaxID:0;
							$optionInputTax[NULL] = $this->lang->line('pleaseselect');
;
							foreach($rowInputTax as $row){
								$optionInputTax[$row->ID] = $row->code.' | '.$row->taxPercentage.' | '.$row->name;
							}
							$js = 'id=inputTax';
							echo form_dropdown('inputTax', $optionInputTax, $preselsec, $js);
						?>                       
                  </div>
                  	 <div class="span2 TAR"><?php echo form_label($this->lang->line('outputTax'),'outputTax');?></div>
                   		<div class="span3">
						<?php
							$preselsec = (isset($rs->outputTaxID))?$rs->outputTaxID:0;
							$optionOutputTax[NULL] = $this->lang->line('pleaseselect');
							foreach($rowOutputTax as $row){
								$optionOutputTax[$row->ID] = $row->code.' | '.$row->taxPercentage.' | '.$row->name;
							}
							$js = 'id=ouputTax';
							echo form_dropdown('ouputTax', $optionOutputTax, $preselsec, $js);
						?>                       
                    </div>                        
                    </div>  <!-- row control -->                      
                  
        <br />image file

               <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                        <?php 
							$data = array(
									'name'=>'validat', 
									'class'=>'btn',
									'onClick'=>"$('#validate').validationEngine('hide');"); 
							echo form_button($data,$this->lang->line('hideprompt'));
							$data = array(
									'name'=>'mysubmit', 
									'class'=>'btn btn-primary');
							//<a href="url_to_delete" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
							$js='onclick="return confirm(\'Press OK to continue...\')"';
							echo form_submit($data,$this->lang->line('submit'),$js);
							?>
                    </div>
                </div>
            </div>                                    
		</div>
	</form>
</div>
</div>                        
</div>
</div>
</div>
