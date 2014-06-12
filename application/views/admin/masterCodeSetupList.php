<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
    var oTable = $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "asSorting": [ "asc"], "aTargets": [ 1 ],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false },
			null, 
			null, 
			null,
			null, 
			null, 
			null, { 
			"bSortable": false } ]});
     oTable.fnSort( [ [1,'asc'] ] );
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
    $("#row_edit").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
				window.location.href = "masterCodeSetup?id=" + ID;		
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
  			url: "masterCodeSetup",
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
				window.location.href = "masterCodeDelete?ID=" + ID;		
                remove_row(rRow);
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
}); 

function changeList(obj){
	var id = obj.value;
	//alert(id);
		$.ajax({
			type: "POST",
			url: "<?php base_url()?>mastercode_id/",
			data: "id="+id,
			dataType:"json",
			success: function(content){
				if(content.status == "success") 
				{
//						alert(content.status);
					$('#test').dataTable().fnClearTable();
					for (var i=1; i<content.message.length; i++){
						$("#test tbody").append('<tr><td style="display:none">' + content.message[i].ID + '</td><td>' + i + '</td><td><a title="Edit" class="btn btn-mini btn-link edit">' + content.message[i].code + '</a></td><td>' + content.message[i].name + '</td><td>' + 
							content.message[i].shortName + '</td><td>' + content.message[i].description + 
							'</td><td>' + content.message[i]. orderNo + '</td><td class="tac"><button class="btn btn-mini btn-danger remove" title="Remove"><span class="i-trashcan"></button></td></tr>');
        			}
				} 
				else 
				{
					$("#error").html('<p>'+content.message+'</p>');
				}
			}
		});
		return false;
}
</script>



<div id="content">                        
<div class="wrap">
<div class="head">
	<div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href="#"><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href="#"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('title') ?></li>
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
                	<h2><?php echo $this->lang->line('title') ?></h2>
                </div>
            	<div class="content">
                    <div class="controls-row">
                    	<div class="span1"><?php echo $this->lang->line('master') ?></div>
                        <div class="input-prepend">
                        <?php
														
							if($mcmaster){
								$preselname = $mcmaster->masterID;
							}else{
								$preselname = '';
							}
							$options = '';
							$options[] = $this->lang->line('pleaseselect');
							foreach($masterName as $row){
								$options[$row->ID] = $row->name;
							}
							$js = 'onChange="changeList(this)"';
							echo form_dropdown('masterID', $options, $preselname, $js);
							?>                                                                                               
                          </div>
                     </div>
                     </div>
            </div>
        	<div class="block">
            	<div class="head">
                	<h2><?php echo $this->lang->line('titlelist') ?></h2>
                    	<ul class="buttons">
                    		<li><a href="<?php echo base_url(); ?>setting/masterCodeSetup" title="<?php echo $this->lang->line('addnew') ?>"><span class="i-plus-2"></span></a></li>
                        </ul>                                       
                </div>
            	<div class="content np table-sorting">
                	
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th class="tac"><?php echo $this->lang->line('#');?></th>
                		<th class="tac"><?php echo $this->lang->line('code');?></th>
                		<th><?php echo $this->lang->line('name');?></th>
                		<th><?php echo $this->lang->line('shortName');?></th>                
                		<th><?php echo $this->lang->line('description');?></th>
                        <th class="tac"><?php echo $this->lang->line('orderNo');?></th>               
                		<th class="tac"><?php echo $this->lang->line('action');?></th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->ID; ?></td>
                	<td class="tac"><?php echo $bil; ?></td>
                	<td class="tac"><a title="Edit" class="btn btn-mini btn-link edit"><?php echo $datatbl->code ?></a></td>
                	<td><?php echo $datatbl->name; ?></td>
                    <td><?php echo $datatbl->shortName; ?></td>
                    <td><?php echo $datatbl->description; ?></td>
					<td class="tac"><?php echo $datatbl->orderNo; ?></td>
                        <td><?php
							$js = 'class="btn btn-mini btn-danger remove" title="' . $this->lang->line("delete") . '"';
							echo form_button('remove','<span class="i-trashcan">',$js);
						?></td>
                </tr>
            <?php endforeach; }?>
					</tbody>
			</table>                                         
			</div>

<div class="dialog" id="row_delete" style="display: none;" title="Delete?">
    <p><?php echo $this->lang->line('message1');?></p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Edit ?">
    <p><?php echo $this->lang->line('message2');?></p>
</div>  

