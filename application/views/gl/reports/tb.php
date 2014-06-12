<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
	$('select').select2();
}); 
	function report(){
		var add_year =$("#add_year option:selected").val();
		var add_period =$("#add_period option:selected").val();
		window.location.href = "trialBalance_print/"+add_year+"/"+add_period;
	}
	
	function selectYearPeriod(obj){
		var year = obj.value;
//		alert(year);
			
			$.ajax({
  				type: "POST",
	  			dataType: "json",
				url: "<?php echo base_url()?>glreports/get_TrialBalance_year/"+year,
				data: year,
	  			async: false,
  				success: function(content){
					if(content.status == "success") {
					var items = [];
					//items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].ID+'">'
						+ content.message[i].period + '</option>');
					}  //end for
					jQuery("#add_period").empty();
					jQuery("#add_period").append(items.join('</br>'));
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				} //end if
			} //end success
				
			}); //end ajax
//	window.location.reload(true); 
}
</script>

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
</div><!-- head --> 
<div class="content">
<div class="wrap">                    
	<div class="row-fluid">
		<div class="span12">
        	<div class="block">
            	<div class="head">
                	<h2><?php echo $this->lang->line('title') ?></h2>
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
							$js='onchange="selectYearPeriod(this)" class="input-medium" id="add_year"';

							echo form_dropdown('add_year', $options, $preselyear, $js);
						?>       
                        </div>
						<div class="span5 tac">
                    	<div class="span2 tar"><?php echo form_label($this->lang->line('period'),'add_period');?></div>
						<?php
							$preselperiod = date("m");
							$options = '';
							$options[] = $this->lang->line('period');
							if($period){
								foreach($period as $row){
									$options[$row->period] = $row->period;
								}
							}
							$js='class="input-medium" id="add_period"';

							echo form_dropdown('add_period', $options, $preselperiod, $js);
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
