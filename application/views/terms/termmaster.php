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
});
	
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
                    	<h2><?php echo $this->lang->line('titlelist') ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                       
                    </div>
				</div>
                <?php
							$data = array(
									'name'=>'termID', 
									'id'=>'termID', 
									'type'=>'hidden',); 
									if($tmaster){
										echo form_input($data, $tmaster->ID);                      
									}
									else
									{
										echo form_input($data); 
									} ?>
				<div class="content np">    
                  <div class="controls-row">
                    	<div class="span2">Term Name:</div>
                   	<div class="span10">
                            	<?php
								$data = array(
									'name'=>'termName', 
									'id'=>'termName', 
									'class'=>'span5 validate[maxSize[30]]',);
									
								if($tmaster){
									echo form_input($data, $tmaster->termName);
								}else
								{
									echo form_input($data, set_value('termName'));
								} 
								 ?>
                                
                  </div>
                  </div>
                    <div class="controls-row">
                    	<div class="span2">Term Description:</div> 
                 	  	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'termDescription', 
									'id'=>'termDescription', 
									'class'=>'span10 validate[maxSize[30]]',);
								if($tmaster){
									echo form_input($data, $tmaster->termDescription);
								}else
								{
									echo form_input($data, set_value('termDescription'));
								} 
								 
								?>
                  </div>
                  </div>
                    <div class="controls-row">
                    	<div class="span2">Due Days:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'dueDays', 
									'id'=>'dueDays', 
									'class'=>'span2 validate[maxSize[5]]',);
								if($tmaster){
									echo form_input($data, $tmaster->dueDays);
								}else
								{
									echo form_input($data, set_value('dueDays'));
								}	 
								
								?>    
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2">Default radio:</div>                                            
                    	<div class="span9">
                      		<label class="radio inline"><input type="radio" name="termStatusID" value="1" <?php if($tmaster){if($tmaster->termStatusID == 1){ ?> checked="checked" <?php }} ?>/> Active</label>
                            <label class="radio inline"><input type="radio" name="termStatusID" value="0" <?php if($tmaster){if($tmaster->termStatusID == 0){ ?> checked="checked" <?php }} ?>/> Inactive</label>
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

