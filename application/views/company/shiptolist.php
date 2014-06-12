<div id="content">                        
<div class="wrap">
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
			null, { 
			"bSortable": false } ]});

    $("table.editable").on("click",".remove",function(){
        rRow = $(this).parents("tr");
        ID = $('td:first', $(this).parents('tr')).text(); 
        $("#row_delete").dialog("open");
    });
    $("table.editable").on("click",".edit",function(){
        rRow = $(this).parents("tr");
		companyID = $("#ID").val();
        ID = $('td:first', $(this).parents('tr')).text(); 
        $("#row_edit").dialog("open");
    });
    $("#row_edit").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
				window.location.href = "<?php echo base_url(); ?>setting/shiptoNew/" + companyID + "/" + ID;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
    function remove_row(row){
 		$.ajax({
  			dataType: "json",
  			type: "POST",
  			url: "<?php echo base_url(); ?>Setting/address_delete",
			data:"ID="+ID,
  			success: function(content){
				if(content.status == 'success'){
        			row.remove();
					alert(content.message);
				}else{
					alert(content.message);
				}
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
		<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
		<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
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
                	<h2><?php echo $this->lang->line('title') ?></h2>
                </div>
				<div class="content np"> <!-- Content 1 -->   
						<?php
							$data = array(
									'name'=>'ID', 
									'id'=>'ID', 
									'disabled'=>TRUE,							
									'type'=>'hidden'); 
							if($companymaster){		
								echo form_input($data, $companymaster->ID); 
							}else{
								echo form_input($data, set_value('ID')); 
                            }?> 
                  
                  <div class="controls-row">
                  	<div class="span2"><?php echo $this->lang->line('companyNo') ?></div>
                   	<div class="span10">
						<?php
							$data = array(
									'name'=>'companyNo', 
									'id'=>'companyNo', 									
									'disabled'=>TRUE,							
									'class'=>'span3'); 
							if($companymaster){		
								echo form_input($data, $companymaster->companyNo); 
							}else{
								echo form_input($data, set_value('companyNo')); 
                            }                       ?> 
                  </div>
                  </div>
                	<div class="controls-row">
                    	<div class="span2"><?php echo $this->lang->line('companyName') ?></div>
                   	<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'companyName', 
									'id'=>'companyName', 
									'disabled'=>TRUE,							
									'class'=>'span8'); 
							if($companymaster){		
								echo form_input($data, $companymaster->companyName); 
							}else{
								echo form_input($data, set_value('companyName')); 
                            }                       ?> 
                  </div>
                  </div>
                 </div><!-- End Content-->
            </div>
        	<div class="block">
            	<div class="head">
                	<h2><?php echo $this->lang->line('titlelist') ?></h2>
                    	<ul class="buttons">
                        <li><a href="<?php echo base_url(); ?>setting/shiptoNew/<?php if($companymaster) echo $companymaster->ID?>" class="" title="<?php echo $this->lang->line('addnew') ?>"><span class="i-plus-2"></span></a></li>
                        </ul>                                        
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th>#</th>
            			<th><?php echo $this->lang->line('address') ?></th>
            			<th><?php echo $this->lang->line('state') ?></th>
            			<th><?php echo $this->lang->line('country') ?></th>
                      	<th width="55" class="tac">Action</th>
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
                    <td><a title="Edit" class="btn btn-mini btn-link edit">
						<?php echo $datatbl->line1; ?><br />
						<?php echo $datatbl->line2; ?><br />
						<?php echo $datatbl->line3; ?><br />
						<?php echo $datatbl->postCode; ?>&nbsp;<?php echo $datatbl->city; ?></a>
                    </td>
                	<td><?php echo $datatbl->fldname; ?></td>
                	<td><?php echo $datatbl->fldcountry; ?></td>
                    <td class="tac"><?php 
							$js = 'class="btn btn-mini btn-danger remove" title="' . $this->lang->line("delete") .'"';
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
    <p>Row will be deleted</p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Are you sure to Edit ?">
    <p>To editing page.....</p>
</div>   
