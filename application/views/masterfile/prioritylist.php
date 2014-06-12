<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
    $("#test").dataTable( {
        "iDisplayLength": 50,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", 
		 "aoColumns": [ { 
			"bSortable": false },
			null,  
			null,  
			null, { 
			"bSortable": false } ]});

    $("table.editable td").dblclick(function () {        
        
		var fldid = $('td:first', $(this).parents('tr')).text(); 
		var fieldname = $(this).attr('id');
        var eContent = $(this).text();
        var eCell = $(this);
            
        if(eContent.indexOf('<') >= 0 || eCell.parents('table').hasClass('oc_disable')) return false;        
            
			eCell.addClass("editing");        
	        eCell.html('<input type="text" value="' + eContent + '" oninput="this.value=this.value.toUpperCase();"/>');
        var eInput = eCell.find("input");
        eInput.focus();
 
        eInput.keypress(function(e){
            if (e.which == 13) {
                var newContent = $(this).val();
                eCell.html(newContent).removeClass("editing");
				var dataToSend= {fldid: fldid, fieldname: fieldname, content: newContent};
			 $.ajax({
  				type: "POST",
  				url: "priority_save",
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
    
    $("table.editable").on("click",".remove",function(){
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
        $("#row_delete").dialog("open");
    });
    function remove_row(row){
        row.remove();
 		$.ajax({
  			type: "POST",
  			url: "priority_delete",
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


</script>

<div class="head">
	<div class="info">
		<h1><?php echo $module ?></h1>
			<ul class="breadcrumb">
            	<li><a href="#">Dashboard</a> <span class="divider">-</span></li>
                <li><a href="#"><?php echo $module ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $title ?></li>
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
                	<h2><?php echo $title ?></h2>
                    	<ul class="buttons">
                        	<li><a href="#" class="block_loading" title="Refresh"><span class="i-cycle"></span></a></li>
                            <li><a href="#" class="block_toggle" title="Close"><span class="i-arrow-down-3"></span></a></li>
                    		<li><a href="../admin/menumaster" title="Add New"><span class="i-plus-2"></span></a></li>
                        </ul>                                        
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th width="12">#</th>
            			<th width="50">Priority</th>
                		<th>Description</th>
                		<th width="55" class="tac">Action</th>
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
                	<td id="code"><?php echo $datatbl->code; ?></td>
                	<td id="description"><?php echo $datatbl->description; ?></td>
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
<div class="dialog" id="row_delete" style="display: none;" title="Delete?">
    <p>Row will be deleted</p>
</div>   
