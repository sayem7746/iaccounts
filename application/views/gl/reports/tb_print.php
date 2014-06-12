<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
 	$("#level2").hide();
   var oTable = $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null, 
			null, { 
			"bSortable": false }, { 
			"bSortable": false }, { 
			"bSortable": false }, { 
			"bSortable": false } ]});
     oTable.fnSort( [ [1,'asc'] ] );
    $("table.editable").on("click",".edit",function(){
        rRow = $(this).parents("tr");
        ID = $('td:first', $(this).parents('tr')).text(); 
		var selper = <?php echo $selper;?>;
		var selyear = <?php echo $selyear;?>;
        $("#row_edit").dialog("open");
    });
    $("#row_edit").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
				window.location.href = "<?php echo base_url(); ?>glreports/accountDetails/" + ID + "/<?php echo $selyear;?>/<?php echo $selper;?>";		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
}); 

function do_print(){
	window.open("<?php echo base_url() ?>glreports/trialBalance_print1/<?php echo $selyear?>/<?php echo $selper?>");
}
</script>

<div class="head print">
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
</div><!-- head --> 
<div class="content">
<div class="wrap">                    
	<div class="row-fluid">
		<div class="span12">
        	<div class="block">
            	<div class="head">
                	<h2><?php echo $this->lang->line('title1') . ' :   ' . $selper . ' - ' . $selyear ?> </h2>
                    <div class="side fr">
                         <button class="btn btn-link" onClick="do_print()">Print</button>
                    </div>
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th class="tac">#</th>
                        <th><?php echo $this->lang->line('acctNo') ?></th>
                        <th><?php echo $this->lang->line('description') ?></th>
    			      	<th class="tac"><?php echo $this->lang->line('yeardebit') ?></th>
    			      	<th class="tac"><?php echo $this->lang->line('yearcredit') ?></th>
                        <th class="tac"><?php echo $this->lang->line('monthdebit') ?></th>
                        <th class="tac"><?php echo $this->lang->line('monthcredit') ?></th>
            		</tr>
        			</thead>
       				 <tbody><?php
						$bil = 0; 
						if($datatbls){
							foreach($datatbls as $datatbl):
							if($datatbl->yeardebit == 0 && $datatbl->yearcredit == 0 && $datatbl->thismonthdr == 0 && $datatbl->thismonthcr == 0 ){
							}else{
 							$bil++?>
                            <tr>
                				<td style="display:none" ><?php echo $datatbl->ID; ?></td>
                				<td class="tac"><?php echo $bil; ?></td>
                    			<td><a title="<?php echo $this->lang->line('details');?>" class="btn btn-mini btn-link edit"><?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2) ?></a></td>
                    			<td><?php echo $datatbl->acctName ?></td>
                    			<td class="tar"><?php echo number_format($datatbl->yeardebit,2) ?></td>
                    			<td class="tar"><?php echo number_format($datatbl->yearcredit,2) ?></td>
                    			<td class="tar"><?php echo number_format($datatbl->thismonthdr,2) ?></td>
                    			<td class="tar"><?php echo number_format($datatbl->thismonthcr,2) ?></td>
                            </tr>
                                <?php }
            			 	endforeach; 
						} ?>
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
<div class="dialog" id="row_edit" style="display: none;" title="<?php echo $this->lang->line('edit');?> ?">
    <p><?php echo $this->lang->line('message1');?></p>
</div>  
