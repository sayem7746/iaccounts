<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
	$("table.editable td").die();
    /* Build the DataTable with third column using our custom sort functions */
    $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100,500],
		 "sPaginationType": "full_numbers", 
		 "aoColumns": [ { 
		 	"bSortable": false }, { 
		 	"bSortable": false }, 
			null, 
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
        
		if(fieldname == 'state' || fieldname == 'country'){
		}else{
        eCell.addClass("editing");        
        eCell.html('<input type="text" value="' + eContent + '"/>');
		}
        var eInput = eCell.find("input");
        eInput.focus();
 
        eInput.keypress(function(e){
            if (e.which == 13) {
                var newContent = $(this).val();
                eCell.html(newContent).removeClass("editing");
				var dataToSend= {fldid: fldid, fieldname: fieldname, content: newContent};
			 $.ajax({
  				type: "POST",
  				url: "location_save",
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
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
        $("#row_edit").dialog("open");
    });
    $("#row_edit").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
				window.location.href = "location?id=" + fldid;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
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
  			url: "location_delete",
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
            	<li><a href="#"><?php echo $this->lang->line('dashboard')?></a> <span class="divider">-</span></li>
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
            			<th>#</th>
            			<th><?php echo $this->lang->line('code')?></th>
                		<th><?php echo $this->lang->line('description')?></th>
                		<th><?php echo $this->lang->line('address')?></th>
                		<th><?php echo $this->lang->line('city')?></th>
                		<th><?php echo $this->lang->line('state')?></th>
                		<th><?php echo $this->lang->line('country')?></th>
                		<th class="tac"><?php echo $this->lang->line('action')?></th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td id="fldid" style="display:none" ><?php echo $datatbl->fldid; ?></td>
                	<td id="bil"><?php echo $bil; ?></td>
                	<td id="code"><?php echo $datatbl->code; ?></td>
                	<td id="desc"><?php echo $datatbl->desc; ?></td>
                	<td id="address"><?php echo $datatbl->address; ?></td>
                	<td id="city"><?php echo $datatbl->city; ?></td>
                	<td id="state"><?php echo $datatbl->fldname; ?></td>
                	<td id="country"><?php echo $datatbl->fldcountry; ?></td>
                    <td class="tac"><?php
							$js = 'class="btn btn-mini btn-primary edit" title="Edit"';
							echo form_button('edit','<span class="i-pen">',$js); ?>&nbsp;<?php
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
    <p><?php echo $this->lang->line('message1')?></p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Edit?">
    <p><?php echo $this->lang->line('message2')?></p>
</div>   
