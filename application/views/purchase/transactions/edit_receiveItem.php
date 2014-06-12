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

				function loadPoListBySupplierID() {
					$('#poList').empty();
					$('#outstandingItems tbody').empty();
					$.ajax({
						type: "POST",
						data: "supplier="+ $("#supplier option:selected").val(),
						url: "<?php echo base_url() ?>receiveItems/getPoList",
						success: function(data) {
							 var resul = eval ("(" + data + ")"); 
	            	       var n=resul.records.length;
	            	       var i=0;
	            	       var opt='' +
	        				'<option></option><option value="-1">None</option>';
	            	        for (i=0;i<n;i++)
	            	        	opt=opt + '<option value="' + resul.records[i].id + '">' + resul.records[i].formNo + '</option>';
							
	            	      $('#poList').append(opt);
						}
   					 });
				}

			    function loadSupplierDefaultValue(me){
					$('#currency').attr("value","");
					$('#exchange_rate').attr("value","");
					loadPoListBySupplierID();
					$.ajax({
						type: "POST",
						data: "supplier="+ $("#supplier option:selected").val(),
						url: "<?php echo base_url() ?>supplier/loadSupplierDefaultValue",
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
						url: "<?php echo base_url() ?>supplier/refreshSupplier",
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
			
				
				
	function calculamount() {
		$("#itemAmount").val($("#itemunitprice").val()*$("#itemqte").val());
	}			
				
 
  function getTotal (){
	$("#totalpayable").val("");
	
	 var n =$("#t_listItemOrdered > tbody > tr").length-1;
	 var total =0;
	 for (i=0; i<=n; i++) {
			total= total + $('#t_listItemOrdered > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
	 }
	 
	 var n1 =$("#t_listItemOrdered > tbody > tr").length-1;
	 var total1 =0;
	 for (i=0; i<=n1; i++) {
			total1= total1 + $('#t_listItemOrdered1 > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
	 }
  
 	 $("#totalpayable").val(total + total1);
	
  }
					
					
function msg(type, message){
	
	$("#msg_div p").html(message);
	$("#msg_div").attr("class","alert " + type);
}

function delRow(me){
	var td=me.parentNode;
	var tr=td.parentNode;
	var tBody=tr.parentNode;
	tBody.removeChild(tr);
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


		function addNewRowWithoutPo(me){
			if (!$("#itemcode").length) {
					 $(''+
					 '<tr>' +

'<td class="span2" ><input type="text" id="itemcode" name="itemcode" onkeyup="getItemDetails(this);" onchange="getItemDetails(this);" data-source="<?php echo $itemCodes; ?>" data-items="4" data-provide="typeahead" class="span12"></td>'+
                        '<td class="span2"><input id="itemname" name="itemname"  type="text" class="span12 validate[required,maxSize[64]]" placeholder="Item Name"></td>'+
                        '<td class="span3"><input id="itemdes" name="itemdes" class="span12 validate[required]" type="text" placeholder="Description"></td>'+
                        '<td class="span1"><input id="itemunitprice" onkeyup="calculamount()" name="itemunitprice" class="span12 validate[required,custom[number]]" type="text" placeholder="Unit Priece"></td>'+
                        '<td class="span1"><input id="itemqte" onkeyup="calculamount()"  name="itemqte" class="span12 validate[required,custom[integer]]" type="text" placeholder="Qty"></td>'+
                        '<td class="span1"><input id="itemAmount" name="itemAmount" onkeydown="return false;" class="span12" type="text" placeholder="Amount (Include Tax)"></td>'+
                        '<td class="span1">'+
						 	'<button class="btn btn-mini btn-primary" onclick="saveItemReceiNoPo(this)" type="button"><i class="icon-ok icon-white"></i></button>'+
						 	'<button id="btnCancel" class="btn btn-mini btn-warning" onclick="delRow(this)" type="button"><i class="icon-remove-circle icon-white"></i></button>'+
						'</td>'+
                    '</tr>').insertBefore( "#trInfos" );
					
					
 
					}else{
						msg (1,"alert","Please, do save the current details before addind new one");
						}
		}
		
		function saveItemReceiced(me){
			
		//$(me).parent().validationEngine('showPrompt', '*date field is required');
		//alert (jQuery( $(tr).find("td").eq(7).children("input:first-child")).valid());
		 	if ($("#receivedID").val()=="null"){ 
			//new 
			 if( $("#frmReceive").validationEngine('validate')){
			 var tr = $(me).parent().parent();
			 var v =$(tr).find("td").eq(7).children("input:last-child").val();
		  	  if (v<1 || v > ($(tr).find("td").eq(4).text()- $(tr).find("td").eq(6).text()) || isNaN($(tr).find("td").eq(7).children("input:last-child").val()*$(tr).find("td").eq(4).text()) ) {
				  $(tr).find("td").eq(7).children("input:last-child").validationEngine('showPrompt', 'Qty received Incorrect');
			  }else {
				  $.ajax({
					  type: "POST",
					  data: {
						  supplierID : $("#supplier").val(),
						  formNo : $("#formNo").val(),
						  deliveryDate : $("#createdDate").val(),
						  shippingMethodID : $("#shippingMethod").val(),
						  supplierDoNo : $("#supplierDoNumber").val(),
						  purchaseOrderID : $("#poList").val(),
						  locationID : $("#location").val(),
						  employeeID : $("#purchaseInvoiceId").val(),
						  memo : $("#memo").val(),

						  poDetailID : $(me).attr("data-podetailsid"),
						  itemCode : $(tr).find("td").eq(0).text(),
						  itemname : $(tr).find("td").eq(1).text(),
						  quantityReceivedTotal : $(tr).find("td").eq(6).text(),
						  description : $(tr).find("td").eq(2).text(),
						  quantityOrder : $(tr).find("td").eq(4).text(),
						  quantityReceived : $(tr).find("td").eq(7).children("input:last-child").val(),
						  unitPrice : $(tr).find("td").eq(3).text(),
						  amount : $(tr).find("td").eq(5).text()
				
						  },
					  url: "<?php echo base_url() ?>receiveItems/saveNewItemReceived",
					  success: function(data) {
						  var resul = eval ("(" + data + ")"); 
						   $("#receivedID").val(resul.receivedID);
						  $("#poList").attr('disabled','disabled');
						  $("#supplier").attr('disabled','disabled');
						  msg("alert alert-success","Data saved successfully !!!")
						  var tr = $(me).parent().parent();
						  $(''+
						   '<tr>' +
							  '<td>' +  $(tr).find("td").eq(0).text() + '</td>'+
							  '<td>' +  $(tr).find("td").eq(1).text()  + '</td>'+
							  '<td>' +  $(tr).find("td").eq(2).text()  + '</td>'+
							  '<td>' +  $(tr).find("td").eq(4).text()  + '</td>'+
							  '<td>' + $(tr).find("td").eq(7).children("input:last-child").val() + '</td>'+
							  '<td>' +  $(tr).find("td").eq(7).children("input:last-child").val()*$(tr).find("td").eq(4).text() + '</td>'+
							  '<td>'+
							  '</td>'+
							  '</tr>'
							).insertBefore( "#trInfos" );
							delRow (me);
							getTotal ();
						  }
					  });
			  }
			 }
			 
			 
			}else{
				// save detail only
				 var tr = $(me).parent().parent();
			 var v =$(tr).find("td").eq(7).children("input:last-child").val();
		  	  if (v<1 || v > ($(tr).find("td").eq(4).text()- $(tr).find("td").eq(6).text()) || isNaN($(tr).find("td").eq(7).children("input:last-child").val()*$(tr).find("td").eq(4).text()) ) {
				  $(tr).find("td").eq(7).children("input:last-child").validationEngine('showPrompt', 'Qty received Incorrect');
			  }else {
				  $.ajax({
					  type: "POST",
					  data: {
						  receiveID : $("#receivedID").val(),

						  poDetailID : $(me).attr("data-podetailsid"),
						  itemCode : $(tr).find("td").eq(0).text(),
						  itemname : $(tr).find("td").eq(1).text(),
						  quantityReceivedTotal : $(tr).find("td").eq(6).text(),
						  description : $(tr).find("td").eq(2).text(),
						  quantityOrder : $(tr).find("td").eq(4).text(),
						  quantityReceived : $(tr).find("td").eq(7).children("input:last-child").val(),
						  unitPrice : $(tr).find("td").eq(3).text(),
						  amount : $(tr).find("td").eq(5).text()
				
						  },
					  url: "<?php echo base_url() ?>receiveItems/saveNewItemDetailOnly",
					  success: function(data) {
						  var resul = eval ("(" + data + ")"); 
						   $("#receivedID").val(resul.receivedID);
						  $("#poList").attr('disabled','disabled');
						  $("#supplier").attr('disabled','disabled');
						  msg("alert alert-success","Data saved successfully !!!")
						  var tr = $(me).parent().parent();
						  $(''+
						   '<tr>' +
							  '<td>' +  $(tr).find("td").eq(0).text() + '</td>'+
							  '<td>' +  $(tr).find("td").eq(1).text()  + '</td>'+
							  '<td>' +  $(tr).find("td").eq(2).text()  + '</td>'+
							  '<td>' +  $(tr).find("td").eq(4).text()  + '</td>'+
							  '<td>' + $(tr).find("td").eq(7).children("input:last-child").val() + '</td>'+
							  '<td>' +  $(tr).find("td").eq(7).children("input:last-child").val()*$(tr).find("td").eq(4).text() + '</td>'+
							  '<td>'+
							  '</td>'+
							  '</tr>'
							).insertBefore( "#trInfos" );
							delRow (me);
							getTotal ();
						  }
					  });
			  }
			}
			
			
			
			}

	function getPoItems(me){
		$('#outstandingItems tbody').empty();
		 $.ajax({
		  type: "POST",
		  data: {
			  poId : $("#poList").val()
			  },
		  url: "<?php echo base_url() ?>receiveItems/getPoItemList",
		  success: function(data) {

			 var resul = eval ("(" + data + ")"); 
			 var n=resul.records.length;
			 var tcontent = "";
			 for (i=0;i<n;i++) {
				tcontent=tcontent + '<tr><td class="span1">' + resul.records[i].itemCode + '</td>' + 
				 		'<td class="span2">' + resul.records[i].itemName + '</td>' + 
						'<td class="span2">' + resul.records[i].description + '</td>' + 
						'<td class="span1">' + resul.records[i].unitPrice + '</td>' + 
						'<td class="span1">' + resul.records[i].quantityOrder + '</td>' + 
						'<td class="span1">' + (resul.records[i].unitPrice*resul.records[i].quantityOrder)  + '</td>' + 
						'<td class="span1">' + resul.records[i].quantityReceivedTotal + '</td>' + 
						'<td class="span1"><input placeholder="R.:' + (resul.records[i].quantityOrder-resul.records[i].quantityReceivedTotal)  +'" name="" class="span12 validate[required,custom[integer], min[1], max[' + (resul.records[i].quantityOrder-resul.records[i].quantityReceivedTotal) +'] ]" type="text"/></td>' + 
						'<td class="span1"><button type="button" onclick="saveItemReceiced(this)" data-poDetailsId="'+ resul.records[i].poDetailId  +'" class="btn btn-mini btn-primary"><i class="icon-ok icon-white"></i></button></td></tr>';
				
			}
			 
				$('#outstandingItems tbody').append(tcontent);
		  }
			
		 });	
	}
	
	function displayLocationAdress(){
		$("#locationAdress").text($("#location option:selected").attr("data-locationadress"));
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
				  $("#itemname").val(resul.description);
				  $("#itemdes").val(resul.name);
			  }else{
				  $("#itemdes").attr("placeholder",data);
				  $("#itemname").attr("placeholder",data);				  }
		  }
	   });
  }
  
  
  
  
  
  
  function saveItemReceiNoPo(me){
		 
	if ($("#receivedID").val()=="null"){ 
			//new 
			 if( $("#frmReceiveItem").validationEngine('validate')){
			 var tr = $(me).parent().parent();
			 var v =$(tr).find("td").eq(7).children("input:last-child").val();
				  $.ajax({
					  type: "POST",
					  data: {
						  
						  supplierID : $("#supplier").val(),
						  formNo : $("#formNo").val(),
						  deliveryDate : $("#createdDate").val(),
						  shippingMethodID : $("#shippingMethod").val(),
						  supplierDoNo : $("#supplierDoNumber").val(),
						  purchaseOrderID : $("#poList").val(),
						  locationID : $("#location").val(),
						  employeeID : $("#purchaseInvoiceId").val(),
						  memo : $("#memo").val(),

						  poDetailID : "-1",
						  itemCode : $("#itemcode").val(),
						  itemname : $("#itemname").val(),
						  quantityReceivedTotal : "0",
						  quantityOrder : "0",
						  description : $("#itemdes").val(),
						  quantityReceived : $("#itemqte").val(),
						  unitPrice : $("#itemunitprice").val(),
						  amount : $("#itemAmount").val()
				
						  },
					  url: "<?php echo base_url() ?>receiveItems/saveNewItemReceived",
					  success: function(data) {
						  var resul = eval ("(" + data + ")"); 
						   $("#receivedID").val(resul.receivedID);
						  $("#poList").attr('disabled','disabled');
						  $("#supplier").attr('disabled','disabled');
						  msg("alert alert-success","Data saved successfully !!!")
						  var tr = $(me).parent().parent();
						  $(''+
						   '<tr>' +
							  '<td>' +  $("#itemcode").val() + '</td>'+
							  '<td>' +  $("#itemname").val()  + '</td>'+
							  '<td>' +  $("#itemdes").val()  + '</td>'+
							  '<td>' +  $("#itemunitprice").val() + '</td>'+
							  '<td>' + $("#itemqte").val() + '</td>'+
							  '<td>' +  $("#itemAmount").val() + '</td>'+
							  '<td>'+
							  '</td>'+
							  '</tr>'
							).insertBefore( "#trInfos" );
							delRow (me);
							getTotal ();
						  }
					  });
			 }
			 
			 
			}else{
				// save detail only
				 var tr = $(me).parent().parent();
				$.ajax({
					type: "POST",
					data: {
						
						receiveID : $("#receivedID").val(),

						poDetailID : "-1",
						itemCode : $("#itemcode").val(),
						itemname : $("#itemname").val(),
						description : $("#itemdes").val(),
						quantityReceived : $("#itemqte").val(),
						quantityReceivedTotal : "0",
						unitPrice : $("#itemunitprice").val(),
						quantityOrder : "0",
						amount : $("#itemAmount").val()
						
			  
						},
					url: "<?php echo base_url() ?>receiveItems/saveNewItemDetailOnly",
					success: function(data) {
						var resul = eval ("(" + data + ")"); 
						 $("#receivedID").val(resul.receivedID);
						$("#poList").attr('disabled','disabled');
						$("#supplier").attr('disabled','disabled');
						msg("alert alert-success","Data saved successfully !!!")
						var tr = $(me).parent().parent();
						 $(''+
						   '<tr>' +
							  '<td>' +  $("#itemcode").val() + '</td>'+
							  '<td>' +  $("#itemname").val()  + '</td>'+
							  '<td>' +  $("#itemdes").val()  + '</td>'+
							  '<td>' +  $("#itemunitprice").val() + '</td>'+
							  '<td>' + $("#itemqte").val() + '</td>'+
							  '<td>' +  $("#itemAmount").val() + '</td>'+
							  '<td>'+
							  '</td>'+
							  '</tr>'
							).insertBefore( "#trInfos" );
						  delRow (me);
						  getTotal ();
						}
					});
			}
			
		
  }
  
  
  
  function editRow(me){
	var tr = $(me).parent().parent();
	var v =$(tr).find("td").eq(4).text();
	
  	if($(me).attr("data-poDetailID")>0){
		  $(tr).find("td").eq(4).empty();
		 $($(tr).find("td").eq(4)).append('<input class="input-mini" type="text" data-previewvalue="' + v + '" value="' + v + '" />');
		 $(tr).find("td").eq(6).empty();
		 $($(tr).find("td").eq(6)).append( '<button class="btn btn-mini btn-primary" style="margin-right:3px;" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" onclick="updateRow(this)" type="button"><i class="icon-ok"></i></button>'+
			  '<button id="btnCancel" class="btn btn-mini btn-warning" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" onclick="cancelEdit(this)" type="button"><i class="icon-remove-sign"></i></button>');
 	}else {
	  if (!$("#itemcode").length) {
	   $(''+
	   '<tr>' +
'<td class="span2" ><input type="text" id="itemcode" name="itemcode" onkeyup="getItemDetails(this);" onchange="getItemDetails(this);" data-source="<?php echo $itemCodes; ?>" data-previewvalue="' + $(tr).find("td").eq(0).text() + '" value="' + $(tr).find("td").eq(0).text() + '" data-provide="typeahead" class="span12"></td>'+
		  '<td class="span2"><input id="itemname" data-previewvalue="' + $(tr).find("td").eq(1).text() + '" value="' + $(tr).find("td").eq(1).text() + '" name="itemname"  type="text" class="span12 validate[required,maxSize[64]]" placeholder="Item Name"></td>'+
		  '<td class="span2"><input id="itemdes" data-previewvalue="' + $(tr).find("td").eq(2).text() + '" value="' + $(tr).find("td").eq(2).text() + '" name="itemdes" class="span12 validate[required]" type="text" placeholder="Description"></td>'+
		  '<td class="span1"><input id="itemunitprice" data-previewvalue="' + $(tr).find("td").eq(3).text() + '" value="' + $(tr).find("td").eq(3).text() + '" onkeyup="calculamountET()" name="itemunitprice" class="span12 validate[required,custom[number]]" type="text" placeholder="Unit Priece"></td>'+
		  '<td class="span1"><input id="itemqte" data-previewvalue="' + $(tr).find("td").eq(4).text() + '" value="' + $(tr).find("td").eq(4).text() + '" onkeyup="calculamountET()"  name="itemqte" class="span12 validate[required,custom[integer]]" type="text" placeholder="Qty"></td>'+
		  '<td class="span1"><input id="itemAmount" data-previewvalue="' + $(tr).find("td").eq(5).text() + '" value="' + $(tr).find("td").eq(5).text() + '" name="itemAmount" onkeydown="return false;" class="input-mini validate[required]" type="text" placeholder="Amount"></td>'+
		  '<td class="span1">'+
			  '<button class="btn btn-mini btn-primary" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" onclick="updateRow(this)" type="button"><i class="icon-ok"></i></button><button id="btnCancel" class="btn btn-mini btn-warning" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" onclick="cancelEdit(this)" type="button"><i class="icon-remove-sign"></i></button>'+
		  '</td>'+
	  '</tr>').insertBefore( "#trInfos" );
		delRow(me);
	  }else{
		  msg (1,"alert","Please, do save the current details before addind new one");
		  }
		
	}
  }
 
  
  function cancelEdit(me){
	  if ($(me).attr("data-poDetailID") <= 0){
		   $(''+
	   '<tr>' +
		  '<td>' +  $("#itemcode").attr("data-previewvalue") + '</td>'+
		  '<td>' + $("#itemname").attr("data-previewvalue") + '</td>'+
		  '<td>' + $("#itemdes").attr("data-previewvalue") + '</td>'+
		  '<td>' + $("#itemunitprice").attr("data-previewvalue") + '</td>'+
		  '<td>' + $("#itemqte").attr("data-previewvalue") + '</td>'+
		  '<td>' + $("#itemAmount").attr("data-previewvalue") + '</td>'+
		  '<td>'+
			 '<button style="margin-right:3px;" onClick="editRow(this)" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
             '<button onClick="deleteRow(this)" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>' +
		  '</td>'+
	  '</tr>').insertBefore( "#trInfos" );
		delRow(me);
		 getTotal ();
	  }else {
		  var tr = $(me).parent().parent();
		 var v =$(tr).find("td").eq(4).children("input:last-child").attr("data-previewvalue");
	  	 $(tr).find("td").eq(4).empty();
		 $(tr).find("td").eq(4).text(v);
		 $(tr).find("td").eq(6).empty();
		 $($(tr).find("td").eq(6)).append(  '<button style="margin-right:3px;" onClick="editRow(this)" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
             '<button onClick="deleteRow(this)" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>');
	  }
  
  }
  
   function deleteRow(){
	 
  }
  
  function updateRow(me){
  	if ($(me).attr("data-poDetailID") <= 0){
		if( $("#frmReceiveItemNoPo").validationEngine('validate')){
			var tr = $(me).parent().parent();
				$.ajax({
					type: "POST",
					data: {
						
						itemReceivedID : $(me).attr("data-myid"),
						option: "noPo",
						itemCode : $("#itemcode").val(),
						itemname : $("#itemname").val(),
						description : $("#itemdes").val(),
						quantityReceived : $("#itemqte").val(),
						unitPrice : $("#itemunitprice").val(),
						amount : $("#itemAmount").val()
			  
						},
					 url: "<?php echo base_url() ?>receiveItems/updateReceiveItemDetail",
					 success: function(data) {
						var tr = $(me).parent().parent();
						 $(''+
						   '<tr>' +
							  '<td>' +  $("#itemcode").val() + '</td>'+
							  '<td>' +  $("#itemname").val()  + '</td>'+
							  '<td>' +  $("#itemdes").val()  + '</td>'+
							  '<td>' +  $("#itemunitprice").val() + '</td>'+
							  '<td>' + $("#itemqte").val() + '</td>'+
							  '<td>' +  $("#itemAmount").val() + '</td>'+
							  '<td>'+
							  '<button style="margin-right:3px;" onClick="editRow(this)" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
             '<button onClick="deleteRow(this)" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>' +
							  '</td>'+
							  '</tr>'
							).insertBefore( "#trInfos" );
						  delRow (me);
						  getTotal ();
						}
					});
		}
	}else {
		var tr = $(me).parent().parent();
		var v =$(tr).find("td").eq(4).children("input:last-child").attr("data-previewvalue");
		var v1 =$(tr).find("td").eq(4).children("input:last-child").val();
		
		$.ajax({
			type: "POST",
			data: {
				itemReceivedID : $(me).attr("data-myid"),
				poDetailID : $(me).attr("data-poDetailID"),
				qtyPoUpdate : v-v1,
				option: "Po",
				quantityReceived : v1
	  
				},
			 url: "<?php echo base_url() ?>receiveItems/updateReceiveItemDetail",
			 success: function(data) {
				var tr = $(me).parent().parent();
				 var tr = $(me).parent().parent();
				 var v =$(tr).find("td").eq(4).children("input:last-child").val();
				 $(tr).find("td").eq(4).empty();
				 $(tr).find("td").eq(4).text(v);
				 $(tr).find("td").eq(6).empty();
				 $($(tr).find("td").eq(6)).append(  '<button style="margin-right:3px;" onClick="editRow(this)" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
					 '<button onClick="deleteRow(this)" data-poDetailID="' + $(me).attr("data-poDetailID") + '" data-myid="' + $(me).attr("data-myid") + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>');
				}
			});
	}
  }
  
  function calculamountET(){
  	$("#itemAmount").val($("#itemunitprice").val()*$("#itemqte").val());
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
                <li class="active"><?php echo $this->lang->line('titlepo_received') ?></li>
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
			<strong><?php echo $this->lang->line('titlepo_received') ?></strong>
		</div>
	</div>
    
    <?php
   if ($receivItems){	
     	$Purchaser = "";
		 $memo = ""; 
		 $shippingmetod ="";
	 foreach($receivItems as $rowIn){
		 $Purchaser = $rowIn->employeeName;
		 $memo = $rowIn->memo;
		 $shippingmetod =$rowIn->shipping;
	?>    
    
	<div class="row-fluid scRow">                            
	  <div class="span4 scCol">
		<div class="block" id="grid_block_1">
        
          <div class="content">
          
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('formNo')?></div>
              <div class="span7">
         		<span class="uneditable-input input-medium"><?php echo $rowIn->reFormNo; ?></span>
              </div>
          </div> <!-- row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('date') ?></div>
         		<div class="span7">
              	 <span class="uneditable-input input-medium"><?php echo $rowIn->deliveryDate; ?></span>
                </div>
          </div> <!-- row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('supplierDoNumber') ?></div>
         	<div class="span7">
				<span class="uneditable-input input-medium"><?php echo $rowIn->supplierDoNo; ?></span>
            </div><!-- span -->
          </div> <!-- row -->
          
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
      
	 
	   <div class="span4 scCol">
		<div class="block" id="grid_block_3">
          <div class="content">
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('supplier') ?></div>
         		<div class="span7">
                 <span class="uneditable-input input-medium"><?php echo $rowIn->supplierName; ?></span>
              </div>
         	</div> <!-- row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('currency') ?></div>
         	<div class="span8">
				<span class="uneditable-input input-medium"><?php echo $rowIn->exchangeRate ; ?></span>            
            </div><!-- span -->
           </div><!-- control row -->
           
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('exchangeRate') ?></div>
         	<div class="span8">
				<span class="uneditable-input input-medium"><?php echo $rowIn->currencyWord; ?></span>
            </div><!-- span -->
            </div><!-- control row -->
          </div><!-- content -->
          
        </div><!-- grid block 1-->
      </div><!-- scCol -->


 <div class="span4 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
       		   <div class="controls-row">
          	 <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('poList')?></div>
         	<div class="span7">
            	<span class="uneditable-input input-medium"><?php echo $rowIn->poFormNo; ?></span>
            </div><!-- span -->
            
          </div><!-- row control -->
          
        	  <div class="controls-row">
       		   	<div class="span3"><?php echo $this->lang->line('location') ?></div>
         		<div class="span7">
            	 <span class="uneditable-input input-medium"><?php echo $rowIn->state; ?></span>
              </div>
            </div> <!-- control -->
            
           	 <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('address') ?></div>
         	  <div class="span8">
                   <span class="uneditable-input input-medium"><?php echo $rowIn->address; ?></span>
               
            </div><!-- span -->
            </div><!-- row control -->
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
      
    </div><!-- row-fluid scRow-->
    
    <?php }
	}else {
	?>
   <div class="alert alert-error">
   	Recieve Items Not found or uneditable !!!
	</div>
	
	<?php }?>
	
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
	       <div class="head">
                     <h2><?php echo $this->lang->line('PoReceivedItems')?></h2>
                 	<ul class="buttons">
                    	<li><a class="block_toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                        	<span class="i-arrow-down-3"></span></a></li>
                    </ul>                                        
             	 </div><!-- head -->
                 
               <div class="content np">
                <?php if($receiveItemsDetails){ ?>
   				<table id="t_listItemOrdered" cellpadding="0" cellspacing="0" width="100%">
            	<thead>
                	<tr>
                        <th><?php echo $this->lang->line('itemCode')?></th>
                        <th><?php echo $this->lang->line('itemName')?></th>
                        <th><?php echo $this->lang->line('itemDesc')?></th>
                        <th><?php echo $this->lang->line('unitPrice')?></th>
                        <th><?php echo $this->lang->line('qtyReceive')?></th>
                        <th><?php echo $this->lang->line('amount')?></th>
                        <th><?php echo $this->lang->line('action')?></th>
                    </tr>
                </thead>
                <tbody>
               
				<?php 
				 $totalpayable =0;
				 foreach ($receiveItemsDetails as $row){
					  if ($row->poDetailID > 0){
				?>
                <tr>
                        <td><?php echo $row->itemCode ?></td>
                        <td><?php echo $row->itemName ?></td>
                        <td><?php echo $row->description ?></td>
                        <td><?php echo $row->unitPrice ?></td>
                        <td><?php echo $row->quantityReceived ?></td>
                        <td><?php echo $row->amount ?></td>
                        <td>
							<button onClick="editRow(this)" data-poDetailID="<?php echo $row->poDetailID?>" data-myid="<?php echo $row->ID; ?>" class="btn btn-mini"><i class="icon-pencil"></i></button>
                         <button onClick="deleteRow(this)" data-poDetailID="<?php echo $row->poDetailID?>" data-myid="<?php echo $row->ID; ?>" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>
                        </td>
                    </tr>
                    <?php  } }?>
                
              <tr id="trInfos1">
                  <td colspan="7">
                      <div id="msg_div1" class="alert alert-info">
                        <h4><?php echo $this->lang->line('lastMessage')?></h4>
                        <p style="padding-top:10px;"><?php echo $this->lang->line('noMessage')?></p>
                    </div>
                </td>
       	     </tr>
                </tbody>
            </table> 
            <?php 
			  }else {
			  ?>
			 <div class="span12 alert alert-error">
			  No items found !!!
			  </div>
			  
			  <?php }?>  
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
    
    
    
    
    
    
    <div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
	       <div class="head">
                     <h2><?php echo $this->lang->line('receivedItemsNoPo')?></h2>
                 	<ul class="buttons">
                    	<li><a class="block_toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                        	<span class="i-arrow-down-3"></span></a></li>
                    </ul>                                        
             	 </div><!-- head -->
                 
               <div class="content np">
           <form id="frmReceiveItemNoPo" action="#"> 
                <?php if($receiveItemsDetails){ ?>
   				<table id="t_listItemOrdered1" cellpadding="0" cellspacing="0" width="100%">
            	<thead>
                	<tr>
                        <th><?php echo $this->lang->line('itemCode')?></th>
                        <th><?php echo $this->lang->line('itemName')?></th>
                        <th><?php echo $this->lang->line('itemDesc')?></th>
                        <th><?php echo $this->lang->line('unitPrice')?></th>
                        <th><?php echo $this->lang->line('qtyReceive')?></th>
                        <th><?php echo $this->lang->line('amount')?></th>
                        <th><?php echo $this->lang->line('action')?></th>
                    </tr>
                </thead>
                <tbody>
               
				<?php 
				 $totalpayable =0;
				 foreach ($receiveItemsDetails as $row){
					 $totalpayable =$totalpayable + $row->amount;
					 if ($row->poDetailID <= 0){
				?>
                <tr>
                        <td><?php echo $row->itemCode ?></td>
                        <td><?php echo $row->itemName ?></td>
                        <td><?php echo $row->description ?></td>
                        <td><?php echo $row->unitPrice ?></td>
                        <td><?php echo $row->quantityReceived ?></td>
                        <td><?php echo $row->amount ?></td>
                        <td>
							<button onClick="editRow(this)" data-poDetailID="<?php echo $row->poDetailID?>" data-myid="<?php echo $row->ID; ?>" class="btn btn-mini"><i class="icon-pencil"></i></button>
                         <button onClick="deleteRow(this)" data-poDetailID="<?php echo $row->poDetailID?>" data-myid="<?php echo $row->ID; ?>" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>
                        </td>
                    </tr>
                    <?php } }?>
                
              <tr id="trInfos">
                  <td colspan="7">
                      <div id="msg_div1" class="alert alert-info">
                        <h4><?php echo $this->lang->line('lastMessage')?></h4>
                        <p style="padding-top:10px;"><?php echo $this->lang->line('noMessage')?></p>
                    </div>
                </td>
       	     </tr>
                </tbody>
            </table> 
            <?php 
			  }else {
			  ?>
			 <div class="span12 alert alert-error">
			  No items found !!!
			  </div>
			  
			  <?php }?>
            </form>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
    
    
    
    
    <?php
   		if ($receivItems){	?>
	<div class="row-fluid scRow">
      <div class="span7 scCol">
		<div class="block" id="grid_block_4">
          <div class="content np">
          
                <div class="controls-row">
                       <div class="span3"><?php echo $this->lang->line('purchaser') ?></div>
                        <div class="span8">
                             <span class="uneditable-input input-medium"><?php echo $Purchaser; ?></span>
                         </div>
                  </div><!-- row control -->
                  
                   <div class="controls-row">
                      <div class="span3"><?php echo $this->lang->line('memo') ?></div>
                      <div class="span8">
                             <textarea style="height: 75px;" id="memo" class="span12"><?php echo $memo; ?></textarea>
                      </div><!-- span -->
                   </div><!-- row control -->
                 
              </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->
                               
	  <div class="span5 scCol">
		<div class="block" id="grid_block_4">
             <div class="content np">     
         	     <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('shippingmethod')?></div>
         	<div class="span8">
            	<span class="uneditable-input input-medium"><?php echo $shippingmetod; ?></span>
            </div><!-- span -->
            
          </div><!-- row control -->
                  
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('totalPayable')?></div>
                      <div class="span8">
                          <input id="totalpayable" disabled="disabled"  class="input-small" type="text" value="<?php echo $totalpayable; ?>">
                      </div>
                  </div><!-- row control -->
           </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
      <?php }?>
</div><!-- grid 1 -->
</div><!-- wrap -->
</div><!-- content -->

                    
                    
   