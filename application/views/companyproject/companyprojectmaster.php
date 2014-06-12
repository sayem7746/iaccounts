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
		<h1><?php echo $module ?></h1>
			<ul class="breadcrumb">
            	<li><a href="#">Dashboard</a> <span class="divider">-</span></li>
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
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2>Supplier Payment Form</h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                       
                    </div>
				</div>
				<div class="content np">       
                     <div class="controls-row">
                    	<div class="span2">Company ID:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'companyID', 
									'id'=>'companyID', 
									'class'=>'span5 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('companyID')); ?>
                  </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span2">Project Name:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'project_name', 
									'id'=>'project_name', 
									'class'=>'span5 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('project_name')); ?>
                  </div>
                  </div>
                        <div class="controls-row">
                    	<div class="span2">Project Manager:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'projectManagerID', 
									'id'=>'projectManagerID', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('totalManagerID')); ?>
                  </div>
                  </div> 
                           <div class="controls-row">
                    	<div class="span2">Total Budget:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'totalBudget', 
									'id'=>'totalBudget', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('totalBudget')); ?>
                  </div>
                  </div>      
                           <div class="controls-row">
                    	<div class="span2">Remarks:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'remarks', 
									'id'=>'remarks', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('remarks')); ?>
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

