<SCRIPT language=Javascript>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
});

function submitBtn()
{
	document.getElementById("submit").disabled=true;
}

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
							/*$data = array(
									'name'=>'acctCodeID', 
									'id'=>'acctCodeID', 
									'type'=>'hidden',); 
													  if($acmaster){
															echo form_input($data, $acmaster->ID);                      
													  }
													  else
													  {
															echo form_input($data); 
													  }*/?>
                                    <div class="content np">
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('addressName') ?></div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
													$data = array(
													'name'=>'addressName',
													'id'=>'addressName',);
													  if($camaster){
															echo form_input($data, $camaster->addressName); 
													  }
													  else
													  {
															echo form_input($data, set_value('addressName')); 
													  }?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
                                            <div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('line1') ?></div>
                                                <div class="span10">
                                                
                                                      <?php
													$data = array(
													'name'=>'line1',
													'id'=>'line1',);
													  if($camaster){
															echo form_input($data, $camaster->line1); 
													  }
													  else
													  {
															echo form_input($data, set_value('line1')); 
													  }?>
                                                </div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('line2') ?></div>
                                                <div class="span10">
                                                
                                                      <?php
													$data = array(
													'name'=>'line2',
													'id'=>'line2',);
													  if($camaster){
															echo form_input($data, $camaster->line2); 
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
                                            <div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('city') ?></div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
													$data = array(
													'name'=>'acctCode',
													'id'=>'acctCode',);
													  if($acmaster){
															echo form_input($data, $acmaster->acctCode); 
													  }
													  else
													  {
															echo form_input($data, set_value('acctCode')); 
													  }?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
                                            <div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('postCode') ?></div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
													$data = array(
													'name'=>'acctCode',
													'id'=>'acctCode',);
													  if($acmaster){
															echo form_input($data, $acmaster->acctCode); 
													  }
													  else
													  {
															echo form_input($data, set_value('acctCode')); 
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
									'onchange' =>'submitBtn()', 
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

