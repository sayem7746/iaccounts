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
	jQuery("#content").find("textbox").keyup(function() {
		jQuery(this).val(jQuery(this).val().toUpperCase());
	});
	
});
	
	function changeList(obj){
		var id = obj.value;
		$.ajax({
			type: "POST",
			url: "<?php base_url()?>getState/",
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
		<h1><?php echo $module ?></h1>
			<ul class="breadcrumb">
            	<li><a href="#"><?php echo $this->lang->line('dashboard')?></a> <span class="divider">-</span></li>
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
				$hidden = array('order_time' => date('Y-m-d H-i-s'),
					'fldid' => $locmaster->fldid);
				$attrib = array('id'=>'validate'); 
				echo form_open_multipart('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $title ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button"><?php echo form_label($this->lang->line('clearform'));?></button>
                    </div>
				</div>
				<div class="content np"> <!-- Content 1 -->   
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo $this->lang->line('locationCode')?></div>
                   		<div class="span3">
                            	<?php 								
								$data = array(
									'name'=>'code', 
									'id'=>'code', 
									'class'=>'span9 validate[required,maxSize[20]]',); 
								echo form_input($data, $locmaster->code); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo $this->lang->line('description')?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'desc', 
									'id'=>'desc', 
									'class'=>'span9 validate[,maxSize[100]]',); 
								echo form_input($data, $locmaster->desc); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo $this->lang->line('phoneNo')?></div>
                   		<div class="span3">
                            	<?php 								
								$data = array(
									'name'=>'phone_no', 
									'id'=>'phone_no', 
									'class'=>'span9 validate[maxSize[25]]',); 
								echo form_input($data, $locmaster->phone_no); ?>
                  		</div>
                    	<div class="span2" TAR><?php echo $this->lang->line('faxNo')?></div>
                   		<div class="span3">
                            	<?php 								
								$data = array(
									'name'=>'fax_no', 
									'id'=>'fax_no', 
									'class'=>'span9 validate[maxSize[25]]',); 
								echo form_input($data, $locmaster->fax_no); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                  <div class="controls-row"><!-- Row 5 -->
                  	<div class="span2"><?php echo $this->lang->line('address')?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'address', 
									'id'=>'address', 
									'class'=>'span9 validate[maxSize[200]]',); 
							echo form_textarea($data, $locmaster->address); ?>                       
                    </div>                        
                  </div><!-- End Row 5-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo $this->lang->line('postcode')?></div>
                   		<div class="span4">
                            	<?php 								
								$data = array(
									'name'=>'postcode', 
									'id'=>'postcode', 
									'class'=>'span9 validate[maxSize[5]]',); 
								echo form_input($data, $locmaster->postcode); ?>
                  		</div>
                    	<div class="span1" TAR><?php echo $this->lang->line('city')?></div>
                   		<div class="span5">
                            	<?php 								
								$data = array(
									'name'=>'city', 
									'id'=>'city', 
									'class'=>'span9 validate[maxSize[50]]',); 
								echo form_input($data, $locmaster->city); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo $this->lang->line('country')?></div>
                   		<div class="span4">
						<?php
							$presel_country = $locmaster->country;
							$options[] = '--Please Select--';
							foreach($country as $row){
								$options[$row->fldid] = $row->fldcountry;
							}
							$js='onChange="changeList(this)"';
							echo form_dropdown('country', $options, $presel_country, $js);
						?>       
                     </div>                
                    	<div class="span1" TAR><?php echo $this->lang->line('state')?></div>
                   		<div class="span4">
						<?php
							$presel_state = $locmaster->state;
							$options='';
							$options[] = '--Please Select--';
							if($state != ''){
								foreach($state as $row){
									$options[$row->fldid] = $row->fldname;
								}
							}
							$js='id=state';
							echo form_dropdown('state', $options, $presel_state, $js);
						?>       
                     </div>                
                  </div><!-- End Row 1 -->
			</div> <!-- End Content 1 -->
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
