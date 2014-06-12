<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
    $("#test").dataTable( {
        "iDisplayLength": 5,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { "bSortable": false }, null, null, null, null, null, { "bSortable": false } ]});
    $("table.editable").on("click",".info",function(){
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
        $("#row_info").dialog("open");
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
				window.location.href = "newmail?id=" + fldid;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
    $("#row_info").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
				window.location.href = "maildetails?id=" + fldid;		
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
                	<h2>Department Master List</h2>
                    	<ul class="buttons">
                        	<li><a href="#" class="block_loading"><span class="i-cycle"></span></a></li>
                            <li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                            <li><a href="#" class="block_remove"><span class="i-cancel-2"></span></a></li>
                        </ul>                                        
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th>#</th>
            			<th>Ref No.</th>
                		<th>Title</th>
                		<th>From</th>
                		<th>Mail date</th>
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
                	<td><?php echo $datatbl->ref_no; ?></td>
                	<td><?php echo $datatbl->title; ?></td>
                	<td><?php echo $datatbl->mailt_from; ?></td>
                	<td><?php echo date("d-m-Y", strtotime($datatbl->mailt_dt)); ?></td>
                    <td class="tac"><?php 
							$js = 'class="btn btn-mini btn-primary edit" title="Edit"';
							echo form_button('edit','<span class="i-pen">',$js); ?>&nbsp;<?php
							$js = 'class="btn btn-mini btn-info info" title="Detail Information"';
							echo form_button('edit','<span class="i-info">',$js); 
							/* $js = 'class="btn btn-mini btn-danger remove" title="Delete"';
							echo form_button('remove','<span class="i-trashcan">',$js); */
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
<div class="dialog" id="row_info" style="display: none;" title="Mail Information">
    <p>Continue to mail details page...</p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Edit?">
    <p>Continue to editing page...</p>
</div>   
