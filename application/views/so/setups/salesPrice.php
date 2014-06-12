<script>
$(document).ready(function(){
	$('select').select2();
});
</script>
<div id="content">                        
<div class="wrap">
                  
<div class="head">
	<div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href='<?php echo base_url()."gl/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
<div class="row-fluid">
	<div class="span12">
			<?php 
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title') ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                    </div>
				</div>
			<div class="content np">
				<div class="controls-row"> <!-- row 1 -->
            		<div class="span2"><?php echo $this->lang->line('items') ?></div>
              		<div class="span9">
					<?php
							$preselitems = '';
							$options[] = $this->lang->line('pleaseselect');
							if($items){
							foreach($items as $row){
								$options[$row->ID] = $row->name.' [ '.$row->description.' ]';
							}
							}
							$js='class="span6" id="itemID"';
							echo form_dropdown('itemID', $options, $preselitems, $js);
						?>       
            		</div>                
         		</div><!-- End Row 1 -->
				<div class="controls-row"> <!-- row 1 -->
            		<div class="span2"><?php echo $this->lang->line('customer') ?></div>
              		<div class="span9">
					<?php
							$preselcust = '';
							$options = '';
							$options[] = $this->lang->line('pleaseselect');
							if($customers){
							foreach($customers as $row){
								$options[$row->ID] = $row->customerName.' [ '.$row->accountCode.' ]';
							}
							}
							$js='class="span6" id="customerID"';
							echo form_dropdown('customerID', $options, $preselcust, $js);
						?>       
            		</div>                
         		</div><!-- End Row 1 -->
				<div class="controls-row"> <!-- row 1 -->
            		<div class="span2"><?php echo $this->lang->line('um') ?></div>
              		<div class="span9">
					<?php
							$preselum = '';
							$options = '';
							$options[] = $this->lang->line('pleaseselect');
							if($um){
							foreach($um as $row){
								$options[$row->fldid] = $row->code.' [ '.$row->desc.' ]';
							}
							}
							$js='class="span4" id="umID"';
							echo form_dropdown('umID', $options, $preselum, $js);
						?>       
            		</div>                
         		</div><!-- End Row 1 -->
				<div class="controls-row"> <!-- row 1 -->
            		<div class="span2"><?php echo $this->lang->line('currency') ?></div>
              		<div class="span9">
					<?php
							$preselcurrency = '';
							$options = '';
							$options[] = $this->lang->line('pleaseselect');
							if($currency){
							foreach($currency as $row){
								$options[$row->fldid] = $row->fldcurr_code.' [ '.$row->fldcurr_desc.' ]';
							}
							}
							$js='class="span4" id="currencyID"';
							echo form_dropdown('currencyID', $options, $preselcurrency, $js);
						?>       
            		</div>                
         		</div><!-- End Row 1 -->
                	<div class="controls-row">
            		<div class="span2"><?php echo $this->lang->line('price') ?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'price', 
									'id'=>'price', 
									'class'=>'span5 validate[required],custom[boolean],maxSize[20]]',); 
								echo form_input($data, set_value('routing_code')); ?>
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
			</div><!-- content -->
		</div><!-- block -->
        </form>
	</div><!-- span12 -->
</div><!-- fluid -->
</div><!-- wrap -->
</div><!-- content -->

