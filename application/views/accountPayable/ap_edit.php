<style type="text/css">
.input-prepend span, input-prepend button{
	height:18px;
	padding:3px;
	}
#content .wrap #grid_content_1 .row-fluid.scRow .row-fluid.scRow .span12.scCol #grid_block_5 .content.np #listDetails tbody #trInfos td .row-fluid .controls-row .span3 {
	font-size: 11px;
	color: #000;
	font-weight: bold;
}
.test {
	font-size: 10px;
}
.span3 {
	font-size: 10px;
}
tbody td {
	font-size:11px;
	}
#content .wrap #grid_content_1 .row-fluid.scRow .row-fluid.scRow .span12.scCol #grid_block_6 .content.np #listCharge tbody #trInfosCharge td .row-fluid .controls-row .span3 {
	font-weight: bold;
}
</style>

<script>
			
			  function getItemDetails(me){
					$("#itemname").val("");
					$("#itemdes").val("");
					$.ajax({
						type: "POST",
						data: "code="+ me.value,
						url: "<?php echo base_url() ?>purchaseInvoice/getItemDetails",
						success: function(data) {
							if(data!="item Not found"){
								 var resul = eval ("(" + data + ")");
								$("#itemname").val(resul.description);
								$("#itemdes").val(resul.name);
								$("#itemTax").val(resul.tax);
								$("#itemTax").attr("data-taxid",resul.taxID);
								$("#displayTaxCode").text(resul.taxcode); 
							}else{
								$("#itemdes").attr("placeholder",data);
								$("#itemname").attr("placeholder",data);
								$("#itemTax").val("");
								$("#itemTaxAmount").val("");
								$("#itemAmountIT").val("");
								$("#itemTax").attr("data-taxid",""); 
								$("#displayTaxCode").html("");
								}
						}
   					 });
				}
				
              function editRow(me){
				//  alert( $(me).parent().parent().find("td").eq(0).html()); 
				   $(''+ 
					 '<tr>' +
					 	'<td class="span1"><input id="itemcode" name="itemcode" onkeyup="getItemDetails(this);" onchange="getItemDetails(this);" data-source="<?php echo $itemCodes; ?>" data-items="4" data-provide="typeahead"  class="span12" type="text" data-previewvalue="' + $(me).parent().parent().find("td").eq(0).html() + '" value="' + $(me).parent().parent().find("td").eq(0).html() + '"></td>' +
						'<td class="span1"><input id="itemname" name="itemname" class="span12" type="text" data-previewvalue="' + $(me).parent().parent().find("td").eq(1).html() + '" value="' + $(me).parent().parent().find("td").eq(1).html() + '"></td>'+
                        '<td class="span2"><input id="itemdes" name="itemdes" class="span12" type="text" data-previewvalue="' + $(me).parent().parent().find("td").eq(2).html() + '" value="' + $(me).parent().parent().find("td").eq(2).html() + '"></td>'+
                        '<td class="span1"><input  id="itemunitprice" onkeyup="calculamount()" onchange="calculamount()" name="itemunitprice" class="span12" type="text" data-previewvalue="' + $(me).parent().parent().find("td").eq(3).html() + '" value="' + $(me).parent().parent().find("td").eq(3).html() + '"></td>'+
                        '<td class="span1"><input id="itemqte"  onkeyup="calculamount()" onchange="calculamount()" name="itemqte"  class="span12" type="text" data-previewvalue="' + $(me).parent().parent().find("td").eq(4).html() + '" value="' + $(me).parent().parent().find("td").eq(4).html() + '"></td>'+
                        '<td class="span1"> <input id="itemAmountET" name="itemAmountET" class="span12" type="text" data-previewvalue="' + $(me).parent().parent().find("td").eq(5).html() + '" value="' + $(me).parent().parent().find("td").eq(5).html() + '"></td>'+
                        '<td class="span1"><div  class="span12 input-prepend"><input data-previewvalue= "' + $(me).attr("data-taxcode") + ' | ' + $(me).attr("data-taxrate") + '"  value="' + $(me).attr("data-taxrate") + '" data-taxid="' + $(me).attr("data-taxid") + '" id="itemTax" onkeyup="calculamount()" onblur="calculamount()" name="itemTax" class="input-mini validate[required, custom[number]]" type="text" placeholder="Tax(%)"><span id="displayTaxCode" style="margin-top:0;" onclick="taxPopup ()"  class="btn add-on">' + $(me).attr("data-taxcode") +'</span></div></td>'+
                        '<td class="span1"><input onkeyup="calculamount()" onchange="calculamount()" id="itemTaxAmount" name="itemTaxAmount" class="span12" type="text" data-previewvalue="' + $(me).parent().parent().find("td").eq(7).html() + '" value="' + $(me).parent().parent().find("td").eq(7).html() + '"></td>'+
                        '<td class="span1"><input onkeyup="calculamount()" onchange="calculamount()" id="itemAmountIT" name="itemAmountIT" class="span12" type="text" data-previewvalue="' + $(me).parent().parent().find("td").eq(8).html() + '" value="' + $(me).parent().parent().find("td").eq(8).html() + '"></td>'+
                        '<td class="span1">'+
						'<button onclick="updateRow(this)"  data-taxid="' + $(me).attr("data-taxid") + '" data-myid="' + $(me).attr("data-myid") +'" data-taxcode="' + $(me).attr("data-taxcode") + '" data-taxrate="' + $(me).attr("data-taxrate") +'" class="btn btn-mini btn-primary" type="button">Update</button>'+
						'<button  id="btnCancel" data-taxcode="' + $(me).attr("data-taxcode") + '" data-taxrate="' + $(me).attr("data-taxrate") +'" onclick="cancelEdit(this)" data-taxid="' + $(me).attr("data-taxid") + '" data-myid="' + $(me).attr("data-myid") +'"  class="btn btn-mini" type="button">Cancel</button></td>'+
                    '</tr>'
					  ).insertBefore( "#trInfos" );
					  delRowInvoice(me);
				  }
				  
				  function calculamount(){
					
					if ($("#itemTax").attr("data-taxid")=="") {
						taxPopup ();
					}
					var j_itemAmountET =$("#itemunitprice").val()*$("#itemqte").val();
					$("#itemAmountET").val(j_itemAmountET);
					
					var j_itemTaxAmount=j_itemAmountET*$("#itemTax").val()/100;
					$("#itemTaxAmount").val(j_itemTaxAmount);
					$("#itemAmountIT").val(j_itemTaxAmount+j_itemAmountET);
					
				}
				
			function calculChargeAmount() { 
			  var t = $("#chargeAmount").val() * $("#listTax option:selected").attr("data-tax") /100;
			  $("#chargetaxAmount").val(t);
			  $("#chargeAmountIT").val(t+  $("#chargeAmount").val()*1);
		  }

				   function EndEdit(me){
					 
					 var dID = $(me).attr("data-itemId");
					 	 $(''+
					 '<tr>' +
						'<td>' +  $("#itemcode").val() + '</td>'+
                        '<td>' + $("#itemname").val() + '</td>'+
                        '<td>' + $("#itemdes").val() + '</td>'+
                        '<td>' + $("#itemunitprice").val() + '</td>'+
                        '<td>' + $("#itemqte").val() + '</td>'+
                        '<td>' + $("#itemAmountET").val() + '</td>'+
                        '<td>' + $("#itemTax").val() + '</td>'+
                        '<td>' + $("#itemTaxAmount").val() + '</td>'+
                        '<td>' + $("#itemAmountIT").val() + '</td>'+
                         '<td>'+
						'<button data-taxcode="' + $(me).attr("data-taxcode") + '" data-taxrate="' + $(me).attr("data-taxrate") +'"  onClick="editRow(this)" data-taxid="' + $(me).attr("data-taxid") + '" data-myid="' + $(me).attr("data-myid") +'" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
                         ' <button my-id="' + dID + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfos" );
					  delRowInvoice(me);
					   getTotal ();
					 }
					 
				  function cancelEdit(me){
					 
					 var dID = $(me).attr("data-itemId");
					 	 $(''+
					 '<tr>' +
						'<td>' +  $("#itemcode").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemname").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemdes").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemunitprice").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemqte").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemAmountET").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemTax").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemTaxAmount").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemAmountIT").attr("data-previewvalue") + '</td>'+
                        '<td>'+
						'<button data-taxcode="' + $(me).attr("data-taxcode") + '" data-taxrate="' + $(me).attr("data-taxrate") +'"  onClick="editRow(this)" data-taxid="' + $(me).attr("data-taxid") + '" data-myid="' + $(me).attr("data-myid") +'" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
                         ' <button my-id="' + dID + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfos" );
					  delRowInvoice(me);
					   getTotal ();
					 }
					 
				function getTotal (){
					
						 var n =$("#listDetails > tbody > tr").length - 2;
						 var totalAmount =0;
						 var impot = 0;
						 var total = 0;
						 var i = 0;
						 for (i=0; i<=n; i++) {
							 
								totalAmount= totalAmount + $('#listDetails > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
								impot= impot + $('#listDetails > tbody > tr:eq(' + i + ') > td:eq(7)').text() *1; 
								total= total + $('#listDetails > tbody > tr:eq(' + i + ') > td:eq(8)').text()*1; 
								
						 }
					
						
						  n =$("#listCharge > tbody > tr").length - 2;
						
						 var totalAmountC =0;
						 var impotC = 0;
						 var totalC = 0;
						 i = 0;
						 for (i=0; i<=n; i++) {
								totalAmountC= totalAmountC + $('#listCharge > tbody > tr:eq(' + i + ') > td:eq(2)').text()*1; 
								impotC= impotC + $('#listCharge > tbody > tr:eq(' + i + ') > td:eq(4)').text() *1; 
								totalC= totalC + $('#listCharge > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
								
						 }
						 
						 $("#totalamount").val(totalAmount + totalAmountC);
					
						$("#impotpayable").val(impot + impotC);
					
						$("#totalpayable").val(total + totalC);
					}
	     
		 function updateRow(me){
			// alert($(me).attr("data-myid"));
		 	$.ajax({
				type: "POST",
				data: {
					  invDetailsId :$(me).attr("data-myid"),
					  itemCode:  $("#itemcode").val(),
					  itemname : $("#itemname").val(), 
					  itemdescription: $("#itemdes").val(),
					  quantity : $("#itemqte").val(),
					  unitPrice: $("#itemunitprice").val(),
					  amountExcludedTax: $("#itemAmountET").val(),
					  taxID :  $("#itemTax").attr("data-taxid"),
					  taxRate: $("#itemTax").val(),
					  taxAmount: $("#itemTaxAmount").val(),
					  amountIncludedTax:$("#itemAmountIT").val()
					  
					},
				url: "<?php echo base_url() ?>purchaseInvoice/updateRowDetail",
					success: function(data) {
				       msg (1,"alert alert-success","Details successfully updated");
					   EndEdit(me);
					} });
					 getTotal();
					$.ajax({
					  type: "POST",
					  data: {
							invoiceId : $("#purchaseInvoiceId").val(),
							totalPayable : $("#totalpayable").val(), 
							totalTaxAmount :  $("#totalamount").val()
						  },
					  url: "<?php echo base_url() ?>purchaseInvoice/updateInvoice",
					  success: function(data) {
						   //update the invoice after delete
						  }
					  });
		}
		 
			  function delRowInvoice(me){
				  var td=me.parentNode;
				  var tr=td.parentNode;
				  var tBody=tr.parentNode;
				  tBody.removeChild(tr);
				  getTotal ();
			  }
			  
			  function msg(n,type, message){
	$("#msg_div" + n +" p").html(message);
	$("#msg_div").attr("class","alert " + type);
}
			  
			  function deleteCompanyDetails(me){
				  
				  $('#popupModal').modal('show');
					$("#_popupTitle").html("Confirm delete");
					$("#_popupContent").html("Your about to delete definively this row. <br/> Click on ok to confirm");
					
					$('#_popupFooter').empty();
	            	   $('#_popupFooter').append('<button class="btn btn-danger" id="detButton">Ok</button>' +
					'<button class="btn" id="canb">Cancel</button>');
					$("#_popupTitle").html("Confirm delete");
					$( "#canb" ).click(function() {
						$('#popupModal').modal('hide');
					});
					$( "#detButton" ).click(function() {
						$('#popupModal').modal('hide');
						$.ajax({
				type: "POST",
				data: {
					  invDetailsId :$(me).attr("data-myid")					  
					},
				url: "<?php echo base_url() ?>purchaseInvoice/deleteCompanyDetails",
					success: function(data) {
				       msg (1,"alert alert-success","Details successfully deleted");
					    delRowInvoice(me);
					} });
					 getTotal();
					$.ajax({
					  type: "POST",
					  data: {
							invoiceId : $("#purchaseInvoiceId").val(),
							totalPayable : $("#totalpayable").val(), 
							totalTaxAmount :  $("#totalamount").val()
						  },
					  url: "<?php echo base_url() ?>purchaseInvoice/updateInvoice",
					  success: function(data) {
						   //update the invoice after delete
						  }
					  });
					});
				  
				  
				  
				  }
				  
				  function editRowCharge (me){
						  if (!$("#chargeAccount").length) {
					 $(''+
					 '<tr>' +
							'<td class="span2" ><select data-previewvalue="' + $(me).parent().parent().find("td").eq(0).html() + '" name="chargeAccount" id="chargeAccount" class= "span12 validate[required]"><option></option>' +
									 <?php
				if($chargeAccount){
				 foreach($chargeAccount as $row){
					 ?>
                     '<option  value="<?php echo $row->ID; ?>"><?php echo $row->acctCode." | "; echo str_replace("'", " ",$row->acctName, $count); ?></option>'+
			    <?php }} ?>
							 '</select></td>'+
													'<td class="span4"><input data-previewvalue="' + $(me).parent().parent().find("td").eq(1).html() + '"  id="chargedesc" name="chargedesc"  type="text" class="span12 validate[required]" placeholder="Description" value="' + $(me).parent().parent().find("td").eq(1).html() + '"></td>'+
													'<td class="span1"><input data-previewvalue="' + $(me).parent().parent().find("td").eq(2).html() + '" class="span12" id="chargeAmount" onchange="calculChargeAmount()" name="chargeAmount" value="' + $(me).parent().parent().find("td").eq(2).html() + '" class="input-mini validate[required, custom[number]]" type="text" placeholder="Amount"></td>'+
													'<td class="span2"><select data-previewvalue="' + $(me).parent().parent().find("td").eq(3).html() + '" onclick="calculChargeAmount()" name="listTax" id="listTax"  class= "span12 validate[required]"><option></option>' +
									 <?php if($taxmaster){
					 foreach($taxmaster as $row2){
					 ?>
                     '<option value="<?php echo $row2->ID; ?>" data-tax="' + <?php echo $row2->taxPercentage; ?> + '">' + 
					 '<?php echo $row2->code." | ".$row2->taxPercentage." | "; echo str_replace("'", " ",$row2->name, $count); ?></option>'+
			    <?php }} ?>
							 '</select></td>'+
										'<td class="span1"> <input data-previewvalue="' + $(me).parent().parent().find("td").eq(4).html() + '" id="chargetaxAmount" value="' + $(me).parent().parent().find("td").eq(4).html() + '"  name="chargetaxAmount" class="span12" type="text" placeholder="Amount"></td>'+
													'<td class="span1"><input data-previewvalue="' + $(me).parent().parent().find("td").eq(5).html() + '" onkeydown="return false;" id="chargeAmountIT" value="' + $(me).parent().parent().find("td").eq(5).html() + '"name="chargeAmountIT" class="span12" type="text" placeholder="Amount (Exclude Tax)"></td>'+
						'<td class="span1">'+
						 	'<button data-myid="' + $(me).attr("data-myid") + '" data-accid="' + $(me).attr("data-accid") + '" data-taxid="' + $(me).attr("data-taxid") + '" onclick = "saveCharge(this)" class="btn btn-mini btn-primary" type="button">Update</button>'+
						 	'<button data-myid="' + $(me).attr("data-myid") + '" data-accid="' + $(me).attr("data-accid") + '" data-taxid="' + $(me).attr("data-taxid") + '" onclick="delCancelEditCharge(this)" id="btnCancelCharge" class="btn btn-mini" type="button">Cancel</button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfosCharge" );
					
					$("#chargeAccount").val($(me).attr("data-accid"));
 					$("#listTax").val($(me).attr("data-taxid"));
					delRowInvoice(me);
					}else{
						msg (2,"alert","Please, do save the current details before addind new one");
						}
				 }	
				 
				 function delCancelEditCharge (me){
					 $("#chargeAccount").val($(me).attr("data-accid"));
 					$("#listTax").val($(me).attr("data-taxid"));
					 	 $(''+
					 '<tr>' +
						'<td>' +  $("#chargeAccount").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#chargedesc").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#chargeAmount").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#listTax").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#chargetaxAmount").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#chargeAmountIT").attr("data-previewvalue") + '</td>'+
                        '<td>'+
						'<button onClick="editRowCharge(this)" data-myid="' + $(me).attr("data-myid") + '" data-accid="' + $(me).attr("data-accid") + '" data-taxid="' + $(me).attr("data-taxid") + '" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
                         ' <button data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfosCharge" );
					  delRowInvoice(me); 
					 }	
					 
					 
					 function saveCharge(me) {
						 $.ajax({
							  type: "POST",
							  data: {
								    chargeId : $(me).attr("data-myid"),
									accountNoID : $("#chargeAccount").val(),
									itemdescription : $("#chargedesc").val(), 
									amountExcludedTax :  $("#chargeAmount").val(),
									taxID : $("#listTax").val(),
									taxAmount : $("#chargetaxAmount").val(),
									amountIncludedTax : $("#chargeAmountIT").val()
									
								  },
							  url: "<?php echo base_url() ?>purchaseInvoice/updateCharge",
								  success: function(data) {
									 msg (2,"alert alert-success","Details successfully updated");
									  $(''+
										 '<tr>' +
											'<td>' +  $("#chargeAccount option:selected").text() + '</td>'+
											'<td>' + $("#chargedesc").val() + '</td>'+
											'<td>' + $("#chargeAmount").val() + '</td>'+
											'<td>' + $("#listTax option:selected").text() + '</td>'+
											'<td>' + $("#chargetaxAmount").val() + '</td>'+
											'<td>' + $("#chargeAmountIT").val() + '</td>'+
											'<td>'+
											'<button onClick="editRowCharge(this)" data-myid="' + $(me).attr("data-myid") + '" data-accid="' + $("#chargeAccount").val() + '" data-taxid="' + $("#listTax").val() + '" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
											 '<button data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i</button>'+
											'</td>'+
										'</tr>'
										  ).insertBefore( "#trInfosCharge" );
					 						 delRowInvoice(me); 
									   getTotal();
									  $.ajax({
										type: "POST",
										data: {
											  invoiceId : $("#purchaseInvoiceId").val(),
											  totalPayable : $("#totalpayable").val(), 
											  totalTaxAmount :  $("#totalamount").val()
											},
										url: "<?php echo base_url() ?>purchaseInvoice/updateInvoice",
										success: function(data) {
											 //update the invoice after delete
											}
										});
										  } });
								 
					}
					
				function  deleteCompanyCharge(me){
							$('#popupModal').modal('show');
						  $("#_popupTitle").html("Confirm delete");
						  $("#_popupContent").html("Your about to delete definively this row. <br/> Click on ok to confirm");
						  
						  $('#_popupFooter').empty();
							 $('#_popupFooter').append('<button class="btn btn-danger" id="detButton">Ok</button>' +
						  '<button class="btn" id="canb">Cancel</button>');
						  $("#_popupTitle").html("Confirm delete");
						  $( "#canb" ).click(function() {
							  $('#popupModal').modal('hide');
						  });
						  $( "#detButton" ).click(function() {
							  $('#popupModal').modal('hide');
							  $.ajax({
					  type: "POST",
					  data: {
							chargeID :$(me).attr("data-myid")					  
						  },
					  url: "<?php echo base_url() ?>purchaseInvoice/deleteCharge",
						  success: function(data) {
							 msg (1,"alert alert-success","Details successfully deleted");
							  delRowInvoice(me);
							  getTotal();
							  $.ajax({
								type: "POST",
								data: {
									  invoiceId : $("#purchaseInvoiceId").val(),
									  totalPayable : $("#totalpayable").val(), 
									  totalTaxAmount :  $("#totalamount").val()
									},
								url: "<?php echo base_url() ?>purchaseInvoice/updateInvoice",
								success: function(data) {
									 //update the invoice after delete
									}
								});
						  } });
						 
						  });
				  			 getTotal ();
					}
					
					
					
					function taxPopup () {
	$('#popupModal').modal('show');
	$("#_popupTitle").html("Purchase Invoice");
	$("#_popupContent").html('' +
	  '<label>Select a tax</label>' +
	  '<select onclick="calculChargeAmount()" name="listTaxPopup" id="listTaxPopup"  class= "validate[required]"><option></option>' +
									 <?php if($taxmaster){
					 foreach($taxmaster as $row2){
					 ?>
                     '<option data-taxcode="<?php echo $row2->code ?>" value="<?php echo $row2->ID; ?>" data-tax="' + <?php echo $row2->taxPercentage; ?> + '">' + 
					 '<?php echo $row2->code." | ".$row2->taxPercentage." | "; echo str_replace("'", " ",$row2->name, $count); ?></option>'+
			    <?php }} ?>
							 '</select>');
	
	$('#_popupFooter').empty();
	   $('#_popupFooter').append('<button class="btn btn-primary" id="confButton">Ok</button>' +
	'<button class="btn" id="canb">Cancel</button>');
	$("#_popupTitle").html("Tax Master");
	$( "#canb" ).click(function() {
		$('#popupModal').modal('hide');
	});
	$( "#confButton" ).click(function() {
		$('#popupModal').modal('hide');
		 $("#itemTax").attr("data-taxid",$("#listTaxPopup").val() );
		 $("#itemTax").val ($("#listTaxPopup option:selected").attr("data-tax"));
		 $("#displayTaxCode").html($("#listTaxPopup option:selected").attr("data-taxcode"));
	});
	
	$( "#calcul" ).trigger( "click" );
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
 <?php
   if ($pInvoice){	 
	 foreach($pInvoice as $rowIn){
	?> 
    <input type="hidden" id="purchaseInvoiceId" value="<?php echo $rowIn->InvID; ?>" />
	<div class="row-fluid scRow">                            
	  <div class="span4 scCol">
		<div class="block" id="grid_block_1">
          <div class="content">
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('supplier'); ?></div>
         	<div class="span8">
               <span class="uneditable-input input-medium"><?php echo $rowIn->supplierName; ?></span>
         	</div>
         </div> <!-- row -->
         <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('formNo') ?></div>
         	<div class="span8">
               <span class="uneditable-input input-medium"><?php echo $rowIn->formNo; ?></span>
         	</div>
         </div> <!-- row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('date') ?></div>
         	<div class="span8">
               <span class="uneditable-input input-medium"><?php echo $rowIn->invoiceDate; ?></span>
         	</div>
         </div> <!-- row -->
         <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('supplierInvoiceNo') ?></div>
         	<div class="span8">
               <span class="uneditable-input input-medium"><?php echo $rowIn->project_name; ?></span>
         	</div>
         </div> <!-- row -->
         <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('project') ?></div>
         	<div class="span8">
               <span class="uneditable-input input-medium"><?php echo $rowIn->supplierInvoiceNo; ?></span>
         	</div>
         </div> <!-- row -->
        </div><!-- content -->
       </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
          	<div class="controls-row">
         	 <div class="span3"><?php echo $this->lang->line('location') ?></div>
         	   <div class="span8">
                <textarea class="input-medium" disabled="disabled" id="termDescription" style="height: 64px; width: 157px;"><?php echo $rowIn->code." | ".$rowIn->address ; ?></textarea>
         	</div>
           </div> <!-- row -->
           
           <div class="controls-row">
         	 <div class="span3"><?php echo $this->lang->line('terms') ?></div>
         	   <div class="span8">
                <span class="uneditable-input input-medium"><?php  echo $rowIn->termName; ?></span>
         	</div>
           </div> <!-- row -->
           
            <div class="controls-row">
         		<div class="span3"><?php echo $this->lang->line('termsdesc') ?></div>
         		<div class="span8">
               		 <textarea class="input-medium" disabled="disabled" id="termDescription" style="height: 113px; width: 153px;">
                <?php echo $rowIn->termDescription ?>
                </textarea>
         		</div>
            </div> <!-- row -->
          </div><!-- content -->
          
        </div><!-- grid block 1-->
      </div><!-- scCol -->
      <div class="span4 scCol">
		<div class="block" id="grid_block_3">
          <div class="content">
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('shipto') ?></div>
         	<div class="span8">
                   <textarea style="width: 160px; height: 123px;" disabled="disabled">
                        <?php  echo $rowIn->addressName; ?>
                        <?php  echo $rowIn->line1; ?>
                        <?php  echo $rowIn->line2; ?>
                        <?php  echo $rowIn->line3; ?>
                  </textarea>
            </div><!-- span -->
            </div><!-- row control -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('currency') ?></div>
         	<div class="span8">
				<span class="uneditable-input input-medium"><?php  echo $rowIn->currencyWord; ?></span>            
            </div><!-- span -->
            </div><!-- control row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('exchangeRate') ?></div>
         	<div class="span8">
				<span class="uneditable-input input-medium"><?php  echo $rowIn->exchangeRate; ?></span>             
            </div><!-- span -->
            </div><!-- control row -->
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
      
    </div><!-- row-fluid scRow-->
    <?php } } ?>
    
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
	       <div class="head">
           	<h2><?php echo $this->lang->line('items') ?></h2>
           	<ul class="buttons">
            	<li><a class="block_toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                        	<span class="i-arrow-down-3"></span></a></li>
          	</ul>                                        
          </div><!-- head -->
          <div class="content np">
   				  <table id="listDetails" cellpadding="0" cellspacing="0" width="100%">
            			<thead>
                			<tr>
                       	 	<th><?php echo $this->lang->line('itemCode') ?></th>
                        	<th><?php echo $this->lang->line('itemName') ?></th>
                        	<th><?php echo $this->lang->line('itemDesc') ?></th>
                        	<th><?php echo $this->lang->line('unitPrice') ?></th>
                        	<th><?php echo $this->lang->line('quantity') ?></th>
                        	<th><?php echo $this->lang->line('amountExcludeTax') ?></th>
                        	<th><?php echo $this->lang->line('tax') ?></th>
                        	<th><?php echo $this->lang->line('taxAmount') ?></th>
                        	<th><?php echo $this->lang->line('amountIncludeTax') ?></th>
                        	<th><?php echo $this->lang->line('action') ?></th>
                    		</tr>
                		</thead>
                		<tbody>
                        	        <?php
				 $t_amountExcludedTax=0;
				 $t_taxAmount=0;
				 $t_amountIncludedTax=0;
				 if($pdetails) {
				 foreach($pdetails as $row){
					     $t_amountExcludedTax += $row->amountExcludedTax; ;
						 $t_taxAmount+= $row->taxAmount;
				 		 $t_amountIncludedTax += $row->amountIncludedTax;
					 ?>
                     <tr>
                    	<td><?php echo $row->itemCode;?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->description; ?></td>
                        <td><?php echo $row->unitPrice; ?></td>
                        <td><?php echo $row->quantity; ?></td>
                        <td><?php echo $row->amountExcludedTax; ?></td>
                        <td><?php echo $row->code." | ".$row->taxRate; ?></td>
                        <td><?php echo $row->taxAmount; ?></td>
                        <td><?php echo $row->amountIncludedTax; ?></td>
                        <td>
                         <button onClick="editRow(this)" 
                         data-taxcode="<?php echo $row->code; ?>" data-taxrate="<?php echo $row->taxRate; ?>"
                          data-taxid="<?php echo $row->taxID; ?>" data-myid="<?php echo $row->ID; ?>" class="btn btn-mini"><i class="icon-pencil"></i></button>
                         <button onClick="deleteCompanyDetails(this)" data-myid="<?php echo $row->ID; ?>" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>
                        </td>
                    </tr>
                     <?php }
					 } else {?>
                         <div class="alert alert-error">
                      <?php echo $this->lang->line('message1') ?>
    </div>
                     <?php }?>
                			<tr id="trInfos">
                	<td colspan="11">
                	    <div id="msg_div1" class="alert alert-info">
                       
                       
                        	<h4><?php echo $this->lang->line('lastMessage') ?></h4>
                        	<p style="padding-top:10px;"><?php echo $this->lang->line('noMessage') ?></p>
   						 </div>
                	</td>
                    
                </tr>
              </tbody>
            </table>     
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
	             <div class="head">
                     <h2><?php echo $this->lang->line('charge') ?></h2>
                 	<ul class="buttons">
                    	<li><a class="block_toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                        	<span class="i-arrow-down-3"></span></a></li>
                    </ul>                                        
             	 </div><!-- head -->
          <div class="content np">
   				<table id="listCharge" cellpadding="0" cellspacing="0" width="100%">
            	<thead>
                	<tr>
                        <th><?php echo $this->lang->line('account') ?></th>
                        <th><?php echo $this->lang->line('description') ?></th>
                        <th><?php echo $this->lang->line('amount') ?></th>
                        <th><?php echo $this->lang->line('tax') ?></th>
                        <th><?php echo $this->lang->line('taxAmount') ?></th>
                        <th><?php echo $this->lang->line('amountIncludeTax') ?></th>
                        <th><?php echo $this->lang->line('action') ?></th>
                    </tr>
                </thead>
                <tbody>
                                 <?php
				 $t_amountExcludedTaxC=0;
				 $t_taxAmountC=0;
				 $t_amountIncludedTaxC=0;
				 if($charge) {
				 foreach($charge as $row){
					     $t_amountExcludedTax += $row->amountExcludedTax; ;
						 $t_taxAmount+= $row->taxAmount;
				 		 $t_amountIncludedTax += $row->amountIncludedTax;
					 ?>
                     <tr>
                    	<td><?php echo $row->acctCode . ' | '. $row->acctName ;?></td>
                        <td><?php echo $row->itemdescription; ?></td>
                        <td><?php echo $row->amountExcludedTax; ?></td>
                        <td><?php echo $row->code . ' | '. $row->taxPercentage; ?></td>
                        <td><?php echo $row->taxAmount; ?></td>
                        <td><?php echo $row->amountIncludedTax; ?></td>
                       <td>
                         <button onClick="editRowCharge(this)" data-taxid="<?php echo $row->taxId?>" data-accid= "<?php echo $row->accountNoID?>" data-myid="<?php echo $row->myid; ?>" class="btn btn-mini"><i class="icon-pencil"></i></button>
                         <button onClick="deleteCompanyCharge(this)" data-myid="<?php echo $row->myid; ?>" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>
                        </td>
                    </tr>
                     <?php }
					 } else {?>
                         <div class="alert alert-error">
                     No charges found ...
    </div>
                     <?php }?>
                <tr id="trInfosCharge">
                	<td colspan="7">
                	    <div id="msg_div2" class="alert alert-info">
                       
                       
                        	<h4><?php echo $this->lang->line('lastMessage') ?></h4>
                        	<p style="padding-top:10px;"><?php echo $this->lang->line('noMessage') ?></p>
					    </div>
                	</td>
                </tr>
                </tbody>
            </table>     
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
    	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
          <div class="content np">
                      <div class="controls-row">
                      
                      <div class="span3"><?php echo $this->lang->line('totalAmount') ?></div>
                      <div class="span8">
                         <input id="totalamount" value="<?php echo $t_amountExcludedTax ?>" class="input-small" type="text" placeholder="0" disabled="disabled" >
                      </div>
                  </div><!-- row control -->
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('importDutyPayable')?></div>
                      <div class="span8">
                          <input value="<?php echo $t_taxAmount ?>" id="impotpayable" class="input-small" type="text" disabled="disabled"  placeholder="0">
                      </div>
                  </div><!-- row control -->
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('totalPayable') ?></div>
                      <div class="span8">
                          <input value="<?php echo $t_amountIncludedTax ?>" id="totalpayable" disabled="disabled"  class="input-small" type="text" placeholder="0">
                      </div>
                  </div><!-- row control -->
                  <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
           				 <!--<button id="calcul" onclick="getTotal()" class="btn btn-minii btn-warning" type="button"> 
                         <i class="icon-ok-circle"></i><?php echo $this->lang->line('calTotal') ?></button>-->
       				</div><!-- btn group -->      
       			</div><!-- side fr -->      
       		</div><!-- footer -->   
              </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
</div><!-- grid 1 -->
</div><!-- wrap -->
</div><!-- content -->
                    
                    
   