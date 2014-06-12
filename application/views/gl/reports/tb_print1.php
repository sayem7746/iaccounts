<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->lang->line('title') ?> <?php echo $selper.'/'.$selyear ?></title>
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
	var url = "<?php echo base_url()?>glreports/tb_excel/<?php echo $selyear?>/<?php echo $selper?>";
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
						$YTDtotal_credit = 0;
						$YTDtotal_debit = 0;
						$total_credit = 0;
						$total_debit = 0;
						if($datatbls){
							foreach($datatbls as $datatbl):
							if($datatbl->yeardebit == 0 && $datatbl->yearcredit == 0 && $datatbl->thismonthdr == 0 && $datatbl->thismonthcr == 0 ){
							}else{
 							$bil++?>
                            <tr>
                				<td class="tac"><?php echo $bil; ?></td>
                    			<td>&nbsp;&nbsp;<?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2) ?></td>
                    			<td>&nbsp;&nbsp;<?php echo $datatbl->acctName ?></td>
                    			<td class="tar"><?php echo number_format($datatbl->yeardebit,2) ?>&nbsp;</td>
                    			<td class="tar"><?php echo number_format($datatbl->yearcredit,2) ?>&nbsp;</td>
                    			<td class="tar"><?php echo number_format($datatbl->thismonthdr,2) ?>&nbsp;</td>
                    			<td class="tar"><?php echo number_format($datatbl->thismonthcr,2) ?>&nbsp;</td>
                            </tr>
                                <?php }
  								$YTDtotal_debit = $YTDtotal_debit + $datatbl->yeardebit;
  								$YTDtotal_credit = $YTDtotal_credit + $datatbl->yearcredit;
  								$total_debit = $total_debit + $datatbl->thismonthdr;
  								$total_credit = $total_credit + $datatbl->thismonthcr;
            			 	endforeach; ?>
                            <tr>
                				<td class="tac"></td>
                    			<td colspan="2" class="tac">&nbsp;&nbsp;<h4><?php echo $this->lang->line('total') ?></h4></td>
                    			<td class="tar"><?php echo number_format($YTDtotal_debit,2) ?>&nbsp;</td>
                    			<td class="tar"><?php echo number_format($YTDtotal_credit,2) ?>&nbsp;</td>
                    			<td class="tar"><?php echo number_format($total_debit,2) ?>&nbsp;</td>
                    			<td class="tar"><?php echo number_format($total_credit,2) ?>&nbsp;</td>
                            </tr>
					<?php	} ?>
					</tbody>
			</table>                                         
</div>
<div style="page-break-after:always"></div>
</html>
