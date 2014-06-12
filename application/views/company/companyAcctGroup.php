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
function submitBtn()
{
	document.getElementById("submit").disabled=true;
}

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
					alert('Data exist...');
					
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
                                        <h2>Add New Code</h2>
                                        <div class="side fr">
                                            <button class="btn" onClick="clear_form('#validate');" type="button">Clear form</button>
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
                                                <div class="span2">Account Type Name</div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
														if($acmaster){
															$preselgroup = $acmaster->acctGroupID;
														}else{
															$preselgroup = '';
														}
														$options = '';
														$options[] = '--Please Select--';
														foreach($accGroup as $row){
															$options[$row->ID] = $row->acctGroupName;
														}
														echo form_dropdown('acctGroupID', $options, $preselgroup);
													?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2">Account Code</div>
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
                                                <div class="span2">Account Name</div>
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
							echo form_button($data,'Hide prompts');
							$data = array(
									'name'=>'submit',
									'id'=>'submit',
									'onchange' =>'submitBtn()', 
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

