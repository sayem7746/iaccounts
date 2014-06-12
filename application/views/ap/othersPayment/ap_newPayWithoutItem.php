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
#content .wrap #grid_content_1 .row-fluid.scRow .row-fluid.scRow .span12.scCol #grid_block_6 .content.np #listCharge tbody #trInfos td .row-fluid .controls-row .span3 {
	font-weight: bold;
}
</style>
<script type="application/javascript">
			
//$(document).ready(function(){
//	$('select').select2();
//});

			  $( document ).ready(function() {
				  $("#amountpaid").dblclick(function() {
					  $(this).val($("#totalpaid").val());
				  });
			  });

			   
				
				
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
				
	
		 function savePayment(me){
				
				if ($("#itemcode").attr("itemID")=="")
					$("#itemname").val("");
				 if( $("#paymentDetail").validationEngine('validate')){
					if ( $("#paymentId").val()=="null"){
						getTotal();
						$.ajax({
						type: "POST",
						data: {
							
								memo : $("#memo").val(),
								payto : $("#payto").val(),
								locationID : $("#location").val(), 
								paymentMethodID : $("#paymentmethood").val(), 
								amountPaid : $("#amountpaid").val(), 
								formNo :  $("#formNo").val(),
								paymentDate : $("#createdDate").val(),
								referenceNo: $("#createdDate").val(),
								accountDescription : $("#accdes").val(),
								accountID : $("#chargeAccount").val(),
								projectID : $("#project").val(),
			
								amountIncludedTax : $("#amountIT").val(),
								itemAccountID : $("#accountID").val(),
								itemdescription: $("#itemDesc").val(),
								amountExcludedTax: $("#amountExcludedTax").val(),
								taxAmount : $("#taxAmount").val(),
								taxID: $("#listTax ").val(),
								taxRate: $("#listTax option:selected").attr("data-tax")
							  
							},
						 url: "<?php echo base_url() ?>OthersPayment/savenewpaywithOutItem",
						 success: function(data) {
					 	 var resul = eval ("(" + data + ")"); 
						  $("#paymentId").val(resul.paymentID);
						  $(''+
						   '<tr>' +
							  '<td>' +  $("#accountID option:selected").text() + '</td>'+
							  '<td>' + $("#itemDesc").val() + '</td>'+
							  '<td>' + $("#amountExcludedTax").val() + '</td>'+
							  '<td>' + $("#listTax option:selected").attr("data-tax") + ' | ' + $("#listTax option:selected").attr("data-taxcode") + '</td>'+
							  '<td>' + $("#taxAmount").val() + '</td>'+
							  '<td>' + $("#amountIT").val() + '</td>'+
							  '<td>' +
							  '</td>'+
						    '</tr>'
							).insertBefore( "#trInfos" );
							$("#btnCancel").trigger("click");
							getTotal();
					        msg (1,"alert alert-success","Details successfully saved");
						} //end function
   					 });//end ajax
					}else{ //savedetailonly
						$.ajax({
						type: "POST",
						data: {
							  otherPaymentID : $("#paymentId").val(),
							  
								amountIncludedTax : $("#amountIT").val(),
								itemAccountID : $("#accountID").val(),
								itemdescription: $("#itemDesc").val(),
								amountExcludedTax: $("#amountExcludedTax").val(),
								taxAmount : $("#taxAmount").val(),
								taxID: $("#listTax").val(),
								taxRate: $("#listTax option:selected").attr("data-tax")
							  
							},
						url: "<?php echo base_url() ?>OthersPayment/savenewpaywithoutItemDetailOnly",
						success: function(data) {
						 msg (1,"alert alert-success","Details successfully saved");
					 	  var resul = eval ("(" + data + ")"); 
					   $(''+
						 '<tr>' +
						 	  '<td>' +  $("#accountID option:selected").text() + '</td>'+
							  '<td>' + $("#itemDesc").val() + '</td>'+
							  '<td>' + $("#amountExcludedTax").val() + '</td>'+
							  '<td>' + $("#listTax option:selected").attr("data-tax") + ' | ' + $("#listTax option:selected").attr("data-taxcode") + '</td>'+
							  '<td>' + $("#taxAmount").val() + '</td>'+
							  '<td>' + $("#amountIT").val() + '</td>'+
							  '<td>' +
							  '</td>'+
						'</tr>'
					    ).insertBefore( "#trInfos" );
					   	$("#btnCancel").trigger("click");
						getTotal();
						msg (1,"alert alert-success","Details successfully saved");
					   }
   					 }); //end ajax
					} //end if data valide
					}else {
						msg (1,"alert alert-error", "Data incorrect or invalid ...");
					}
				}
				 
				
				
			
			
function addRow(){
	if (!$("#accountID").length) {
					 $(''+
					 '<tr>' +
							'<td class="span2"> <select name="accountID" id="accountID" class="span12" validate[required]"><option></option>' +
									 <?php
				if($chargeAccount){
				 foreach($chargeAccount as $row){
					 ?>
                     '<option value="<?php echo $row->ID; ?>"><?php echo $row->acctCode." | "; echo str_replace("'", " ",$row->acctName, $count); ?></option>'+
			    <?php }} ?>
							 '</select></td>'+
													'<td class="span4"><input  id="itemDesc" name="itemDesc"  type="text" class="span12 validate[required]" placeholder="Description"></td>'+
													'<td class="span1"><input id="amountExcludedTax" onkeyup="calculAmount()" name="amountExcludedTax" class="span12 validate[required, custom[number]]" type="text" placeholder="Amount"></td>'+
													'<td class="span2"><select onchange="calculAmount()" name="listTax" id="listTax"  class= "span12 validate[required]"><option></option>' +
									 <?php if($taxmaster){
					 foreach($taxmaster as $row2){
					 ?>
                     '<option value="<?php echo $row2->ID; ?>" data-taxcode ="<?php echo $row2->code; ?>" data-tax="<?php echo $row2->taxPercentage; ?>">' + 
					 '<?php echo $row2->code." | ".$row2->taxPercentage." | "; echo str_replace("'", " ",$row2->name, $count); ?></option>'+
			    <?php }} ?>
							 '</select></td>'+
													'<td class="span1"><input id="taxAmount" disabled name="taxAmount" class="span12" type="text" placeholder="Amount"></td>'+
													'<td class="span1"><input disabled  id="amountIT" name="amountIT" class="span12" type="text" placeholder="Amount (Exclude Tax)"></td>'+
						'<td class="span1">'+
						 	'<button onclick = "savePayment()" class="btn btn-mini btn-primary" type="button"><i class="icon-ok"></i></button>'+
						 	'<button onclick="delRow(this)" id="btnCancel" class="btn btn-mini btn-warning" type="button"><i class="icon-remove"></i></button>'+
						'</td>'+
                    '</tr>'
					  ).insertBefore( "#trInfos" );
					
					//$('select').select2();
 
					}else{
						msg (2,"alert","Please, do save the current details before addind new one");
						}
}
  

  function getTotal (){
	  
	 $("#totalamount").val("");
  
	$("#impotpayable").val("");
  
	$("#totalpayable").val("");
	 var n =$("#paymentDetails > tbody > tr").length-1;
	 var totalAmount =0;
	 var impot = 0;
	 var total = 0;
	 for (i=0; i<=n; i++) {
			totalAmount= totalAmount + $('#paymentDetails > tbody > tr:eq(' + i + ') > td:eq(2)').text()*1; 
			impot= impot + $('#paymentDetails > tbody > tr:eq(' + i + ') > td:eq(4)').text() *1; 
			total= total + $('#paymentDetails > tbody > tr:eq(' + i + ') > td:eq(5)').text()*1; 
	 }
	
	
	
	 $("#totalallocated").val(totalAmount);
  
	$("#totaltaxamount").val(impot);
  
	$("#totalpaid").val(total);
	
	$("#outofbalance").val(total-impot-totalAmount);
	
  }
					
					
function msg(n,type, message){
	
	$("#msg_div"+n +" p").html(message);
	$("#msg_div"+n).attr("class","alert " + type);
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

function refreshPayMethod(){
	$.ajax({
	type: "POST",
	url: "<?php echo base_url() ?>OthersPayment/refreshPayMethod",
	success: function(data) {
	
	   var resul = eval ("(" + data + ")"); 
	   var n=resul.records.length;
	   var i=0;
	   var opt='' +
		'<option></option>';
		for (i=0;i<n;i++)
			opt=opt + '<option value="' + resul.records[i].id +'">' + resul.records[i].name + '</option>';
		$('#paymentmethood').empty();
		$('#paymentmethood').append(opt);
	}
   });	
}


	function calculAmount(){
		var am = $("#listTax option:selected").attr("data-tax")*$("#amountExcludedTax").val()/100;
		 $("#taxAmount").val("0");
	 	 $("#amountIT").val("0");
		 if  (!isNaN(am)){
			$("#taxAmount").val(am);
			$("#amountIT").val(am*1 + 1*$("#amountExcludedTax").val());
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
                <li class="active"><?php echo $this->lang->line('titlewithout') ?></li>
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
<form id="paymentDetail" action="#">
<input type="hidden" name="paymentId" id="paymentId" value="null" />   
	<div class="row-fluid">
		<div class="alert alert-info">
			<strong><?php echo $this->lang->line('titlewithout') ?></strong>
		</div>
	</div>
	<div class="row-fluid scRow">                            
	  <div class="span4 scCol">
		<div class="block" id="grid_block_1">
          <div class="content">
              <div class="controls-row">
                <div class="span3"><?php echo $this->lang->line('payto') ?></div>
                <div class="span9">
                   <textarea id="payto" class="span12 validate[required]" placeholder="<?php echo $this->lang->line('payto') ?>"></textarea>
                </div><!-- span -->
              </div> <!-- row -->
              
         	
          <div class="controls-row">
          	<div class="span3"><?php echo $this->lang->line('paymentmethood') ?></div>
         	<div class="span8">
            	 <div class="input-append span12">
            	<select class="span11 validate[required]" id="paymentmethood">
				  <option></option>
                   <?php
					if($paymentmethod != ''){
				 		foreach($paymentmethod as $row){
					 ?>
                     <option value="<?php  echo $row->ID; ?>"><?php echo $row->name?></option>
			    <?php }} ?>
                </select>
                <div class="btn-group span1">
            	 <button class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                        <!-- dropdown menu links -->
                        <li><a target="_blank" href="<?php echo base_url() ?>setting/masterCodeSetup"  id="btnLocation">
                        <i class="icon-plus-sign"></i><?php echo $this->lang->line('addpaymethod')?></a></li>
                        <li><a href="#" onclick="refreshPayMethod()"><i class="icon-refresh"></i><?php echo $this->lang->line('refreshlist')?></a></li>
                   </ul>
            </div>
          </div> <!-- btnn group -->
                </div>
            </div>
            
                 <div class="controls-row">
          	<div class="span3"><?php echo $this->lang->line('location') ?></div>
         	<div class="span8">
            	 <div class="input-append span12">
            	<select class="span11 validate[required]" id="location">
				  <option></option>
                   <?php
					if($location != ''){
				 		foreach($location as $row){
					 ?>
                     <option value="<?php  echo $row->fldid; ?>"><?php echo $row->city." | ".$row->address;?></option>
			    <?php }} ?>
                </select>
                <div class="btn-group span1">
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
            
            
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
          	<div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('amountpaid') ?></div>
         	<div class="span9">
				<input id="amountpaid" class="span12 validate[required]" type="text" placeholder="0.00">
            </div><!-- span -->
          </div> <!-- row -->
          
          
            
            	<div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('refno') ?></div>
         	<div class="span9">
				<input id="amountpaid" class="span12 validate[required]" type="text" placeholder="Ref no">
            </div><!-- span -->
          </div> <!-- row -->
          
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('accountdescription') ?></div>
         	<div class="span9">
				<textarea id="accdes" class="span12" placeholder="..." ></textarea>
            </div><!-- span -->
          </div> <!-- row -->
            
         
            
         
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
	  <div class="span4 scCol">
		<div class="block" id="grid_block_3">
          <div class="content">
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('account') ?></div>
         	<div class="span9">
    			<select name="chargeAccount" id="chargeAccount" class="span12" validate[required]"><option></option>' +
									 <?php
				if($chargeAccount){
				 foreach($chargeAccount as $row){
					 ?>
                     '<option value="<?php echo $row->ID; ?>"><?php echo $row->acctCode." | "; echo str_replace("'", " ",$row->acctName, $count); ?></option>'+
			    <?php }} ?>
                </select>
         	</div>
         	</div> <!-- row -->
            
             <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('balance') ?></div>
         	<div class="span9">
				<input id="balance" class="span12 validate[required]" type="text" placeholder="0.00">
            </div><!-- span -->
          </div> <!-- row -->
          
          
            <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('date') ?></div>
         	<div class="span9">
              	 <?php
					$data = array(
					'name' => 'createdDate',
					'id' => 'createdDate',
					'type' => 'text',
					'onkeydown' => 'return false',
					'class' => 'span12 datepicker validate[required]',);
					echo form_input($data, date('d-m-Y'));
					?>
            </div>
          </div> <!-- row -->
          
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('formno')?></div>
         	<div class="span5">
                  <input class="span12 validate[required]" id="formNo" name="formNo" value='<?php echo "$formNo"; ?>' style="color:red;"   type="text" placeholder="Form number ...">
            </div>
         	<div class="span4">
                  <input  class="span11"   type="text" placeholder="Serial" disabled="disabled">
            </div>
          </div> <!-- row -->
       
          <div class="controls-row">
         	<div class="span3"><?php echo $this->lang->line('project') ?></div>
         	<div class="span8">
             <div class="input-append span12">
                <select id="project" class="span11 validate[required]">
				 <option></option>
                 <?php
				if($project != ''){
				 foreach($project as $row){
					 ?>
                     <option value="<?php echo $row->ID; ?>"><?php echo $row->project_name; ?></option>
			    <?php }} ?>
                </select>
                <div class="btn-group span1">
                 <button class="btn btn-mini btn-primary  dropdown-toggle" data-toggle="dropdown">
                	<span class="i-arrow-down-2"></span>
                  </button>
                  	<ul class="dropdown-menu">
                        <!-- dropdown menu links -->
                        <li><a target="_blank" href="<?php echo base_url() ?>project/new"  id="btnNewPro">
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
    </div><!-- row-fluid scRow-->
    

	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
	             <div class="head">
                     <h2><?php echo $this->lang->line('paymentdetails')?></h2>
                 	<ul class="buttons">
                    	<li><a class="block_toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                        	<span class="i-arrow-down-3"></span></a></li>
                    </ul>                                        
             	 </div><!-- head -->
          <div class="content np">
   				<table id="paymentDetails" cellpadding="0" cellspacing="0" width="100%">
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
                <tr id="trInfos">
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
                     	<button style="margin-right:6px;" onclick="$('#paymentDetail').validationEngine('hide');" class="btn btn-mini" type="button" name="validat">Hide prompts</button>
           				<button id="addRowCharge" onclick="addRow()" class="btn btn-mini btn-primary" type="button">
                        <i class="icon-plus-sign"></i><?php echo $this->lang->line('addNewCharge')?></button>
             			
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
                      <div class="span12">
                             <textarea placeholder="<?php echo $this->lang->line('memo') ?>" style="height: 170px;" id="memo" class="span12"></textarea>
                      </div><!-- span -->
                   </div><!-- row control -->
                  
              </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->        
	  <div class="span6 scCol">
		<div class="block" id="grid_block_4">
          <div class="content np">
                      <div class="controls-row">
                      
                      <div class="span3"><?php echo $this->lang->line('totalallocated')?></div>
                      <div class="span8">
                          <input id="totalallocated" class="input-small" type="text" placeholder="0" disabled="disabled" >
                      </div>
                  </div><!-- row control -->
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('totaltaxamount')?></div>
                      <div class="span8">
                          <input id="totaltaxamount" class="input-small" type="text" disabled="disabled"  placeholder="0">
                      </div>
                  </div><!-- row control -->
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('totalpaid')?></div>
                      <div class="span8">
                          <input id="totalpaid" disabled="disabled"  class="input-small" type="text" placeholder="0">
                      </div>
                  </div><!-- row control -->
                  <div class="controls-row">
                    <div class="span3"><?php echo $this->lang->line('outofbalance')?></div>
                      <div class="span8">
                          <input id="outofbalance" disabled="disabled"  class="input-small" type="text" placeholder="0">
                      </div>
                  </div><!-- row control -->
                 
              </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
</form>
</div><!-- grid 1 -->
</div><!-- wrap -->
</div><!-- content -->

                    
                    
   