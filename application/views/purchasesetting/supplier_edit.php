<script>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
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
					jQuery("#fldsupp_state").empty();
					jQuery("#fldsupp_state").append(items.join('</br>'));
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
                <li><a href="home"><?php echo $module ?></a> <span class="divider">-</span></li>
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
				$hidden = array('order_time' => date('Y-m-d H-i-s'),
					'fldid' => $suppmaster->fldid);
				$attrib = array('id'=>'validate'); 
				echo form_open_multipart('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $title ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                    </div>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
				<div class="content np"> <!-- Content 1 -->   
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Supplier Code:','fldsupp_code');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_code', 
									'id'=>'fldsupp_code', 
									'class'=>'span3 validate[required,maxSize[20]]',); 
								echo form_input($data, $suppmaster->fldsupp_code); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Supplier Name:','fldsupp_name');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_name', 
									'id'=>'fldsupp_name', 
									'class'=>'span9 validate[required,maxSize[100]]',); 
								echo form_input($data, $suppmaster->fldsupp_name); ?>
                  		</div>
                 	</div><!-- End Row 4-->
			</div> <!-- End Content 1 -->
            </div> <!-- span12 -->                                   
            </div> <!-- row-fluid -->                                   
	<div class="row-fluid">
		<div class="span12">
            	<div class="block">
                	<div class="head">
                    	<h2>Contact Information</h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
				<div class="content np"> <!-- Content 1 -->   
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Contact Person:','fldsupp_contactperson');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_contactperson', 
									'id'=>'fldsupp_contactperson', 
									'class'=>'span9 validate[maxSize[100]]',); 
								echo form_input($data, $suppmaster->fldsupp_contactperson); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Phone Number:','fldsupp_phone');?></div>
                   		<div class="span3">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_phone', 
									'id'=>'fldsupp_phone', 
									'class'=>'span9 validate[maxSize[25]]',); 
								echo form_input($data, $suppmaster->fldsupp_phone); ?>
                  		</div>
                    	<div class="span2" TAR><?php echo form_label('Fax Number:','fldsupp_fax');?></div>
                   		<div class="span3">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_fax', 
									'id'=>'fldsupp_fax', 
									'class'=>'span9 validate[maxSize[25]]',); 
								echo form_input($data, $suppmaster->fldsupp_fax); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Mobile Number:','fldsupp_mobile');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_mobile', 
									'id'=>'fldsupp_mobile', 
									'class'=>'span3 validate[maxSize[20]]',); 
								echo form_input($data, $suppmaster->fldsupp_mobile); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Address:','fldsupp_addr');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_addr', 
									'id'=>'fldsupp_addr', 
									'class'=>'span9 validate[maxSize[100]]',); 
								echo form_input($data, $suppmaster->fldsupp_addr); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                     	<div class="span2"><?php echo form_label('','fldsupp_addr1');?></div>
                  		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_addr1', 
									'id'=>'fldsupp_addr1', 
									'class'=>'span9 validate[maxSize[100]]',); 
								echo form_input($data, $suppmaster->fldsupp_addr1); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                     	<div class="span2"><?php echo form_label('','fldsupp_addr2');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_addr2', 
									'id'=>'fldsupp_addr2', 
									'class'=>'span9 validate[maxSize[100]]',); 
								echo form_input($data, $suppmaster->fldsupp_addr2); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Postcode:','fldsupp_postcode');?></div>
                   		<div class="span4">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_postcode', 
									'id'=>'fldsupp_postcode', 
									'class'=>'span9 validate[maxSize[5]]',); 
								echo form_input($data, $suppmaster->fldsupp_postcode); ?>
                  		</div>
                    	<div class="span1" TAR><?php echo form_label('City:','fldsupp_city');?></div>
                   		<div class="span5">
                            	<?php 								
								$data = array(
									'name'=>'fldsupp_city', 
									'id'=>'fldsupp_city', 
									'class'=>'span9 validate[maxSize[50]]',); 
								echo form_input($data, $suppmaster->fldsupp_city); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Country:','fldsupp_country');?></div>
                   		<div class="span4">
						<?php
							$preselcat = $suppmaster->fldsupp_country;
							$options[] = '--Please Select--';
							foreach($country as $row){
								$options[$row->fldid] = $row->fldcountry;
							}
							$js='onChange="changeList(this)"';
							echo form_dropdown('fldsupp_country', $options, $preselcat, $js);
						?>       
                     </div>                
                    	<div class="span1" TAR><?php echo form_label('State:','fldsupp_state');?></div>
                   		<div class="span4">
						<?php
							$preseltype = $suppmaster->fldsupp_state;
							$options='';
							$options[] = '--Please Select--';
							if($state != ''){
								foreach($state as $row){
									$options[$row->fldid] = $row->fldname;
								}
							}
							$js='id=fldsupp_state';
							echo form_dropdown('fldsupp_state', $options, $preseltype, $js);
						?>       
                     </div>                
                  </div><!-- End Row 1 -->
			</div> <!-- End Content 1 -->
            </div> <!-- span12 -->                                   
            </div> <!-- row-fluid -->                                   
	<div class="row-fluid">
		<div class="span12">
            	<div class="block">
                	<div class="head">
                    	<h2>Financial Information</h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
		<div class="content np">    
        	<div class="controls-row"> <!-- row 1 -->
            	<div class="span2"><?php echo form_label('Account Payable:','fldsupp_ap_acc');?></div>
            	<div class="span10">
						<?php
							$preselaccmaster = $suppmaster->fldsupp_ap_acc;
							$options = '';
							$options[] = '--Please Select Accont Number--';
							foreach($accmaster as $row){
								$options[$row->fldac_code] = '['.$row->fldac_code .'] '. $row->fldac_desc;
							}
							echo form_dropdown('aset_acc', $options, $preselaccmaster); ?>
                            &nbsp;&nbsp;
							<?php
							$preselsubacc = $suppmaster->fldsupp_ap_cc;
							$options = '';
							$options[] = '--Please Select Sub Account--';
							foreach($subacc as $row){
								$options[$row->fldsubac_code] = '['.$row->fldsubac_code .'] '. $row->fldsubac_description;
							}
							echo form_dropdown('fldsupp_ap_cc', $options, $preselsubacc);
						?>       
             	</div>
                  </div><!-- End Row 1 -->
			</div> <!-- End Content 1 -->
            </div> <!-- span12 -->                                   
            </div> <!-- row-fluid -->                                   
	<div class="row-fluid">
		<div class="span12">
            	<div class="block">
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
