<SCRIPT language=Javascript>
function changeList(obj){
	var id = obj.value;
	//alert(id);
		$.ajax({
			type: "POST",
			url: "<?php base_url()?>mastercode_id/",
			data: "id="+id,
			dataType:"json",
			success: function(content){
				if(content.status == "success") 
				{
					
					var items = [];
					items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) 
					{
					//alert(content.message[i].ID);
						items.push('<option value="'+content.message[i].ID+'">' + content.message[i].name + '</option>');
					}
					jQuery("#masterCode").empty();
					jQuery("#masterCode").append(items.join('</br>'));
				} 
				else 
				{
					$("#error").html('<p>'+content.message+'</p>');
				}
			}
		});
		return false;
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
                                        <h2><?php echo $this->lang->line('title') ?></h2>
                                    </div>
						<?php
							$data = array(
									'name'=>'masterCodeSetupID', 
									'id'=>'masterCodeSetupID', 
									'type'=>'hidden',); 
									if($mcmaster)
									{
										echo form_input($data, $mcmaster->ID);                      
									}
									else
									{
										echo form_input($data); 
									}?>
                                    <div class="content np">
                                    		<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('master') ?></div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
														
														if($mcmaster){
															$preselname = $mcmaster->masterID;
														}else{
															$preselname = '';
														}
														$options = '';
														$options[] = $this->lang->line('pleaseselect');
														foreach($masterName as $row){
															$options[$row->ID] = $row->name;
														}
														$js = 'onChange="changeList(this)"';
														echo form_dropdown('masterID', $options, $preselname, $js);
													?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('parentMaster') ?></div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
														$options = '';
														$options[] = $this->lang->line('pleaseselect');
														if($mcmaster){
															$preselparentmaster = $mcmaster->parentFilterID;
															foreach($masterParent as $row){
															$options[$row->ID] = $row->name;
														}
														}else{
															$preselparentmaster = '0';
														}
														$js='id=masterCode';
														echo form_dropdown('masterCode', $options, $preselparentmaster, $js);
													?>
                                                </div>                                                                                                
                                            	</div>
                                            </div>
                                            <div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('code') ?></div>
                                                <div class="span10">
                                                
                                                      <?php
													$data = array(
													'name'=>'code',
													'id'=>'code',
													'onkeypress'=>'return isNumberKey(event)',
													'maxlength'=>'4',);
													  if($mcmaster){
															echo form_input($data, $mcmaster->code); 
													  }
													  else
													  {
															echo form_input($data, set_value('code')); 
													  }?>
                                                </div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('name') ?></div>
                                                <div class="span10">
                                                
                                                      <?php
													$data = array(
													'name'=>'name',
													'id'=>'name',
													'maxlength'=>'64',);
													  if($mcmaster){
															echo form_input($data, $mcmaster->name); 
													  }
													  else
													  {
															echo form_input($data, set_value('name')); 
													  }?>
                                                </div>
                                            </div>
                                            <div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('shortName') ?></div>
                                                <div class="span10">
                                                
                                                      <?php
													$data = array(
													'name'=>'shortName',
													'id'=>'shortName',
													'maxlength'=>'8',);
													  if($mcmaster){
															echo form_input($data, $mcmaster->shortName); 
													  }
													  else
													  {
															echo form_input($data, set_value('shortName')); 
													  }?>
                                                </div>
                                            </div>
                                            <div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('description') ?></div>
                                                <div class="span10">
                                                
                                                      <?php
													$data = array(
													'name'=>'description',
													'id'=>'description',
													'maxlength'=>'128',);
													  if($mcmaster){
															echo form_input($data, $mcmaster->description); 
													  }
													  else
													  {
															echo form_input($data, set_value('description')); 
													  }?>
                                                </div>
                                            </div>
											<div class="controls-row">
                                                <div class="span2"><?php echo $this->lang->line('orderNo') ?></div>
                                                <div class="span9">
                                                <div class="input-prepend">
                                                   <?php
													$data = array(
													'name'=>'orderNo',
													'id'=>'orderNo',
													'maxlength'=>'11',);
													
													if($mcmaster){
														echo form_input($data, $mcmaster->orderNo); 
													}
													else
													{
														echo form_input($data, set_value('orderNo')); 
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

