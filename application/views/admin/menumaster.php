
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
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2>Menu Master</h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                    </div>
				</div>
				<div class="content np">    
                	<div class="controls-row">
                    	<div class="span2"><?php echo form_label('Code:','code');?></div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'code', 
									'id'=>'code', 
									'class'=>'span2 validate[required],maxSize[10]]',); 
								echo form_input($data, set_value('code')); ?>
                                <span class="help-inline">Required, max size = 10</span>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Description:','name');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'name', 
									'id'=>'name', 
									'class'=>'span6 validate[required, maxSize[30]]',); 
							echo form_input($data, set_value('name')); ?>                       
                            <span class="help-inline">Required, max size = 30</span>
                   </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Parent:','parents');?></div>
                   	<div class="span4">
						<?php
							$preseldept = '0';
							$options[] = '--Please Select--';
							foreach($menupar as $row){
								$options[$row->fldid] = $row->code . ' -> ' . $row->name;
							}

							echo form_dropdown('parents', $options, $preseldept);
						?>       
                     </div>                
                     </div>                
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Urls:','urls');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'urls', 
									'id'=>'urls', 
									'class'=>'span8 validate[required, maxSize[100]]',); 
							echo form_input($data, set_value('urls')); ?>                       
                            <span class="help-inline">Required, max size = 100</span>
                   </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Acess:','access');?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'access', 
									'id'=>'access', 
									'class'=>'span8 validate[maxSize[100]]',); 
							echo form_input($data, set_value('access')); ?>                       
                   </div>                        
                  </div>
                  <div class="controls-row">
                  	<div class="span2"><?php echo form_label('Sequence:','seq');?></div>
                   	<div class="span4">
						<?php
							$data = array(
									'name'=>'seq', 
									'id'=>'seq', 
									'class'=>'span2 validate[required, custom[integer],maxSize[11]]',); 
							echo form_input($data, set_value('seq')); ?>                       
                   </div>                        
                   	 <div class="span5">
                  	<div class="span2"><?php echo form_label('Submenu:','submenu');?></div>
                   	<div class="span4">&nbsp;&nbsp;
						<?php
							$data = array(
									'name'=>'submenu', 
									'id'=>'submenu', 
									'class'=>'ibutton',); 
							echo form_radio($data, '1', FALSE); ?>
                            <span class="help-inline">Yes</span>&nbsp;&nbsp;/
						<?php echo form_radio($data, '0', TRUE); ?>
                            <span class="help-inline">No</span>
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
