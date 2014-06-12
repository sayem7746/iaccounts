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
	$("#totalOtherCharges").val("");
	
	 var n =$("#listInvoice > tbody > tr").length-1;
	 var amount =0;
	 var discount = 0;
	 var apBalance = 0;
	 var totalAmountApplied = 0;
	 for (i=0; i<=n; i++) {
			totalAmountApplied= totalAmountApplied + $('#listInvoice > tbody > tr:eq(' + i + ') > td:eq(8) input').val()*1; 
			discount= discount + ($('#listInvoice > tbody > tr:eq(' + i + ') > td:eq(7) input').val() *1); 
			//alert (totalAmountApplied);
			//alert (discount);
	 }
 	$("#totalDiscount").val(discount );  
	$("#totalApplied").val(totalAmountApplied);
  
	//$("#totalOtherCharges").val(total + totalCharge);
	calculateBalance();
  }
  
  function calculateTotalCharges(me) {
	  $("#totalOtherCharges").val($(me).val());
	  $("#otherCharges").val($(me).val());
	 	calculateBalance(); 
  }
  
  function updateTotalAmountPaid(me) {
	  	//alert($(me).val());
	var totalPaid = $(me).val();
	$("#TotalPaid").val(totalPaid);
	var totalApplied = $("#totalApplied").val()*1;
	var totalCharges = $("#totalCharges").val()*1;
	if (isNaN(totalApplied )) 
		totalApplied =0;
	
	if (isNaN(totalCharges )) 
		totalCharges =0;
	var outOfBalance = totalPaid - totalApplied - totalCharges;

	$("#outOfBalance").val(outOfBalance);
	if (outOfBalance<0)
		$("#outOfBalance").attr("style", "color:red;");
	else
		$("#outOfBalance").attr("style", "color:black;");
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
	
	alert(totalPaid);
	alert(totalApplied);
	alert(totalCharges);
			
	var outOfBalance = totalPaid - totalApplied - totalCharges;

	$("#outOfBalance").val(outOfBalance);
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
                    <div class="span3"><?php echo form_label($this->lang->line('supplier'),'Supplier');?></div>
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
                    	<div class="span3"><?php echo form_label($this->lang->line('address'),'address');?></div>
                   	<div class="span6" id="supplierAddress">
                           <?php
							//echo $rs->line1.'<br>'.$rs->line2;
							//echo $rs->line3.'<br>'.$rs->postCode.' '.$rs->city;	 
?>
                  </div>
                  </div>
                  <div class="controls-row">
                    	<div class="span3"><?php echo form_label($this->lang->line('project'),'project');?></div>
                   	<div class="span6">
                            	<?php 								
    						$preselproject = '0';
							$options = '';
							$options[] = '--Please Select--';
							foreach($project as $row){
							$options[$row->ID] = $row->project_name;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('project', $options, $preselproject);
							?>
	              </div>
                  </div>   
                     <div class="controls-row">
                    	<div class="span3"><?php echo form_label($this->lang->line('amtPaid'),'amtPaid');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'amountPaid', 
									'id'=>'amountPaid',
									'onChange'=>'updateTotalAmountPaid(this)',
									'class'=>'span18');
								echo form_input($data, set_value('amountPaid')); ?>
                  </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span3"><?php echo form_label($this->lang->line('balance'),'balance');?></div>
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
                    	<div class="span3"><?php echo form_label($this->lang->line('paymentMethod'),'paymentMethod');?></div>
                   		<div class="span6">
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
          </div><!-- content-->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span6 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
     		<div class="controls-row">
                    	<div class="span3"><?php echo form_label($this->lang->line('acctDescription'),'acctDescription');?></div>
                   	<div class="span6">
                            	<?php 								
							$preselcurr = '0';
							$options = '';
							$options[] = '--Please Select--';
							foreach($acctNo as $row){
							$options[$row->ID] = '['.$row->acctCode.'] '.$row->acctName;
							}
							//$js='onChange="changeList(this)"';
							echo form_dropdown('currency', $options, $preselcurr);
						?>       
                  </div>
                  </div> 
                  <div class="controls-row">
                    	<div class="span3"><?php echo form_label($this->lang->line('formNo'),'formNo');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'formNo', 
									'id'=>'formNo', 
									'class'=>'span14 validate[maxSize[30]]',
									'value'=>$formNo,); 
								echo form_input($data, set_value('formNo'));
								echo $formSerialNo; ?>
                  </div>
                  </div>              
                 <div class="controls-row">
                       <div class="span3"><?php echo form_label($this->lang->line('paymentDate'),'createdDate');?></div>
                       <div class="span6">
				                 <?php
								$data = array(
								'name' => 'createdDate',
								'id' => 'createdDate',
								'type' => 'text',
								'class' => 'span datepicker2',);
								echo form_input($data, date('d-m-Y'));
                    	        ?>
                         </div>    
                         </div>      
                 <div class="controls-row">
                    	<div class="span3"><?php echo form_label($this->lang->line('currency'),'currency');?></div>
                   		<div class="span6">
						<?php
							$preselcurr = ($supplierID==0 || $supplierID=='')?'1':$supplierInfo->currencyID;
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
                    	<div class="span3"><?php echo form_label($this->lang->line('exchangeRate'),'exchangeRate');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'exchangeRate', 
									'id'=>'exchangeRate', 
									'class'=>'span14 validate[maxSize[30]]',); 
								echo form_input($data, set_value('exchangeRate')); ?>
                  </div>
                  </div>      
                           <div class="controls-row">
                    	<div class="span3"><?php echo form_label($this->lang->line('refNo'),'refNo');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'referenceNo', 
									'id'=>'referenceNo', 
									'class'=>'span14 validate[maxSize[30]]',); 
								echo form_input($data, set_value('referenceNo')); ?>
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
									'class'=>'btn btn-primary');
							$js='onclick="return confirm(\'Press OK to continue...\')"';
							echo form_submit($data,'Submit',$js);
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
                        <th><?php echo form_label($this->lang->line('invoiceFormNo'),'invoiceFormNo');?></th>
            			<th><?php echo form_label($this->lang->line('invoiceNo'),'invoiceNo');?></th>
                        <th><?php echo form_label($this->lang->line('invoiceDate'),'invoiceDate');?></th>
                        <th><?php echo form_label($this->lang->line('totalAmount'),'totalAmount');?></th>   
                        <th><?php echo form_label($this->lang->line('apBalance'),'apBalance');?></th>                         
                		<th class="tac"><?php echo form_label($this->lang->line('discount'),'discount');?></th>    
                        <th class="tar"><?php echo form_label($this->lang->line('amountApplied'),'amountApplied');?></th>   
            		</tr>
        			</thead>
       				 <tbody>
                    <?php
					//echo var_dump($rsPendingInvoice);
					if ($rsPendingInvoice) {
						$i=1;
						foreach ($rsPendingInvoice as $rs){
							echo '<tr id="'.$rs->ID.'"><td>'.$i++.'</td>';
							echo '<td>'.$rs->formNo.'['.$this->formSetup_model->getFormSerialNo_zeroLeading($rs->ID).']</td>';
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
										'onChange'=>'getDiscount(this)', 
										'class'=>'span8 validate[required,custom[number]]',); 
									echo form_input($dataDiscount); 
							echo '</div></td>';
						//<!-- End Row 7-->';	
							echo '<td class="tar">';
							echo '<div class="span10">';
									$dataAmuontApplied = array(
										'name'=>'amountApplied[]', 
										'id'=>'amountApplied[]', 
										'onChange'=>'getTotal()',
										'onClick'=>'updateAmountApplied()', 
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
                    	<div class="span2"><?php echo form_label($this->lang->line('memo'),'memo');?></div>
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
                    <div class="span3"><?php echo form_label($this->lang->line('totalDiscount'),'totalDiscount');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'totalDiscount', 
									'id'=>'totalDiscount',
									'disabled'=>'disabled',
									'class'=>'span18' );
								echo form_input($data, set_value('totalDiscount')); ?>
                  	</div>
			</div>
            <div class="controls-row">
                    <div class="span3"><?php echo form_label($this->lang->line('BankCharges'),'BankCharges');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'BankCharges', 
									'id'=>'BankCharges',
									'class'=>'span18',
									'onChange'=>'calculateTotalCharges(this)');
								echo form_input($data, set_value('BankCharges')); ?>
                  </div>
            </div>
            <div class="controls-row">
                    <div class="span3"><?php echo form_label($this->lang->line('totalOtherCharges'),'totalOtherCharges');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'otherCharges', 
									'id'=>'otherCharges',
									'disabled'=>'disabled',
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
                    	<div class="span4"><?php echo form_label($this->lang->line('TotalPaid'),'TotalPaid');?></div>
	                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'TotalPaid', 
									'id'=>'TotalPaid',
									'disabled'=>'disabled',
									'onChange'=>'calculateBalance(this)',
									'class'=>'span18');
								echo form_input($data, set_value('TotalPaid')); ?>
    	              </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span4"><?php echo form_label($this->lang->line('totalApplied'),'totalApplied');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'totalApplied', 
									'disabled'=>'disabled',
									'id'=>'totalApplied',
									'class'=>'span18');
								echo form_input($data, set_value('totalApplied')); ?>
                  </div>
                  </div>
                     <div class="controls-row">
                    	<div class="span4"><?php echo form_label($this->lang->line('totalOtherCharges'),'totalOtherCharges');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'totalOtherCharges', 
									'id'=>'totalOtherCharges',
									'disabled'=>'disabled',
									'class'=>'span18');
								echo form_input($data, set_value('totalOtherCharges')); ?>
                  </div>
                  </div>
                    <div class="controls-row">
                    	<div class="span4"><?php echo form_label($this->lang->line('outOfBalance'),'outOfBalance');?></div>
                   	<div class="span6">
                            	<?php 								
								$data = array(
									'name'=>'outOfBalance', 
									'id'=>'outOfBalance',
									'disabled'=>'disabled',
									'class'=>'span18');
								echo form_input($data, set_value('outOfBalance')); ?>
                  </div>
                  </div>
          </div><!-- content-->
        </div><!-- grid block 5-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
</div><!-- grid 1 -->
</div><!-- wrap -->
</div><!-- content -->

