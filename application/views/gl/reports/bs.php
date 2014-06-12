<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
   $('select').select2();
   var oTable = $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null, 
			null,
			null ]});
     oTable.fnSort( [ [1,'asc'] ] );
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
				window.location.href = "<?php echo base_url(); ?>glreports/journalDetails/" + ID;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
}); 
function do_print(){
	var addyear = $('#add_year option:selected').val();
	window.open("<?php echo base_url() ?>glreports/financialPosition_print/"+addyear);
}
 
function changeList(){
	var addyear = $('#add_year option:selected').val();
	var urls = "<?php echo base_url();?>glreports/financialposition/"+addyear;
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
            	<li><a href="#"><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href="<?php echo base_url()?>generalLedger/home"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('title') ?></li>
            </ul>
		</div><!-- info -->
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
                    <div class="side fr">
                         <button class="btn btn-link" onClick="do_print()">Print</button>
                    </div>
                    </div><!-- head -->
				<div class="content np">    
                	<div class="controls-row"><!-- Row 4-->
						<div class="span5 tac">
                    	<div class="span2 tar"><?php echo form_label($this->lang->line('year'),'add_year');?></div>
						<?php
							$preselyear = $selyear;
							$options = '';
							foreach($yrs as $row){
								$options[$row] = $row;
							}
							$js='class="input-medium" id="add_year"';

							echo form_dropdown('add_year', $options, $preselyear, $js);
						?>       
                        </div>
						<div class="span2 tac">
                        <?php 
							$data = array(
									'name'=>'mysubmit', 
									'class'=>'btn btn-small btn-primary');
									$js="onClick='changeList()'";
							echo form_button($data,$this->lang->line('generatereport'),$js);
							?>
                        </div>
                 	</div><!-- End Row 4-->
				</div><!-- content -->
            	<div class="content np">
            	<table cellpadding="0" cellspacing="0" width="100%">
                	<thead>
                    <tr>
                        <th><?php echo $this->lang->line('description') ?></th>
                        <th class="tac"><?php echo $this->lang->line('lastyear') ?></th>
                        <th class="tac"><?php echo $this->lang->line('thisyear') ?></th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php 
				if($accountGroup){
				foreach($accountGroup as $datatbl):
							$total_thisyear = 0;
							$total_lastyear = 0;
                            $thisyear_amount = 0;
                            $lastyear_amount = 0;
				?>
  			<?php if ($datatbl->title == 1) {?>
           	<tr>
                	<td colspan="3"><h5><?php echo $this->lang->line($datatbl->acctGroupName)?></h5></td>
                </tr>
                <?php } ?>
                	<?php foreach($groupdetails as $rowdet):
									$rowdet_thisyeartotal = 0;
									$rowdet_lastyeartotal = 0;
							if($rowdet->parentID == $datatbl->ID){?>
  						<?php if ($rowdet->title == 1) {?>
            					<tr>
                					<td colspan="3">&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet->acctGroupName)?></strong></td>
                				</tr>
                <?php } ?>
                				<?php foreach($groupdetails as $rowdet1):
									$rowdet1_thisyeartotal = 0;
									$rowdet1_lastyeartotal = 0;
										if($rowdet1->parentID == $rowdet->ID){?>
  											<?php if ($rowdet1->title == 1) {?>
            								<tr>
                								<td colspan="3">&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet1->acctGroupName)?></strong></td>
                							</tr>
                <?php } ?>
                				<?php foreach($accountdetails as $row):
										if($row->acctGroupID == $rowdet1->ID){?>
                                       <?php	if($row->lastyeardebit == 0 && $row->lastyearcredit == 0 && $row->currentyeardebit == 0 && $row->currentyearcredit == 0){ }else{ ?>
            								<tr>
                								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                								<td class="tar"><?php echo number_format($row->lastyeardebit-$row->lastyearcredit,2) ?></td>
                								<td class="tar"><?php echo number_format(($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit),2) ?></td>
                							</tr>
                                            <?php $rowdet1_thisyeartotal = $rowdet1_thisyeartotal + 
												($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $rowdet1_lastyeartotal = $rowdet1_lastyeartotal + ($row->lastyeardebit-$row->lastyearcredit);?>
                                            <?php $rowdet_thisyeartotal = $rowdet_thisyeartotal + 
												($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $rowdet_lastyeartotal = $rowdet_lastyeartotal + ($row->lastyeardebit-$row->lastyearcredit);?>
                                            <?php $total_thisyear = $total_thisyear + ($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $total_lastyear = $total_lastyear + ($row->lastyeardebit-$row->lastyearcredit);?>
                                    <?php } ?>        
			            		<?php 	}
								endforeach;?>
            					<tr>
                					<td>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line($rowdet1->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></td>
                					<td class="tar"><?php echo number_format($rowdet1_lastyeartotal,2) ?></td>
                					<td class="tar"><?php echo number_format($rowdet1_thisyeartotal,2) ?></td>
                				</tr>
			            		<?php 	}
								endforeach;?>
                				<?php foreach($accountdetails as $row):
										if($row->acctGroupID == $rowdet->ID){?>
                                       <?php	if($row->lastyeardebit == 0 && $row->lastyearcredit == 0 && $row->currentyeardebit == 0 && $row->currentyearcredit == 0){ }else{ ?>
            								<tr>
                								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                								<td class="tar"><?php echo number_format($row->lastyeardebit-$row->lastyearcredit,2) ?></td>
                								<td class="tar"><?php echo number_format(($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit),2) ?></td>
                							</tr>
                                            <?php $total_thisyear = $total_thisyear + ($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $total_lastyear = $total_lastyear + ($row->lastyeardebit-$row->lastyearcredit);?>
                                            <?php $rowdet_thisyeartotal = $rowdet_thisyeartotal + 
												($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $rowdet_lastyeartotal = $rowdet_lastyeartotal + ($row->lastyeardebit-$row->lastyearcredit);?>
                                     <?php } ?>
			            		<?php 	}
								endforeach;?>
            					<tr>
                					<td>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line($rowdet->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></td>
                					<td class="tar"><?php echo number_format($rowdet_lastyeartotal,2) ?></td>
                					<td class="tar"><?php echo number_format($rowdet_thisyeartotal,2) ?></td>
                				</tr>
            		<?php 	}
							endforeach;?>
                				<?php foreach($accountdetails as $row):
										if($row->acctGroupID == $datatbl->ID){?>
                                <?php        	if($row->acctCode == '130000000') { ?>
                                <?php 			$thisyear_amount = $currentretained * -1;?>
                                <?php 			$lastyear_amount = $row->lastyeardebit-$row->lastyearcredit?>
                                <?php 		}else{ ?>
                                <?php 			$thisyear_amount = ($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit)?>
                                <?php 			$lastyear_amount = $row->lastyeardebit-$row->lastyearcredit?>
                                <?php 		} ?>
            								<tr>
                								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                								<td class="tar"><?php echo number_format($lastyear_amount,2) ?></td>
                								<td class="tar"><?php echo number_format($thisyear_amount,2) ?></td>
                							</tr>
                                            <?php $total_thisyear = $total_thisyear + $thisyear_amount;?>
                                            <?php $total_lastyear = $total_lastyear + $lastyear_amount;?>
			            		<?php 	}
								endforeach;?>
            					<tr>
                					<td><h4><?php echo $this->lang->line($datatbl->acctGroupName)?> <?php echo $this->lang->line('total') ?></h4></td>
                					<td class="tar"><?php echo number_format($total_lastyear,2) ?></td>
                					<td class="tar"><?php echo number_format($total_thisyear,2) ?></td>
                				</tr>
            <?php endforeach; }?>
                     </tbody>
                     </table>
				</div><!-- content -->
				</div><!-- block -->
			</div><!-- span12 -->
		</div><!-- row-fluid -->	
	</div><!-- wrap -->
</div><!-- content -->
<div class="dialog" id="row_edit" style="display: none;" title="<?php echo $this->lang->line('edit');?> ?">
    <p><?php echo $this->lang->line('message1');?></p>
</div>  
