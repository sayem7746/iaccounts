<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
	$('select').select2();
}); 
	function report(){
		var add_year =$("#add_year option:selected").val();
		window.location.href = "trialBalanceFiscalyear_print/"+add_year;
	}
</script>

<div class="head">
	<div class="info">
		<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
			<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href='<?php echo base_url()."gl/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('title2') ?></li>
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
            	<div class="head">
                	<h2><?php echo $this->lang->line('title2') ?></h2>
                        <div class="side fr">
                </div>
				<div class="content np"> <!-- Content 1 -->   
                	<div class="controls-row"><!-- Row 4-->
						<div class="span5 tac">
                    	<div class="span2 tar"><?php echo form_label($this->lang->line('year'),'add_year');?></div>
						<?php
							$preselyear = date('Y');
							$options = '';
							foreach($yrs as $row){
								$options[$row] = $row;
							}
							$js='class="input-small validate[required]" id="add_year"';

							echo form_dropdown('add_year', $options, $preselyear, $js);
						?>       
                        </div>
                 	</div><!-- End Row 4-->
            		<div class="footer">
            			<div class="side fr">
                			<div class="btn-group">
                        <?php 
							$data = array(
									'name'=>'validat', 
									'class'=>'btn btn-primary',
									'onClick'=>"report()"); 
							echo form_button($data,$this->lang->line('generatereport'));
							?>
                    		</div>
                		</div>
            		</div>                                    
				</div>                                
			</div>                                
		</div>
	</div>                                
</div><!-- wrap -->
</div><!-- content -->                                
</div><!-- wrap -->
</div><!-- content -->
