<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->lang->line('title')?> - <?php echo $year ?></title>
<link rel="stylesheet" href="<?php echo base_url()?>css/stylesheets.css" type="text/css" />
<style media="print" type="text/css">
	/*body{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}*/
	.printButton { display: none; }
</style>
<script language="javascript" type="text/javascript">	
function do_print(){
	window.print();
}
function do_printexcel(){
	var url = "<?php echo base_url()?>glreports/financialPosition_excel/<?php echo $year?>";
	window.location.href = url;
}
/*
function do_printexcel(){
	var url = "<?php echo base_url()?>glreports/accountBalanceSummary_print";
		url = url + "<?php echo $add_month?>/EXCEL";
		window.location.href = url;
} */
</script>
</head>
<div class="printButton" align="center">
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr>
        <td align="center" colspan="2">
        	<?php 
			$js = 'onClick="do_print()" class="btn btn-primary Print" title="Print"';
			echo form_button('Print','<span class="i-printer">',$js);?>&nbsp;&nbsp; <?php
			$js = 'onClick="do_printexcel()" class="btn btn-primary EXCEL" title="Download"';
			echo form_button('EXCEL','<span class="i-download">',$js);?>&nbsp;&nbsp; <?php
			$js = 'onClick="javascript:window.close();" class="btn btn-warning Close" title="Close"';
			echo form_button('Close','<span class="i-switch">',$js);?>
        </td>
    </tr>
</table>
</div>
<div>
	<table border="1" cellpadding="1" cellspacing="0" width="100%">
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
</div>
<div style="page-break-after:always"></div>
</html>
