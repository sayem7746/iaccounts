<script>
jQuery(document).ready(function() {
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
                    	<h2><?php echo $title ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                    </div>
				</div>
				<div class="content np">    
                	<div class="controls-row">
                    	<div class="span2"><?php echo form_label('Routing Code:','routing_code');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'routing_code', 
									'id'=>'routing_code', 
									'class'=>'span5 validate[required],maxSize[20]]',); 
								echo form_input($data, set_value('routing_code')); ?>
                                <span class="help-inline">Required, max size = 20</span>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Description:','routing_desc');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'routing_desc', 
									'id'=>'routing_desc', 
									'class'=>'span10 validate[required, maxSize[100]]',); 
							echo form_input($data, set_value('routing_desc')); ?>                       
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Approver:','routing_approver');?></div>
                   	<div class="span4">
						<?php
							$preseldept = '0';
							$options[] = '--Please Select--';
							foreach($usermaster as $row){
								$options[$row->userid] = $row->username;
							}

							echo form_dropdown('routing_approver', $options, $preseldept);
						?>       
                     </div>                
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Sequence:','routing_seq');?></div>
                   	<div class="span1">
						<?php
							$data = array(
									'name'=>'routing_seq', 
									'id'=>'routing_seq', 
									'class'=>'span10 validate[required,custom[integer], maxSize[100]]',); 
							echo form_input($data, set_value('routing_seq')); ?>                       
                    </div>                        
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
							echo form_submit($data,'Submit');
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
