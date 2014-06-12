<script type="application/javascript">
$(document).ready(function() {
	$('select').select2();
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
});
function selectshipto(obj){
		var customerID = obj.value;
//		alert(year);
			postData = {
				customerID : customerID
			};
			$.ajax({
  				type: "POST",
	  			dataType: "json",
				url: "<?php echo base_url()?>sotransaction/shipto",
				data: postData,
	  			async: false,
  				success: function(content){
					if(content.status == "success") {
					var items = [];
					//items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].ID+'">'
						+ content.message[i].addressCode + ' [ ' +content.message[i].addressName + ' ]</option>');
					}  //end for
					jQuery("#deliveryToID").empty();
					jQuery("#deliveryToID").append(items.join('</br>'));
					$('#currencyID').val(content.message1.currencyID).change();
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				} //end if
			} //end success
				
			}); //end ajax

}
function addRow(){
var rowCount = document.getElementById('oTable').rows.length - 1 ;
var rowArrayId = rowCount ;
var toBeAdded = 1;
if (toBeAdded=='')
    { toBeAdded = 2; }	
else if(toBeAdded>100)
{
  toBeAdded = 100;
}
  for (var i = 1; i <= toBeAdded; i++) {
    var rowToInsert = '';
    rowToInsert = "<td class='span2'><select id='itemID' style='width: 200px;' onChange='selectDesc(this)'></select></td>";
    rowToInsertUM = "<td class='span1'><select id='unitOfMeasureID' class='input-mini' ></select></td>";
	rowDaterequired = "<td class='span1 tar'><input type='text' name='requiredDate' class='input-mini datepicker2' value='<?php echo date("d-m-Y")?>'/></td>";
    $("#oTable tbody").append(
		"<tr><td style='display:none'></td><td>"+ (parseInt(rowArrayId) + 1) +"</td>" +
		rowToInsert +
        "<td class='span5'><input type='text' name='description' class='span12 description'/>"+
        rowDaterequired +
        rowToInsertUM +
        "<td class='span1 tar'><input type='text' name='unitprice' class='span12 validate[custom[integer]] tar' onBlur='calculate_amount(this)'/></td>"+
        "<td class='span1 tar'><input type='text' name='qtyOrd' class='span12 validate[custom[integer]] tar' onBlur='calculate_amount(this)' value='0' /></td>"+
        "<td class='span1 tar'><input type='text' name='totalAmount' class='span12 validate[custom[integer]] tar' disabled/></td>"+
        "<td class='tac'><button class='btn btn-mini btn-danger remove' title='<?php echo $this->lang->line('cancel') ?>'><span class='icon-remove-circle'></button>" + 
		"<button class='btn btn-mini btn-primary' title='<?php echo $this->lang->line('save') ?>' onClick='saveDetails(this)'><span class='icon-ok-circle'></button></td>"+
        "</tr>");

//	$('select').select2();
	rowArrayId = rowArrayId + 1;
  }
  selectoption(toBeAdded);
  selectUnitmeasure();
	$('select').select2({
		placeholder: 'Please',
	});
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	$("#addLine").hide(); 
	$("#mysubmit").show(); 
//	$("#savedetails").show(); 
}

function selectoption(toBeAdded){
//	var numrows = $("#numberofrows").val();
//	var tablerows = $("#oTable > tbody >tr").length;
//	var startrows = parseInt($("#oTable > tbody >tr").length) - numrows;
		$.ajax({
			type: "POST",
        	url: '<?php echo base_url();?>sotransaction/itemSearch',
			dataType:"json",
			success: function(content){
				if(content.status == "success") {
					var items = [];
					items.push('<option value=""><?php echo $this->lang->line('pleaseselect')?></option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].ID+'">'
						+ content.message[i].itemCode + ' [ '+ content.message[i].name + ' ]</option>');
					}
//					for (var x = startrows; x < tablerows ; x++) {
 						var rowId = "#itemID";
						jQuery(rowId).empty();
						jQuery(rowId).append(items.join('</br>'));
//					}
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				}
					return false;
			}
		});
}
function selectUnitmeasure(){
		$.ajax({
			type: "POST",
        	url: '<?php echo base_url();?>sotransaction/umSearch',
			dataType:"json",
			success: function(content){
				if(content.status == "success") {
					var items = [];
//					items.push('<option value=""><?php echo $this->lang->line('pleaseselect')?></option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].fldid+'">'
//						+ content.message[i].code + ' [ '+ content.message[i].desc + ' ]</option>');
						+ content.message[i].code + '</option>');
					}
//					for (var x = startrows; x < tablerows ; x++) {
 						var rowId = "#unitOfMeasureID";
						jQuery(rowId).empty();
						jQuery(rowId).append(items.join('</br>'));
//					}
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				}
					return false;
			}
		});
}
function selectDesc(obj){
    var eRow   = $(this).parents('tr');
	var ID = obj.value;
	postData = {
		ID : ID
	};
	
		$.ajax({
			type: "POST",
        	url: '<?php echo base_url();?>sotransaction/itemSearch2',
			dataType:"json",
			data: postData,
	  				async: false,
			success: function(content){
				if(content.status == "success") {
					$('td:eq(3)', $(obj).parents('tr')).find("input").val(content.message.description);
  					$('#unitOfMeasureID').val(content.message.unitOfMeasureID).change();
				}
			}
		});
}
function saveDetails(obj){
    var eRow   = $(this).parents('tr');
	var customerID = $("#customerID option:selected").val();
	if(customerID == 0){
		alert("<?php echo $this->lang->line('msj_custID')?>");
		$('#customerID').focus();
		return;
	}else{
		var itemID = $('td:eq(2) option:selected', $(obj).parents('tr')).val();
		if(itemID == 0){
			alert("<?php echo $this->lang->line('msj_itemID')?>");
			$('td:eq(2)', $(obj).parents('tr')).focus();
			return;
		}else{
			var totalAmount = $('td:eq(8)', $(obj).parents('tr')).find("input").val();
			if(totalAmount == 0){
				alert("<?php echo $this->lang->line('msj_totalamount')?>");
				$('td:eq(6)', $(obj).parents('tr')).focus();
				return;
			}else if(totalAmount == ''){
				alert("<?php echo $this->lang->line('msj_totalamount')?>");
				$('td:eq(6)', $(obj).parents('tr')).focus();
				return;
			}else{
				var OrderNo = $("#OrderNo").val();
				var ID = $("#ID").val();
				var effdate = $("#effdate").val();
				var exchangeRate = $("#exchangeRate").val();
				var currencyID = $("#currencyID option:selected").val();
				var deliveryToID = $("#deliveryToID option:selected").val();
				var description = $('td:eq(3)', $(obj).parents('tr')).find("input").val();
				var requiredDate = $('td:eq(4)', $(obj).parents('tr')).find("input").val();
				var unitmeasure = $('td:eq(5) option:selected', $(obj).parents('tr')).val();
				var unitPrice = $('td:eq(6)', $(obj).parents('tr')).find("input").val();
				var ordQty = $('td:eq(7)', $(obj).parents('tr')).find("input").val();
//				alert('2');
				postData = {
					customerID : customerID,
					ID : ID,
					currencyID : currencyID,
					effdate : effdate,
					deliveryToID : deliveryToID,
					exchangeRate : exchangeRate,
					itemID : itemID,
					totalAmount : totalAmount,
					OrderNo : OrderNo,
					description : description,
					unitmeasure : unitmeasure,
					unitPrice : unitPrice,
					ordQty : ordQty,
					requiredDate : requiredDate
				};
/*				$.ajax({
					type: "POST",
        			url: '<?php echo base_url();?>sotransaction/sodetails_save',
					dataType:"json",
					data: postData,
	  				async: false,
					success: function(content){
						if(content.status == "success") {
  							$('#ID').val(content.message);
						}
					}
				});
				
*/			}
			refreshEdit();
		}
	}
}
function calculate_amount(obj){
	var totalAmount = parseFloat($('td:eq(6)', $(obj).parents('tr')).find("input").val()) * parseFloat($('td:eq(7)', $(obj).parents('tr')).find("input").val());
	$('td:eq(8)', $(obj).parents('tr')).find("input").val(totalAmount.toFixed(2));
}

function refreshEdit(){
	var ID = $('#ID').val();
	var urls = "<?php echo base_url();?>sotransaction/salesOrder/"+ID;
		window.location = urls;
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
                <li><a href='<?php echo base_url()."so/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
			<div class="controls-row"> <!-- row 1 -->
            	<div class="span3"><?php echo $this->lang->line('customer') ?></div>
              	<div class="span9">
					<?php
							$preselcust = '';
							$options[] = $this->lang->line('pleaseselect');
							foreach($customers as $row){
								$options[$row->ID] = $row->customerName.' [ '.$row->accountCode.' ]';
							}
							$js='class="span8" onChange="selectshipto(this)" id="customerID"';
							echo form_dropdown('customerID', $options, $preselcust, $js);
						?>       
                	<div class="btn-group">
						<button class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown">
                		<span class="i-arrow-down-2"></span>
                		</button>
						<ul class="dropdown-menu">
      					<!-- dropdown menu links -->
      						<li><a target="_blank" href="<?php echo base_url() ?>CustomerSetup/CustomerNew"  id="btnNewCustomer">
                    			<i class="icon-plus-sign"></i> <?php echo $this->lang->line('addNewCustomer')?></a></li>
                                <li><a href="#" onclick="refreshSupplier()" id="btnNewSupplier"><i class="icon-refresh"></i> <?php echo $this->lang->line('refreshlist')?></a></li>
						</ul>
         			</div><!-- btn group -->
            	</div>                
         	</div><!-- End Row 1 -->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span3"><?php echo form_label($this->lang->line('orderNo'),'OrderNo');?></div>
                   		<div class="span9">
                            	<?php 								
								$data = array(
									'name'=>'OrderNo', 
									'id'=>'OrderNo', 
									'class'=>'input-medium validate[required,maxSize[32]]',); 
								echo form_input($data); ?>
                            	<?php 								
								$data = array(
									'name'=>'ID', 
									'id'=>'ID', 
									'type'=>'hidden',); 
								echo form_input($data); ?>
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
          </div><!--content -->
        </div><!--grid_block_1 -->
      </div><!--span6 scCol -->
	  <div class="span6 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
			<div class="controls-row"> <!-- row 1 -->
            	<div class="span3"><?php echo $this->lang->line('shipto') ?></div>
              	<div class="span9">
					<?php
							$preselshipto = '';
							$options ='';
							$options[] = $this->lang->line('pleaseselect');
							$js='class="span8" id="deliveryToID"';
							echo form_dropdown('deliveryToID', $options, $preselshipto, $js);
						?>       
            	</div>                
         	</div><!-- End Row 1 -->
			<div class="controls-row"> <!-- row 1 -->
            	<div class="span3"><?php echo $this->lang->line('currency') ?></div>
              	<div class="span9">
					<?php
							$preselcurrency = '';
							$options[] = $this->lang->line('pleaseselect');
							foreach($currency as $row){
								$options[$row->fldid] = $row->fldcurr_code.' [ '.$row->fldcurr_desc.' ]';
							}
							$js='class="span8" id="currencyID" disabled';
							echo form_dropdown('currencyID', $options, $preselcurrency, $js);
						?>       
            	</div>                
         	</div><!-- End Row 1 -->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span3"><?php echo form_label($this->lang->line('exchangerate'),'exchangeRate');?></div>
                   		<div class="span9">
                            	<?php 								
								$data = array(
									'name'=>'exchangeRate', 
									'id'=>'exchangeRate', 
									'class'=>'input-medium tar',); 
								echo form_input($data, number_format(1,2)); ?>
                  		</div>
                 	</div><!-- End Row 4-->
          </div><!--content -->
        </div><!--grid_block_2 -->
      </div><!--span6 scCol -->
    </div><!--row-fluid scRow -->
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_3">
	       <div class="head">
           	<h2><?php echo $this->lang->line('orderdetails')?></h2>
           	<div class="buttons">
            	<li><button class="btn btn-primary" onClick="addRow()" id="addLine"><span class="i-plus"></span><?php echo $this->lang->line('addnewline')?></button></li>
          	</div>                                        
          </div><!-- head -->
          <div class="content np">
   			<table id="oTable" cellpadding="0" cellspacing="0" width="100%">
         		<thead>
             	<tr>
            		<th>#</th>
            		<th><?php echo $this->lang->line('itemCode')?></th>
            		<th><?php echo $this->lang->line('description')?></th>
            		<th><?php echo $this->lang->line('daterequired')?></th>
            		<th><?php echo $this->lang->line('um')?></th>
            		<th class="tar"><?php echo $this->lang->line('unitPrice')?></th>
            		<th class="tar"><?php echo $this->lang->line('qtyOrd')?></th>
            		<th class="tar"><?php echo $this->lang->line('amount')?></th>
            		<th class="tac"><?php echo $this->lang->line('action')?></th>
              	</tr>
        		</thead>
                <tbody>
                </tbody>
     		</table>
          </div><!--content -->
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                    </div>
                </div>
            </div>                                    
        </div><!--grid_block_3 -->
      </div><!--span6 scCol -->
    </div><!--row-fluid scRow -->
</div><!--grid_content_1 -->
</div><!--wrap -->
</div><!--content -->
