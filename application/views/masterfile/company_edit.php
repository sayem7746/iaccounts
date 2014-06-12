<script>
$(document).ready(function(){
	$('select').select2();
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	jQuery("#content").find("input").keyup(function() {
		if (jQuery(this).attr('id') == "role") {
			jQuery(this).val(jQuery(this).val().toUpperCase());
		}
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

<div id="content">                        
<div class="wrap">
<div class="head">
	<div class="info">
		<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
		<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url(); ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href="home"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
				$hidden = array('order_time' => date('Y-m-d H-i-s'), 'ID'=>$umaster->ID);
				$attrib = array('ID'=>$umaster->ID); 
				echo form_open_multipart('', $attrib, $hidden);?>
                                <!-- form id="validate" method="POST" action="javascript:alert('Form #validate submited');"-->
                                <div class="block">
                                    <div class="head">
                                        <h2><?php echo $this->lang->line('title') ?></h2>
                                    </div>
                                    <div class="content np">    
                                            <div class="controls-row">
                                                <div class="span2"><?php echo form_label($this->lang->line('companyNo'));?></div>
                                                <div class="span10">
                                                      <?php
													$data = array(
													'name'=>'companyNo', 
													'class'=>'span3 validate[required,minSize[5],maxSize[10]]',); 
													echo form_input($data, $umaster->companyNo); ?>
                                                </div>
                                            </div>                    
                                            <div class="controls-row">
                                                <div class="span2"><?php echo form_label($this->lang->line('companyName'));?></div>
                                                <div class="span10">
                                                    <?php
														$data = array(
															'name'=>'companyName',
															'id'=>'companyName', 
															'class'=>'span8 validate[required,maxSize[128]]',); 
														//$js='Readonly';	 
														echo form_input($data, $umaster->companyName);
													?>
                                                </div>
                                            </div>
                                            <div class="controls-row">
                                                <div class="span2"><?php echo form_label($this->lang->line('incorporateDate'));?></div>
                                                <div class="span10">
                                                <div class="input-prepend">
                                                    <span class="add-on"><i class="i-calendar"></i></span>
													<?php
													$data = array(
													'name' => 'incorporateDate',
													'id' => 'incorporateDate',
													'type' => 'text',
													'class' => 'datepicker2',);
													echo form_input($data, date('d-m-Y'), $umaster->incorporateDate);
													?>
                                                </div>
                                                </div>
                                            </div>                            
                                            <div class="controls-row">
                                                <div class="span2"><?php echo form_label($this->lang->line('phoneNo'));?></div>
                                                <div class="span10">
                                                    <?php
													$data = array(
													'name'=>'phoneNo',); 
													echo form_input($data, $umaster->phoneNo); ?>
                                                </div>
                                            </div>
                                            <div class="controls-row">
                                                <div class="span2"><?php echo form_label($this->lang->line('faxNo'));?></div>
                                                <div class="span10">
                                                    <?php
													$data = array(
													'name'=>'faxNo',); 
													echo form_input($data, $umaster->faxNo); ?>
                                                </div>
                                            </div>             
                                            <div class="controls-row">
                                                <div class="span2"><?php echo form_label($this->lang->line('email'));?></div>
                                                <div class="span10">
                                                    <?php
													$data = array(
													'name'=>'email',); 
													echo form_input($data, $umaster->email); ?>
                                                </div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo form_label($this->lang->line('website'));?></div>
                                                <div class="span10">
                                                    <?php
													$data = array(
													'name'=>'website',); 
													echo form_input($data, $umaster->website); ?>
                                                </div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('currency') ?></div>
                                                <div class="span10">
                                                    <?php
														$preseldept = $umaster->currencyID;
														$options[NULL] = $this->lang->line('select');
														foreach($currency as $row){
															$options[$row->fldid] = $row->fldcurr_code . " [" . $row->fldcurr_desc . "]";
														}
														$js='style="width: 250px;"';
														echo form_dropdown('currencyID', $options, $preseldept, $js);
													?>
                                                </div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo form_label($this->lang->line('uploadLogo'));?></div>
                                                <div class="span10">
                                                    <?php 
													$data = array(
													'name'=>'uploadLogo',
													'type'=>'file',); 
													echo form_input($data, $umaster->uploadLogo);
													
													?>
                                                </div>
                                            </div>   
											<div class="controls-row">
                                                <div class="span10"><?php echo $this->lang->line('note1') ?>
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

