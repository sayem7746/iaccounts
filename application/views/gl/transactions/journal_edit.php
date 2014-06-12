<script>
$(document).ready(function(){
	$('#journalTable').hide();
	$('select').select2();
	$("#btnAddnew").hide();
	$("#savedetails").hide();
//	$('#acctCodel').select2();savedetails
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
    var oTable = $("#test").dataTable( {
		"iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", 
		 "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null, 
			null, 
			null, 
			null ]});
			
    $("table.editable td").live('dblclick',function () {        
        
		var fldid = $('td:first', $(this).parents('tr')).text(); 
		var fieldname = $(this).attr('id');
        var eContent = $(this).text();
        var eCell = $(this);
            
        if(eContent.indexOf('<') >= 0 || eCell.parents('table').hasClass('oc_disable')) return false;        
            
        eCell.addClass("editing");        
        eCell.html('<input type="text" value="' + eContent + '"/>');
        
        var eInput = eCell.find("input");
        eInput.focus();
 
        eInput.keypress(function(e){
            if (e.which == 13) {
                var newContent = $(this).val();
                eCell.html(newContent).removeClass("editing");
				var dataToSend= {fldid: fldid, fieldname: fieldname, content: newContent};
			 $.ajax({
  				type: "POST",
  				url: "journaldetails_save",
				data:dataToSend,
  				success: function(){
				alert('Data has been saved...');
				}, 
			 });       
                // Here your ajax actions after pressed Enter button
            }
        });
 
        eInput.focusout(function(){
            eCell.text(eContent).removeClass("editing");            
            // Here your ajax action after focus out from input
			alert('Data not saved...');
        });        
    });

    $("table.editable").on("click",".edit",function(){
        var eRow   = $(this).parents('tr');
        var eState = $(this).attr('data-state');
        
        if(eState == null){
            $(this).html('Save');
            eState = 1;
        }
        
        eRow.find('td').each(function(){            
            if(eState == 1){
                var eContent = $(this).html();                
                if(eContent.indexOf('<') < 0){
					if($(this).index() != 0)
                    $(this).addClass("editing").html('<input type="text" value="' + eContent + '"/>');                    
					if($(this).index() == 1){
					}
                }
            }
            if(eState == 2){
                var eContent = $(this).find('input').val();                                
                if(eContent != null){
                    $(this).removeClass("editing").html(eContent);
                    // Here your ajax action after Save button pressed
			        fldid = $('td:first', $(this).parents('tr')).text(); 
			 		alert(fldid);
					/* $.ajax({
  						type: "POST",
  						url: "menu_save?id=" + fldid,
  						success: function(){
						alert('Data has been saved...');
					}, 
		});   */    // Here your ajax action after delete confirmed
					
                }
            }
        });
        
        if(eState == 1) 
            $(this).attr('data-state','2');
        else{
            $(this).removeAttr('data-state');
            $(this).html('Edit');
        }
    });
    $("table.editable").on("click",".remove",function(){
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
        rRow.remove();
    });
    $("table.editable").on("click",".removeline",function(){
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
        $("#row_delete").dialog("open");
    });
    function remove_row(row){
        row.remove();
 		$.ajax({
  			type: "POST",
  			url: "journaldetails_delete",
			data:"fldid="+fldid,
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


function saveJournal(){
	var total_credit = 0;
	var total_debit = 0;
	if($('#description').val() == '' && $('#journal_number').val() == ''){ 
		alert('<?php echo $this->lang->line('message1') ?>');
		$('#description').focus();
	}else{
		var journalNo = $('#journal_number').val();
		var description = $('#description').val();
		var effdate = $('#effdate').val();
		$('#journal_number').attr('disabled','disabled');
		$('#description').attr('disabled','disabled');
		$('#effdate').attr('disabled','disabled');
		$('#mysubmit').hide();
		$('#hidePrompt').hide();
		$('#journalTable').show();
		var bil = 1;
		var postData = {
			'journalNo' : journalNo,
			'description' : description,
			'effdate' : effdate,
		};
 		$.ajax({
  			type: "POST",
  			dataType: "json",
			url: "<?php echo base_url()?>Gltransaction/journal_head",
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
}


function editclass(obj){
		var acctCodet = obj.value;
//		$('#account_code').val(acctCodet);
        var eRow   = $(obj).parents('tr');
        var eState = $(this).attr('data-state');
        if(eState == null){
            $(this).html('Save');
            eState = 1;
        }
        eRow.find('td').each(function(){            
            if(eState == 1){
               var eContent = $(this).html();                
                if(eContent.indexOf('<') < 0){
					if($(this).index() == 1){
                    	$(this).html(parseInt($('#bill').val()) + 1);
						$('#bill').val(parseInt($('#bill').val()) + 1);
					}
					if($(this).index() == 2){
						$(this).addClass("editing")
					}
					if($(this).index() == 3){
                    	$(this).addClass("editing").html('<input type="text" id="description" value="' + eContent + '"/>');                    
					}
					if($(this).index() == 4){
                    	$(this).addClass("editing").html('<input class="tar" type="text" id="amount_dr" value="' + eContent + '"/>');                    
					}
					if($(this).index() == 5){
                    	$(this).addClass("editing").html('<input class="tar" type="text" id="amount_cr" value="' + eContent + '"/>');                    
					}
					if($(this).index() == 6){
                    	$(this).addClass("editing").html('<button onClick="saveData(this)" class=\"btn btn-mini btn-primary btn-block save\">Save</button>');                    
					}
                }
            }
        });
/*        
            if(eState == 2){
                var eContent = $(this).find('input').val();                                
                if(eContent != null){
                    $(this).removeClass("editing").html(eContent);
                    // Here your ajax action after Save button pressed
			        fldid = $('td:first', $(this).parents('tr')).text(); 
			 		alert(fldid);
					/* $.ajax({
  						type: "POST",
  						url: "menu_save?id=" + fldid,
  						success: function(){
						alert('Data has been saved...');
					}, 
		});      // Here your ajax action after delete confirmed
					
                }
            }
        });
        
        if(eState == 1) 
            $(this).attr('data-state','2');
        else{
            $(this).removeAttr('data-state');
            $(this).html('Edit');
        }
		*/
}

function addRow(){
var rowCount = document.getElementById('oTable').rows.length - 1 ;
var rowArrayId = rowCount ;
var toBeAdded = document.getElementById('numberofrows').value;
if (toBeAdded=='')
    { toBeAdded = 2; }	
else if(toBeAdded>100)
{
  toBeAdded = 100;
}
  for (var i = 1; i <= toBeAdded; i++) {
    var rowToInsert = '';
    rowToInsert = "<td class='span2'><select id='accountID"+rowArrayId+"' style='width: 250px;'></select></td>";
    $("#oTable tbody").append(
		"<tr><td style='display:none'></td><td>"+ (parseInt(rowArrayId) + 1) +"</td>" +
		rowToInsert +
        "<td class='span9'><input type='text' name='description["+rowArrayId+"]' class='span12'/>"+
        "<td class='span4 tar'><input type='text' name='amountdr["+rowArrayId+"]' class='span12 validate[custom[integer]]' onBlur='calculate_amount()'/></td>"+
        "<td class='span4 tar'><input type='text' name='amountcr["+rowArrayId+"]' class='span12 validate[custom[integer]]' onBlur='calculate_amount()'/></td>"+
        "<td class='tac'><button class='btn btn-mini btn-danger remove' title='<?php echo $this->lang->line('delete') ?>'><span class='i-trashcan'></button></td>"+
        "</tr>");

//	$('select').select2();
	rowArrayId = rowArrayId + 1;
  }
  selectoption(toBeAdded);
	$('select').select2({
		placeholder: 'Please',
	});
	$("#btnAddnew").hide();
	$("#savedetails").show();
}

function selectoption(toBeAdded){
	var numrows = $("#numberofrows").val();
	var tablerows = $("#oTable > tbody >tr").length;
	var startrows = parseInt($("#oTable > tbody >tr").length) - numrows;
		$.ajax({
			type: "POST",
        	url: '<?php echo base_url();?>gltransaction/accountSearch',
			dataType:"json",
			success: function(content){
				if(content.status == "success") {
					var items = [];
					items.push('<option value="">-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].ID+'">'
						+ content.message[i].acctCode + ' ['+ content.message[i].acctName + ']</option>');
					}
					for (var x = startrows; x < tablerows ; x++) {
 						var rowId = "#accountID" + x;
						jQuery(rowId).empty();
						jQuery(rowId).append(items.join('</br>'));
					}
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				}
					return false;
			}
		});
}

function savedetails(){
	if($("#amountcredit").val() != $("#amountdebit").val()){ 
		alert('<?php echo $this->lang->line('message5') ?>');
		$('#description').focus();
	}else{
		var amountcredit = $("#amountcredit").val();
		var amountdebit = $("#amountdebit").val();
		var totalamount = $("#totalamount").val();
		var journalNo = $('#journal_number').val();
		var numrows = $("#numberofrows").val();
		var tablerows = $("#oTable > tbody >tr").length;
		var startrows = parseInt($("#oTable > tbody >tr").length) - numrows;
		var rows = $("#oTable").dataTable().fnGetNodes();
//	var accountno =$("#acctCode option:selected").val();
		for (var i = startrows; i < tablerows ; i++){
			if($(rows[i]).find("td:eq(2) option:selected").val()){
				postData = {
					'sequence' : $(rows[i]).find("td:eq(1)").html(),
					'journalNo' : journalNo,
					'acctCode' : $(rows[i]).find("td:eq(2) option:selected").val(),
					'description' : $(rows[i]).find("td:eq(3) input").val(),
					'amountdr' : $(rows[i]).find("td:eq(4) input").val(),
					'amountcr' : $(rows[i]).find("td:eq(5) input").val(),
					'amountcredit' : amountcredit,
					'amountdebit' : amountdebit,
					'totalamount' : totalamount,
				};
				alert($(rows[i]).find("td:eq(2) option:selected").val());
 				$.ajax({
  					type: "POST",
  					dataType: "json",
					url: "<?php base_url()?>journaldetails_insert",
					data: postData ,
	  				success: function(content){
						if(content.status == "success") {
							location.reload();
						}
					}
				});  
			}
		}
	}
		location.reload();
}

function calculate_amount(){
	var numrows = $("#numberofrows").val();
	var tablerows = $("#oTable > tbody >tr").length;
	var startrows = parseInt($("#oTable > tbody >tr").length) - numrows;
	var total_credit = 0;
	var total_debit = 0;
	for (var i = 0; i < tablerows ; i++){
		if($('#oTable > tbody > tr:eq(' + i + ') > td:eq(4)').text() && i < startrows)
			 total_credit = parseFloat(total_credit) + parseFloat($('#oTable > tbody > tr:eq(' + i + ') > td:eq(4)').text());
		else if($('#oTable > tbody > tr:eq(' + i + ') > td:eq(4)').find("input").val())
			total_credit = parseFloat(total_credit) + parseFloat($('#oTable > tbody > tr:eq(' + i + ') > td:eq(4)').find("input").val());
		if($('#oTable > tbody > tr:eq(' + i + ') > td:eq(5)').text()  && i < startrows)
			 total_debit = parseFloat(total_debit) + parseFloat($('#oTable > tbody > tr:eq(' + i + ') > td:eq(5)').text());
		else if($('#oTable > tbody > tr:eq(' + i + ') > td:eq(5)').find("input").val()) total_debit = parseFloat(total_debit) + parseFloat($('#oTable > tbody > tr:eq(' + i + ') > td:eq(5)').find("input").val());
	}
	$("#amountcredit").val(total_credit.toFixed(2));
	$("#amountdebit").val(total_debit.toFixed(2));
	$("#totalamount").val((parseFloat(total_credit) - parseFloat(total_debit)).toFixed(2));
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
</div>  <!-- Head -->                                                                  
                    
<div class="content" id="grid_content_1">
	<div class="row-fluid">
		<div class="alert alert-info">
			<strong><?php echo $this->lang->line('title') ?></strong>
		</div>
	</div>
	<div class="row-fluid scRow">                            
	  <div class="span8 scCol">
		<div class="block" id="grid_block_1">
          <div class="content">
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label($this->lang->line('jlnumber'),'journal_number');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'journal_number', 
									'id'=>'journal_number', 
									'disabled'=>'disabled',
									'class'=>'input-medium validate[required,maxSize[50]]',); 
								echo form_input($data, $journalHead->journalID); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Description:','description');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'description', 
									'id'=>'description', 
									'disabled'=>'disabled',
									'class'=>'span12 validate[required,maxSize[100]]',); 
								echo form_input($data, $journalHead->description); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                  <div class="controls-row"><!-- Row 3 -->
                    	<div class="span2"><?php echo form_label($this->lang->line('effective_date'),'effdate');?></div>
                    <div class="span9">
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="i-calendar"></i></span>
                            	<?php 								
								$data = array(
									'type'=>'text',
									'name'=>'effdate', 
									'id'=>'effdate', 
									'disabled'=>'disabled',
									'class'=>'input-medium datepicker2',); 
								echo form_input($data, date('d-m-Y', strtotime($journalHead->effective_date))); ?>
                        </div>                                                                                                
                     </div>
                    </div><!-- End Row 3 -->
          </div><!-- End Content-->
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                        <?php 
							$data = array(
									'name'=>'hidePrompt', 
									'id'=>'hidePrompt', 
									'class'=>'btn',
									'onClick'=>"$('#validate').validationEngine('hide');"); 
							echo form_button($data,'Hide prompts');
							$data = array(
									'name'=>'mysubmit', 
									'id'=>'mysubmit', 
									'class'=>'btn btn-primary');
									$js = 'onClick="saveJournal()"';
							echo form_button($data,$this->lang->line('next'), $js);
							?>
                    </div>
                </div>
            </div>    <!-- footer -->                                
        </div>  <!-- Block grid-->                                  
      </div>     <!-- span8 -->                               
	  <div class="span4 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span5"><?php echo $this->lang->line('controlamount');?></div>
                   		<div class="span7">
                            	<?php 								
								$data = array(
									'name'=>'totalamount', 
									'id'=>'totalamount', 
									'disabled'=>'disabled',
									'class'=>'input-small tar',); 
								echo form_input($data); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span5"><?php echo $this->lang->line('amount_cr_ttl');?></div>
                   		<div class="span7">
                            	<?php 								
								$data = array(
									'name'=>'amountcredit', 
									'id'=>'amountcredit', 
									'disabled'=>'disabled',
									'class'=>'input-small validate[required,maxSize[50]]',); 
								echo form_input($data); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span5"><?php echo $this->lang->line('amount_dr_ttl');?></div>
                   		<div class="span7">
                            	<?php 								
								$data = array(
									'name'=>'amountdebit', 
									'id'=>'amountdebit', 
									'disabled'=>'disabled',
									'class'=>'input-small validate[required,maxSize[50]]',); 
								echo form_input($data); ?>
                  		</div>
                 	</div><!-- End Row 4-->
          </div><!-- End Content-->
			<div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                    </div>
                </div>
            </div>    <!-- footer -->                                        
         </div> <!-- Block grid-->                                   
      </div> <!-- scCol-->                                   
     </div> <!-- row-fluid scRow-->                                   
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
	 	<div class="block" id="journalTable">
        	<div class="head">
            	<h2><?php echo $this->lang->line('details') ?></h2>
                	<ul class="buttons" id="btnAddnew">
                 		<li><button id="addnew" onclick="addRow()" class="btn btn-small btn-primary" type="button" title="<?php echo $this->lang->line('addnew') ?>"><i class="icon-plus-sign"></i></button>
                            <input id="numberofrows" type="text" class="input-mini" value="10"> <?php echo $this->lang->line('row') ?></li>
                	</ul>                                        
        	</div>
                            	<?php 								
								$data = array(
									'name'=>'bill', 
									'id'=>'bill', 
									'value'=> 1,
									'type' => 'hidden'); 
								echo form_input($data); ?>
          	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="oTable" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th width="5">#</th>
            			<th><?php echo $this->lang->line('acctCode')?></th>
            			<th><?php echo $this->lang->line('description')?></th>
            			<th class="tar"><?php echo $this->lang->line('amount_dr')?></th>
            			<th class="tar"><?php echo $this->lang->line('amount_cr')?></th>
            			<th class="tac"><?php echo $this->lang->line('action')?></th>
            		</tr>
        			</thead>
       				 <tbody>
                     <!--tr>
                     	<td></td>
                        <td id=acctCode>
                        	<?php
							$preselcat = '';
							$options = '';
							$options[] = $this->lang->line('pleaseselect');
							foreach($chartAccounts as $row){
								$options[$row->ID] = $row->acctCode . " [" . $row->acctName . "]";
							}
							$js='onChange="editclass(this)" style="width: 250px;"';
							echo form_dropdown('acctCode', $options, $preselcat, $js);
							?>
                            </td>
                        <td id=descriptin></td>
                        <td id=amountdr></td>
                        <td></td>
                        <td></td>
                     </tr -->
					</tbody>
			</table>                                         
			</div>
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
           			<button id="savedetails" onclick="savedetails()" class="btn btn-small btn-primary" type="button" title="<?php echo $this->lang->line('submit') ?>">
                        <i class="icon-plus-sign"></i> <?php echo $this->lang->line('submit') ?></button>
       				</div><!-- btn group -->      
       			</div><!-- side fr -->      
       		</div><!-- footer -->      
		</div><!-- Block grid-->
</div>
</div>                        
</div>                        
</div>
</div>
</div>
<div class="dialog" id="row_delete" style="display: none;" title="<?php echo $this->lang->line('delete') ?>?">
    <p><?php echo $this->lang->line('message6') ?></p>
</div>   
