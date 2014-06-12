<script>
$(document).ready(function(){
	jQuery('.datetimepicker2').datetimepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
});
</script>
<div id="content">                        
<div class="wrap">
                  
<div class="head">
	<div class="info">
		<h1><?php echo $screenname ?></h1>
			<ul class="breadcrumb">
            	<li><a href="#">Dashboard</a> <span class="divider">-</span></li>
                <li><a href="#">Master Files</a> <span class="divider">-</span></li>
                <li class="active"><?php echo $screenname ?></li>
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
								'fldid' => $slamaster->fldid);
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $screenname ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                    </div>
				</div>
				<div class="content np"> <!-- Content 1 -->   
                	<div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Category:','category');?></div>
                   		<div class="span4">
						<?php
							$preselcat = $slamaster->category;
							$options[] = '--Please Select--';
							foreach($reqcategory as $row){
								$options[$row->code] = $row->description;
							}
							echo form_dropdown('category', $options, $preselcat);
						?>       
                     </div>                
                    	<div class="span2" TAR><?php echo form_label('Type:','type');?></div>
                   		<div class="span4">
						<?php
							$preseltype = $slamaster->type;
							$options='';
							$options[] = '--Please Select--';
							foreach($reqtype as $row){
								$options[$row->code] = $row->description;
							}
							echo form_dropdown('type', $options, $preseltype);
						?>       
                     </div>                
                  </div><!-- End Row 1 -->
                	<div class="controls-row"><!-- Row 2 -->
                    	<div class="span2"><?php echo form_label('Reason:','reason');?></div>
                   		<div class="span4">
						<?php
							$preselrea = $slamaster->reason;
							$options='';
							$options[] = '--Please Select--';
							foreach($reqreason as $row){
								$options[$row->code] = $row->description;
							}
							echo form_dropdown('reason', $options, $preselrea);
						?>       
                     </div>                
                    	<div class="span2" TAR><?php echo form_label('Priority:','priority');?></div>
                   		<div class="span4">
						<?php
							$preselprty = $slamaster->priority;
							$options='';
							$options[] = '--Please Select--';
							foreach($priority as $row){
								$options[$row->code] = $row->description;
							}
							echo form_dropdown('priority', $options, $preselprty);
						?>       
                     </div>                
                  </div><!-- End Row 2 -->
                	<div class="controls-row"><!-- Row 2 -->
                    	<div class="span2"><?php echo form_label('Routing:','routing_code');?></div>
                   		<div class="span4">
						<?php
							$preselcat = $slamaster->routing_code;
							$options='';
							$options[] = '--Please Select--';
							foreach($routingmaster as $row){
								$options[$row->routing_code] = $row->routing_code . ' -> ' . $row->routing_desc;
							}
							echo form_dropdown('routing_code', $options, $preselcat);
						?>       
                     </div>                
                  </div><!-- End Row 2 -->
                  <div class="controls-row"><!-- Row 3 -->
                  	<div class="span2"><?php echo form_label('Start Effective Date:','start_date');?></div>
                    <div class="span4">
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="i-calendar"></i></span>
                            	<?php 								
								$data = array(
									'type'=>'text',
									'name'=>'start_date', 
									'id'=>'start_date', 
									'class'=>'validate[required] datetimepicker2',); 
								echo form_input($data, date("d-m-Y h:i", strtotime($slamaster->start_date))); ?>
                        </div>                                                                                                
                     </div>
                  </div><!-- End Row 2 -->
                  <div class="controls-row"><!-- Row 3 -->
                  	<div class="span2"><?php echo form_label('End Effective Date:','end_date');?></div>
                    <div class="span4">
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="i-calendar"></i></span>
                            	<?php 								
								$data = array(
									'type'=>'text',
									'name'=>'end_date', 
									'id'=>'end_date', 
									'class'=>'validate[required] datetimepicker2',); 
								echo form_input($data, date("d-m-Y h:i", strtotime($slamaster->end_date))); ?>
                        </div>                                                                                                
                     </div>
                    </div><!-- End Row 3 -->
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
