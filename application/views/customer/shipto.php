<script>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	jQuery("#accountCode").keyup(function() {
		jQuery(this).val(jQuery(this).val().toUpperCase());
	});
});
	function changeList(obj){
		var id = obj.value;
		$.ajax({
			type: "POST",
			url: "<?php base_url()?>../../setting/getState/",
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
				$hidden['customerID'] = $customermaster->ID;
				if($shiptomaster)
				$hidden['ID'] = $shiptomaster->ID;
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
				</div>
				<div class="content np"> <!-- Content 1 -->   
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('accountCode') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'customerID', 
									'id'=>'customerID', 		
									'disabled'=>TRUE,							
									'class'=>'span3'); 
							if($customermaster){		
								echo form_input($data, $customermaster->accountCode); 
							}else{
								echo form_input($data, set_value('customerID')); 
                            }                       ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('customerCompanyNo') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'customerCompanyNo', 
									'id'=>'customerCompanyNo', 									
									'disabled'=>TRUE,							
									'class'=>'span3'); 
							if($customermaster){		
								echo form_input($data, $customermaster->customerCompanyNo); 
							}else{
								echo form_input($data, set_value('customerCompanyNo')); 
                            }                       ?> 
                  </div>
                  </div>
                	<div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('customerName') ?></div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'customerName', 
									'id'=>'customerName', 
									'disabled'=>TRUE,							
									'class'=>'span8'); 
							if($customermaster){		
								echo form_input($data, $customermaster->customerName); 
							}else{
								echo form_input($data, set_value('customerName')); 
                            }                       ?> 
                  </div>
                  </div>
                 </div><!-- End Content-->
            </div> <!-- Block -->                                   
			<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title') ?></h2>
				</div>
		<div class="content np">    
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('shiptocode') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'addressCode', 
									'id'=>'addressCode', 									
									'class'=>'span3 validate[required]',); 
							if($shiptomaster){		
								echo form_input($data, $shiptomaster->addressCode); 
							}else{
								echo form_input($data, set_value('addressCode')); 
                            }                       ?> 
                  </div>
                  </div>
                  <div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('address') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'line1', 
									'id'=>'line1', 									
									'class'=>'span8 validate[maxSize[128]]',); 
							if($shiptomaster){		
								echo form_input($data, $shiptomaster->line1); 
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
							if($shiptomaster){		
								echo form_input($data, $shiptomaster->line2); 
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
							if($shiptomaster){		
								echo form_input($data, $shiptomaster->line3); 
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
							if($shiptomaster){		
								echo form_input($data, $shiptomaster->city); 
							}else{
								echo form_input($data, set_value('city')); 
                            }                       ?> 
        
                  </div>
                    <div class="span1" TAR><?php echo $this->lang->line('postcode') ?></div>
                     <div class="span4">
						<?php
							$data = array(
									'name'=>'postCode', 
									'id'=>'postCode', 									
									'class'=>'span3 validate[minSize[5],maxSize[5]]',); 
							if($shiptomaster){		
								echo form_input($data, $shiptomaster->postCode); 
							}else{
								echo form_input($data, set_value('postCode')); 
                            }                       ?> 
                  </div>
                  </div>
					<div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo $this->lang->line('country') ?></div>
                   		<div class="span4">
						<?php
							if($shiptomaster){		
								$preselcountry = $shiptomaster->countryID;
							}else{
								$preselcountry = '458';
                            }                        
							$options[] = '--Please Select--';
							foreach($country as $row){
								$options[$row->fldid] = $row->fldcountry;
							}
							$js='onChange="changeList(this)"';
							echo form_dropdown('countryID', $options, $preselcountry, $js);
						?>       
                     </div>                
                    	<div class="span1" TAR><?php echo $this->lang->line('state') ?></div>
                   		<div class="span4">
						<?php
							if($shiptomaster){		
								$preselstate = $shiptomaster->stateID;
							}else{
								$preselstate = '0';
                            }                        
							$options='';
							$options[] = '--Please Select--';
							if($state != ''){
								foreach($state as $row){
									$options[$row->fldid] = $row->fldname;
								}
							}
							$js='id=stateID';
							echo form_dropdown('stateID', $options, $preselstate, $js);
						?>       
                     </div>                
                  </div><!-- End Row 1 -->
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
