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
