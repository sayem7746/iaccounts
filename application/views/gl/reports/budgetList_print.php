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
	var url = "<?php echo base_url()?>glreports/BudgetList_excel/<?php echo $year?>";
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
            			<th><?php echo $this->lang->line('acctCode')?></th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 1</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 2</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 3</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 4</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 5</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 6</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 7</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 8</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 9</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 10</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 11</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 12</th>
            			<th class="tac"><?php echo $this->lang->line('total')?></th>
            		</tr>
        			</thead>
       				 <tbody>
					<?php $bil = 0; 
					$datatbl_total = 0;
					$accountID = '';
					if($budgetdetails){
						foreach($budgetdetails as $datatbl): ?>
                        <?php if($datatbl->acctID != $accountID){ ?>
                        <?php 	if($accountID != '') {?>
                        			<td class="tar"><?php echo number_format($datatbl_total) ?>&nbsp;</td>
                        			</tr>
						<?php } ?>
						<?php		$datatbl_total = $datatbl->amountcr; ?>			
                        <?php 	$accountID = $datatbl->acctID; ?>
                                <tr>
                					<td>&nbsp;&nbsp;<?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2).' [ '.$datatbl->acctName.' ]'?></td>
                        			<td class="tar"><?php echo number_format($datatbl->amountcr)?>&nbsp;</td>
                        <?php }else{?>
						<?php		$datatbl_total = $datatbl_total + $datatbl->amountcr; ?>			
                        			<td class="tar"><?php echo number_format($datatbl->amountcr)?>&nbsp;</td>
                        <?php } ?>
				<?php   endforeach; ?>
                        			<td class="tar"><?php echo number_format($datatbl_total) ?>&nbsp;</td>
                        			</tr>
			<?php }?>
                     </tbody>
                     </table>
</div>
<div style="page-break-after:always"></div>
</html>
