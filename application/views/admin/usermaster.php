<!--script>
function notyConfirm(){
	noty({
		text: 'Do you want to continue?',
        type: 'information',
		layout: 'topCenter',
        buttons: [{
			addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
            	$noty.close();
				return true;
//            	noty({text: 'You clicked "Ok" button', type: 'success', layout: 'topCenter'});
            	}
            },
            {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                $noty.close();
				return false;
//                noty({text: 'You clicked "Cancel" button', type: 'error', layout: 'topCenter'});
                }
            }]
        })                                                    
}                                            

</script -->
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
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $title ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button"><?php echo $this->lang->line('clear'); ?></button>
                    </div>
				</div>
				<div class="content np">    
                	<div class="controls-row">
                    	<div class="span2"><?php echo form_label($this->lang->line('userid'),'userid');?></div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'userid', 
									'id'=>'userid', 
									'class'=>'span5 validate[required,maxSize[20]]',); 
								echo form_input($data, set_value('userid')); ?>
                                <span class="help-inline">Required, max size = 20</span>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('password1'),'password1');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'password1', 
									'id'=>'password1', 
									'type'=>'password',									
									'class'=>'span3 validate[required,minSize[5],maxSize[10]]',); 
							echo form_input($data, set_value('password1')); ?>                       
                        <span class="help-inline">Required, min size = 5, max size = 10</span>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('password'),'password');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'password',
									'id'=>'password',
									'type'=>'password',									
									'class'=>'span3 validate[required,equals[password1]]',); 
							echo form_input($data, set_value('password')); ?>                       
                        <span class="help-inline">Required, equals Password</span>
                  </div>                            
                  </div>                            
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('username'),'username');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'username', 
									'id'=>'username', 
									'class'=>'span10 validate[maxSize[150]]',); 
							echo form_input($data, set_value('username')); ?>                       
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('position'),'position');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'position', 
									'id'=>'position', 
									'class'=>'span5 validate[maxSize[50]]',); 
							echo form_input($data, set_value('position')); ?>                       
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('department'),'department');?></div>
                   	<div class="span4">
						<?php
							$preseldept = '0';
							$options[NULL] = $this->lang->line('select');
							foreach($deptrec as $row){
								$options[$row->code] = $row->description;
							}

							echo form_dropdown('department', $options, $preseldept);
						?>       
                     </div>                
                   	 <div class="span5">
                  	 <div class="span2 TAR"><?php echo form_label($this->lang->line('section'),'section');?></div>
                   		<div class="span3">
						<?php
							$preselsec = '0';
							$optsec[NULL] = $this->lang->line('select');
							foreach($secrec as $row){
								$optsec[$row->code] = $row->description;
							}

							echo form_dropdown('section', $optsec, $preselsec);
						?>                       
                    </div>                        
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('phone_off'),'phone_off');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'phone_off', 
									'id'=>'phone_off', 
									'class'=>'span5 validate[maxSize[30]]',); 
							echo form_input($data, set_value('phone_off')); ?>                       
                     </div>                
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('phone_mobile'),'phone_mobile');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'phone_mobile', 
									'class'=>'span5 validate[maxSize[30]]',); 
							echo form_input($data, set_value('phone_mobile')); ?>                       
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('email'),'email');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'email', 
									'class'=>'span5 validate[required,custom[email]]',); 
							echo form_input($data, set_value('email')); ?>                       
							<span class="help-inline">Example: example@change.com</span>
                    </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label($this->lang->line('role'),'role');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'role', 
									'id'=>'role', 
									'class'=>'span2'); 
							echo form_input($data, set_value('role')); ?>                       
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
							echo form_button($data,$this->lang->line('validat'));
							$data = array(
									'name'=>'mysubmit', 
									'class'=>'btn btn-primary');
							$js='onclick="return confirm(\'Press OK to continue...\')"';
							echo form_submit($data,$this->lang->line('submit'),$js);
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
