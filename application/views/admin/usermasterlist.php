<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
    $("#test").dataTable( {
        "iDisplayLength": 5,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false }, { 
		 	"bSortable": false }, 
			null, 
			null, 
			null, 
			null, 
			null, null, { "bSortable": false }, { "bSortable": false } ]});

    $("table.editable").on("click",".remove",function(){
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
        $("#row_delete").dialog("open");
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
				window.location.href = "usermaster?id=" + fldid;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
    function remove_row(row){
        row.remove();
 		$.ajax({
  			type: "POST",
  			url: "usermaster_delete",
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
    $("table.editable").on("click",".access",function(){
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
        $("#row_access").dialog("open");
    });
    $("#row_access").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "OK": function() {
				window.location.href = "user_access/" + fldid;		
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
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'>Dashboard</a> <span class="divider">-</span></li>
                <li><a href="home"><?php echo $module ?></a> <span class="divider">-</span></li>
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
                    	<ul class="buttons">
                        	<li><a href="#" class="block_loading" title="Refresh"><span class="i-cycle"></span></a></li>
                            <li><a href="#" class="block_toggle" title="Close"><span class="i-arrow-down-3"></span></a></li>
                            <li><a href="#" class="block_remove"><span class="i-cancel-2"></span></a></li>
                        </ul>                                        
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th>#</th>
            			<th>User ID</th>
                		<th>User Name</th>
                		<th>Position</th>
                		<th>Department</th>                
                		<th>Section</th>                
                		<th>Email</th>                
                		<th>Office Phone</th>               
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
                	<td><?php echo $bil; ?></td>
                	<td><button class="btn btn-link access" title="User Access"><?php echo $datatbl->userid; ?></button></td>
                	<td><?php echo $datatbl->username; ?></td>
                	<td><?php echo $datatbl->position; ?></td>
                	<td><?php echo $datatbl->department; ?></td>
                	<td><?php echo $datatbl->section; ?></td>
                	<td><?php echo $datatbl->email; ?></td>
                	<td><?php echo $datatbl->phone_off; ?></td>
                    <td><?php 
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
    <p>Row will be deleted</p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Edit ?">
    <p>To editing page.....</p>
</div>   
<div class="dialog" id="row_access" style="display: none;" title="Setting User Access ?">
    <p>Click OK to continue.....</p>
</div>   
