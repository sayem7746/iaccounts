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
						url: "<?php echo base_url() ?>itemsetup/getItemDetails",
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
                        '<td class="span1">'+
						'<button data-myid="' + $(me).attr("data-myid") +'" onclick="updateRow(this)" class="btn btn-mini btn-primary" type="button">Update</button>'+
						'<button data-myid="' + $(me).attr("data-myid") +'"  id="btnCancel"  onclick="cancelEdit(this)" data-taxid="' + $(me).attr("data-taxid") + '"   class="btn btn-mini" type="button">Cancel</button></td>'+
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
                         '<td>'+
						'<button data-myid="' + $(me).attr("data-myid") +'" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
                         ' <button my-myid="' + dID + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfos" );
					  delRowInvoice(me);
					   getTotal ();
					 }
					 
				  function cancelEdit(me){
					 
					 	 $(''+
					 '<tr>' +
						'<td>' +  $("#itemcode").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemname").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemdes").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemunitprice").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemqte").attr("data-previewvalue") + '</td>'+
                        '<td>' + $("#itemAmountET").attr("data-previewvalue") + '</td>'+
                        '<td>'+
						'<button onClick="editRow(this)" data-myid="' + $(me).attr("data-myid")  +'" class="btn btn-mini"><i class="icon-pencil"></i></button>' +
                         ' <button onclick="deletePoDetails()" data-myid="' +  $(me).attr("data-myid") + '" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfos" );
					  delRowInvoice(me);
					   getTotal ();
					 }
					 
				function getTotal (){
					
						 var n =$("#listDetails > tbody > tr").length - 2;
						
						 var total = 0;
						 var i = 0;
						 for (i=0; i<=n; i++) {
							 
								total= total + $('#listDetails > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
								
						 }
					
						
						$("#totalpayable").val(total);
					}
	     
		 function updateRow(me){
			// alert($(me).attr("data-myid"));
		 	$.ajax({
				type: "POST",
				data: {
					  poID :$(me).attr("data-myid"),
					  itemCode:  $("#itemcode").val(),
					  itemname : $("#itemname").val(), 
					  itemdescription: $("#itemdes").val(),
					  quantity : $("#itemqte").val(),
					  unitPrice: $("#itemunitprice").val()
					  
					},
				url: "<?php echo base_url() ?>PO_Transaction/updatePoDetail",
				success: function(data) {
				       msg (1,"alert alert-success","Details successfully updated");
					   EndEdit(me);
					} });
					 getTotal();
					
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
			  
			  function deletePoDetails(me){
				  
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
							url: "<?php echo base_url() ?>PO_Transaction/deletePoRow",
							success: function(data) {
								   msg (1,"alert alert-success","Details successfully deleted");
									delRowInvoice(me);
								}
						   });
			   			 getTotal();
					
			});
				  
				  
				  
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
					  url: "<?php echo base_url() ?>PO_Transaction/deleteCharge",
						  success: function(data) {
							 msg (1,"alert alert-success","Details successfully deleted");
							  delRowInvoice(me);
							  getTotal();
							  $.ajax({
								type: "POST",
								data: {
									  invoiceId : $("#PO_TransactionId").val(),
									  totalPayable : $("#totalpayable").val(), 
									  totalTaxAmount :  $("#totalamount").val()
									},
								url: "<?php echo base_url() ?>PO_Transaction/updateInvoice",
								success: function(data) {
									 //update the invoice after delete
									}
								});
						  } });
						 
						  });
				  			 getTotal ();
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
                <li class="active"><?php echo $this->lang->line('titlepo') ?></li>
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
			<strong><?php echo $this->lang->line('titlepo') ?></strong>
		</div>
	</div>
 <?php
   if ($pInvoice){	 
	 foreach($pInvoice as $rowIn){
	?> 
    <input type="hidden" id="poID" value="<?php echo $rowIn->termAndConditionID; ?>" />
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
               <span class="uneditable-input input-medium"><?php echo $rowIn->poDate; ?></span>
         	</div>
         </div> <!-- row -->
         
        </div><!-- content -->
       </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
          	
           
           <div class="controls-row">
         	 <div class="span3"><?php echo $this->lang->line('terms') ?></div>
         	   <div class="span8">
                <span class="uneditable-input input-medium"><?php  echo $rowIn->termName; ?></span>
         	</div>
           </div> <!-- row -->
           
            <div class="controls-row">
         		<div class="span3"><?php echo $this->lang->line('termsdesc') ?></div>
         		<div class="span8">
               		 <textarea class="input-medium" disabled="disabled" id="termDescription" style="height: 66px; width: 153px;">
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
                        	<th><?php echo $this->lang->line('amount') ?></th>
                            <th><?php echo $this->lang->line('action') ?></th>
                    		</tr>
                		</thead>
                		<tbody>
                        	        <?php
				 $t_taxAmount=0;
				 if($pdetails) {
				 foreach($pdetails as $row){
						 $t_taxAmount+= $row->total;
					 ?>
                     <tr>
                    	<td><?php echo $row->itemCode;?></td>
                        <td><?php echo $row->itemName; ?></td>
                        <td><?php echo $row->description; ?></td>
                        <td><?php echo $row->unitPrice; ?></td>
                        <td><?php echo $row->quantityOrder; ?></td>
                        <td><?php echo $row->total; ?></td>
                        <td>
                         <button onClick="editRow(this)" data-myid="<?php echo $row->ID; ?>" class="btn btn-mini"><i class="icon-pencil"></i></button>
                         <button onClick="deletePoRow(this)" data-myid="<?php echo $row->ID; ?>" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></button>
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
          <div class="content np">
                 
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('totalPayable'); ?></div>
                      <div class="span8">
                          <input value="<?php echo $t_taxAmount; ?>" id="totalpayable" disabled="disabled"  class="input-small" type="text" placeholder="0">
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
                    
                    
   