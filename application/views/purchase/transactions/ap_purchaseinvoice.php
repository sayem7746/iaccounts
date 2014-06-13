<style type="text/css">

.input-append button {
	height:30px;}
.input-append select {
	width:140px;}

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
tbody {
	font-size: 10px;
	}
#content .wrap #grid_content_1 .row-fluid.scRow .row-fluid.scRow .span12.scCol #grid_block_6 .content.np #listCharge tbody #trInfosCharge td .row-fluid .controls-row .span3 {
	font-weight: bold;
}
</style>
<script type="application/javascript">
			
//$(document).ready(function(){
//	$('select').select2();
//});


			    function loadSupplierDefaultValue(me){
					$('#currency').attr("value",'');
					$('#exchange_rate').attr("value",'');
					$.ajax({
						type: "POST",
						data: "supplier="+ $("#supplier option:selected").val(),
						url: "<?php echo base_url() ?>purchasetransaction/loadSupplierDefaultValue",
						success: function(data) {
							 var resul = eval ("(" + data + ")"); 
							$('#currency').attr("value",resul.records[0].currency);
							$('#exchange_rate').attr("value",resul.records[0].exchangeRate);
						}
   					 });
				}
				
			  	function refreshSupplier(){
					$.ajax({
						type: "POST",
						url: "<?php echo base_url() ?>purchasetransaction/refreshSupplier",
						success: function(data) {
						
						   var resul = eval ("(" + data + ")"); 
	            	       var n=resul.records.length;
	            	       var i=0;
	            	       var opt='' +
	        				'<option></option>';
	            	        for (i=0;i<n;i++)
	            	        	opt=opt + '<option value="' + resul.records[i].id + '">' + resul.records[i].supplierName + '</option>';
							$('#supplier').empty();
	            	      $('#supplier').append(opt);
						}
   					 });
					 
				}
				
				
				
				
				function getItemCode(me){
					$.ajax({
						type: "POST",
						data: "itemCode="+$(me).val(),
						url: "<?php echo base_url() ?>purchasetransaction/getItemCodes",
						success: function(data) {
						   $("#itemcode").attr("data-source", data);
						}
   					 });
				}
				
				function refreshTerms(){
					$.ajax({
						type: "POST",
						url: "<?php echo base_url() ?>purchasetransaction/refreshTerms",
						success: function(data) {
						
						   var resul = eval ("(" + data + ")"); 
	            	       var n=resul.records.length;
	            	       var i=0;
	            	       var opt='' +
	        				'<option></option>';
	            	        for (i=0;i<n;i++)
	            	        	opt=opt + '<option value="' + resul.records[i].id + '">' + resul.records[i].termName + '</option>';
							$('#term').empty();
	            	       $('#term').append(opt);
						}
   					 });
					 
				}
				
				function refreshProject(){
					$.ajax({
						type: "POST",
						url: "<?php echo base_url() ?>purchasetransaction/refreshProject",
						success: function(data) {
						
						   var resul = eval ("(" + data + ")"); 
	            	       var n=resul.records.length;
	            	       var i=0;
	            	       var opt='' +
	        				'<option></option>';
	            	        for (i=0;i<n;i++)
	            	        	opt=opt + '<option value="' + resul.records[i].id +'">' + resul.records[i].projectName + '</option>';
							$('#project').empty();
	            	        $('#project').append(opt);
						}
   					 });
				}
				
				function openModalAddSupplier(){
					$.ajax({
						type: "POST",
						url: "<?php echo base_url() ?>supplier/SupplierNew",
						success: function(result) {
							$("#_popupContent").empty();
							$("#_popupContent").append(result);
							$('#popupModal').modal('show');
							$("#_popupTitle").html("New Supplier");
							$("#popupModal").attr("style","width:900px;left:530px;");
						}
   					 });
				}
				function getTermDescription(me){
					$.ajax({
						type: "POST",
						data: "term="+ me.value,
						url: "<?php echo base_url() ?>purchasetransaction/getTermDescription",
						success: function(data) {
							$('#termDescription').html(data);
						}
   					 });
				}
				
	
				function saveParchaseRow(){
				 if( $("#parchaseDetailForm").validationEngine('validate')){
					if ( $("#purchaseInvoiceId").val()=="null"){
						getTotal();
						$.ajax({
						type: "POST",
						data: {
							shippingMethodID : $("#shippingmethod").val(),
							employeeID : $("#purchaser").val(),
							memo : $("#memo").val(),
							  totalPayable : $("#totalpayable").val(), 
							  totalTaxAmount :  $("#totalamount").val(),
						      supplierID : $("#supplier").val(),
							  locationID :  $("#location").val(),
							  itemCode:  $("#itemcode").val(),
							  formNo : $("#formNo").val(),
							  invoiceDate: $("#createdDate").val(),
							  supplierInvoiceNo : $("#supinvoicenumber").val(),
							  projectID: $("#project").val(),
							  termsID: $("#term").val(),
							  currencyID: $("#currency").val(),
							  exchangeRate : $("#exchange_rate").val(),
							  shipToID : $("#shiptoAddress").val(),
							  itemname : $("#itemname").val(), 
							  itemdescription: $("#itemdes").val(),
							  quantity : $("#itemqte").val(),
							  unitPrice: $("#itemunitprice").val(),
							  amountExcludedTax: $("#itemAmountET").val(),
							  taxID: $("#itemTax").attr("data-taxid"),
							  taxRate: $("#itemTax").val()
							  
							},
						 url: "<?php echo base_url() ?>purchasetransaction/savePurchaseRow",
						 success: function(data) {
					 	 var resul = eval ("(" + data + ")"); 
						  $("#purchaseInvoiceId").val(resul.invoiceID);
						  $(''+
						   '<tr>' +
							  '<td>' +  $("#itemcode").val() + '</td>'+
							  '<td>' + $("#itemname").val() + '</td>'+
							  '<td>' + $("#itemdes").val() + '</td>'+
							  '<td>' + $("#itemunitprice").val() + '</td>'+
							  '<td>' + $("#itemqte").val() + '</td>'+
							  '<td>' + $("#itemAmountET").val() + '</td>'+
							  '<td>' + $("#displayTaxCode").text() + " | " + $("#itemTax").val() + '</td>'+
							  '<td>' + $("#itemTaxAmount").val() + '</td>'+
							  '<td>' + $("#itemAmountIT").val() + '</td>'+
							  '<td>'+
							  '<button onclick="deleteCompanyDetail(this)" data-detailid='+ resul.detailID +' class="btn btn-small btn-danger" type="button"><i class="icon-trash"></i></button>'+
							  '</td>'+
						      '</tr>'
							).insertBefore( "#trInfos" );
							$("#btnCancel").trigger("click");
							$("#calcul").trigger( "click" );
							getTotal();
							$.ajax({
							  type: "POST",
							  data: {
								    invoiceId : $("#purchaseInvoiceId").val(),
								  	totalPayable : $("#totalpayable").val(), 
							 	    totalTaxAmount :  $("#totalamount").val()
								  },
							  url: "<?php echo base_url() ?>purchasetransaction/updateInvoice",
							  success: function(data) {
								   //update the invoice after delete
								  }
							  });
					       msg (1,"alert alert-success","Details successfully saved");
						} //end function
   					 });//end ajax
					}else{
						$.ajax({
						type: "POST",
						data: {
							  invoiceId : $("#purchaseInvoiceId").val(),
							  
							  itemCode:  $("#itemcode").val(),
							  itemname : $("#itemname").val(), 
							  itemdescription: $("#itemdes").val(),
							  quantity : $("#itemqte").val(),
							  unitPrice: $("#itemunitprice").val(),
							  amountExcludedTax: $("#itemAmountET").val(),
							  taxID: $("#itemTax").attr("data-taxid"),
							  taxRate: $("#itemTax").val()
							  
							},
						url: "<?php echo base_url() ?>purchasetransaction/saveParchaseDetail",
						success: function(data) {
						 msg (1,"alert alert-success","Details successfully saved");
					 	  var resul = eval ("(" + data + ")"); 
					   $(''+
						 '<tr>' +
							'<td>' +  $("#itemcode").val() + '</td>'+
							'<td>' + $("#itemname").val() + '</td>'+
							'<td>' + $("#itemdes").val() + '</td>'+
							'<td>' + $("#itemunitprice").val() + '</td>'+
							'<td>' + $("#itemqte").val() + '</td>'+
							'<td>' + $("#itemAmountET").val() + '</td>'+
							'<td>' + $("#displayTaxCode").text() + " | " +  $("#itemTax").val() + '</td>'+
							'<td>' + $("#itemTaxAmount").val() + '</td>'+
							'<td>' + $("#itemAmountIT").val() + '</td>'+
							'<td>'+
							'<button onclick="deleteCompanyDetail(this)" data-detailid='+ resul.detailID +' class="btn btn-small btn-danger" type="button"><i class="icon-trash"></i></button>'+
							'</td>'+
						'</tr>'
					    ).insertBefore( "#trInfos" );
					    $("#btnCancel").trigger("click");
						$( "#calcul" ).trigger( "click" );
						getTotal();
						$.ajax({
						  type: "POST",
						  data: {
								invoiceId : $("#purchaseInvoiceId").val(),
								totalPayable : $("#totalpayable").val(), 
								totalTaxAmount :  $("#totalamount").val()
							  },
						  url: "<?php echo base_url() ?>purchasetransaction/updateInvoice",
						  success: function(data) {
							   //update the invoice after delete
							  }
						  });
					   }
   					 }); //end ajax
					} //end if data valide
					}else {
						msg (1,"alert alert-error", "Data incorrect or invalid ...");
					}
					$( "#calcul" ).trigger( "click" );
				}
				 
				function deleteCompanyDetail(me){
					$('#popupModal').modal('show');
					$("#_popupTitle").html("Confirm delete");
					$("#_popupContent").html("Your about to delete definively this row. <br/> Click on ok to confirm");
					
					$('#_popupFooter').empty();
	            	   $('#_popupFooter').append('<button class="btn btn-mini btn-danger" id="detButton">Ok</button>' +
					'<button class="btn btn-mini" id="canb">Cancel</button>');
					$("#_popupTitle").html("Confirm delete");
					$( "#canb" ).click(function() {
						$('#popupModal').modal('hide');
					});
					$( "#detButton" ).click(function() {
						$('#popupModal').modal('hide');
						$.ajax({
						type: "POST",
						data: "detailsId="+ $(me).attr("data-detailid"),
						url: "<?php echo base_url() ?>purchasetransaction/deleteCompanyDetails",
						success: function(data) {
							msg (1,"alert alert-success","Data deleted succesfuly ...");
							var td=me.parentNode;
							var tr=td.parentNode;
							var tBody=tr.parentNode;
							tBody.removeChild(tr);
							getTotal();
							$.ajax({
							  type: "POST",
							  data: {
								    invoiceId : $("#purchaseInvoiceId").val(),
								  	totalPayable : $("#totalpayable").val(), 
							 	    totalTaxAmount :  $("#totalamount").val()
								  },
							  url: "<?php echo base_url() ?>purchasetransaction/updateInvoice",
							  success: function(data) {
								   //update the invoice after delete
								  }
							  });
							}
						});
					});
					
					$( "#calcul" ).trigger( "click" );
					}
				
				function getItemDetails(me){
					$("#itemname").val("");
					$("#itemdes").val("");
					$.ajax({
						type: "POST",
						data: "code="+ me.value,
						url: "<?php echo base_url() ?>purchasetransaction/getItemDetails",
						success: function(data) {
							if(data!="item Not found"){
								 var resul = eval ("(" + data + ")");
								$("#itemname").val(resul.name);
								$("#itemdes").val(resul.description);
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
				
				function calculamountET(){
					if  ($("#totalamount").val()=="NaN"){
						
					$("#totalamount").val("0");
					
					$("#impotpayable").val("0");
					
					$("#totalpayable").val("0");
				  }
					if ($("#itemTax").attr("data-taxid")=="") {
						taxPopup ();
					}
					var j_itemAmountET =$("#itemunitprice").val()*$("#itemqte").val();
					$("#itemAmountET").val(j_itemAmountET);
					var j_itemTaxAmount=j_itemAmountET*$("#itemTax").val()/100;
					$("#itemTaxAmount").val(j_itemTaxAmount);
					$("#itemAmountIT").val(j_itemTaxAmount+j_itemAmountET);
					
					
				}
				
				function addRowInvoice(){
					
					if (!$("#itemcode").length) {
					 $(''+
					 '<tr>' +
'<td class="span2" ><input type="text" id="itemcode" name="itemcode" onkeyup="getItemDetails(this);" onchange="getItemDetails(this);" data-source="<?php echo $itemCodes; ?>" data-items="4" data-provide="typeahead" class="span12"></td>'+
                        '<td class="span2"><input id="itemname" name="itemname"  type="text" class="span12 validate[required,maxSize[64]]" placeholder="Item Name"></td>'+
                        '<td class="span2"><input id="itemdes" name="itemdes" class="span12 validate[required]" type="text" placeholder="Description"></td>'+
                        '<td class="span1"><input id="itemunitprice" onkeyup="calculamountET()" name="itemunitprice" class="span12 validate[required,custom[number]]" type="text" placeholder="Unit Priece"></td>'+
                        '<td class="span1"><input id="itemqte" onkeyup="calculamountET()"  name="itemqte" class="span12 validate[required,custom[integer]]" type="text" placeholder="Qty"></td>'+
                        '<td class="span1"><input id="itemAmountET" name="itemAmountET" onkeydown="return false;" class="input-mini validate[required]" type="text" placeholder="Amount (Exclude Tax)"></td>'+
                        '<td class="span1"><div  class="input-prepend"><input data-taxid="" id="itemTax" onkeyup="calculamountET()" name="itemTax" class="span6 validate[required, custom[number]]" type="text" placeholder="Tax(%)"><span onclick="taxPopup ()" style="margin-top:0;" id="displayTaxCode"  class="btn add-on">....</span></div></td>'+
                        '<td class="span1"><input id="itemTaxAmount" name="itemTaxAmount" onkeydown="return false;" class="span12" type="text" placeholder="Tax Amount"></td>'+
                        '<td class="span1"><input id="itemAmountIT" name="itemAmountIT" onkeydown="return false;" class="span12" type="text" placeholder="Amount (Include Tax)"></td>'+
                        '<td class="span1">'+
						 	'<button class="btn btn-mini btn-primary" onclick="saveParchaseRow()" type="button">Save</button>'+
						 	'<button id="btnCancel" class="btn btn-mini" onclick="delRowInvoice(this)" type="button">Cancel</button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfos" );
					
					
 
					}else{
						msg (1,"alert","Please, do save the current details before addind new one");
						}
				}
 
  function getTotal (){
	  
	 $("#totalamount").val("");
  
	$("#impotpayable").val("");
  
	$("#totalpayable").val("");
	 var n =$("#listDetails > tbody > tr").length-1;
	 var totalAmount =0;
	 var impot = 0;
	 var total = 0;
	 for (i=0; i<=n; i++) {
			totalAmount= totalAmount + $('#listDetails > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
			impot= impot + $('#listDetails > tbody > tr:eq(' + i + ') > td:eq(7)').text() *1; 
			total= total + $('#listDetails > tbody > tr:eq(' + i + ') > td:eq(8)').text()*1; 
	 }
	
	// calcul for charge
	
	 var n =$("#listCharge > tbody > tr").length-1;
	 var totalAmountCharge =0;
	 var impotCharge = 0;
	 var totalCharge = 0;
	 for (i=0; i<=n; i++) {
			totalAmountCharge= totalAmountCharge + $('#listCharge > tbody > tr:eq(' + i + ') > td:eq(2)').text()*1; 
			impotCharge= impotCharge + $('#listCharge > tbody > tr:eq(' + i + ') > td:eq(4)').text() *1; 
			totalCharge= totalCharge + $('#listCharge > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
	 }
	 
	 $("#totalamount").val(totalAmount + totalAmountCharge );
  
	$("#impotpayable").val(impot +  impotCharge);
  
	$("#totalpayable").val(total + totalCharge);
	
  }
					
					
function msg(n,type, message){
	
	$("#msg_div"+n +" p").html(message);
	$("#msg_div"+n).attr("class","alert " + type);
}

function delRowInvoice(me){
	var td=me.parentNode;
	var tr=td.parentNode;
	var tBody=tr.parentNode;
	tBody.removeChild(tr);
}

function checkformNumber(me){
	var answer ="no";
	$.ajax({
	  type: "POST",
	  data: "code="+ me.value,
	  url: "<?php echo base_url() ?>purchasetransaction/checkformNumber",
	  success: function(data) {
		  answer = data;
		  if(data=="yes"){
			  $("#formNo").attr("placeholder","Error: Number exist ...");
			  $("#formNo").val("");
			  msg (1,"alert", "This form number is already used ");
		  }
	  }
   });
   return answer;
}














function saveCharge(){
	 if( $("#parchaseDetailForm").validationEngine('validate')){
	if ( $("#purchaseInvoiceId").val()=="null"){
		  $.ajax({
		  type: "POST",
		  data: {
				supplierID : $("#supplier").val(),
							  
				itemCode:  $("#itemcode").val(),
				formNo : $("#formNo").val(),
				shipToID : $("#shiptoAddress").val(),
				invoiceDate: $("#createdDate").val(),
				supplierInvoiceNo : $("#supinvoicenumber").val(),
				projectID: $("#project").val(),
				termsID: $("#term").val(),
				currencyID: $("#currency").val(),
				exchangeRate : $("#exchange_rate").val(),
				locationID :  $("#location").val(),
				shippingMethodID : $("#shippingmethod").val(),
				employeeID : $("#purchaser").val(),
				memo : $("#memo").val(),
				
				accountNoID : $("#chargeAccount").val(), 
				itemdescription: $("#chargedesc").val(),
				amountExcludedTax : $("#chargeAmount").val(),
				taxID: $("#listTax").val(),
				taxAmount: $("#chargetaxAmount").val(),
				amountIncludedTax: $("#chargeAmountIT").val()
				
			  },
		  url: "<?php echo base_url() ?>purchasetransaction/saveCharge",
		  success: function(data) {
			var resul = eval ("(" + data + ")"); 
			$("#purchaseInvoiceId").val(resul.invoiceID);
			$(''+
		   '<tr>' +
			  '<td>' + $("#chargeAccount option:selected").text() + '</td>'+
			  '<td>' + $("#chargedesc").val() + '</td>'+
			  '<td>' + $("#chargeAmount").val() + '</td>'+
			  '<td>' + $("#listTax option:selected").text() + '</td>'+
			  '<td>' + $("#chargetaxAmount").val() + '</td>'+
			  '<td>' + $("#chargeAmountIT").val() + '</td>'+
			  '<td>'+
		       '<button onclick="deleteCharge(this)" data-ChargeId='+ resul.chargeId +' class="btn btn-mini btn-danger" type="button"><i class="icon-trash"></i></button>'+
			  '</td>'+
		  '</tr>'
			).insertBefore( "#trInfosCharge" );
			$("#btnCancelCharge").trigger("click");
			$("#calcul" ).trigger( "click" );
		    msg (2,"alert alert-success","Charge successfully saved");
			getTotal();
			$.ajax({
			  type: "POST",
			  data: {
					invoiceId : $("#purchaseInvoiceId").val(),
					totalPayable : $("#totalpayable").val(), 
					totalTaxAmount :  $("#totalamount").val()
				  },
			  url: "<?php echo base_url() ?>purchasetransaction/updateInvoice",
			  success: function(data) {
				   //update the invoice after delete
				  }
			  });
		  } // function
	    });//end ajax
	  }else{
		  $.ajax({
		  type: "POST",
		  data: {
				invoiceId : $("#purchaseInvoiceId").val(),
							  
				accountNoID : $("#chargeAccount").val(), 
				itemdescription: $("#chargedesc").val(),
				amountExcludedTax : $("#chargeAmount").val(),
				taxID: $("#listTax").val(),
				taxAmount: $("#chargetaxAmount").val(),
				amountIncludedTax: $("#chargeAmountIT").val()
				
			  },
		  url: "<?php echo base_url() ?>purchasetransaction/saveChargeDetailOnly",
		  success: function(data) {
			var resul = eval ("(" + data + ")"); 
			$(''+
		   '<tr>' +
			  '<td>' + $("#chargeAccount option:selected").text() + '</td>'+
			  '<td>' + $("#chargedesc").val() + '</td>'+
			  '<td>' + $("#chargeAmount").val() + '</td>'+
			  '<td>' + $("#listTax option:selected").text() + '</td>'+
			  '<td>' + $("#chargetaxAmount").val() + '</td>'+
			  '<td>' + $("#chargeAmountIT").val() + '</td>'+
			  '<td>'+
		       '<button onclick="deleteCharge(this)" data-ChargeId='+ resul.chargeId +' class="btn btn-mini btn-danger" type="button"><i class="icon-trash"></i></button>'+
			  '</td>'+
		  '</tr>'
			).insertBefore( "#trInfosCharge" );
			$("#btnCancelCharge").trigger("click");
			$("#calcul").trigger( "click" );
		    msg (2,"alert alert-success","Charge successfully saved");
			getTotal();
			$.ajax({
			  type: "POST",
			  data: {
					invoiceId : $("#purchaseInvoiceId").val(),
					totalPayable : $("#totalpayable").val(), 
					totalTaxAmount :  $("#totalamount").val()
				  },
			  url: "<?php echo base_url() ?>purchasetransaction/updateInvoice",
			  success: function(data) {
				   //update the invoice after delete
				  }
			  });
		  }
	   });//end ajax
	  }
  }else {
   msg (2,"alert alert-error", "Data incorrect or invalid ...");
  }
  
  $("#calcul").trigger( "click" );
}


function addRowInvoiceCharge(){
	if (!$("#chargeAccount").length) {
					 $(''+
					 '<tr>' +
							'<td class="span2"> <select name="chargeAccount" id="chargeAccount" class="span12" validate[required]"><option></option>' +
									 <?php
				if($chargeAccount){
				 foreach($chargeAccount as $row){
					 ?>
                     '<option value="<?php echo $row->ID; ?>"><?php echo $row->acctCode." | "; echo str_replace("'", " ",$row->acctName, $count); ?></option>'+
			    <?php }} ?>
							 '</select></td>'+
													'<td class="span4"><input  id="chargedesc" name="chargedesc"  type="text" class="span12 validate[required]" placeholder="Description"></td>'+
													'<td class="span1"><input id="chargeAmount" onchange="calculChargeAmount()" name="chargeAmount" class="span12 validate[required, custom[number]]" type="text" placeholder="Amount"></td>'+
													'<td class="span2"><select onclick="calculChargeAmount()" name="listTax" id="listTax"  class= "span12 validate[required]"><option></option>' +
									 <?php if($taxmaster){
					 foreach($taxmaster as $row2){
					 ?>
                     '<option value="<?php echo $row2->ID; ?>" data-tax="' + <?php echo $row2->taxPercentage; ?> + '">' + 
					 '<?php echo $row2->code." | ".$row2->taxPercentage." | "; echo str_replace("'", " ",$row2->name, $count); ?></option>'+
			    <?php }} ?>
							 '</select></td>'+
													'<td class="span1"><input id="chargetaxAmount"  name="chargetaxAmount" class="span12" type="text" placeholder="Amount"></td>'+
													'<td class="span1"><input onkeydown="return false;" id="chargeAmountIT" name="chargeAmountIT" class="span12" type="text" placeholder="Amount (Exclude Tax)"></td>'+
						'<td class="span1">'+
						 	'<button onclick = "saveCharge()" class="btn btn-mini btn-primary" type="button">Save</button>'+
						 	'<button onclick="delRowInvoice(this)" id="btnCancelCharge" class="btn btn-mini" type="button">Cancel</button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfosCharge" );
					
					//$('select').select2();
 
					}else{
						msg (2,"alert","Please, do save the current details before addind new one");
						}
}

function refreshLocation(){
 $.ajax({
	type: "POST",
	url: "<?php echo base_url() ?>purchasetransaction/refreshLocation",
	success: function(data) {
	
	   var resul = eval ("(" + data + ")"); 
	   var n=resul.records.length;
	   var i=0;
	   var opt='' +
		'<option></option>';
		for (i=0;i<n;i++)
			opt=opt + '<option value="' + resul.records[i].id +'">' + resul.records[i].location + '</option>';
		$('#location').empty();
		$('#location').append(opt);
	}
   });	
}

function calculChargeAmount() { 
	var t = $("#chargeAmount").val() * $("#listTax option:selected").attr("data-tax") /100;
	$("#chargetaxAmount").val(t);
	$("#chargeAmountIT").val(t+  $("#chargeAmount").val()*1);
}

function deleteCharge(me){
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
		  data: {chargeID : $(me).attr("data-ChargeId") },
		  url: "<?php echo base_url() ?>purchasetransaction/deleteCharge",
		  success: function(data) {
			//  msg (2,"alert alert-success","Data deleted succesfuly ...");
			  var td=me.parentNode;
			  var tr=td.parentNode;
			  var tBody=tr.parentNode;
			  tBody.removeChild(tr);
			  getTotal();
			  $.ajax({
				type: "POST",
				data: {
					  invoiceId : $("#purchaseInvoiceId").val(),
					  totalPayable : $("#totalpayable").val(), 
					  totalTaxAmount :  $("#totalamount").val()
					},
				url: "<?php echo base_url() ?>purchasetransaction/updateInvoice",
				success: function(data) {
					 //update the invoice after delete
					}
				});
			  }
		  });
	  });
	  
	  $("#calcul").trigger( "click" );
}

function displaysAdress(){
		$("#shiptoDesc").html("");
		$("#shiptoDesc").html($("#shiptoAddress option:selected").attr("data-line1") +
							   "&#10;" + $("#shiptoAddress option:selected").attr("data-line2") +
							   "&#10;" + $("#shiptoAddress option:selected").attr("data-line3"));
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
		 calculamountET();
	});
	
	
}

function refreshpurchaserlist(){
	 $.ajax({
	type: "POST",
	url: "<?php echo base_url() ?>employeeSetup/refreshEmployee",
	success: function(data) {
	
	   var resul = eval ("(" + data + ")"); 
	   var n=resul.records.length;
	   var i=0;
	   var opt='' +
		'<option></option>';
		for (i=0;i<n;i++)
			opt=opt + '<option value="' + resul.records[i].id +'">' + resul.records[i].employeeName + '</option>';
		$('#location').empty();
		$('#location').append(opt);
	}
   });	
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
                <li><a href='<?php echo base_url()."AccountPayables/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
<form id="parchaseDetailForm" action="#">    
	<div class="row-fluid">
		<div class="alert alert-info">
			<strong><?php echo $this->lang->line('title') ?></strong>
		</div>
	</div>
	<div class="row-fluid scRow">                            
	  <div class="span4 scCol">
		<div class="block" id="grid_block_1">
          <div class="content">
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('supplier') ?></div>
         	<div class="span8">
                 <div class="input-append">
    
    			
                <input type="hidden" id="purchaseInvoiceId" value="null"/>
                <select class="input-medium validate[required]" id="supplier" onchange="loadSupplierDefaultValue(this)">
                 <option></option>
                <?php
				if($supplier != ''){
				 foreach($supplier as $row){
					 ?>
                     <option value="<?php echo $row->ID; ?>"> <?php echo $row->supplierName; ?></option>
			    <?php }} ?>
                </select>
                <div class="btn-group">
                <button class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
                	<span class="i-arrow-down-2"></span>
                </button>
				<ul class="dropdown-menu">
      			<!-- dropdown menu links -->
      				<li><a target="_blank" href="<?php echo base_url() ?>supplier/SupplierNew"  id="btnNewSupplier">
                    	<i class="icon-plus-sign"></i> <?php echo $this->lang->line('addNewSupplier')?></a></li>
      				<li><a href="#" onclick="refreshSupplier()" id="btnNewSupplier">
                    	<i class="icon-refresh"></i><?php echo $this->lang->line('refreshlist')?></a></li>
				</ul>
                </div>
                </div>
         	</div>
         	</div> <!-- row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('formNo')?></div>
         	<div class="span4">
                  <input class="input-mini validate[required]" id="formNo" name="formNo" value='<?php echo "$formNo"; ?>' style="color:red;"   type="text" placeholder="Form number ...">
            </div>
         	<div class="span4">
                  <input  class="input-mini"   type="text" placeholder="Serial" disabled="disabled">
            </div>
          </div> <!-- row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('date') ?></div>
         	<div class="span8">
              	 <?php
					$data = array(
					'name' => 'createdDate',
					'id' => 'createdDate',
					'type' => 'text',
					'onkeydown' => 'return false',
					'class' => 'input-small datepicker validate[required]',);
					echo form_input($data, date('d-m-Y'));
					?>
            </div>
          </div> <!-- row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('supplierInvoiceNo') ?></div>
         	<div class="span9">
				<input id="supinvoicenumber" class="span12 validate[required]" type="text" placeholder="Supplier Invoice Number">
            </div><!-- span -->
          </div> <!-- row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('project') ?></div>
         	<div class="span8">
             <div class="input-append">
                <select id="project" class="input-medium validate[required]">
				 <option></option>
                 <?php
				if($project != ''){
				 foreach($project as $row){
					 ?>
                     <option value="<?php echo $row->ID; ?>"><?php echo $row->project_name; ?></option>
			    <?php }} ?>
                </select>
                <div class="btn-group">
                 <button class="btn btn-mini btn-primary  dropdown-toggle" data-toggle="dropdown">
                	<span class="i-arrow-down-2"></span>
                  </button>
                  	<ul class="dropdown-menu">
                        <!-- dropdown menu links -->
                        <li><a target="_blank" href="<?php echo base_url() ?>project/ProjectSetup"  id="btnNewPro">
                        <i class="icon-plus-sign"></i><?php echo $this->lang->line('addNewProject')?></a></li>
                        <li><a href="#" onclick="refreshProject()"><i class="icon-refresh"></i><?php echo $this->lang->line('refreshlist')?></a>
                        </li>
             		 </ul>
                     </div> <!-- btn group -->
                </div> <!-- append -->
            </div><!-- span -->
        	
          </div> <!-- row control -->
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
          <div class="controls-row">
          
          	<div class="span3"><?php echo $this->lang->line('location') ?></div>
         	<div class="span8">
            	 <div class="input-append">
            	<select class="input-medium validate[required]" id="location">
				  <option></option>
                   <?php
					if($location != ''){
				 		foreach($location as $row){
					 ?>
                     <option value="<?php  echo $row->fldid; ?>"><?php echo $row->code." | ".$row->address. " | ".$row->city ; ?></option>
			    <?php }} ?>
                </select>
                <div class="btn-group">
            	 <button class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                        <!-- dropdown menu links -->
                        <li><a target="_blank" href="<?php echo base_url() ?>setting/location"  id="btnLocation">
                        <i class="icon-plus-sign"></i><?php echo $this->lang->line('addLocation')?></a></li>
                        <li><a href="#" onclick="refreshLocation()"><i class="icon-refresh"></i><?php echo $this->lang->line('refreshlist')?></a></li>
                   </ul>
            </div>
          </div> <!-- btnn group -->
                </div>
            </div>
            
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('terms')?></div>
         	<div class="span8">
            	<div class="input-append">
                    <select id="term" onchange="getTermDescription(this)" class="input-medium validate[required]">
                      <option></option>
                       <?php
                        if($terms != ''){
                            foreach($terms as $row){
                         ?>
                         <option value="<?php echo $row->ID; ?>"><?php echo $row->termName; ?></option>
                    <?php }} ?>
                    </select>
                    <div class="btn-group">
                        <button class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="i-arrow-down-2"></span>
                        </button>
                          <ul class="dropdown-menu">
                                <!-- dropdown menu links -->
                                <li><a target="_blank" href="<?php echo base_url() ?>term/term_newform"  id="btnNewTer">
                                <i class="icon-plus-sign"></i><?php echo $this->lang->line('addNewTerms')?></a></li>
                                <li><a href="#" onclick="refreshTerms()"><i class="icon-refresh"></i><?php echo $this->lang->line('refreshlist')?></a>
                                </li>
                        </ul>
                    </div><!-- btn group -->
                </div><!-- append -->
            </div><!-- span -->
            
          </div><!-- row control -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('termsdesc') ?></div>
         	<div class="span8">
                <textarea style="height: 123px; " disabled="disabled" id="termDescription" class="span12">
                </textarea>
            </div><!-- span -->
            </div><!-- row control -->
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_3">
          <div class="content">
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('shipto') ?></div>
         	<div class="span8">
                   <select id="shiptoAddress" onchange ="displaysAdress()" class="input-medium validate[required]">
    				<option data-line1="" data-line2="" data-line3="" data-postcode=""></option>
                     <?php
					if($shipto != ''){
				 		foreach($shipto as $row){
					 ?>
                     <option  data-line1="<?php echo $row->line1 ?>" data-line2="<?php echo $row->line2 ?>" data-line3="<?php echo $row->line3 ?>" data-postcode="<?php echo $row->postCode ?>" value="<?php echo $row->ID; ?>">
					 <?php echo $row->addressName ." | ".$row->city ; ?></option>
			    <?php }} ?>
                   </select>
            </div><!-- span -->
            </div><!-- row control -->
            <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('shiptoDesc') ?></div>
         	<div class="span8">
                   <textarea style="height: 75px;" disabled="disabled"ssss id="shiptoDesc" class="span12">
                   		
                   </textarea>
            </div><!-- span -->
            </div><!-- row control -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('currency') ?></div>
         	<div class="span8">
				<input id="currency" name="currency" type="text" placeholder="Currency" disabled class="input-medium validate[required,minSize[5],maxSize[10]]">            
            </div><!-- span -->
            </div><!-- control row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('exchangeRate') ?></div>
         	<div class="span8">
				<input class="input-medium" id="exchange_rate" name="exchange_rate" type="text" placeholder="Example: 3.2" >           
            </div><!-- span -->
            </div><!-- control row -->
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
	       <div class="head">
           	<h2><?php echo $this->lang->line('items')?></h2>
           	<ul class="buttons">
            	<li><a class="block_toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                        	<span class="i-arrow-down-3"></span></a></li>
          	</ul>                                        
          </div><!-- head -->
          <div class="content np">
   				  <table id="listDetails" cellpadding="0" cellspacing="0" width="100%">
            			<thead>
                			<tr>
                       	 	<th><?php echo $this->lang->line('itemCode')?></th>
                        	<th><?php echo $this->lang->line('itemName')?></th>
                        	<th><?php echo $this->lang->line('itemDesc')?></th>
                        	<th><?php echo $this->lang->line('unitPrice')?></th>
                        	<th><?php echo $this->lang->line('quantity')?></th>
                        	<th><?php echo $this->lang->line('amountExcludeTax')?></th>
                        	<th><?php echo $this->lang->line('amountTax')?></th>
                        	<th><?php echo $this->lang->line('taxAmount')?></th>
                        	<th><?php echo $this->lang->line('amountIncludeTax')?></th>
                        	<th><?php echo $this->lang->line('action')?></th>
                    		</tr>
                		</thead>
                		<tbody>
                			<tr id="trInfos">
                				<td colspan="11">
                	    			<div id="msg_div1" class="alert alert-info">
                       				  <h4><?php echo $this->lang->line('lastMessage')?></h4>
                   					  <p style="padding-top:10px;"><?php echo $this->lang->line('noMessage')?></p>
					 			  </div>
               				  </td>
               			  </tr>
               		</tbody>
           		  </table>
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                    <button style="margin-right:6px;" onclick="$('#parchaseDetailForm').validationEngine('hide');" class="btn btn-mini" type="button" name="validat">Hide prompts</button>
           			<button id="addRow" onclick="addRowInvoice()" class="btn btn-mini btn-primary" type="button">
                        <i class="icon-plus-sign"></i><?php echo $this->lang->line('addNewDetails')?></button>
       				</div><!-- btn group -->      
       			</div><!-- side fr -->      
       		</div><!-- footer -->      
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
	             <div class="head">
                     <h2><?php echo $this->lang->line('charge')?></h2>
                 	<ul class="buttons">
                    	<li><a class="block_toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                        	<span class="i-arrow-down-3"></span></a></li>
                    </ul>                                        
             	 </div><!-- head -->
          <div class="content np">
   				<table id="listCharge" cellpadding="0" cellspacing="0" width="100%">
            	<thead>
                	<tr>
                        <th><?php echo $this->lang->line('account')?></th>
                        <th><?php echo $this->lang->line('description')?></th>
                        <th><?php echo $this->lang->line('amount')?></th>
                        <th><?php echo $this->lang->line('tax')?></th>
                        <th><?php echo $this->lang->line('taxAmount')?></th>
                        <th><?php echo $this->lang->line('amountIncludeTax')?></th>
                        <th><?php echo $this->lang->line('action')?></th>
                    </tr>
                </thead>
                <tbody>
                <tr id="trInfosCharge">
                	<td colspan="7">
                	    <div id="msg_div2" class="alert alert-info">
                        	<h4><?php echo $this->lang->line('lastMessage')?></h4>
                        	<p style="padding-top:10px;"><?php echo $this->lang->line('noMessage')?></p>
					    </div>
                	</td>
                </tr>
                </tbody>
            </table>
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                     	<button style="margin-right:6px;" onclick="$('#parchaseDetailForm').validationEngine('hide');" class="btn btn-mini" type="button" name="validat">Hide prompts</button>
           				<button id="addRowCharge" onclick="addRowInvoiceCharge()" class="btn btn-mini btn-primary" type="button">
                        <i class="icon-plus-sign"></i><?php echo $this->lang->line('addNewCharge')?></button>
             			
       				</div><!-- btn group -->      
       			</div><!-- side fr -->      
       		</div><!-- footer -->      
          </div><!-- content -->

        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
	<div class="row-fluid scRow"> 
      <div class="span7 scCol">
		<div class="block" id="grid_block_4">
          <div class="content np">
          			<div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('shippingmethod')?></div>
         	<div class="span8">
            	<div class="span12 input-append">
                <select id="shippingmethod"  class="span11 validate[required]">
				  <option></option>
                   <?php
					if($shippingmethod != ''){
				 		foreach($shippingmethod as $row){
					 ?>
                     <option value="<?php echo $row->ID; ?>"><?php echo $row->name; ?></option>
			    <?php }} ?>
                </select>
                <div class="span1 btn-group">
            	<button class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
                	<span class="i-arrow-down-2"></span>
                </button>
                  <ul class="dropdown-menu">
                        <!-- dropdown menu links -->
                        <li><a target="_blank" href="<?php echo base_url() ?>term/term_newform"  id="btnNewTer">
                        <i class="icon-plus-sign"></i><?php echo $this->lang->line('addNewTerms')?></a></li>
                        <li><a href="#" onclick="refreshTerms()"><i class="icon-refresh"></i><?php echo $this->lang->line('refreshlist')?></a>
                        </li>
              	</ul>
             </div><!-- btn group -->
                </div><!-- append -->
            </div><!-- span -->
            
          </div><!-- row control -->
                      <div class="controls-row">
                             <div class="span3"><?php echo $this->lang->line('purchaser') ?></div>
                              <div class="span8">
                                   <div class="input-append span12">
                      
                                  
                                  <input type="hidden" id="purchaseInvoiceId" value="null"/>
                                  <select class="span11 input-medium validate[required]" id="purchaser">
                                   <option></option>
                                  <?php
                                  if($purchaser != ''){
                                   foreach($purchaser as $row){
                                       ?>
                                       <option value="<?php echo $row->ID; ?>"> <?php echo $row->employeeName; ?></option>
                                  <?php }} ?>
                                  </select>
                                  <div class="span1 btn-group">
                                  <button class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
                                      <span class="i-arrow-down-2"></span>
                                  </button>
                                  <ul class="dropdown-menu">
                                  <!-- dropdown menu links -->
                                      <li><a target="_blank" href="<?php echo base_url() ?>employeeSetup/EmployeeNew"  id="EmployeeNew">
                                          <i class="icon-plus-sign"></i> <?php echo $this->lang->line('newpurchaser')?></a></li>
                                      <li><a href="#" onclick="refreshpurchaserlist()" id="btnNewSupplier">
                                          <i class="icon-refresh"></i><?php echo $this->lang->line('refreshlist')?></a></li>
                                  </ul>
                                  </div>
                                  </div>
                               </div>
                  </div><!-- row control -->
                  
                   <div class="controls-row">
                      <div class="span3"><?php echo $this->lang->line('memo') ?></div>
                      <div class="span8">
                             <textarea style="height: 75px;" id="memo" class="span12"></textarea>
                      </div><!-- span -->
                   </div><!-- row control -->
                  
              </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->        
	  <div class="span5 scCol">
		<div class="block" id="grid_block_4">
          <div class="content np">
                      <div class="controls-row">
                      
                      <div class="span3"><?php echo $this->lang->line('totalAmount')?></div>
                      <div class="span8">
                          <input id="totalamount" class="input-small" type="text" placeholder="0" disabled="disabled" >
                      </div>
                  </div><!-- row control -->
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('importDutyPayable')?></div>
                      <div class="span8">
                          <input id="impotpayable" class="input-small" type="text" disabled="disabled"  placeholder="0">
                      </div>
                  </div><!-- row control -->
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('totalPayable')?></div>
                      <div class="span8">
                          <input id="totalpayable" disabled="disabled"  class="input-small" type="text" placeholder="0">
                      </div>
                  </div><!-- row control -->
                  <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
           				 <button id="calcul" onclick="getTotal()" class="btn btn-mini btn-warning" type="button"> 
                         <i class="icon-ok-circle"></i><?php echo $this->lang->line('calTotal')?></button>
                         
       				</div><!-- btn group -->      
       			</div><!-- side fr -->      
       		</div><!-- footer -->   
              </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
</form>
</div><!-- grid 1 -->
</div><!-- wrap -->
</div><!-- content -->

                    
                    
   