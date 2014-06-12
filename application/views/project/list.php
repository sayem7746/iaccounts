<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
    $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false },   
			null, 
			null,
			null,
			null,
			null,
			null,
			null, { 
			"bSortable": false } ]});

    $("table.editable").on("click",".remove",function(){
        rRow = $(this).parents("tr");
        ID = $('td:first', $(this).parents('tr')).text(); 
        $("#row_delete").dialog("open");
    });
    $("table.editable").on("click",".edit",function(){
        rRow = $(this).parents("tr");
        ID = $('td:first', $(this).parents('tr')).text(); 
        $("#row_edit").dialog("open");
    });
    $("table.editable").on("click",".shipto",function(){
        rRow = $(this).parents("tr");
        ID = $('td:first', $(this).parents('tr')).text();
		urls = "shiptolist/" + ID; 
			window.location.replace(urls);    
	});
    $("#row_edit").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
				window.location.href = "ProjectSetup?ID=" + ID;		
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
  			url: "project_delete",
			data:"ID="+ID,
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
<div id="content">                        
<div class="wrap">
<div class="head">
	<div class="info"
					<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> 
                    [ <?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href="#"><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href="#"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('titlelist') ?></li>
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
                	<h2><?php echo $this->lang->line('titlelist') ?></h2>
                    	<ul class="buttons">
                    	<ul class="buttons">
                        	<li><a href="ProjectSetup" class="" title="New"><span class="i-plus-2"></span></a></li>
                        </ul>                                        
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th>#</th>
            			<th><?php echo $this->lang->line('project_name') ?></th>
                        <th><?php echo $this->lang->line('companyID') ?></th>
            			<th><?php echo $this->lang->line('projectManagerID') ?></th>
                        <th><?php echo $this->lang->line('totalBudget') ?></th>
                        <th><?php echo $this->lang->line('remarks') ?></th>
                        <th><?php echo $this->lang->line('updatedBy') ?></th>

                		<th width="55" class="tac"><?php echo $this->lang->line('action') ?></th>
            		</tr>
        			</thead>
       				 <tbody>
                     
			<?php $bil = 0; 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                <td style="display:none" ><?php echo $datatbl->ID; ?></td>
                <td><?php echo $bil; ?></td>
                <td><a title="Edit" class="btn btn-mini btn-link edit"><?php echo $datatbl->project_name; ?></a></td>
                      <td><?php echo $datatbl->companyID; ?></td>
                      <td><?php echo $datatbl->projectManagerID; ?></td>
                      <td><?php echo $datatbl->totalBudget; ?></td>
                      <td><?php echo $datatbl->remarks; ?></td>
                      <td><?php echo $datatbl->updatedBy; ?></td>
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
<div class="dialog" id="row_delete" style="display: none;" title="Are you sure to Delete?">
    <p><?php echo $this->lang->line('message1') ?></p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Are you sure to Edit ?">
    <p><?php echo $this->lang->line('message2') ?></p>
</div>

