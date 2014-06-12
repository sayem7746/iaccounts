<SCRIPT language=Javascript>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
});

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
</div><!-- head --> 
<div class="content">
<div class="wrap">                    
	<div class="row-fluid">
		<div class="span12">
        	<div class="block">
            	<div class="row-fluid">

                            <div class="span12">
			<?php 
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
                                <!-- form id="validate" method="POST" action="javascript:alert('Form #validate submited');"-->
                                <div class="block">
                                    <div class="head">
                                        <h2><?php echo $this->lang->line('addnew') ?></h2>
                                        <div class="side fr">
                                            <button class="btn" onClick="clear_form('#validate');" type="button"><?php echo $this->lang->line('clearform') ?></button>
                                        </div>
                                    </div>
						<?php
							$data = array(
									'name'=>'acctCodeID', 
									'id'=>'acctCodeID', 
									'type'=>'hidden',); 
													  if($acmaster){
															echo form_input($data, $acmaster->ID);                      
													  }
													  else
													  {
															echo form_input($data); 
													  }?>
                                    <div class="content np">
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('accounttypename') ?></div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
														if($acmaster){
															$preselgroup = $acmaster->acctGroupID;
														}else{
															$preselgroup = '';
														}
														$options = '';
														$options[] = $this->lang->line('pleaseSelect');
														foreach($accGroup as $row){
															$options[$row->ID] = $row->acctGroupName;
														}
														echo form_dropdown('acctGroupID', $options, $preselgroup);
													?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('acctCode') ?></div>
                                                <div class="span10">
                                                
                                                      <?php
													$data = array(
													'name'=>'acctCode',
													'id'=>'acctCode',
													'onkeypress'=>'return isNumberKey(event)',
													'maxlength'=>'9',);
													  if($acmaster){
															echo form_input($data, $acmaster->acctCode); 
													  }
													  else
													  {
															echo form_input($data, set_value('acctCode')); 
													  }?>
                                                </div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('acctName') ?></div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
													$data = array(
													'name'=>'acctName',
													'id'=>'acctName',);
													
													if($acmaster){
														echo form_input($data, $acmaster->acctName); 
													}
													else
													{
														echo form_input($data, set_value('acctName')); 
													}?>
                                                </div>                                                                                                
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
							echo form_button($data, $this->lang->line('hideprompt'));
							$data = array(
									'name'=>'submit',
									'id'=>'submit',
									'class'=>'btn btn-primary');
							echo form_submit($data,$this->lang->line('submit'));
							?>
                    </div>
                </div>
            </div>                                    
                                </div>
                                </form>

                            </div>

                        </div>

