<SCRIPT language=Javascript>
       <!--
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       //-->
    </SCRIPT>
	
	<script>
$(document).ready(function(){
	$('#journalTable').hide();
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	
    
    $("table.editable").on("click",".edit",function(){
        var eRow   = $(this).parents('tr');
        var eState = $(this).attr('data-state');
        
        if(eState == null){
            $(this).html('Save');
            eState = 1;
        }
        
        
        
        if(eState == 1) 
            $(this).attr('data-state','2');
        else{
            $(this).removeAttr('data-state');
            $(this).html('Edit');
        }
    });
        
});

function yearperiodCheck(){
	if($('#financialYear').val() == ''){ 
		alert('<?php echo $this->lang->line('year') ?>');
		$('#financialYear').focus();
	}
	else if ($('#period').val() == ''){
		alert('<?php echo $this->lang->line('period') ?>');
		$('#period').focus();
	}
	else{
		var financialYear = $('#financialYear').val();
		var period = $('#period').val();
		//$('#hidePrompt').hide();
		//$('#journalTable').show();
		var postData = {
			'financialYear' : financialYear,
			'period' : period,
		};
		//alert("<?php echo base_url()?>financialCalendarCheck_yearperiod");
 		$.ajax({
  			type: "POST",
  			dataType: "json",
			url: "<?php echo base_url()?>companySetup/financialCalendarCheck_yearperiod",
			data: postData ,
  			success: function(content){
				if(content.status == "success") {
					$('#startDate').removeAttr('disabled');
					$('#endDate').removeAttr('disabled');
					$('#startDate').focus();
				}else if(content.status == "false"){
					alert('Data exists...');
					
					$('#startDate').removeAttr('disabled');
					$('#endDate').removeAttr('disabled');
					$('#startDate').val(content.startDate);
					$('#endDate').val(content.endDate);
					$('#fcID').val(content.ID);
					$('#startDate').focus();
					
				}
			}
		});        // Here your ajax action after delete confirmed
//		location.reload();
	}
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
                                        <h2>FINANCIAL CALENDAR</h2>
                                        <div class="side fr">
                                            <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                                        </div>
                                    </div>
						<?php
							$data = array(
									'name'=>'fcID', 
									'id'=>'fcID', 
									'type'=>'hidden',); 
							echo form_input($data); ?>                       
                                    <div class="content np">
											<div class="controls-row">
                                                <div class="span2">Year</div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
														//echo '<select name="financialYear" id="financialYear" value="financialYear">';
 
														//echo '</select>';
														if($fycmaster){
															$preselyear = $fycmaster->financialYear;
														}else{
															$preselyear = date('Y');
														}
														$options = '';
														$options[] = '--Please Select--';
														for($i=-2; $i<6; $i++){
															$options[date('Y', strtotime($i . "  year"))] = date('Y', strtotime($i . "  year"));
														}
														$js='style="width: 250px;"';
														echo form_dropdown('financialYear', $options, $preselyear, $js);
													?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2">Period</div>
                                                <div class="span10">
                                                      <?php
													$data = array(
													'name'=>'period',
													'id'=>'period',
													'onkeypress'=>'return isNumberKey(event)',
													'maxlength'=>'2',
													'onBlur' =>'yearperiodCheck()');
													if($fycmaster){
														echo form_input($data, $fycmaster->period);                      
													}
													else
													{
														echo form_input($data, set_value('period')); 
													} 
													 ?>
                                                </div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2">Start date</div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                    <span class="add-on"><i class="i-calendar"></i></span>
													<?php
													$data = array(
													'name' => 'startDate',
													'id' => 'startDate',
													'type' => 'text',
													'class' => 'datepicker2',);
													if($fycmaster){
														echo form_input($data, date('d-m-Y', strtotime($fycmaster->startDate)));                      
													}
													else
													{
														echo form_input($data, date('d-m-Y')); 
													}
													
													?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2">End date</div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                    <span class="add-on"><i class="i-calendar"></i></span>
													<?php
													$data = array(
													'name' => 'endDate',
													'id' => 'endDate',
													'type' => 'text',
													'class' => 'datepicker2',);
													if($fycmaster){
														echo form_input($data, date('d-m-Y', strtotime($fycmaster->endDate)));                      
													}
													else
													{
														echo form_input($data, date('d-m-Y')); 
													}
													?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2">Status</div>
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
									'name'=>'submit',
									'id'=>'submit',
									'class'=>'btn btn-primary');
							echo form_submit($data,'Submit');
							?>
                    </div>
                </div>
            </div>                                    
                                </div>
                                </form>

                            </div>

                        </div>

