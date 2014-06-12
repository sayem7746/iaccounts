<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
   $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null,
			null, 
			null,
			null,
			null,
		   { 
			"bSortable": false } ]});

    $("table.editable").on("click",".remove",function(){
        rRow = $(this).parents("tr");
        ID = $('td:first', $(this).parents('tr')).text(); 
        $("#row_delete").dialog("open");
    });
    $("table.editable").on("click",".edit",function(){
        rRow = $(this).parents("tr");
        ID = $('td:first', $(this).parents('tr')).text(); 
        $("#row_edit").dialog("open");
    });
    $("#row_edit").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
				window.location.href = "paymentForm?ID=" + ID;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
    function remove_row(row){
        row.remove();
 		$.ajax({
  			type: "POST",
  			url: "supppayment_delete",
			data:"ID="+ID,
  			success: function(){
				alert('Row has been deleted...');
			},
		});       // Here your ajax action after delete confirmed
    }
    $("#row_delete").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Delete": function() {
                remove_row(rRow);
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
}); 
 
</script>
<div class="head">
	<div class="info">
		<h1><?php echo $module ?></h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'>Dashboard</a> <span class="divider">-</span></li>
                <li><a href="file:///C|/xampp/htdocs/iaccounts/application/views/supplier/home"><?php echo $module ?></a> <span class="divider">-</span></li>
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
        	<div class="block">
            	<div class="head">
                	<h2><?php echo $title ?></h2>
                    	<ul class="buttons">
                        	<li><a href="#" class="block_loading" title="Refresh"><span class="i-cycle"></span></a></li>
                            <li><a href="#" class="block_toggle" title="Close"><span class="i-arrow-down-3"></span></a></li>
                            <li><a href="#" class="block_remove"><span class="i-cancel-2"></span></a></li>
                        </ul>                                        
                </div>
                				<div class="content np">    
                    <div class="controls-row">
                  <div class="span2"><?php echo form_label('supplierID:','supplierID');?></div>
                   	<div class="span10">
						<?php
							$preselpayee = '0';
							$options = '';
							$options[] = '--Please Select--';
							foreach($supplier as $row){
							$options[$row->ID] = $row->supplierName;
							}
							$js='onChange="changeList(this)"';
							echo form_dropdown('supplierID', $options, $preselpayee, $js);
						?>                        
                  </div>
                  </div>
                  <div class="controls-row">
                    	<div class="span2">Supplier Address:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'supplierAddress', 
									'id'=>'supplierAddress', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('supplierAddress')); ?>
                                <span class="help-inline">Required, max size = 10</span>
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2">Address 2</div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'line1', 
									'id'=>'line1', 									
									'class'=>'span5 validate[maxSize[30]]',); 
							echo form_input($data, set_value('line1')); ?>                      
                  </div>
                  </div>
                  <div class="controls-row">
                  	<div class="span2">City:</div>
                   	<div class="span4">
						<?php
							$data = array(
									'name'=>'city', 
									'id'=>'city', 									
									'class'=>'span3 validate[maxSize[10]]',); 
							echo form_input($data, set_value('city')); ?>                       
        
                  </div>
                    <div class="span1" TAR><?php echo form_label('PostCode:','postCode');?></div>
                     <div class="span4">
						<?php
							$data = array(
									'name'=>'postCode', 
									'id'=>'postCode', 									
									'class'=>'span3 validate[maxSize[10]]',); 
							echo form_input($data, set_value('postCode')); ?>                       
                  </div>
                  </div>
                  <div class="controls-row">
                    	<div class="span2">Project:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'project', 
									'id'=>'project', 
									'class'=>'span5 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('project')); ?>
                  </div>
                  </div>   
                     <div class="controls-row">
                    	<div class="span2">Amount Paid:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'amountPaid', 
									'id'=>'amountPaid', 
									'class'=>'span5 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('amountPaid')); ?>
                  </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span2">Balance:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'outOfBalance', 
									'id'=>'outOfBalance', 
									'class'=>'span5 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('outOfBalance')); ?>
                  </div>
                  </div>
                  
                 <div class="controls-row"> 
                    	<div class="span2"><?php echo form_label('Payment Method:','paymentmethod');?></div>
                   		<div class="span4">
						<?php
							$preselpayment = '2';
							$options = '';
							$options[] = '--Please Select--';
							foreach($paymentmethod as $row){
							$options[$row->ID] = $row->name;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('paymentmethod', $options, $preselpayment);
						?>       
                     </div> 
                     </div> 
                        <div class="controls-row">
                    	<div class="span2">Account Description:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'accountDescription', 
									'id'=>'accountDescription', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('accountDescription')); ?>
                  </div>
                  </div> 
                           <div class="controls-row">
                    	<div class="span2">Exchange Rate:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'exchangeRate', 
									'id'=>'exchangeRate', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('exchangeRate')); ?>
                  </div>
                  </div>      
                  <div class="controls-row">
                    	<div class="span2">Form No:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'formNo', 
									'id'=>'formNo', 
									'class'=>'span5 validate[maxSize[30]]',
									'value'=>$formNo,); 
								echo form_input($data, set_value('formNo')); ?>
                  </div>
                  </div>              
                 <div class="controls-row">
                       <div class="span2">Payment Date:</div>
                       <div class="span9">
                       <div class="input-prepend">
                         <span class="add-on"><i class="i-calendar"></i></span>
				                 <?php
								$data = array(
								'name' => 'createdDate',
								'id' => 'createdDate',
								'type' => 'text',
								'class' => 'datepicker',);
								echo form_input($data, date('d-m-Y'));
                    	        ?>
                          </div>
                         </div>    
                         </div>      
                 <div class="controls-row">
                    	<div class="span2"><?php echo form_label('Currency:','currency');?></div>
                   		<div class="span4">
						<?php
							$preselcurr = '1';
							$options = '';
							$options[] = '--Please Select--';
							foreach($currency as $row){
							$options[$row->fldid] = $row->fldcurr_code;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('currency', $options, $preselcurr);
						?>       
                     </div> 
                     </div>
                           <div class="controls-row">
                    	<div class="span2">Reference No:</div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'referenceNo', 
									'id'=>'referenceNo', 
									'class'=>'span5 validate[maxSize[30]]',); 
								echo form_input($data, set_value('referenceNo')); ?>
                  </div>
                  </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th>Invoice No</th>
                        <th>Invoice Date</th>
                        <th>Total Amount</th>   
                        <th>AP Balance</th>                         
                		<th>Discount</th>    
                        <th>Amount Applied</th>   
            		</tr>
        			</thead>
       				 <tbody></tbody>
			
</div>                                
</div>
</div>                                
</div>
</div>                                
</div>
</div>
<div class="dialog" id="row_delete" style="display: none;" title="Are you sure to Delete?">
    <p>Row will be deleted</p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Are you sure to Edit ?">
    <p>To editing page.....</p>
</div>   
