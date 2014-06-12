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
	
	/*function changeList(obj){
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
	}*/

</script>

<script>
function changeList(obj){
var id = obj.value;
//alert(fad);
$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>tax/loadTaxType/"+id,
			data: "taxGroup="+id,
			dataType:"json",
			success: function(content){
					var items = [];
					items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].ID+'">'
						+ content.message[i].code + " [" + content.message[i].description + "]" + '</option>');
					}
					jQuery("#taxType").empty();
					jQuery("#taxType").append(items.join('</br>'));
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
                  	<div class="span2"><?php echo $this->lang->line('code') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'code',
									'id'=>'code',								
									'class'=>'span3 validate[required,maxSize[10]]',); 
							echo form_input($data, set_value('code')); ?>                       
                  </div>                            
                  </div>    
                	<div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('name') ?></div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'name', 
									'id'=>'name', 
									'class'=>'span8 validate[required,maxSize[128]]',); 
								echo form_input($data, set_value('name')); ?>
                  </div>
                  </div>
                     <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo $this->lang->line('taxClass') ?></div>
                   		<div class="span4">
						<?php
							$preselclass= '';
							$options[] = '--Please Select--';
							foreach($class as $row){
								$options[$row->ID] = $row->code . " [" . $row->description . "]";
							}
							$js='style="width: 250px;"';
							echo form_dropdown('taxClass', $options, $preselclass, $js);
						?>       
                     </div>                
                     </div>                
                      <div class="controls-row"> <!-- row 1 -->
                   	<div class="span2"><?php echo $this->lang->line('taxGroup') ?></div>
                   		<div class="span4">
						<?php
							$preselgroup = '0';
							$options='';
							$options[] = '--Please Select--';
							if($group != ''){
								foreach($group as $row){
								$options[$row->ID] = $row->code . " [" . $row->description . "]";
								}
							}
							//$js='style="width: 250px;"';
							$js='id="taxGroup"; name="taxGroup"; onChange="changeList(this)"; style="width: 250px;"';
							echo form_dropdown('taxGroup', $options, $preselgroup, $js);
						?>       
                         </div>                
                  </div><!-- End Row 1 -->
                      <div class="controls-row"> <!-- row 1 -->
                   	<div class="span2"><?php echo $this->lang->line('taxType') ?></div>
                   		<div class="span4">
						<?php
							$preseltype = '0';
							$options='';
							$options[] = '--Please Select--';
							if($group != ''){
								foreach($taxtype as $row){
								$options[$row->ID] = $row->code . " [" . $row->description . "]";
								}
							}
							$js='id="taxType"; style="width: 250px;"';
							echo form_dropdown('taxType', $options, $preseltype, $js);
						?>       
                         </div>                
                  </div><!-- End Row 1 -->
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('taxPercentage') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'taxPercentage',
									'id'=>'taxPercentage',								
									'class'=>'span2 validate[required,maxSize[10]]',); 
							echo form_input($data, set_value('code')); ?>                       
                  </div>                            
                  </div>    
                	<div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('description') ?></div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'description', 
									'id'=>'description', 
									'class'=>'span8 validate[required,maxSize[128]]',); 
								echo form_input($data, set_value('description')); ?>
                  </div>
                  </div>
                   <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo $this->lang->line('taxAccount') ?></div>
                   		<div class="span4">
						<?php
							$presellinkAP = '';
							$options = '';
							$options[] = '--Please Select--';
							foreach($accounts as $row){
							$options[$row->ID] = $row->acctCode . " [" . $row->acctName . "]";
							}
							$js='style="width: 250px;"';
							echo form_dropdown('taxAccount', $options, $presellinkAP, $js);
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
		</div>
	</form>

