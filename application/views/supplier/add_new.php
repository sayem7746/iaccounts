<script>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	jQuery("#supplierCode").keyup(function() {
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
					jQuery("#supplierStateID").empty();
					jQuery("#supplierStateID").append(items.join('</br>'));
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
		<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
		<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href="#"><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href="#"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
                    
<div class="content">
                    
	<div class="row-fluid">
		<div class="span12">
			<?php 
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				if($suppliermaster)
				$hidden['ID'] = $suppliermaster->ID;
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title') ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                    </div>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
				<div class="content np"> <!-- Content 1 -->   
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('supplierCode') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'supplierCode', 
									'id'=>'supplierCode', 									
									'class'=>'span3 validate[required]',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->supplierCode); 
							}else{
								echo form_input($data, set_value('supplierCode')); 
                            }                       ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('registrationNo') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'supplierCompanyNo', 
									'id'=>'supplierCompanyNo', 									
									'class'=>'span3 validate[required]',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->supplierCompanyNo); 
							}else{
								echo form_input($data, set_value('supplierCompanyNo')); 
                            }                       ?> 
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
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->supplierName); 
							}else{
								echo form_input($data, set_value('supplierName')); 
                            }                       ?> 
                  </div>
                  </div>
                 </div><!-- End Content-->
            </div> <!-- Block -->                                   
			<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('addressinfo') ?></h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
		<div class="content np">    
                  <div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('address') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'line1', 
									'id'=>'line1', 									
									'class'=>'span8 validate[maxSize[128]]',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->line1); 
							}else{
								echo form_input($data, set_value('line1')); 
                            }                       ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2">&nbsp;</div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'line2', 
									'id'=>'line2', 									
									'class'=>'span8 validate[maxSize[128]]',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->line2); 
							}else{
								echo form_input($data, set_value('line2')); 
                            }                       ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2">&nbsp;</div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'line3', 
									'id'=>'line3', 									
									'class'=>'span8 validate[maxSize[128]]',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->line3); 
							}else{
								echo form_input($data, set_value('line3')); 
                            }                       ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('city') ?></div>
                   	<div class="span4">
						<?php
							$data = array(
									'name'=>'city', 
									'id'=>'city', 									
									'class'=>'span8',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->city); 
							}else{
								echo form_input($data, set_value('city')); 
                            }                       ?> 
        
                  </div>
                    <div class="span1" TAR><?php echo $this->lang->line('postcode') ?></div>
                     <div class="span4">
						<?php
							$data = array(
									'name'=>'supplierPostCode', 
									'id'=>'supplierPostCode', 									
									'class'=>'span3 validate[minSize[5],maxSize[5]]',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->supplierPostCode); 
							}else{
								echo form_input($data, set_value('supplierPostCode')); 
                            }                       ?> 
                  </div>
                  </div>
					<div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo $this->lang->line('country') ?></div>
                   		<div class="span4">
						<?php
							if($suppliermaster){		
								$preselcat = $suppliermaster->supplierCountryID;
							}else{
								$preselcat = '458';
                            }                        
							$options[] = '--Please Select--';
							foreach($country as $row){
								$options[$row->fldid] = $row->fldcountry;
							}
							$js='onChange="changeList(this)"';
							echo form_dropdown('supplierCountryID', $options, $preselcat, $js);
						?>       
                     </div>                
                    	<div class="span1" TAR><?php echo $this->lang->line('state') ?></div>
                   		<div class="span4">
						<?php
							if($suppliermaster){		
								$preselcat = $suppliermaster->supplierStateID;
							}else{
								$preselcat = '0';
                            }                        
							$options='';
							$options[] = '--Please Select--';
							if($state != ''){
								foreach($state as $row){
									$options[$row->fldid] = $row->fldname;
								}
							}
							$js='id=supplierStateID';
							echo form_dropdown('supplierStateID', $options, $preselcat, $js);
						?>       
                     </div>                
                  </div><!-- End Row 1 -->
                 </div><!-- End Content-->
            </div> <!-- Block -->                                   
			<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('contactinfo') ?></h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
		<div class="content np">    
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('attention') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'attention',
									'id'=>'attention',
									'class'=>'span8',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->attention); 
							}else{
								echo form_input($data, set_value('attention')); 
                            }                       ?> 
                  </div>                            
                  </div>  
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('email') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'email', 
									'class'=>'span5 validate[custom[email]]',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->email); 
							}else{
								echo form_input($data, set_value('email')); 
                            }                       ?> 
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
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->website); 
							}else{
								echo form_input($data, set_value('website')); 
                            }                       ?> 
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
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->phoneNumber1); 
							}else{
								echo form_input($data, set_value('phoneNumber1')); 
                            }                       ?> 
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
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->fax); 
							}else{
								echo form_input($data, set_value('fax')); 
                            }                       ?> 
 							<span class="help-inline"><?php echo $this->lang->line('example') ?>: 603 61851515</span>
                    </div>                        
                  </div>    
                 </div><!-- End Content-->
                 </div><!-- End Content-->
            </div> <!-- Block -->                                   
			<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('othersinfo') ?></h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
		<div class="content np">    
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('generalNote') ?></div>
                   	<div class="span10">
                    	<?php
                            $data = array(
									'name'=>'generalNote', 
									'class'=>'span10',); 
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->generalNote); 
							}else{
								echo form_input($data, set_value('generalNote')); 
                            }                       ?> 
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
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->gstRegNo); 
							}else{
								echo form_input($data, set_value('gstRegNo')); 
                            }                       ?> 
							<span class="help-inline"><?php echo $this->lang->line('example') ?>:A234-A</span>
                    </div>                        
                  </div>
                  <div class="controls-row"> 
                    	<div class="span2"><?php echo $this->lang->line('termstatus') ?></div>
                   		<div class="span4">
						<?php
							if($suppliermaster){		
								$preselstatus = $suppliermaster->termstatus; 
							}else{
								$preselstatus = ''; 
                            }                       
							$options = '';
							$options[] = '--Please Select--';
							foreach($termstatus as $row){
							$options[$row->ID] = $row->name;
							}
							$js='';
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
							if($suppliermaster){		
								echo form_input($data, $suppliermaster->creditLimit); 
							}else{
								echo form_input($data, set_value('creditLimit')); 
                            }                       ?> 
              
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
							if($suppliermaster){		
								$presellinkAP = $suppliermaster->linkedAPAccountID; 
							}else{
								$presellinkAP = ''; 
                            }                       
							$options = '';
							$options[] = '--Please Select--';
							foreach($chartAccounts as $row){
							$options[$row->ID] = $row->acctCode . " [" . $row->acctName . "]";
							}
							$js='style="width: 250px;"';
							echo form_dropdown('linkedAPAccountID', $options, $presellinkAP, $js);
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
							if($suppliermaster){		
								echo form_input($data, date("d-m-Y", strtotime($suppliermaster->createdDate))); 
							}else{
								echo form_input($data, date('d-m-Y'));
                            }                        
                    	        ?>
                          </div>
                         </div>    
                         </div>    
                 <div class="controls-row"> 

                    	<div class="span2"><?php echo $this->lang->line('currency') ?></div>
                   		<div class="span4">
						<?php
							if($suppliermaster){		
								$preselcurr = $suppliermaster->currencyID; 
							}else{
								$preselcurr = ''; 
                            }                       
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
                 </div><!-- End Content-->
                	<div class="head">
				</div>
		<div class="content np">    
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
							echo form_submit($data,'Submit');
							?>
                    </div>
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
