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
            	<li><a href='<?php echo base_url()."home" ?>'>Dashboard</a> <span class="divider">-</span></li>
                <li><a href="file:///C|/xampp/htdocs/iaccounts/application/views/supplier/home"><?php echo $module ?></a> <span class="divider">-</span></li>
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
				'id' => $umaster->id, 
				'password' => $umaster->password);
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $title ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                    </div>
				</div>
				<div class="content np">    
                	<div class="controls-row">
                    	<div class="span2">Supplier ID:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'supplierID', 
									'id'=>'supplierID', 
									'class'=>'span5 validate[maxSize[20]]',); 
								echo form_input($data, $umaster->supplierID); ?>
                                
                  </div>
                  </div>
                	<div class="controls-row">
                    	<div class="span2">Address Name:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'addressName', 
									'id'=>'addressName', 
									'class'=>'span5 validate[maxSize[20]]',);
								echo form_input($data, $umaster->addressName); ?>
                                
                  </div>
                  </div>
                  <div class="controls-row">
                    	<div class="span2">Address 2:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'line1', 
									'id'=>'line1', 
									'class'=>'span5 validate[maxSize[20]]',);
								echo form_input($data, $umaster->line1); ?>
                                
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('City:','city');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'city', 
									'id'=>'city', 
									'class'=>'span5 validate[maxSize[50]]',); 
							echo form_input($data, $umaster->city); ?>                       
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Post Code:','postCode');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'postCode', 
									'class'=>'span5 validate[maxSize[30]]',); 
							echo form_input($data, $umaster->postCode); ?>                       
                    </div>                        
                  </div>
               	<div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Country:','country');?></div>
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
                    	<div class="span1" TAR><?php echo form_label('State:','state');?></div>
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
									'cass'=>'btn btn-primary');
							$js='onclick="return confirm(\'Press OK to continue...\')"';
							echo form_submit($data,'Submit', $js);
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
