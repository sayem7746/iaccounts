<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->lang->line('title') ?> <?php echo $year ?></title>
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
	var url = "<?php echo base_url()?>glreports/profitNloss_excel/<?php echo $year?>";
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
                        <th align="left">&nbsp;&nbsp;<?php echo $this->lang->line('description') ?></th>
                        <th class="tar"><?php echo $this->lang->line('thisyear') ?>&nbsp;&nbsp;</th>
            		</tr>
        			</thead>
       				 <tbody>
	<?php $bil = 0; 
	$datatbl_total = 0;
	if($accountGroup){
		foreach($accountGroup as $datatbl):
			$bil++?>
 			<?php if ($datatbl->title == 1) {?>
            		<tr>
                		<td colspan="2">&nbsp;<strong><?php echo $this->lang->line($datatbl->acctGroupName)?></strong></td>
                	</tr>
            <?php }?>
      <?php foreach($accountdetails as $row):
				if($row->acctGroupID == $datatbl->ID){?>
      	<?php 
					if($row->currentyeardebit != '' && $row->currentyearcredit !=''){ ?>
                 <?php $totalamount = $row->currentyearcredit - $row->currentyeardebit ?>
            			<tr>
                			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                			<td class="tar"><?php echo ($totalamount == 0 )?'':number_format($totalamount,2)?>&nbsp;&nbsp;</td>
                		</tr>
             	<?php
						$datatbl_total = $datatbl_total + $totalamount;
							?>
			<?php   } ?>
			<?php } ?>
		<?php endforeach;?>
      	<?php if($groupdetails){ 
				foreach($groupdetails as $rowdet):
							$rowdet_credit = 0;
					if($rowdet->parentID == $datatbl->ID){
						if ($rowdet->title == 1) {?>
            				<tr>
                				<td colspan="2">&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet->acctGroupName)?></strong></td>
                			</tr>
                	<?php } ?>
      				<?php foreach($accountdetails as $row):
							if($row->acctGroupID == $rowdet->ID){?>
      	<?php 
								if($row->currentyeardebit != '' && $row->currentyearcredit !=''){ ?>
                 			<?php   $totalamount = $row->currentyearcredit - $row->currentyeardebit ?>
            						<tr>
                						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                						<td class="tar"><?php echo ($totalamount == 0 )?'':number_format($totalamount,2)?>&nbsp;&nbsp;</td>
                					</tr>
             	<?php
											$rowdet_credit = $rowdet_credit + $totalamount;
											$datatbl_total = $datatbl_total + $totalamount;
							?>
						<?php  } ?>
					<?php } ?>
				<?php endforeach;?>
				<?php foreach($groupdetails as $rowdet1): 
					$rowdet1_credit = 0; ?>
				<?php	if($rowdet1->parentID == $rowdet->ID){
							if ($rowdet1->title == 1) {?>
            					<tr>
                					<td colspan="2">&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet1->acctGroupName)?></strong></td>
                				</tr>
                	<?php 	} ?>
				<?php   foreach($groupdetails as $rowdet2): 
					$rowdet2_credit = 0; ?>
				<?php		if($rowdet2->parentID == $rowdet1->ID){
								if ($rowdet2->title == 1) {?>
            						<tr>
                						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet2->acctGroupName)?></strong></td>
                					</tr>
                	<?php 		} ?>
 				<?php   foreach($groupdetails as $rowdet3): 
					$rowdet3_credit = 0; ?>
				<?php		if($rowdet3->parentID == $rowdet2->ID){
								if ($rowdet3->title == 1) {?>
            						<tr>
                						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet3->acctGroupName)?></strong></td>
                					</tr>
                	<?php 		} ?>
     				<?php 	  foreach($accountdetails as $row2):
									if($row2->acctGroupID == $rowdet3->ID){?>
      	<?php 

										if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php   		  $totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            								<tr>
                								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                								<td class="tar"><?php echo ($totalamount < 0 )?number_format($totalamount * -1,2):number_format($totalamount,2)?>&nbsp;&nbsp;</td>
                							</tr>
             	<?php
											$rowdet_credit = $rowdet_credit + $totalamount;
											$rowdet1_credit = $rowdet1_credit + $totalamount;
											$rowdet2_credit = $rowdet2_credit + $totalamount;
											$rowdet3_credit = $rowdet3_credit + $totalamount;
											$datatbl_total = $datatbl_total + $totalamount;
							?>
						<?php  		} ?>
                	<?php   		  }	 ?>
				<?php   		  endforeach;?>
            						<tr>
                						<td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo $this->lang->line($rowdet3->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                						<td class="tar"><?php echo ($rowdet3_credit < 0 )?number_format($rowdet3_credit * -1,2):number_format($rowdet3_credit,2) ?>&nbsp;&nbsp;</td>
                					</tr>
                	<?php 		} ?>
				<?php   		  endforeach;?>
     				<?php 	  foreach($accountdetails as $row2):
									if($row2->acctGroupID == $rowdet2->ID){?>
      	<?php 
										if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php   		  $totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            								<tr>
                								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                								<td class="tar"><?php echo ($totalamount < 0 )?number_format($totalamount * -1,2):number_format($totalamount,2)?>&nbsp;&nbsp;</td>
                							</tr>
             	<?php
											$rowdet_credit = $rowdet_credit + $totalamount;
											$rowdet1_credit = $rowdet1_credit + $totalamount;
											$rowdet2_credit = $rowdet2_credit + $totalamount;
											$datatbl_total = $datatbl_total + $totalamount;
							?>
						<?php  		} ?>
                	<?php   		  }	 ?>
				<?php   		  endforeach;?>
            						<tr>
                						<td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo $this->lang->line($rowdet2->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                						<td class="tar"><?php echo ($rowdet2_credit < 0 )?number_format($rowdet2_credit * -1,2):number_format($rowdet2_credit,2) ?>&nbsp;&nbsp;</td>
                					</tr>
                	<?php   } ?>
				<?php   endforeach;?>
      			<?php   foreach($accountdetails as $row2):
							if($row2->acctGroupID == $rowdet1->ID){?>
      	<?php 
								if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php 	$totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            							<tr>
                							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                							<td class="tar"><?php echo ($totalamount < 0 )?number_format($totalamount * -1,2):number_format($totalamount,2)?>&nbsp;&nbsp;</td>
                						</tr>
             	<?php
										$rowdet_credit = $rowdet_credit + $totalamount;
										$rowdet1_credit = $rowdet1_credit + $totalamount;
										$datatbl_total = $datatbl_total + $totalamount;
							?>
						<?php  	} ?>
                	<?php   	}	 ?>
				<?php 	endforeach;?>
            			  <tr>
                			<td><strong>&nbsp;&nbsp;&nbsp;&nbsp;
								<?php echo $this->lang->line($rowdet1->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                			<td class="tar"><?php echo number_format($rowdet1_credit,2) ?>&nbsp;&nbsp;</td>
                		  </tr>
                	<?php } ?>
				<?php endforeach;?>
            			  <tr>
                			<td><strong>
								<?php echo $this->lang->line($rowdet->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                			<td class="tar"><?php echo number_format($rowdet_credit,2) ?>&nbsp;&nbsp;</td>
                		  </tr>
<!-- row det -->
                <?php } ?>
		<?php  endforeach; ?>
            			  <tr>
                			<td><h4><?php echo $this->lang->line($datatbl->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></h4></td>
                			<td class="tar"><?php echo number_format($datatbl_total,2) ?>&nbsp;&nbsp;</td>
                		  </tr>
        <?php } ?>
<?php  endforeach; ?>
		<!--tr>
			<td><h4><?php echo $this->lang->line('netincome') ?></h4></td>
        	<td class="tar"><?php echo number_format($datatbl_total,2) ?>&nbsp;&nbsp;</td>
  		</tr -->
	<?php }?>
                     </tbody>
                     </table>
</div>
<div style="page-break-after:always"></div>
</html>
