<script>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
    $('.add_more').click(function(e){
        e.preventDefault();
        $(this).before("<input name='file_load[]' type='file' class='uni' multiple/>");
    });
	
	jQuery("#content").find("input").keyup(function() {
		jQuery(this).val(jQuery(this).val().toUpperCase());
	});
});
function saveSupplierPayment() {
//	alert('save?');
	var balance = $("#outOfBalance").val();
	if (balance != 0){
		alert ("<?php echo $this->lang->line('balanceError'); ?>"+balance);
		return false;
	}else {
		$("#supplierPayment_Form").submit();
	};
}


	function changeList(obj){
		var id = obj.value;
		var urls = "<?php echo base_url();?>supplierpayment/newForm/"+id;
		window.location = urls;
	/*	alert(id);
		$.ajax({
			type: "POST",
			url: "<?php base_url()?>supplierpayment/newForm/",
			data: "supplier="+id,
			dataType:"json",
			success: function(content){
				if(content.status == "success") {
					$('#supplierAddress').val(content.message.addressName);
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				}
			}
		}); 
		return false;
	*/}
 function getDiscount(me){
	var tr = $(me).attr("data-trId");
	var payable = $("#" + tr + " td:eq(5)").text();
	if (isNaN(payable )) 
	    payable =0;
	var discount =  payable * $(me).val() / 100;
	var afterDiscount = payable - discount;
	var amountApplied = $("#" + tr + " td:eq(7)").text();

	$("#" + tr + " td:eq(7) input").val(discount);
	if (amountApplied > afterDiscount)
		$("#" + tr + " td:eq(7) input").val(afterDiscount);
	getTotal();
	
 }
 
	 
 function getTotal (){
	  
	$("#totalDiscount").val("");
	$("#totalApplied").val("");
	
	 var n =$("#listInvoice > tbody > tr").length-1;
	 var amount =0;
	 var discount = 0;
	 var apBalance = 0;
	 var amountApplied =0;
	 var totalAmountApplied = 0;
	 for (i=0; i<=n; i++) {
		 	amountApplied = $('#listInvoice > tbody > tr:eq(' + i + ') > td:eq(7) input').val()*1;
			totalAmountApplied= totalAmountApplied +  amountApplied;
			if (isNaN(amountApplied))
				amountApplied = 0;
			//count discount only if amt applied > 0
//			if (amountApplied > 0)
				discount= discount + ($('#listInvoice > tbody > tr:eq(' + i + ') > td:eq(6) input').val() *1); 
	 }
 	$("#totalDiscount").val(discount.toFixed(2) );  
	$("#totalApplied").val(totalAmountApplied.toFixed(2));
  
	//$("#totalOtherCharges").val(total + totalCharge);
	calculateBalanceAfterApplied(totalAmountApplied,discount);
	//hoi(totalAmountApplied,discount);

  }
  
	function calculateTotalCharges(me) {
		var charges = $(me).val();
		var totalDiscount = $("#totalDiscount").val()*1;
		if (isNaN(charges )) 
			charges =0;
		if (isNaN(totalDiscount)) 
			totalDiscount =0;
		var totalCharges = totalDiscount - charges;
		$("#totalOtherCharges").val(totalCharges.toFixed(2));
		$("#otherCharges").val(totalCharges.toFixed(2));
		calculateBalanceAfterCharges(totalCharges); 
  }
  
	function updateTotalAmountPaid(me) {
		//alert($(me).val());
		var totalPaid = $(me).val()*1;
		
		$("#totalPaid").val(totalPaid.toFixed(2));
		calculateBalanceAfterPaid(totalPaid);
	}

	function reverseAmountPaid(){
		var totalPaid = 0;
		var amountPaid = $("#amountPaid").val()*1;
		var totalApplied = $("#totalApplied").val()*1;
		var totalCharges = $("#totalCharges").val()*1;
		var outOfBalance = $("#outOfBalance").val()*1;

		if (isNaN(outOfBalance )) 
			totalPaid =0;
		
		if (isNaN(totalApplied )) 
			totalApplied =0;
		
		if (isNaN(totalCharges )) 
			totalCharges =0;
				
		totalPaid = amountPaid + outOfBalance  ;
		$("#amountPaid").val(totalPaid.toFixed(2));
		$("#outOfBalance").val('0.00');
	}
	
	function updateAmountApplied(me) {
//		var tr = $(me).attr("data-trId");
		var rRow = $(me).parents("tr");
		var payable = $("td:eq(5)", rRow).text();
//		alert (payable);
		if (isNaN(payable )) 
			payable =0;
		var balance = $("#outOfBalance").val()*1;
		if (isNaN(balance )) 
			balance =0;
		if (balance < 0){
			balance = balance * (-1);
			//alert ('balance='+balance+' payable='+payable);
			if (balance> payable)
				//applied = payable
				$(rRow).find("td:eq(7) input").val(payable);
			else
				//applied = balance
				//$("td:eq(7)", rRow).val(balance);
				$(rRow).find("td:eq(7) input").val(balance);
		}
	}

  	function calculateBalance() {
		var totalPaid = $("#totalPaid").val()*1;
		var totalApplied = $("#totalApplied").val()*1;
		var totalCharges = $("#totalCharges").val()*1;
		if (isNaN(totalPaid )) 
			totalPaid =0;
		
		if (isNaN(totalApplied )) 
			totalApplied =0;
		
		if (isNaN(totalCharges )) 
			totalCharges =0;
				
		var outOfBalance = totalApplied - totalPaid - totalCharges;
	
		$("#outOfBalance").val(outOfBalance.toFixed(2));
		if (outOfBalance<0)
			$("#outOfBalance").attr("style", "color:red;");
		else
			$("#outOfBalance").attr("style", "color:black;");
//		if (outOfBalance == 0)
//			$("#mysubmit").removeAttr('disabled');
//			$("#mysubmit").show();
//		else	$("#mysubmit").attr('disabled','disabled');	
//			$("#mysubmit").show();
  }

  	function calculateBalanceAfterPaid(me) {
		var totalPaid = me;
		var totalApplied = $("#totalApplied").val()*1;
		var totalCharges = $("#totalOtherCharges").val()*1;
		
		if (isNaN(totalApplied )) 
			totalApplied =0;
		
		if (isNaN(totalCharges )) 
			totalCharges =0;
				
		var outOfBalance = totalApplied - totalPaid - totalCharges;
//		alert ('after paid'+outOfBalance +'='+ totalApplied +'-'+ totalPaid +'-'+ totalCharges);
		
		$("#outOfBalance").val(outOfBalance.toFixed(2));
		if (outOfBalance<0)
			$("#outOfBalance").attr("style", "color:red;");
		else
			$("#outOfBalance").attr("style", "color:black;");
	}

  	function calculateBalanceAfterApplied(me,discount) {
//	function  hoi(me,discount) {
//		alert('calculateBalanceAfterApplied');
		var totalPaid = $("#totalPaid").val()*1;
		var totalApplied = me;
		var totalCharges = 0 ;//$("#totalOtherCharges").val()*1;
		var bankCharges = $("#BankCharges").val()*1;
		if (isNaN(bankCharges))
			bankCharges =0;
		if (isNaN(totalPaid )) 
			totalPaid =0;
		
		totalCharges =discount - bankCharges;
		$("#totalOtherCharges").val(totalCharges.toFixed(2));		
		$("#otherCharges").val(totalCharges.toFixed(2));
		var outOfBalance = totalApplied - totalPaid - totalCharges;
		//alert ('after applied'+outOfBalance +'='+ totalApplied +'-'+ totalPaid +'-'+ bankCharges +'+'+discount);
		
		$("#outOfBalance").val(outOfBalance.toFixed(2));
		if (outOfBalance<0)
			$("#outOfBalance").attr("style", "color:red;");
		else
			$("#outOfBalance").attr("style", "color:black;");
  	}
  
    function calculateBalanceAfterCharges(me) {
		var totalPaid = $("#totalPaid").val()*1;
		var totalApplied = $("#totalApplied").val()*1;
		var totalCharges = me;
		if (isNaN(totalApplied)) 
			totalApplied =0;
		if (isNaN(totalPaid)) 
			totalPaid =0;
				
		var outOfBalance = totalApplied - totalPaid - totalCharges;
		//alert ('after charges'+outOfBalance +'='+ totalApplied +'-'+ totalPaid +'-'+ totalCharges);
		$("#outOfBalance").val(outOfBalance.toFixed(2));
		if (outOfBalance<0)
			$("#outOfBalance").attr("style", "color:red;");
		else
			$("#outOfBalance").attr("style", "color:black;");
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
                                        
	</div><!-- head --> 
<div class="content" id="grid_content_1">
<form id="supplierPayment_Form" name="supplierPayment_Form" method="post" action="<?php echo base_url(); ?>supplierPayment/save">
<input type="hidden" id="ID" name="ID" value="<?php echo $ID;?>" />
	<div class="row-fluid">
		<div class="alert alert-info">
			<strong><?php echo $this->lang->line('title') ?></strong>
		</div>
	</div>
	<div class="row-fluid scRow">                            
	  <div class="span6 scCol">
		<div class="block" id="grid_block_1">
          <div class="content">
                    <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('supplier');?></div>
                   	<div class="span6">
						<?php
							$preselpayee = $supplierID;
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
                    	<div class="span3"><?php echo $this->lang->line('address');?></div>
                   	<div class="span8" id="supplierAddress"  style="line-height:1">
                           <?php
						   if ($supplierInfo) {
							echo $supplierInfo->line1.'<br>'.$supplierInfo->line2.'<br>';
							echo $supplierInfo->line3.'<br>'.$supplierInfo->supplierPostCode.' '.$supplierInfo->city;	 
							echo '<br>Tel:'.$supplierInfo->phoneNumber1.' Fax:'.$supplierInfo->fax;
						   }
?>
                  </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('amtPaid');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'amountPaid', 
									'id'=>'amountPaid',
									'onBlur'=>'updateTotalAmountPaid(this)',
									'ondblclick'=>'reverseAmountPaid()',
									'class'=>'span18');
								echo form_input($data, set_value('amountPaid')); ?>
                  </div>
                  </div>
                  
                  <div class="controls-row"> 
                    	<div class="span3"><?php echo $this->lang->line('paymentMethod');?></div>
                   		<div class="span6">
						<?php
							$preselpayment = '2';
							$options = '';
							$options[] = '--Please Select--';
							foreach($paymentmethod as $row){
							$options[$row->ID] = $row->name;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('paymentMethodID', $options, $preselpayment);
						?>       
                     </div> 
                     </div> 
                     <div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('refNo');?></div>
 	                  	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'referenceNo', 
									'id'=>'referenceNo', 
									'class'=>'span14 validate[maxSize[30]]',); 
								echo form_input($data, set_value('referenceNo')); ?>
   		               </div>
                  </div> 
                     <div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('acctDescription');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'acctDescription', 
									'id'=>'acctDescription', 
									'class'=>'span14 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('acctDescription')); ?>
                  </div>
                  </div>
          </div><!-- content-->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span6 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
     		<div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('acctID');?></div>
                   	<div class="span6">
                            	<?php 								
							$preselcurr = '0';
							$options = '';
							$options[] = '--Please Select--';
							foreach($acctNo as $row){
							$options[$row->ID] = '['.$row->acctCode.'] '.$row->acctName;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('accountID', $options, $preselcurr);
						?>       
                  </div>
                  </div> 
                     <div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('balance');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'balance', 
									'id'=>'balance', 
									'class'=>'span14 validate[,maxSize[30]]',); 
								echo form_input($data, set_value('balance')); ?>
                  </div>
                  </div>
                  <div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('formNo');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'formNo', 
									'id'=>'formNo', 
									'class'=>'span14 validate[maxSize[30]]',
									'value'=>$formNo,); 
								echo form_input($data, set_value('formNo'));
								echo '<input  class="input-mini"   type="text" placeholder="Serial No" disabled="disabled">'; ?>
                  </div>
                  </div>              
                  <div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('project');?></div>
                   	<div class="span6">
                            	<?php 								
    						$preselproject = '0';
							$options = '';
							$options[] = '--Please Select--';
							foreach($project as $row){
							$options[$row->ID] = $row->project_name;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('projectID', $options, $preselproject);
							?>
	              </div>
                  </div>   
                 <div class="controls-row">
                       <div class="span3"><?php echo $this->lang->line('paymentDate');?></div>
                       <div class="span6">
				                 <?php
								$data = array(
								'name' => 'paymentDate',
								'id' => 'paymentDate',
								'type' => 'text',
								'class' => 'span datepicker2',);
								echo form_input($data, date('d-m-Y'));
                    	        ?>
                         </div>    
                         </div>      
                 <div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('currency');?></div>
                   		<div class="span6">
						<?php
							$preselcurr = ($supplierID==0 || $supplierID=='')?'1':$supplierInfo->currencyID;
							$options = '';
							$options[] = '--Please Select--';
							foreach($currency as $row){
							$options[$row->fldid] = $row->fldcurr_code;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('currencyID', $options, $preselcurr);
						?>       
                     </div> 
                     </div>
                           <div class="controls-row">
                    	<div class="span3"><?php echo $this->lang->line('exchangeRate');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'exchangeRate', 
									'id'=>'exchangeRate', 
									'class'=>'span14 validate[maxSize[30]]',); 
								echo form_input($data, set_value('exchangeRate')); ?>
                  </div>
                  </div>      
          </div><!-- content-->
        </div><!-- grid block 2-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
	<div class="row-fluid">
 		<div class="block" id="grid_block_3">
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
									'name'=>'mysubmit', 
									'id'=>'mysubmit', 
								//	'disabled'=>'disabled',
									'class'=>'btn btn-primary');
							$js='onclick="saveSupplierPayment()"';
							echo form_button($data, $this->lang->line('save'), $js);
							//echo form_submit($data,'Submit',$js);
							?>
                    </div>
                </div>
               </div>
       	  <div class="content np table-sorting">
            	<table name="listInvoice" id="listInvoice" cellpadding="0" cellspacing="0" width="100%" id="test" class="editable" border="0">
                	<thead>
                    <tr>
              			<th style="display:none"></th>
                        <th>#</th>
                        <th><?php echo $this->lang->line('invoiceFormNo');?></th>
            			<th><?php echo $this->lang->line('invoiceNo');?></th>
                        <th><?php echo $this->lang->line('invoiceDate');?></th>
                        <th><?php echo $this->lang->line('totalAmount');?></th>   
                        <th><?php echo $this->lang->line('apBalance');?></th>                         
                		<th class="tac"><?php echo $this->lang->line('discount');?></th>    
                        <th class="tar"><?php echo $this->lang->line('amountApplied');?></th>   
            		</tr>
        			</thead>
       				 <tbody>
                    <?php
					//echo var_dump($rsPendingInvoice);
					if ($rsPendingInvoice) {
						$i=1;
						//for new payment, ID = supplierInvoiceID. for update payemnt, ID=detailPaymentID
						foreach ($rsPendingInvoice as $rs){
							echo '<tr id="'.$rs->ID.'"><td>'.$i++;
							$suppPaymentID = isset($rs->suppPaymentID)?$rs->suppPaymentID:"";
							$suppInvoiceID = isset($rs->suppInvoiceID)?$rs->suppInvoiceID:"";
							echo '<input type="hidden" id="suppPaymentID[]" name="suppPaymentID[]" value="'. $suppPaymentID.'"/>';
							echo '<input type="hidden" id="suppInvoiceID[]" name="suppInvoiceID[]" value="'. $suppInvoiceID.'"/>';
							echo '</td><td>'.$rs->formNo.'['.$this->formSetup_model->getFormSerialNo_zeroLeading($rs->ID).']</td>';
							echo '<td >'.$rs->supplierInvoiceNo.'</td>';	
							echo '<td>'.date("d-m-Y",strtotime($rs->invoiceDate)).'</td>';	
							echo '<td class="tar">'.number_format($rs->totalAmount,2,'.',',').'</td>';	
							echo '<td class="tar">'.number_format($rs->totalPayable,2,'.',',').'</td>';	
							//<!-- col 7-->
							echo '<td><div class="span8">';
									$dataDiscount = array(
										'name'=>'discount[]', 
										'id'=>'discount[]',
										'data-trId' =>$rs->ID, 
										'onChange'=>'getTotal()', 
										'class'=>'span8 validate[required,custom[number]]',); 
									echo form_input($dataDiscount); 
							echo '</div></td>';
						//<!-- End Row 7-->';	
							echo '<td class="tar">';
							echo '<div class="span10">';
									$dataAmuontApplied = array(
										'name'=>'amountApplied[]', 
										'id'=>'amountApplied[]', 
										'onBlur'=>'getTotal()',
										'ondblclick'=>'updateAmountApplied(this)', 
										'class'=>'span10 validate[required,custom[number]]',); 
									echo form_input($dataAmuontApplied); 
							echo '</div>';
							echo '</td></tr>';	
						}
					}?>			
					</tbody>
			</table>                                         
          </div><!-- content-->
       </div><!-- grid block 3-->
    </div><!-- row-fluid scRow-->
	<div class="row-fluid scRow">                            
	  <div class="span4 scCol">
		<div class="block" id="grid_block_5">
          <div class="content">
				<div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('memo');?></div>
                   	<div class="span9">
                            	<?php 								
								$data = array(
									'name'=>'memo', 
									'id'=>'memo',
									'class'=>'input-block-level',
									'cols'=>'80',);
								echo form_textarea($data, set_value('memo')); ?>
                  </div>
                  </div>
          </div><!-- content-->
        </div><!-- grid block 4-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_4">
          <div class="content">
			<div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('totalDiscount');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'totalDiscount', 
									'id'=>'totalDiscount',
									'readonly'=>'readonly',
									'align'=>'right',
									'class'=>'span18' );
								echo form_input($data, set_value('totalDiscount')); ?>
                  	</div>
			</div>
            <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('BankCharges');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'BankCharges', 
									'id'=>'BankCharges',
									'class'=>'span18',
									'onBlur'=>'calculateTotalCharges(this)');
								echo form_input($data, set_value('BankCharges')); ?>
                  </div>
            </div>
            <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('totalOtherCharges');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'otherCharges', 
									'id'=>'otherCharges',
									'readonly'=>'readonly',
									'class'=>'span18');
								echo form_input($data, set_value('otherCharges')); ?>
                  	</div>
            </div>
          </div><!-- content-->
        </div><!-- grid block 4-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_5">
          <div class="content">
                     <div class="controls-row">
                    	<div class="span4"><?php echo $this->lang->line('TotalPaid');?></div>
	                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'totalPaid', 
									'id'=>'totalPaid',
									'readonly'=>'readonly',
									'class'=>'span18');
								echo form_input($data, set_value('TotalPaid')); ?>
    	              </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span4"><?php echo $this->lang->line('totalApplied');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'totalApplied', 
									'readonly'=>'readonly',
									'id'=>'totalApplied',
									'class'=>'span18');
								echo form_input($data, set_value('totalApplied')); ?>
                  </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span4"><?php echo $this->lang->line('totalOtherCharges');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'totalOtherCharges', 
									'id'=>'totalOtherCharges',
									'readonly'=>'readonly',
									'class'=>'span18');
								echo form_input($data, set_value('totalOtherCharges')); ?>
                  </div>
                  </div>
                    <div class="controls-row">
                    	<div class="span4"><?php echo $this->lang->line('outOfBalance');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'outOfBalance', 
									'id'=>'outOfBalance',
									'readonly'=>'readonly',
									'class'=>'span18');
								echo form_input($data, set_value('outOfBalance')); ?>
                  </div>
                  </div>
          </div><!-- content-->
        </div><!-- grid block 5-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
</div><!-- grid 1 -->
</form>
</div><!-- wrap -->
</div><!-- content -->

<?php 
/* function saveSupplierPayment1() {
	var balance = $("#outOfBalance").val();
	if (balance != 0){
		alert ("<?php echo $this->lang->line('balanceError'); ?>"+balance);
		return false;
	}
	var journalNo = $('#journal_number').val();
		var bil = 1;
	//		var addressID = $('#').val();
		var postData = {
			 'journalNo'	: journalNo,
			 'description': description,
			 'effdate'	: effdate,
			 'supplierID'	: $('#supplierID').val(),
			 'projectID'	: $('#projectID').val(),
			 'amountPaid' : $('#amountPaid').val(),
			 'paymentMethodID' : $('#paymentMethodID').val(),
			 'referenceNo' : $('#referenceNo').val(),
			 'accountID' : $('#accountID').val(),
			 'formNo' : $('#formNo').val(),
			 'paymentDate' : $('#paymentDate').val(),
			 'currencyID' : $('#currencyID').val(),
			 'memo' 		: $('#memo').val(),
			 'totalDiscount' : $('#totalDiscount').val(),
			 'bankCharges' : $('#bankCharges').val(),
			 'totalOtherCharge' : $('#totalOtherCharge').val(),
			 'totalPaid'  : $('#totalPaid').val(),
			 'totalApplied' : $('#totalApplied').val(),
			 'outOfBalance' : $('#outOfBalance').val(),
		};
 		$.ajax({
  			type: "POST",
  			dataType: "json",
			url: "<?php echo base_url();?>supplierPayment/save",
			data: postData ,
  			success: function(content){
					$("#error").html('<p>'+content.message+'</p>');
				if(content.status == "success") {
					$('#journal_number').val(content.message.seqNumber);
					$("#btnAddnew").show();
				}else if(content.status == "success1"){
					$('#journal_number').val(content.journalID).change();
					$('#description').val(content.message.description);
					$('#effdate').val(content.message.effdate);
					for (var i=0; i<content.datatbls.length; i++){
						if(content.datatbls[i].amount_dr != '0')
						$("#oTable tbody").append('<tr><td style="display:none">' +
							content.datatbls[i].ID + '</td><td>' +
							bil + '</td><td>' + 
							content.datatbls[i].acctcode + '</td><td id="description">' + 
//							content.datatbls[i].acctcode + ' [' + content.datatbls[i].acctname + ']</td><td>' + 
							content.datatbls[i].description + '</td><td class="tar" id="amount_dr">' + 
							parseFloat(content.datatbls[i].amount_dr).toFixed(2) + '</td><td class="tar" id="amount_cr"></td><td class="tac">' + 
							'<button class="btn btn-mini btn-danger removeline" title="<?php echo $this->lang->line('delete') ?>"><span class="i-trashcan"></button>' + '</td></tr>');
						if(content.datatbls[i].amount_cr != '0')
						$("#oTable tbody").append('<tr><td style="display:none">' +
							content.datatbls[i].ID + '</td><td>' +
							bil + '</td><td>' + 
							content.datatbls[i].acctcode + '</td><td id="description">' + 
//							content.datatbls[i].acctcode + ' [' + content.datatbls[i].acctname + ']</td><td>' + 
							content.datatbls[i].description + '</td><td class="tar" id="amount_dr"></td><td class="tar" id="amount_cr">' + 
							parseFloat(content.datatbls[i].amount_cr).toFixed(2) + '</td><td class="tac">' +
							'<button class="btn btn-mini btn-danger removeline" title="<?php echo $this->lang->line('delete') ?>"><span class="i-trashcan"></button>' + '</td></tr>');
//						if(i == 0)
						if(content.datatbls[i].amount_cr != '0')
			 				total_credit = parseFloat(total_credit) + parseFloat($('#oTable > tbody > tr:eq(' + i + ') > td:eq(5)').text());
						if(content.datatbls[i].amount_dr != '0')
			 				total_debit = parseFloat(total_debit) + parseFloat($('#oTable > tbody > tr:eq(' + i + ') > td:eq(4)').text());
						bil++;
        			}
						$('#bill').val(content.datatbls.length);
					$("#btnAddnew").show();
					$("#amountcredit").val(total_credit.toFixed(2));
					$("#amountdebit").val(total_debit.toFixed(2));
					$("#totalamount").val((parseFloat(total_debit) - parseFloat(total_credit)).toFixed(2));
				}else if(content.status == "failed"){
					alert(content.message);
				}
			}
		});        // Here your ajax action after delete confirmed
//		location.reload();
	}

} */ ?>