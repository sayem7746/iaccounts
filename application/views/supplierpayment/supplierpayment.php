<script>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
    $('.add_more').click(function(e){
        e.preventDefault();
        $(this).before("<input name='file_load[]' type='file' class='uni' multiple/>");
    });
	
	jQuery("#content").find("input").keyup(function() {
		jQuery(this).val(jQuery(this).val().toUpperCase());
	});
});
	
	function changeList(obj){
		var id = obj.value;
		alert(id);
		$.ajax({
			type: "POST",
			url: "<?php base_url()?>getAddress/",
			data: "address="+id,
			dataType:"json",
			success: function(content){
				if(content.status == "success") {
					$('#supplierAddress').val(content.message.addressName);
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				}
			}
		}); 
		return false;
	}

</script>
<div id="content">                        
<div class="wrap">
                  
<div class="head">
	<div class="info">
		<h1><?php echo $module ?></h1>
			<ul class="breadcrumb">
            	<li><a href="#">Dashboard</a> <span class="divider">-</span></li>
                <li><a href="#"><?php echo $module ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $title ?></li>
            </ul>
	</div>
                          
	<div class="search">
		<form action="<?php echo base_url() ?>admin/search" method="post">
			<input name="search_text" type="text" placeholder="search..."/>                                
            <button type="submit"><span class="i-magnifier"></span></button>
		</form>
	</div>                        
</div>  <!-- Head -->
                                                                                   
<div class="content">
                    
	<div class="row-fluid">
		<div class="span12">
			<?php 
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2>Supplier Payment Form</h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                       
                    </div>
				</div>
				<div class="content np">    
                    <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('supplier'),'Supplier');?></div>
                   	<div class="span10">
						<?php
							$preselpayee = '0';
							$options = '';
							$options[] = '--Please Select--';
							foreach($supplier as $row){
							$options[$row->ID] = $row->supplierName;
							}
							$js='onChange="changeList(this)"';
							echo form_dropdown('supplierID', $options, $preselpayee, $js);
						?>                        
                  </div>
                  </div>
                  <div class="controls-row">
                    	<div class="span2">Supplier Address:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'supplierAddress', 
									'id'=>'supplierAddress', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('supplierAddress')); ?>
                                <span class="help-inline">Required, max size = 10</span>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2">Address 2</div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'line1', 
									'id'=>'line1', 									
									'class'=>'span5 validate[maxSize[30]]',); 
							echo form_input($data, set_value('line1')); ?>                      
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2">City:</div>
                   	<div class="span4">
						<?php
							$data = array(
									'name'=>'city', 
									'id'=>'city', 									
									'class'=>'span3 validate[maxSize[10]]',); 
							echo form_input($data, set_value('city')); ?>                       
        
                  </div>
                    <div class="span1" TAR><?php echo form_label('PostCode:','postCode');?></div>
                     <div class="span4">
						<?php
							$data = array(
									'name'=>'postCode', 
									'id'=>'postCode', 									
									'class'=>'span3 validate[maxSize[10]]',); 
							echo form_input($data, set_value('postCode')); ?>                       
                  </div>
                  </div>
                  <div class="controls-row">
                    	<div class="span2">Project:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'project', 
									'id'=>'project', 
									'class'=>'span5 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('project')); ?>
                  </div>
                  </div>   
                     <div class="controls-row">
                    	<div class="span2">Amount Paid:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'amountPaid', 
									'id'=>'amountPaid', 
									'class'=>'span5 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('amountPaid')); ?>
                  </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span2">Balance:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'outOfBalance', 
									'id'=>'outOfBalance', 
									'class'=>'span5 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('outOfBalance')); ?>
                  </div>
                  </div>
                  
                  <div class="controls-row"> 
                    	<div class="span2"><?php echo form_label('Payment Method:','paymentmethod');?></div>
                   		<div class="span4">
						<?php
							$preselpayment = '2';
							$options = '';
							$options[] = '--Please Select--';
							foreach($paymentmethod as $row){
							$options[$row->ID] = $row->name;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('paymentmethod', $options, $preselpayment);
						?>       
                     </div> 
                     </div> 
                        <div class="controls-row">
                    	<div class="span2">Account Description:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'accountDescription', 
									'id'=>'accountDescription', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('accountDescription')); ?>
                  </div>
                  </div> 
                           <div class="controls-row">
                    	<div class="span2">Exchange Rate:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'exchangeRate', 
									'id'=>'exchangeRate', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('exchangeRate')); ?>
                  </div>
                  </div>      
                  <div class="controls-row">
                    	<div class="span2">Form No:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'formNo', 
									'id'=>'formNo', 
									'class'=>'span5 validate[maxSize[30]]',
									'value'=>$formNo,); 
								echo form_input($data, set_value('formNo')); ?>
                  </div>
                  </div>              
                 <div class="controls-row">
                       <div class="span2">Payment Date:</div>
                       <div class="span9">
                       <div class="input-prepend">
                         <span class="add-on"><i class="i-calendar"></i></span>
				                 <?php
								$data = array(
								'name' => 'createdDate',
								'id' => 'createdDate',
								'type' => 'text',
								'class' => 'datepicker',);
								echo form_input($data, date('d-m-Y'));
                    	        ?>
                          </div>
                         </div>    
                         </div>      
                 <div class="controls-row">
                    	<div class="span2"><?php echo form_label('Currency:','currency');?></div>
                   		<div class="span4">
						<?php
							$preselcurr = '1';
							$options = '';
							$options[] = '--Please Select--';
							foreach($currency as $row){
							$options[$row->fldid] = $row->fldcurr_code;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('currency', $options, $preselcurr);
						?>       
                     </div> 
                     </div>
                           <div class="controls-row">
                    	<div class="span2">Reference No:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'referenceNo', 
									'id'=>'referenceNo', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('referenceNo')); ?>
                  </div>
                  </div> 
                <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                        <?php 
							$data = array(
									'name'=>'validat', 
									'class'=>'btn',
									'onClick'=>"$('#validate').validationEngine('hide');"); 
							echo form_button($data,'Hide prompts');
							$data = array(
									'name'=>'mysubmit', 
									'class'=>'btn btn-primary');
							$js='onclick="return confirm(\'Press OK to continue...\')"';
							echo form_submit($data,'Submit',$js);
							?>
                    </div>
                </div>
                            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Total Amount</th>   
                        <th>AP Balance</th>                         
                		<th>Discount</th>    
                        <th>Amount Applied</th>   
            		</tr>
        			</thead>
       				 <tbody>
					</tbody>
			</table>                                         
			</div>
            
</div>                                
</div>
</div>                                
</div>
</div>                                
</div>
</div>
<div class="dialog" id="row_delete" style="display: none;" title="Are you sure to Delete?">
    <p>Row will be deleted</p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Are you sure to Edit ?">
    <p>To editing page.....</p>
</div> 
                
        
	</form>

