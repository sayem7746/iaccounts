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
	 
	 var total1 =0;
	 var n1 =$("#t_listItemNoPo > tbody > tr").length-1;
	 for (i=0; i<=n1; i++) {
			total1= total1 + $('#t_listItemNoPo > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
	 }
  
 	 $("#totalpayable").val(total+total1);
	
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
                    '</tr>'
					  ).insertBefore( "#trInfos" );
					
					
 
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
						  shippingMethodID : $("#shippingmethod").val(),
						  supplierDoNo : $("#supplierDoNumber").val(),
						  purchaseOrderID : $("#poList").val(),
						  locationID : $("#location").val(),
						  employeeID : $("#purchaser").val(),
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
							).insertBefore( "#trInfos1" );
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
							).insertBefore( "#trInfos1" );
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
    <form id="frmReceive" action="#"> 
	<div class="row-fluid scRow">                            
	  <div class="span4 scCol">
		<div class="block" id="grid_block_1">
        
          <div class="content">
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('supplier') ?></div>
         	<div class="span8">
                 <div class="input-append">
    
    			
                <input type="hidden" id="receivedID" value="null"/>
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
         	<div class="span3"><?php echo $this->lang->line('supplierDoNumber') ?></div>
         	<div class="span9">
				<input id="supplierDoNumber" class="span12 validate[required]" type="text" placeholder="Supplier Invoice Number">
            </div><!-- span -->
          </div> <!-- row -->
          
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
          <div class="controls-row">
          	 <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('poList')?></div>
         	<div class="span8">
            	<div class="span12 input-append">
                <select id="poList" onchange="getPoItems(this)" class="span11 validate[required]">
				  <option></option>
                </select>
               
                </div><!-- append -->
            </div><!-- span -->
            
          </div><!-- row control -->
          <div class="controls-row">
       		   	<div class="span3"><?php echo $this->lang->line('location') ?></div>
         	<div class="span8">
            	 <div class="span12 input-append">
            	<select onchange="displayLocationAdress()" class="span11 validate[required]" id="location">
				  <option></option>
                   <?php
					if($location != ''){
				 		foreach($location as $row){
					 ?>
                     <option data-locationadress="<?php  echo $row->address; ?>" value="<?php  echo $row->fldid; ?>">
					 <?php echo $row->code." | ".$row->city ; ?></option>
			    <?php }} ?>
                </select>
                <div class="span1 btn-group">
            	 <button class="btn btn-min btn-primary dropdown-toggle" data-toggle="dropdown">
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
            </div> <!-- control -->
            
            <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('address') ?></div>
         	<div class="span8">
                   <textarea style="height: 75px;" disabled="disabled"ssss id="locationAdress" class="span12"></textarea>
            </div><!-- span -->
            </div><!-- row control -->
          </div>
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_3">
          <div class="content">
          
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('currency') ?></div>
         	<div class="span8">
				<input id="currency" name="currency" type="text" placeholder="Currency" disabled class="input-medium validate[required,minSize[5],maxSize[10]]">            
            </div><!-- span -->
            </div><!-- control row -->
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('exchangeRate') ?></div>
         	<div class="span8">
				<input disabled class="input-medium" id="exchange_rate" name="exchange_rate" type="text" placeholder="Example: 3.2" >           
            </div><!-- span -->
            </div><!-- control row -->
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
    </form>
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
	       <div class="head">
           	<h2><?php echo $this->lang->line('outstandingPo')?></h2>
           	<ul class="buttons">
            	<li><a class="block_toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                        	<span class="i-arrow-down-3"></span></a></li>
          	</ul>                                        
          </div><!-- head -->
          <div class="content np">
   				  <table id="outstandingItems" cellpadding="0" cellspacing="0" width="100%">
            			<thead>
                			<tr>
                       	 	<th><?php echo $this->lang->line('itemCode')?></th>
                        	<th><?php echo $this->lang->line('itemName')?></th>
                        	<th><?php echo $this->lang->line('itemDesc')?></th>
                        	<th><?php echo $this->lang->line('unitPrice')?></th>
                        	<th><?php echo $this->lang->line('qtyOrder')?></th>
                            <th><?php echo $this->lang->line('amount')?></th>
                            <th><?php echo $this->lang->line('totalQtyReceive')?></th>
                        	<th><?php echo $this->lang->line('qtyReceive')?></th>
                        	<th><?php echo $this->lang->line('action')?></th>
                    		</tr>
                		</thead>
                		<tbody>
                			
               		</tbody>
           		  </table>
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                    <button style="margin-right:6px;" onclick="$('#parchaseDetailForm').validationEngine('hide');" class="btn btn-mini" type="button" name="validat">Hide prompts</button>
                    
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
                     <h2><?php echo $this->lang->line('receivedItems')?></h2>
                 	<ul class="buttons">
                    	<li><a class="block_toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                        	<span class="i-arrow-down-3"></span></a></li>
                    </ul>                                        
             	 </div><!-- head -->
          <div class="content np">
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
          </div><!-- content -->

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
           <form id="frmReceiveItem" action="#"> 
   				<table id="t_listItemNoPo" cellpadding="0" cellspacing="0" width="100%">
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
            </form>
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                    <button id="addRow" onclick="addNewRowWithoutPo()" class="btn btn-mini btn-primary" type="button">
                        <i class="icon-plus-sign icon-white"></i><?php echo $this->lang->line('addNewItem')?></button>
                    
       				</div><!-- btn group -->      
       			</div><!-- side fr -->      
       		</div><!-- footer -->      
          </div><!-- content -->

        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
    
    
	<div class="row-fluid scRow">
      <div class="span6 scCol">
		<div class="block" id="grid_block_4">
          <div class="content np">
                      <div class="controls-row">
                             <div class="span3"><?php echo $this->lang->line('purchaser') ?></div>
                              <div class="span8">
                                   <div class="input-append">
                      
                                  
                                  <input type="hidden" id="purchaseInvoiceId" value="null"/>
                                  <select class="input-medium validate[required]" id="purchaser">
                                   <option></option>
                                  <?php
                                  if($purchaser != ''){
                                   foreach($purchaser as $row){
                                       ?>
                                       <option value="<?php echo $row->ID; ?>"> <?php echo $row->employeeName; ?></option>
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
       <div class="span1 scCol">
       </div>                           
	  <div class="span5 scCol">
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
                    <div class="span3"><?php echo $this->lang->line('totalPayable')?></div>
                      <div class="span8">
                          <input id="totalpayable" disabled="disabled"  class="input-small" type="text" placeholder="0">
                      </div>
                  </div><!-- row control -->
              </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
</div><!-- grid 1 -->
</div><!-- wrap -->
</div><!-- content -->

                    
                    
   