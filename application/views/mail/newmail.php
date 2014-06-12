<script>
$(document).ready(function(){
    $('.add_more').click(function(e){
        e.preventDefault();
        $(this).before("<input name='file_load[]' type='file' class='uni' multiple/>");
    });
});
</script>
<div id="content">                        
<div class="wrap">
                  
<div class="head">
	<div class="info">
		<h1><?php echo $module ?></h1>
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
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				$attrib = array('id'=>'validate'); 
				echo form_open_multipart('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2>New Mail</h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                    </div>
				</div>
				<div class="content np"> <!-- Content 1 -->   
                  <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Mail Referrence No. :','ref_no');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'ref_no', 
									'id'=>'ref_no', 
									'class'=>'span9 validate[required],maxSize[100]',); 
								echo form_input($data, set_value('ref_no')); ?>
                  		</div>
                  </div><!-- End Row 1 -->
                  <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Mail From :','mailt_from');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'mailt_from', 
									'id'=>'mailt_from', 
									'class'=>'span9 validate[required],maxSize[50]',); 
								echo form_input($data, set_value('mailt_from')); ?>
                  		</div>
                  </div><!-- End Row 1 -->
                  <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Mail To :','mailt_to');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'mailt_to', 
									'id'=>'mailt_to', 
									'class'=>'span9 validate[required],maxSize[50]',); 
								echo form_input($data, set_value('mailt_to')); ?>
                  		</div>
                  </div><!-- End Row 1 -->
                  <div class="controls-row"><!-- Row 3 -->
                  	<div class="span2"><?php echo form_label('Mail Date:','mailt_dt');?></div>
                    <div class="span9">
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="i-calendar"></i></span>
                            	<?php 								
								$data = array(
									'type'=>'text',
									'name'=>'mailt_dt', 
									'id'=>'mailt_dt', 
									'class'=>'validate[required] datepicker',); 
								echo form_input($data, set_value('mailt_dt')); ?>
                        </div>
                    </div>
                    </div><!-- End Row 3 -->
                  <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Title :','title');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'title', 
									'id'=>'title', 
									'class'=>'span9 validate[required],maxSize[100]',); 
								echo form_input($data, set_value('title')); ?>
                  		</div>
                  </div><!-- End Row 1 -->
                  <div class="controls-row"><!-- Row 2 -->
                  	<div class="span2"><?php echo form_label('Description:','desc');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'desc', 
									'id'=>'desc', 
									'class'=>'span9 validate[maxSize[255]',); 
							echo form_textarea($data, set_value('desc')); ?>                       
                    </div>                        
                  </div><!-- End Row 2 -->
                	<div class="controls-row"><!-- Row 4-->
                    <div class="span2" TAR><?php echo form_label('Received Date:','mailt_rvcdate');?></div>
                    <div class="span9">
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="i-calendar"></i></span>
                            	<?php 								
								$data = array(
									'type'=>'text',
									'name'=>'mailt_rvcdate', 
									'id'=>'mailt_rvcdate', 
									'class'=>'datepicker',); 
								echo form_input($data, set_value('mailt_rvcdate')); ?>
                        </div>
                     </div>
                 	</div><!-- End Row 4-->
                  <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Recieved By :','mailt_rcv_by');?></div>
                   	<div class="span4">
						<?php
							$preseldept = '0';
							$options[] = '--Please Select--';
							foreach($usermaster as $row){
								$options[$row->userid] = $row->username;
							}
							echo form_dropdown('mailt_rcv_by', $options, $preseldept);
						?>       
                     </div>                
                  </div><!-- End Row 1 -->
                  <div class="controls-row"> <!-- row 1 -->
                    	<div class="span2"><?php echo form_label('Recieved By :','mailt_type');?></div>
                   	<div class="span4">
						<?php
							$options='';
							$preseldept = '0';
							$options[] = '--Please Select--';
							foreach($mailtype as $row){
								$options[$row->code] = $row->desc;
							}
							echo form_dropdown('mailt_type', $options, $preseldept);
						?>       
                     </div>                
                  </div><!-- End Row 1 -->
                  <div class="controls-row"><!-- Row 5 -->
                  	<div class="span2"><?php echo form_label('Attachment:','file_load');?></div>
                   	<div class="span6">
						<?php
							$counter = 1;
							$data = array(
									'name'=>'file_load', 
									'class'=>'span8',);
							echo form_upload($data, set_value('file_load')); 
                            ?>
					 </div>                        
                  </div><!-- End Row 5-->
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
