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
					jQuery("#stateID").empty();
					jQuery("#stateID").append(items.join('</br>'));
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
				if($employeemaster)
				$hidden['ID'] = $employeemaster->ID;
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title') ?></h2>
                        <div class="side fr">
                         <button class="btn" onClick="clear_form('#validate');" type="button"><?php echo $this->lang->line('clearForm') ?></button>
                    </div>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
				<div class="content np"> <!-- Content 1 -->   
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('employeeCode') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'employeeCode', 
									'id'=>'employeeCode', 									
									'class'=>'span3 validate[required]',); 
							if($employeemaster){		
								echo form_input($data, $employeemaster->employeeCode); 
							}else{
								echo form_input($data, set_value('employeeCode')); 
                            }                       ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('employeeName') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'employeeName', 
									'id'=>'employeeName', 									
									'class'=>'span3 validate[required]',); 
							if($employeemaster){		
								echo form_input($data, $employeemaster->employeeName); 
							}else{
								echo form_input($data, set_value('employeeName')); 
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
                    	<div class="span2"><?php echo $this->lang->line('line1') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'line1', 
									'id'=>'line1', 									
									'class'=>'span8 validate[maxSize[128]]',); 
							if($employeemaster){		
								echo form_input($data, $employeemaster->line1); 
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
							if($employeemaster){		
								echo form_input($data, $employeemaster->line2); 
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
							if($employeemaster){		
								echo form_input($data, $employeemaster->line3); 
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
							if($employeemaster){		
								echo form_input($data, $employeemaster->city); 
							}else{
								echo form_input($data, set_value('city')); 
                            }                       ?> 
        
                  </div>
                    <div class="span1" TAR><?php echo $this->lang->line('postCode') ?></div>
                     <div class="span4">
						<?php
							$data = array(
									'name'=>'postCode', 
									'id'=>'postCode', 									
									'class'=>'span3 validate[minSize[5],maxSize[5]]',); 
							if($employeemaster){		
								echo form_input($data, $employeemaster->postCode); 
							}else{
								echo form_input($data, set_value('postCode')); 
                            }                       ?> 
                  </div>
                  </div>
					<div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo $this->lang->line('countryID') ?></div>
                   		<div class="span4">
						<?php
							if($employeemaster){		
								$preselcat = $employeemaster->countryID;
							}else{
								$preselcat = '458';
                            }                        
							$options[] = '--Please Select--';
							foreach($country as $row){
								$options[$row->fldid] = $row->fldcountry;
							}
							$js='onChange="changeList(this)"';
							echo form_dropdown('countryID', $options, $preselcat, $js);
						?>       
                     </div>                
                         	<div class="span1" TAR><?php echo $this->lang->line('stateID') ?></div>
                   		<div class="span4">
						<?php
							if($employeemaster){		
								$preselcat = $employeemaster->stateID;
							}else{
								$preselcat = '0';
                            }                        
							$options='';
							$options[] = '--Please Select--';
							if($state != ''){
								foreach($state as $row)
								{
									$options[$row->fldid] = $row->fldname;
								}
							}
							$js='id=stateID';
							echo form_dropdown('stateID', $options, $preselcat, $js);
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
                  	<div class="span2"><?php echo $this->lang->line('phoneNo') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'phoneNo',
									'id'=>'phoneNo',
									'class'=>'span5',); 
							if($employeemaster){		
								echo form_input($data, $employeemaster->phoneNo); 
							}else{
								echo form_input($data, set_value('phoneNo')); 
                            }                       ?> 
                            
               	<span class="help-inline"><?php echo $this->lang->line('example') ?>:603 61851515</span>
                     </div>                
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('email') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'email', 
									'class'=>'span5 validate[custom[email]]',); 
							if($employeemaster){		
								echo form_input($data, $employeemaster->email); 
							}else{
								echo form_input($data, set_value('email')); 
                            }                       ?> 
							<span class="help-inline"><?php echo $this->lang->line('example') ?>: accounts@salihin.com.my</span>
                    </div>                        
                  </div>    
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
                    	<div class="span2"><?php echo $this->lang->line('gender') ?></div>
                   		<div class="span4">
						<?php
							if($employeemaster){		
								$preselgen= $employeemaster->gender; 
							}else{
								$preselgen = ''; 
                            }                       
							$options = '';
							$options[] = '--Please Select--';
							foreach($gender as $row){
							$options[$row->ID] = $row->name;
							}
							$js='';
							echo form_dropdown('gender', $options, $preselgen, $js);
						?>       
                     </div> 
                     </div>     
                         <div class="controls-row">
                       <div class="span2"><?php echo $this->lang->line('dateOfJoin') ?></div>
                    	<div class="span9">
                       <div class="input-prepend">
                         <span class="add-on"><i class="i-calendar"></i></span>
				                 <?php
								$data = array(
								'name' => 'dateOfJoin',
								'id' => 'dateOfJoin',
								'type' => 'text',
								'class' => 'datepicker',);
							if($employeemaster){		
								echo form_input($data, date("d-m-Y", strtotime($employeemaster->dateOfJoin))); 
							}else{
								echo form_input($data, date('d-m-Y'));
                            }                        
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
