<script>
$(document).ready(function(){
	$('select').select2();
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
		$.ajax({
			type: "POST",
			url: "<?php base_url()?>../setting/getState/",
			data: "region="+id,
			dataType:"json",
			success: function(content){
				if(content.status == "success") {
					var items = [];
					items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].fldid+'">'
						+ content.message[i].fldname + '</option>');
					}
					jQuery("#state").empty();
					jQuery("#state").append(items.join('</br>'));
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				}
			}
		});
		return false;
	}

</script>                      
<div class="wrap">
                                                                                   
<div class="content">
                    
	<div class="row-fluid">
		<div class="span12">
			<?php 
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title') ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                       
                    </div>
				</div>
				<div class="content np">    
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('supplierCompanyNo') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'supplierCompanyNo',
									'id'=>'supplierCompanyNo',								
									'class'=>'span3 validate[required,minSize[5],maxSize[10]]',); 
							echo form_input($data, set_value('supplierCompanyNo')); ?>                       
                  </div>                            
                  </div>    
                	<div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('supplierName') ?></div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'supplierName', 
									'id'=>'supplierName', 
									'class'=>'span8 validate[required,maxSize[128]]',); 
								echo form_input($data, set_value('supplierName')); ?>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('supplierAccountCode') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'supplierAccountCode', 
									'id'=>'supplierAccountCode', 									
									'class'=>'span3 validate[required,minSize[5],maxSize[10]]',); 
							echo form_input($data, set_value('supplierAccountCode')); ?>                       
                  </div>
                  </div>
                     <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo $this->lang->line('country') ?></div>
                   		<div class="span4">
						<?php
							$preselcat = '458';
							$options[] = '--Please Select--';
							foreach($country as $row){
								$options[$row->fldid] = $row->fldcountry;
							}
							$js='onChange="changeList(this)" style="width: 250px;"';
							echo form_dropdown('supplierCountryID', $options, $preselcat, $js);
						?>       
                     </div>                
                    	<div class="span1" TAR><?php echo $this->lang->line('state') ?></div>
                   		<div class="span4">
						<?php
							$preseltype = '0';
							$options='';
							$options[] = '--Please Select--';
							if($state != ''){
								foreach($state as $row){
									$options[$row->fldid] = $row->fldname;
								}
							}
							$js='id=state style="width: 250px;"';
							echo form_dropdown('supplierStateID', $options, $preselcat, $js);
						?>       
                         </div>                
                  </div><!-- End Row 1 -->
			</div> <!-- End Content 1 -->
		<div class="content np"> 
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('attention') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'attention',
									'id'=>'attention',								
									'class'=>'span3 validate[minSize[5],maxSize[10]]',); 
							echo form_input($data, set_value('attention')); ?>                       
                  </div>                            
                  </div>  
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('email') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'email', 
									'class'=>'span5 validate[custom[email]]',); 
							echo form_input($data, set_value('email')); ?>                       
							<span class="help-inline"><?php echo $this->lang->line('example') ?>: accounts@salihin.com.my</span>
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('website') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'website', 
									'class'=>'span5 validate[maxSize[16]]',); 
							echo form_input($data, set_value('website')); ?>                       
                    </div>                        
                  </div>                   
                  <div class="content np"> 	     		                                                           
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('phoneNumber1') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'phoneNumber1', 
									'id'=>'phoneNumber1', 
									'class'=>'span5 validate[maxSize[16]]',); 
							echo form_input($data, set_value('phoneNumber1')); ?>                       
 							<span class="help-inline"><?php echo $this->lang->line('example') ?>: 603 61851515</span>
                     </div>                
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('phoneNumber2') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'phoneNumber2', 
									'class'=>'span5 validate[maxSize[16]]',); 
							echo form_input($data, set_value('phoneNumber2')); ?>                       
 							<span class="help-inline"><?php echo $this->lang->line('example') ?>: 603 61851515</span>
                    </div>                        
                  </div>
                      <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('fax') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'fax', 
									'class'=>'span5 validate[maxSize[16]]',); 
							echo form_input($data, set_value('fax')); ?>                       
 							<span class="help-inline"><?php echo $this->lang->line('example') ?>: 603 61851515</span>
                    </div>                        
                  </div>    
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('generalNote') ?></div>
                   	<div class="span10">
                    	<?php
                            $data = array(
									'name'=>'generalNote', 
									'class'=>'span5 validate[maxSize[16]]',); 
							echo form_input($data, set_value('generalNote')); ?>   	                     
                  </div>                                                
                  </div>
                  <div class="controls-row">
                  	<div class="span3"><?php echo $this->lang->line('gstRegNo') ?></div>
                   	<div class="span7">
						<?php
							$data = array(
									'name'=>'gstRegNo', 
									'id'=>'gstRegNo', 
									'class'=>'span2'); 
							echo form_input($data, set_value('gstRegNo')); ?>                       
							<span class="help-inline"><?php echo $this->lang->line('example') ?>:A234-A</span>
                    </div>                        
                  </div>
                  <div class="controls-row"> 
                    	<div class="span2"><?php echo $this->lang->line('termstatus') ?></div>
                   		<div class="span4">
						<?php
							$preselstatus = '1';
							$options = '';
							$options[] = '--Please Select--';
							foreach($termstatus as $row){
							$options[$row->ID] = $row->name;
							}
							$js='style="width: 250px;"';
							echo form_dropdown('termstatus', $options, $preselstatus, $js);
						?>       
                     </div> 
                     </div>                      
                   <div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('creditLimit') ?></div>
                   		<div class="span4">
                        <?php 								
							$data = array(
									'name'=>'creditLimit', 
									'id'=>'creditLimit', 
									'class'=>'span5');
							echo form_input($data, set_value('creditLimit')); ?>
              
                   		</div>
                        <div class="span4">
                      <label class="checkbox inline">
                      <input type="checkbox" class="validate" name="terms" value="1"/>Credit Limit Alert</label>
                      </div>
                    </div>
                   <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo $this->lang->line('linkedAPAccountID') ?></div>
                   		<div class="span4">
						<?php
							$presellinkAP = '';
							$options = '';
							$options[] = '--Please Select--';
							foreach($chartAccounts as $row){
							$options[$row->ID] = $row->acctCode . " [" . $row->acctName . "]";
							}
							$js='style="width: 250px;"';
							echo form_dropdown('linkedAPAccount', $options, $presellinkAP, $js);
						?>       
                     </div> 
                     </div>  
                   <div class="controls-row">
                       <div class="span2"><?php echo $this->lang->line('createdDate') ?></div>
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

                    	<div class="span2"><?php echo $this->lang->line('currency') ?></div>
                   		<div class="span4">
						<?php
							$preselcurr = '1';
							$options = '';
							$options[] = '--Please Select--';
							foreach($currency as $row){
							$options[$row->fldid] = $row->fldcurr_code . " [" . $row->fldcurr_desc . "]";
							}
							$js='style="width: 250px;"';
							echo form_dropdown('currencyID', $options, $preselcurr, $js);
						?>       
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
            </div>   
	</form>

