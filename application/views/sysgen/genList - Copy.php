<script>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	jQuery("#supplierCode").keyup(function() {
		jQuery(this).val(jQuery(this).val().toUpperCase());
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
</div>  <!-- Head -->                                                                  
<div class="content">                   
	<div class="row-fluid">
		<div class="span12">
			<?php 
				$index = 0;
//				var_dump($generalsetup);
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				if($generalsetup)
					$hidden['ID'] = $generalsetup[0]->ID;
				$attrib = array('ID'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title') ?></h2>
                        <div class="side fr"></div>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
					</div> <!--head-->
	                <div class="content np"> <!-- Content 1 -->   
                  <?php 
					$options = '';
					$options[] = '--Please Select--';
					//general setup- retainedEarnings + profitlostYear + exchangeVariances + bankchargesAccount 
					foreach($chartAccounts as $row){
						$options[$row->ID] = $row->acctCode.' [ ' .$row->acctName .' ]';
					}
					for ($index=0; $index < 4; $index++) {?>
						<div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line($generalsetup[$index]->accountCode); ?></div>
                   		<div class="span5">
						<?php
							$preselgen= $generalsetup[$index]->accountID; 
							if ($generalsetup[$index]->updateable <> 1)
								$js=' disabled="disabled" ';
							else $js='';
							echo form_dropdown($generalsetup[$index]->accountCode.'[]', $options, $preselgen, $js);
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->updateable); 
							
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->ID); 
							?> 
                     </div> 
                     </div> 
                  <?php } //end for index?>
                     <div class="controls-row"> 
                     <div class="span12">
                     <label class="checkbox inline"><?php echo $this->lang->line('text1')?></label>
                     <input type="checkbox" class="validate" name="signature" value="1"/> 
                     </div>  
                     </div>                
            </div><!-- End Content-->
            </div> <!-- Block -->                                   
			<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title2') ?></h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				</div>
		<div class="content np">   
        <?php
			//customers and sales report section 
			for ($index=4; $index < 12; $index++) {?>

                        <div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line($generalsetup[$index]->accountCode); ?></div>
                   		<div class="span5">
						<?php
							$preselgen= $generalsetup[$index]->accountID; 
							if ($generalsetup[$index]->updateable <> 1)
								$js=' disabled="disabled" ';
							else $js='';
							echo form_dropdown($generalsetup[$index]->accountCode.'[]', $options, $preselgen, $js);
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->updateable); 
							
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->ID); 
							?> 
                     </div> 
                     </div> 
        <?php } //end for ?>
                  </div><!-- End Row 1 -->
                 </div><!-- End Content-->
            </div> <!-- Block -->                                   
			<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title4') ?></h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				   </div>
			<div class="content np">  
        <?php
			//supplier and purchasing section 
			for ($index=12; $index < 14; $index++) {?>

                        <div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line($generalsetup[$index]->accountCode); ?></div>
                   		<div class="span5">
						<?php
							$preselgen= $generalsetup[$index]->accountID; 
							if ($generalsetup[$index]->updateable <> 1)
								$js=' disabled="disabled" ';
							else $js='';
							echo form_dropdown($generalsetup[$index]->accountCode.'[]', $options, $preselgen, $js);
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->updateable); 
							
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->ID); 
							?> 
                     </div> 
                     </div> 
        <?php } //end for 
			//repeat from index 10,11
			for ($i=10; $i < 12; $i++) {?>
                        <div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line($generalsetup[$i]->accountCode); ?></div>
                   		<div class="span5">
						<?php
							$preselgen= $generalsetup[$i]->accountID; 
							if ($generalsetup[$i]->updateable <> 1)
								$js=' disabled="disabled" ';
							else $js='';
							echo form_dropdown($generalsetup[$i]->accountCode.'[]', $options, $preselgen, $js);
							$data = array(
									'name'=>$generalsetup[$i]->accountCode.'[]', 
									'id'=>$generalsetup[$i]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$i]->updateable); 
							
							$data = array(
									'name'=>$generalsetup[$i]->accountCode.'[]', 
									'id'=>$generalsetup[$i]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$i]->ID); 
							?> 
                     </div> 
                     </div> 
        <?php } //end for ?>
                </div> <!-- content -->                                   
                </div> <!-- Block -->                                   
                    
                    <div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title6') ?></h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
					</div>
					<div class="content np">  
        <?php
			//item default section 
			//sales account repeat from index=5 ?>

                        <div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line($generalsetup[5]->accountCode); ?></div>
                   		<div class="span5">
						<?php
							$preselgen= $generalsetup[5]->accountID; 
							if ($generalsetup[$index]->updateable <> 1)
								$js=' disabled="disabled" ';
							else $js='';
							echo form_dropdown($generalsetup[5]->accountCode.'[]', $options, $preselgen, $js);
							$data = array(
									'name'=>$generalsetup[5]->accountCode.'[]', 
									'id'=>$generalsetup[5]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[5]->updateable); 
							
							$data = array(
									'name'=>$generalsetup[5]->accountCode.'[]', 
									'id'=>$generalsetup[5]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[5]->ID); 
							?> 
                     </div> 
                     </div> 
<?php			for ($index=14; $index < 17; $index++) {?>

                        <div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line($generalsetup[$index]->accountCode); ?></div>
                   		<div class="span5">
						<?php
							$preselgen= $generalsetup[$index]->accountID; 
							if ($generalsetup[$index]->updateable <> 1)
								$js=' disabled="disabled" ';
							else $js='';
							echo form_dropdown($generalsetup[$index]->accountCode.'[]', $options, $preselgen, $js);
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->updateable); 
							
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->ID); 
							?> 
                     </div> 
                     </div> 
        <?php } //end for ?>
                </div> <!-- content -->                                   
                </div> <!-- Block -->                                   
				<div class="block">
                    <div class="head">
                    	<h2><?php echo $this->lang->line('title7') ?></h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
					</div>
                <div class="content np"> 
<?php			//gst tax section 
			for ($index=17; $index < 25; $index++) {?>

                        <div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line($generalsetup[$index]->accountCode); ?></div>
                   		<div class="span5">
						<?php
							$preselgen= $generalsetup[$index]->accountID; 
							if ($generalsetup[$index]->updateable <> 1)
								$js=' disabled="disabled" ';
							else $js='';
							echo form_dropdown($generalsetup[$index]->accountCode.'[]', $options, $preselgen, $js);
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->updateable); 
							
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->ID); 
							?> 
                     </div> 
                     </div> 
        <?php } //end for ?>
                </div> <!-- content -->                                   
                </div> <!-- Block -->                                   
               	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title3') ?></h2>
                            <ul class="buttons">                                            
                            	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                        	</ul>                                         
				    </div> <!--head-->
					<div class="content np"> 
                        <div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line($generalsetup[$index]->accountCode); ?></div>
                   		<div class="span5">
						<?php
							$preselgen= $generalsetup[$index]->accountID; 
							if ($generalsetup[$index]->updateable <> 1)
								$js=' disabled="disabled" ';
							else $js='';
							echo form_dropdown($generalsetup[$index]->accountCode.'[]', $options, $preselgen, $js);
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->updateable); 
							
							$data = array(
									'name'=>$generalsetup[$index]->accountCode.'[]', 
									'id'=>$generalsetup[$index]->accountCode.'[]', 
									'type'=>'hidden'); 
							echo form_input($data, $generalsetup[$index]->ID); 
							?> 
                     </div> 
                     </div> 
				</div>
                </div><!--end block -->
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                        <?php 
							
							$data = array(
									'name'=>'mysubmit', 
									'class'=>'btn btn-primary');
							$js='onclick="return confirm(\'Press OK to continue...\')"';
							echo form_submit($data,'Update',$js);
							
							$data = array(
									'name'=>'mycancel', 
									'class'=>'btn btn-primary');
							$js='onclick="return confirm(\'Are you sure to cancel...\')"';
							echo form_submit($data,'Cancel',$js);
							
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
<?php
//end of general system setup
//by farhana
?>