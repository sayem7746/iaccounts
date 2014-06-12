<script>
jQuery(document).ready(function() {
	jQuery("#content").find("input").keyup(function() {
		if (jQuery(this).attr('id') == "role") {
			jQuery(this).val(jQuery(this).val().toUpperCase());
		}
	});
});
</script>

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
</script>

<script>
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
					alert('data already there');
					
					$('#startDate').removeAttr('disabled');
					$('#endDate').removeAttr('disabled');
					$('#startDate').val(content.startDate);
					$('#endDate').val(content.endDate);
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
</div><!-- head --> 
<div class="content">
<div class="wrap">                    
	<div class="row-fluid">
		<div class="span12">
            	<div class="row-fluid">

                            <div class="span12">
			<?php 
//				$hidden = array('order_time' => date('Y-m-d H-i-s'), 
//					'fldid' => $umaster->fldid, 
//					'password' => $umaster->password);
//				$attrib = array('id'=>'validate'); 
				$hidden = array('order_time' => date('Y-m-d H-i-s'), 'ID'=>$umaster->ID);
//				var_dump($umaster);
				$attrib = array('ID'=>$umaster->ID); 
				echo form_open_multipart('', $attrib, $hidden);?>
                                <!-- form id="validate" method="POST" action="javascript:alert('Form #validate submited');"-->
                                <div class="block">
                                    <div class="head">
                                        <h2>FINANCIAL CALENDAR</h2>
                                        <div class="side fr">
                                            <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
                                        </div>
                                    </div>
                                    <div class="content np">
											<div class="controls-row">
                                                <div class="span2">Year</div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
														$current_year = date("Y");
														$range = range($current_year, ($current_year + 6));
														echo '<select name="financialYear" id="financialYear">';
 
														for($i=2; $i>0; $i--){
															$yearBefore = $current_year - $i;
															echo '<option value="'.$yearBefore.'">'.$yearBefore.'</option>';
														}
														foreach($range as $r)
														{
															echo '<option value="'.$r.'">'.$r.'</option>';
														}
 
														echo '</select>';
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
													//'onkeypress'=>'return isNumberKey(event)',
													'maxlength'=>'2',
													'onBlur' =>'yearperiodCheck()',); 
													echo form_input($data, $umaster->period); ?>
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
													echo form_input($data, date('d-m-Y'), $umaster->startDate);
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
													echo form_input($data, date('d-m-Y'), $umaster->endDate);
													?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2">Status</div>
                                            </div>                                               
                                            <div class="controls-row">                        
                                                <div class="span12">
                                                    <label class="checkbox inline">
                                                        <input type="checkbox" class="validate[required]" name="terms" value="1"/> Yes, I accept your terms and conditions.
                                                    </label>
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
									'name'=>'submit', 
									'class'=>'btn btn-primary');
							$js='onclick="return confirm(\'Press OK to continue...\')"';
							echo form_submit($data,'Submit',$js);
							?>
                    </div>
                </div>
            </div>                                    
                                </div>
                                </form>

                            </div>

                        </div>

