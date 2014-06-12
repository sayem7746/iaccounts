<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
	$("table.editable td").die();
    $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", 
		 "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null, 
			null, 
			null, 
			null, { 
			"bSortable": false } ]});
			

    $("table.editable td").live('dblclick',function () {        
        
		var fldid = $('td:first', $(this).parents('tr')).text(); 
		var fieldname = $(this).attr('id');
        var eContent = $(this).text();
        var eCell = $(this);
            
        if(eContent.indexOf('<') >= 0 || eCell.parents('table').hasClass('oc_disable')) return false;        
            
        eCell.addClass("editing");        
        eCell.html('<input id="test1" type="text" value="' + eContent + '"/>');
        
        var eInput = eCell.find("input");
        eInput.focus();
 
        eInput.keypress(function(e){
            if (e.which == 13) {
                var newContent = $(this).val();
                eCell.html(newContent).removeClass("editing");
				var dataToSend= {fldid: fldid, fieldname: fieldname, content: newContent};
			 $.ajax({
  				type: "POST",
  				url: "umconv_save",
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
					if($(this).attr('id') == 'bil'){
					}else{
                    	$(this).addClass("editing").html('<input type="text" value="' + eContent + '"/>');                    }
                }
            }
            if(eState == 2){
                var eContent = $(this).find('input').val();                                
                if(eContent != null){
                    $(this).removeClass("editing").html(eContent);
                }
            }
        });
        
        if(eState == 1) 
            $(this).attr('data-state','2');
        else{
        	var fromum = $('td:nth-child(2)', $(this).parents('tr')).text(); 
        	var toum = $('td:nth-child(3)', $(this).parents('tr')).text(); 
        	var unitm = $('td:nth-child(4)', $(this).parents('tr')).text(); 
        	var factor = $('td:nth-child(5)', $(this).parents('tr')).text(); 
			var dataToSend = {from_um: fromum, to_um: toum, unitm: unitm, factor: factor};
			 $.ajax({
  				type: "POST",
  				url: "umconv_insert",
				data:dataToSend,
  				success: function(){
				alert('Data has been saved...');
				}, 
			 });       
            $(this).removeAttr('data-state');
            $(this).html('Edit');
        }
    });
    $("table.editable").on("click",".remove",function(){
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
        $("#row_delete").dialog("open");
    });
    function remove_row(row){
        row.remove();
 		$.ajax({
  			type: "POST",
  			url: "umconv_delete",
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
	jQuery(".editing").find("input").keyup(function() {
		jQuery(this).val(jQuery(this).val().toUpperCase());
	});
}); 
function addRow(tableID) {
 
	var table = document.getElementById(tableID);
	var um = <?php echo json_encode($datatblsum); ?>;       	        
	
	var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
 
	var cell1 = row.insertCell(0);
	cell1.innerHTML = rowCount;
 
	var cell2 = row.insertCell(1);
	var element2 = document.createElement("select");
	element2.id = 'from_um';
	for ( var i = 0; i < um.length; i++) {
	var option = document.createElement("option");
		option.text = '[ ' + um[i].code + ' ] - ' +um[i].desc;
		option.value = um[i].code;
		element2.appendChild(option);
	}
	cell2.appendChild(element2);
 
	var cell3 = row.insertCell(2);
	var element3 = document.createElement("select");
	element3.id = 'to_um';
	for ( var i = 0; i < um.length; i++) {
	var option = document.createElement("option");
		option.text = '[ ' + um[i].code + ' ] - ' +um[i].desc;
		option.value = um[i].code;
		element3.appendChild(option);
	}
	cell3.appendChild(element3);

	var cell4 = row.insertCell(3);
    var element4 = document.createElement("input");
	element4.type = "text";
	element4.id = "unitm";
	cell4.appendChild(element4); 
 }
</script>

<div class="head">
	<div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href='<?php echo base_url()."item/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('title1') ?></li>
            </ul>
	</div>
	<div class="search">
		<form action="<?php echo base_url() ?>admin/search" method="post">
			<input name="search_text" type="text" placeholder="search..."/>                                
            <button type="submit"><span class="i-magnifier"></span></button>
		</form>
	</div>                        
</div><!-- head --> 
<div class="content">
<div class="wrap">                    
	<div class="row-fluid">
		<div class="span12">
        	<div class="block">
            	<div class="head">
                	<h2><?php echo $this->lang->line('titlelist1') ?></h2>
                    	<ul class="buttons">
                            <li><a href="umconversion" title="<?php echo $this->lang->line('addnew') ?>"><span class="i-plus-2"></span></a></li>
                        </ul>                                        
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th width="20">#</th>
            			<th><?php echo $this->lang->line('from') ?></th>
            			<th><?php echo $this->lang->line('toum') ?></th>
            			<th><?php echo $this->lang->line('unit') ?></th>
                		<th><?php echo $this->lang->line('factor') ?></th>
                		<th class="tac" width="10">Action</th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->fldid; ?></td>
                	<td id="bil"><?php echo $bil; ?></td>
                	<td id="from_um"><?php echo $datatbl->from_um; ?></td>
                	<td id="to_um"><?php echo $datatbl->to_um; ?></td>
                	<td id="unitm"><?php echo $datatbl->unitm; ?></td>
                	<td id="factor"><?php echo $datatbl->factor; ?></td>
                    <td class="tac"><?php
							$js = 'class="btn btn-mini btn-danger remove" title="Delete"';
							echo form_button('remove','<span class="i-trashcan">',$js);
							?>
                    </td>
                </tr>
            <?php endforeach; }?>
					</tbody>
			</table>                                         
			</div>
</div>                                
</div>
</div>                                
</div>
</div>                                
</div>
</div>
<div class="dialog" id="row_delete" style="display: none;" title="<?php echo $this->lang->line('delete') ?>?">
    <p><?php echo $this->lang->line('message1') ?></p>
</div>   
