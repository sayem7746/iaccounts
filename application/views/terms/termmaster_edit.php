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
	
	});});
	
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
                    	<div class="span2">Term Name:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'termName', 
									'id'=>'termName', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('termName')); ?>
                                
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
								echo form_input($data, set_value('termDescription')); ?>
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
								echo form_input($data, set_value('dueDays')); ?>    
                  </div>
                  </div>
                  <div class="controls-row"> 
                    	<div class="span2"><?php echo form_label('Term Status:','termstatus');?></div>
                   		<div class="span4">
						<?php
							$preselstatus = '1';
							$options = '';
							$options[] = '--Please Select--';
							foreach($termstatus as $row){
							$options[$row->ID] = $row->name;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('termstatus', $options, $preselstatus);
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