<script type="text/javascript">
$(document).ready(function() {
   /* Build the DataTable with third column using our custom sort functions */
   
   //Data table configurations
   var oTable = $("#test").dataTable({
	   	"iDisplayLength": 10,
		"aLengthMenu": [5,10,25,50,100],
		"sPaginationType": "full_numbers",
		"aoColumns": [{"bSortable": false},
						null,
						null,
						null,
						null,
						null,
						null,
						{"bSortable": false},
						{"bSortable": false},
					] 
	});
	oTable.fnSort( [ [1,'asc'] ] );
   
   /*
    $("table.editable").on("click",".copy",function(){
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
				window.location.href = "<?php echo base_url();?>GLtransaction/jlCopy/" + fldid;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });*/    
}); 
 
function changeList(){
	var addyear = $('#add_year option:selected').val();
	var addper = $('#add_period option:selected').val();
	var urls = "<?php echo base_url();?>GLtransaction/journalCopy/"+addyear+"/"+addper;
		window.location = urls;
}


</script>

<div id="content">                        
<div class="wrap">
<div class="head">
	<div class="info">
        <h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
            <?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
        <ul class="breadcrumb">
            <li><a href='<?php echo base_url(); ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
            <li><a href="home"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
        
        <div class="content">
            <div class="wrap">   
                
                <div class="row-fluid">
                    <div class="span12">
                        <div class="block">                            
                            <div class="head">
                                <h2><?php echo $this->lang->line('title') ?></h2>
                                <div class="side fr">
                                    <div class="btn-group">
                                        <a href="<?php echo base_url(); ?>locationtransfer/add" class="btn btn-primary" title="Add Location Transfer">Add Transfer</a>                                               
                                    </div>
                                </div>
                            </div><!-- head -->
                        <div class="content np table-sorting">
                            <table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable itemTbl">
                                <thead>
                                <tr>
			            			<th style="display:none"></th>
                                    <th class="tac">Location ID</th>
                                    <th class="tac">From Location</th>
                                    <th class="tac">To Location</th>
                                    <th class="tac">Movement Type</th>
                                    <th class="tac">Memo</th>
                                    <th class="tac">Date Transfer</th>
                                    <th class="tac">Edit</th>
                                    <th class="tac">Delete</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
								<?php $bil = 0; 
                                if(isset($datatbls) && !empty($datatbls)):
                                    foreach($datatbls as $item):
                                    $bil++?>
                                    <tr class="itemList itemList<?php $item->ID; ?>">
                                        <td style="display:none" ><?php echo $item->ID; ?></td>
                                        <td class="tac"><?php echo $item->ID; ?></td>
                                        <td class="tac"><?php echo $item->fromLoc; ?></td>
                                        <td class="tac"><?php echo $item->toLoc; ?></td>
                                        <td class="tac"><?php echo $item->movetype; ?></td>
                                        <td class="tac"><?php echo $item->memo; ?></td>
                                        <td class="tac"><?php echo $item->dateTransfer; ?></td>
                                        <td class="tac">
                                            <div class="btn-toolbar">
                                                <div class="btn-group">
                                                    <a href="<?php echo site_url("locationtransfer/edit/".$item->ID); ?>" class="btn btn-mini btn-primary"><i class="icon-pencil"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                        	<div class="btn-toolbar">
                                                <div class="btn-group">
                                                    <a href="<?php echo site_url("locationtransfer/delete/".$item->ID); ?>" class="btn btn-mini btn-danger"><span class="icon-remove"></span></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                    endforeach;
                                else:
                                ?>
                                    <tr class="itemList">
                                        <td style="display:none" ></td>
                                        <td class="tac">No data available</td>
                                        <td class="tac"></td>
                                        <td class="tac"></td>
                                        <td class="tac"></td>
                                        <td class="tac"></td>
                                        <td class="tac"></td>
                                        <td class="tac"></td>
                                        <td></td>
                                    </tr>	                         
                                <?php
                                endif;?>
                            	</tbody>         
                            </table>
                        </div><!-- content -->
                        <div class="footer">
                            <div class="side fr">
                                <div class="btn-group">
                                    &nbsp;
                                </div>
                            </div>
                        </div>                                    
                        </div><!-- block -->
                    </div><!-- span12 -->
                </div><!-- row-fluid -->	
            </div><!-- wrap -->
        </div><!-- content -->
	</div>
</div>