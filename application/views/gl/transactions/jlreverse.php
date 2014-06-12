<script>
$(document).ready(function(){
	$('select').select2();
//	$('#acctCodel').select2();savedetails
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
});


function saveJournal(){
	var total_credit = 0;
	var total_debit = 0;
	if($('#description').val() == '' && $('#journal_number').val() == ''){ 
		alert('<?php echo $this->lang->line('message1') ?>');
		$('#description').focus();
	}else{
		var oriID = $('#oriID').val();
		var journalNo = $('#orijournal_number').val();
		var description = $('#description').val();
		var effdate = $('#effdate').val();
		$('#journal_number').attr('disabled','disabled');
		$('#description').attr('disabled','disabled');
		$('#effdate').attr('disabled','disabled');
		$('#mysubmit').hide();
		$('#hidePrompt').hide();
		$('#journalTable').show();
		var bil = 1;
		var postData = {
			'oriID' : oriID,
			'journalNo' : journalNo,
			'description' : description,
			'effdate' : effdate,
		};
 		$.ajax({
  			type: "POST",
  			dataType: "json",
			url: "<?php echo base_url()?>Gltransaction/journal_reverse_save",
			data: postData ,
  			success: function(content){
				if(content.status == "success") {
					var urls = "<?php echo base_url();?>GLtransaction/journal_copy_edit/"+content.journalID;
					window.location = urls;
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
                    
<div class="content" id="grid_content_1">
	<div class="row-fluid">
		<div class="alert alert-info">
			<strong><?php echo $this->lang->line('title') ?></strong>
		</div>
	</div>
	<div class="row-fluid scRow">                            
	  <div class="span7 scCol">
		<div class="block" id="grid_block_1">
          <div class="content">
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label($this->lang->line('jlnumber'),'journal_number');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'journal_number', 
									'id'=>'journal_number', 
									'disabled'=>'disabled',
									'class'=>'input-medium validate[required,maxSize[50]]',); 
								echo form_input($data); 
								$data = array(
									'name'=>'oriID', 
									'id'=>'oriID', 
									'type'=>'hidden'); 
								echo form_input($data, $orijournal->ID); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Description:','description');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'description', 
									'id'=>'description', 
									'class'=>'span12 validate[required,maxSize[100]]',); 
								echo form_input($data, set_value('description')); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                  <div class="controls-row"><!-- Row 3 -->
                    	<div class="span3"><?php echo form_label($this->lang->line('effective_date'),'effdate');?></div>
                    <div class="span9">
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="i-calendar"></i></span>
                            	<?php 								
								$data = array(
									'type'=>'text',
									'name'=>'effdate', 
									'id'=>'effdate', 
									'class'=>'input-medium datepicker2',); 
								echo form_input($data, date('d-m-Y')); ?>
                        </div>                                                                                                
                     </div>
                    </div><!-- End Row 3 -->
          </div><!-- End Content-->
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                        <?php 
							$data = array(
									'name'=>'hidePrompt', 
									'id'=>'hidePrompt', 
									'class'=>'btn',
									'onClick'=>"$('#validate').validationEngine('hide');"); 
							echo form_button($data,'Hide prompts');
							$data = array(
									'name'=>'mysubmit', 
									'id'=>'mysubmit', 
									'class'=>'btn btn-primary');
									$js = 'onClick="saveJournal()"';
							echo form_button($data,$this->lang->line('next'), $js);
							?>
                    </div>
                </div>
            </div>    <!-- footer -->                                
        </div>  <!-- Block grid-->                                  
      </div>     <!-- span8 -->                               
	  <div class="span5 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
			<div class="alert alert-info">
				<strong><?php echo $this->lang->line('orititle') ?></strong>
			</div>
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span3"><?php echo form_label($this->lang->line('jlnumber'),'orijournal_number');?></div>
                   		<div class="span8">
                            	<?php 								
								$data = array(
									'name'=>'orijournal_number', 
									'id'=>'orijournal_number', 
									'disabled'=>'disabled',
									'class'=>'input-medium]',); 
								echo form_input($data, $orijournal->journalID); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span3"><?php echo form_label($this->lang->line('description'),'oridescription');?></div>
                   		<div class="span9">
                            	<?php 								
								$data = array(
									'name'=>'oridescription', 
									'disabled'=>'disabled',
									'id'=>'oridescription', 
									'class'=>'span12',); 
								echo form_input($data, $orijournal->description); ?>
                  		</div>
                 	</div><!-- End Row 4-->
          </div><!-- End Content-->
			<div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                    </div>
                </div>
            </div>    <!-- footer -->                                        
         </div> <!-- Block grid-->                                   
      </div> <!-- scCol-->                                   
     </div> <!-- row-fluid scRow-->                                   
</div>                        
</div>
</div>
</div>
<div class="dialog" id="row_delete" style="display: none;" title="Delete?">
    <p>Row will be deleted</p>
</div>   
