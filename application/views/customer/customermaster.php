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

<div id="content">                        
<div class="wrap">
                  
<div class="head">
	<div class="info">
		<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
		<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'>Dashboard</a> <span class="divider">-</span></li>
                <li><a href="../supplier/home"><?php echo $module ?></a> <span class="divider">-</span></li>
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
                    	<h2><?php echo $title ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button"><?php echo $this->lang->line('clear'); ?></button>
                            </div>
                                    </div>
						<?php
							$data = array(
									'name'=>'companyID', 
									'id'=>'companyID', 
									'type'=>'hidden',); 
													  if($customer){
															echo form_input($data, $customer->ID);                      
													  }
													  else
													  {
															echo form_input($data); 
													  }?>
				<div class="content np"> <!-- Content 1 -->   
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('companyID') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'companyID', 
									'id'=>'companyID', 									
									'class'=>'span3 validate[required]',);
								echo form_input($data, set_value('companyID')); 
                                                  ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('customerName') ?></div>
                   	<div class="span10">
						  <?php
													$data = array(
													'name'=>'customerName',
													'id'=>'customerName',);
													
													if($customer){
														echo form_input($data, $customer->customerName); 
													}
													else
													{
														echo form_input($data, set_value('customerName')); 
													}?>
                  </div>
                  </div>
                	<div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('accountCode') ?></div>
                   	<div class="span10">
                            	<?php
													$data = array(
													'name'=>'accoutnCode',
													'id'=>'accountCode',);
													
													if($customer){
														echo form_input($data, $customer->accountCode); 
													}
													else
													{
														echo form_input($data, set_value('accountCode')); 
													}?>
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
                    	<div class="span2"><?php echo $this->lang->line('addressName') ?></div>
                   	<div class="span10">
						<?php
													$data = array(
													'name'=>'addressName',
													'id'=>'addressName',);
													
													if($customer){
														echo form_input($data, $customer->addressName); 
													}
													else
													{
														echo form_input($data, set_value('addressName')); 
													}?>
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
							
								echo form_input($data, set_value('line2')); 
                                                  ?> 
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
							
								echo form_input($data, set_value('line3')); 
                                                  ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('city') ?></div>
                   	<div class="span4">
						<?php
													$data = array(
													'name'=>'city',
													'id'=>'city',);
													
													if($customer){
														echo form_input($data, $customer->city); 
													}
													else
													{
														echo form_input($data, set_value('city')); 
													}?> 
        
                  </div>
                    <div class="span1" TAR><?php echo $this->lang->line('postCode') ?></div>
                     <div class="span4">
						<?php
							$data = array(
									'name'=>'postCode', 
									'id'=>'postCode', 									
									'class'=>'span3 validate[minSize[5],maxSize[5]]',); 
							
								echo form_input($data, set_value('postCode')); 
                                                   ?> 
                  </div>
                  </div>
					<div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Country:','countryID');?></div>
                   		<div class="span4">
						<?php
							$preselcat = '458';
							$options[] = '--Please Select--';
							foreach($country as $row){
								$options[$row->fldid] = $row->fldcountry;
							}
							$js='onChange="changeList(this)"';
							echo form_dropdown('country', $options, $preselcat, $js);
						?>       
                     </div>                
                    	<div class="span1" TAR><?php echo form_label('State:','stateID');?></div>
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
							$js='id=state';
							echo form_dropdown('state', $options, $preselcat, $js);
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
                  	<div class="span2"><?php echo $this->lang->line('position') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'position',
									'id'=>'position',
									'class'=>'span8',); 
						
								echo form_input($data, set_value('position')); 
                                                 ?> 
                  </div>                            
                  </div>  
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('email') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'email', 
									'class'=>'span5 validate[custom[email]]',); 
							
								echo form_input($data, set_value('email')); 
                                                 ?> 
							<span class="help-inline"><?php echo $this->lang->line('example') ?>: accounts@salihin.com.my</span>
                    </div>                        
                  </div>                   
                  <div class="content np"> 	     		                                                           
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('telOffice') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'telOffice', 
									'id'=>'telOffice', 
									'class'=>'span5 validate[maxSize[16]]',); 
							
								echo form_input($data, set_value('telOffice')); 
                                                  ?> 
 							<span class="help-inline"><?php echo $this->lang->line('example') ?>: 603 61851515</span>
                     </div>                
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('telHp') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'telHp', 
									'class'=>'span5 validate[maxSize[16]]',); 
							echo form_input($data, set_value('telHp')); ?>                       
 							<span class="help-inline"><?php echo $this->lang->line('example') ?>: 012 6185151</span>
                    </div>                        
                  </div>
                 </div><!-- End Content-->
                 </div><!-- End Content-->
            </div> <!-- Block -->                                   
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
                </div>
            </div>                                    
		</div>
	</form>
</div>
</div>                        
</div>
</div>
</div>
