<?php //print_r($supplier); exit(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		//Balanace Sheet datatable configuration
	   	var oTableBalance = $("#test").dataTable({
			"iDisplayLength": 5,
			"aLengthMenu": [5,10,25,50,100],
			"sPaginationType": "full_numbers",
			"aoColumns": [null,
							null,
							null,
							null,
						] 
		});
		oTableBalance.fnSort( [ [1,'asc'] ] );
		//Profit and loss accounts datatable configuration
	   	var oTableProfit = $("#profitNloss").dataTable({
			"iDisplayLength": 5,
			"aLengthMenu": [5,10,25,50,100],
			"sPaginationType": "full_numbers",
			"aoColumns": [null,
							null,
							null,
							null,
						] 
		});
		oTableProfit.fnSort( [ [1,'asc'] ] );
		//Data table configurations end	
		$('.indusList').change(function(){
			$('.buzTypeItm').css({display:'none'});
			var indusId = $(this).val();
			$('.indus'+indusId).css({display:'block'});
			$('.buzTypeList').val('0');
		});
		
		//Get table information
		/*$('.buzTypeList').change(function(){
			var serial = 1;
			oTableBalance.fnClearTable();
			$.ajax({
				url: "<?php echo base_url(); ?>setting/getTypeInfo/",
				async: false,
				type: "POST",
				data: 'ID='+$(this).val()+'&acctClass=0',
				dataType: "html",
				success: function(data) {
					//blncShtBody
					var obj = jQuery.parseJSON(data);
					if(typeof obj[0].ID !== 'undefined' ){
						oTableBalance.fnDeleteRow(0,null,true);
						jQuery.each(obj,function(i,v){
							oTableBalance.fnAddData( [
												serial,
												v.acctCode,
												v.acctName,
												v.acctTypeName 
												] );
						serial++;
						});
						
					}else{	
						alert("No Data");
					}
				}
			});
			oTableProfit.fnClearTable();
			serial=1;
			$.ajax({
				url: "<?php echo base_url(); ?>setting/getTypeInfo/",
				async: false,
				type: "POST",
				data: 'ID='+$(this).val()+'&acctClass=1',
				dataType: "html",
				success: function(data) {
					//blncShtBody
					var obj = jQuery.parseJSON(data);
					if(typeof obj[0].ID !== 'undefined' ){
						oTableProfit.fnDeleteRow(0,null,true);
						jQuery.each(obj,function(i,v){
							oTableProfit.fnAddData( [
												serial,
												v.acctCode,
												v.acctName,
												v.acctTypeName 
												] );
						serial++;
						});
						
					}else{	
						alert("No Data");
					}
				}
			});	
		});*/
	});	
</script>

<div id="content">                        
    <div class="wrap">
    	<!--Header start here-->
		<div class="head">
            <div class="info">
                <h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
                    <?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
                <ul class="breadcrumb">
                    <li><a href="#"><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                    <li><a href="#"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                    <li class="active"><?php echo $this->lang->line('titlelist') ?></li>
                </ul>
            </div>
            <div class="search">
                <form action="<?php echo base_url() ?>admin/search" method="post">
                    <input name="search_text" type="text" placeholder="search..."/>                                
                    <button type="submit"><span class="i-magnifier"></span></button>
                </form>
            </div>                        
        </div>
        <!--Header end here-->
        
        <!--Alert Message start-->
        <?php 	
			$message = $this->session->flashdata('msg');
			$alert = $this->session->flashdata('danger-msg');
			if(isset($message) && $message != ''): ?>
            <div class="content alertbox">                                                
                <div class="row-fluid">
                    <div class="span12">        
                        <div class="alert alert-success">            
                            <strong>Success! </strong><?php echo $message;?>
                        </div>       
                    </div>
                </div>
            </div>
        <?php	
			elseif(isset($alert) && $alert != ''): ?>
            <div class="content alertbox">                                                
                <div class="row-fluid">
                    <div class="span12">        
                        <div class="alert alert-error">            
                            <strong>Deleted! </strong><?php echo $alert;?>
                        </div>       
                    </div>
                </div>
            </div>
		<?php endif; ?>
        <!--Alert Message end-->
        
        <!--Chart of Account top form start-->
        <?php if($isShowDropdown): ?>
        <div class="content">
            <div class="wrap">                    
                <div class="row-fluid">
                    <div class="span12">
                        <div class="block">
                        <?php echo form_open('setting/createCompanyChartofAccount',array("id"=>"chartofaccount")); ?>
                            <div class="head">
                                <h2><?php echo $this->lang->line('title') ?></h2>
                            </div><!-- head -->
							<div class="content np">    
                                <div class="controls-row"><!-- Row 4-->
                                    <div class="span6 tac">
                                    	<input type="hidden" name="companyID" value="<?php echo element('compID', $this->session->userdata('logged_in')); ?>" />
                                    	<div class="span6 tar"><?php echo form_label($this->lang->line('industry_classification'));?></div>
                                        <div class="input-prepend">
                                            <?php
												$preselcat = '';
												$options[] = '--Please Select--';
												foreach($industryInfo as $row){
													$options[$row->indusID] = $row->indusName;
												}
												$js='class="input-medium indusList" id="indusID"';
												echo form_dropdown('indusList', $options, $preselcat, $js);
											?>     
                                        </div>  
                                    </div>
                                    <div class="span6 tac">
                                    	<div class="span6 tar"><?php echo form_label($this->lang->line('type_of_business'));?></div>
                                        <div class="input-prepend">
                                            <?php
												$preselcat = '';
												unset($options);
												$options = array();
												$options[] = '--Please Select--';
												foreach($industryInfo as $row){
													$options[$row->bizID] = $row->bizName;
													$optionClass[$row->bizID] = 'buzTypeItm indus'.$row->indusID;
												}
												$js='class="input-medium buzTypeList" id="BuzTypeID"';
												echo form_dropdown('businessTypeID', $options, $preselcat, $js, $optionClass);
											?>     
                                        </div>  
                                    </div>
                                </div><!-- End Row 4-->
                            </div><!-- content -->
                    		<div class="footer">
                                <div class="side fr">
                                    <div class="btn-group">
                                        <?php 
                                            $data = array(
                                                        'name'=>'addprice', 
                                                        'class'=>'btn btn-warning',
                                                        'id'=>'adItmPrice'
                                                    );
                                            echo form_submit($data,$this->lang->line('save'));
                                            ?>
                                    </div>
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
			</div>
		</div>
        <?php endif; ?>
        <!--Chart of Account top form end-->
        
        <!--Main content start here-->
        <?php if(isset($profitNloss[0]) && isset($balance[0])): ?>
        <!--Table for balance Sheet start-->
        <div class="content">
            <div class="wrap">                    
                <div class="row-fluid">
                    <div class="span12">
                        <div class="block">
                            <div class="head">
                                <h2><?php echo $this->lang->line('accntMstBalanceSheet') ?></h2>                                       
                            </div>
                            <div class="content np table-sorting">
                                <table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable balncSheet">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('serialno') ?></th>
                                            <th><?php echo $this->lang->line('account') ?></th>
                                            <th><?php echo $this->lang->line('accountName') ?></th>
                                            <th><?php echo $this->lang->line('accountType') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="blncShtBody">
                                    	<?php 
										if(isset($balance[0])):
										foreach($balance as $row):
										?>
                                        <tr>
                                        	<td><?php echo $row->acctCode; ?></td>
                                            <td><?php echo $row->acctName; ?></td>
                                            <td><?php echo $row->acctGroupName; ?></td>
                                            <td><?php echo $row->acctTypeName; ?></td>
                                        </tr>
                                        <?php
										endforeach;
                                        endif;
										?>
                                    </tbody>
                                </table>                                         
                        	</div>
                            <div class="footer">
                                <div class="side fr">
                                    <div class="btn-group">
                                        &nbsp;
                                    </div>
                                </div>
                            </div> 
                        </div>                                
                    </div>
                </div>                                
            </div>
        </div>
        <!--Table for balance Sheet end-->
        <!--Table for balance Sheet start-->
        <div class="content">
            <div class="wrap">                    
                <div class="row-fluid">
                    <div class="span12">
                        <div class="block">
                            <div class="head">
                                <h2><?php echo $this->lang->line('accntMstProfitNLossAccounts') ?></h2>                                       
                            </div>
                            <div class="content np table-sorting">
                                <table cellpadding="0" cellspacing="0" width="100%" id="profitNloss" class="editable balncSheet">
                                    <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('serialno') ?></th>
                                        <th><?php echo $this->lang->line('account') ?></th>
                                        <th><?php echo $this->lang->line('accountName') ?></th>
                                        <th><?php echo $this->lang->line('accountType') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody class="blncShtBody">
                                     	<?php 
										if(isset($profitNloss[0])):
										foreach($profitNloss as $row):
										?>
                                        <tr>
                                        	<td><?php echo $row->acctCode; ?></td>
                                            <td><?php echo $row->acctName; ?></td>
                                            <td><?php echo $row->acctGroupName; ?></td>
                                            <td><?php echo $row->acctTypeName; ?></td>
                                        </tr>
                                        <?php
										endforeach;
                                        endif;
										?>   
                                    </tbody>
                                </table>                                         
                        	</div>
                            <div class="footer">
                                <div class="side fr">
                                    <div class="btn-group">
                                        &nbsp;
                                    </div>
                                </div>
                            </div> 
                        </div>                                
                    </div>
                </div>                                
            </div>
        </div>
        <!--Table for balance Sheet end-->
        <?php endif; ?>
        <!--Main content end here-->
	</div>
</div>
<div class="dialog" id="row_delete" style="display: none;" title="Are you sure to Delete?">
    <p><?php echo $this->lang->line('message1') ?></p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Are you sure to Edit ?">
    <p><?php echo $this->lang->line('message2') ?></p>
</div>

