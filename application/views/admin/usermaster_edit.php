<script>
jQuery(document).ready(function() {
	jQuery("#content").find("input").keyup(function() {
		if (jQuery(this).attr('id') == "role") {
			jQuery(this).val(jQuery(this).val().toUpperCase());
		}
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
					'fldid' => $umaster->fldid, 
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
                    	<div class="span2">User ID:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'userid', 
									'id'=>'userid', 
									'class'=>'span5 validate[required],maxSize[20]]',);
								$js='Readonly';	 
								echo form_input($data, $umaster->userid, $js); ?>
                                <span class="help-inline">Required, max size = 20</span>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Name:','username');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'username', 
									'id'=>'username', 
									'class'=>'span10 validate[maxSize[150]]',); 
							echo form_input($data, $umaster->username); ?>                       
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Position:','position');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'position', 
									'id'=>'position', 
									'class'=>'span5 validate[maxSize[50]]',); 
							echo form_input($data, $umaster->position); ?>                       
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Department:','department');?></div>
                   	<div class="span4">
						<?php
							$preseldept = $umaster->department;
							$options[] = '--Please Select--';
							foreach($deptrec as $row){
								$options[$row->code] = $row->description;
							}

							echo form_dropdown('department', $options, $preseldept);
						?>       
                     </div>                
                   	 <div class="span5">
                  	 <div class="span2 TAR"><?php echo form_label('Section:','section');?></div>
                   		<div class="span3">
						<?php
							$preselsec = $umaster->section;
							$optsec[] = '--Please Select--';
							foreach($secrec as $row){
								$optsec[$row->code] = $row->description;
							}

							echo form_dropdown('section', $optsec, $preselsec);
						?>                       
                    </div>                        
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Office Phone:','phone_off');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'phone_off', 
									'id'=>'phone_off', 
									'class'=>'mask_phone_ext span5 validate[maxSize[30]]',); 
							echo form_input($data, $umaster->phone_off); ?>                       
 							<span class="help-inline">Example: 98 (765) 432-10-98</span>
                     </div>                
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Mobile:','phone_mobile');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'phone_mobile', 
									'class'=>'mask_mobile span5 validate[maxSize[30]]',); 
							echo form_input($data, $umaster->phone_mobile); ?>                       
 							<span class="help-inline">Example: 98 (765) 432-10-98</span>
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2">Email:</div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'email', 
									'class'=>'span5 validate[required,custom[email]]',); 
							echo form_input($data, $umaster->email); ?>                       
							<span class="help-inline">Example: example@change.com</span>
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2">Access:</div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'role', 
									'id'=>'role', 
									'class'=>'span2'); 
							echo form_input($data, $umaster->role); ?>                       
							<span class="help-inline">Example: ADMIN</span>
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
