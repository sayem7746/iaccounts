<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->lang->line('title') ?> <?php echo $selyear ?></title>
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
	var url = "<?php echo base_url()?>glreports/tbfy_excel/<?php echo $selyear?>";
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
                        <th class="tac"><?php echo $this->lang->line('lastyear') ?></th>
                        <th class="tac"><?php echo $this->lang->line('thisyear') ?></th>
            		</tr>
        			</thead>
       				 <tbody><?php
						$bil = 0; 
						if($datatbls){
							$total_thisyear = 0;
							$total_lastyear = 0;
							foreach($datatbls as $datatbl):
							if($datatbl->lastyeardebit == 0 && $datatbl->lastyearcredit == 0 && $datatbl->currentyeardebit == 0 && $datatbl->currentyearcredit == 0 ){
							}else{
 							$bil++?>
                            <tr>
                				<td class="tac"><?php echo $bil; ?></td>
                    			<td>&nbsp;&nbsp;
									<?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2) ?></td>
                    			<td>&nbsp;&nbsp;<?php echo $datatbl->acctName ?></td>
                    			<td class="tar"><?php echo number_format($datatbl->lastyeardebit - $datatbl->lastyearcredit,2) ?>&nbsp;</td>
                    			<td class="tar"><?php echo number_format(($datatbl->lastyeardebit - $datatbl->lastyearcredit)+
									($datatbl->currentyeardebit - $datatbl->currentyearcredit),2) ?>&nbsp;</td>
                            </tr>
								<?php $total_thisyear = $total_thisyear + ($datatbl->lastyeardebit - $datatbl->lastyearcredit)+
									($datatbl->currentyeardebit - $datatbl->currentyearcredit); ?>
								<?php $total_lastyear = $total_lastyear + ($datatbl->lastyeardebit - $datatbl->lastyearcredit); ?>
                                <?php }
            			 	endforeach; ?>
						<?php } ?>
					</tbody>
			</table>                                         
</div>
<div style="page-break-after:always"></div>
</html>
