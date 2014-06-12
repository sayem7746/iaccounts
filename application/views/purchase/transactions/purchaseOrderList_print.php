<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supplier Payment List<?php echo $mode.'/'.$dateFrom.'/'.$dateTo ?></title>
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
	var url = "<?php echo base_url()?>PO_Transaction/poList_excel/<?php echo $mode?>/<?php echo $dateFrom?>/<?php echo $dateTo?>";
	window.location.href = url;
}
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
			<th class="tal"><?php echo $this->lang->line('supplierName') ?></th>
			<th><?php echo $this->lang->line('purchaseOrderNo') ?></th>
			<th class="tal"><?php echo $this->lang->line('salesAgentName') ?></th>
			<th><?php echo $this->lang->line('formNo') ?></th>
            <th><?php echo $this->lang->line('poDate') ?></th>               
		</tr>
		</thead>
		<tbody>
	<?php $bil = 0;
			//echo var_dump($datatbls); 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td  class="tac"><?php echo $bil; ?></td>
                	<td><?php echo $datatbl->supplierName ?></td>
                    <td class="tac"><?php echo $datatbl->purchaseOrderNo ?></td>
                    <td><?php echo $datatbl->salesAgentName ?></td>
                	<td class="tac"><?php echo $datatbl->formNo.'['.$this->FormSetup_model->getFormSerialNo_zeroLeading($datatbl->ID).']'; ?></td>
                    <td class="tac"><?php echo date('d-m-Y', strtotime($datatbl->poDate)); ?></td>
                </tr>
            <?php endforeach; }?>
		</tbody>
	</table>                                         
</div>
<div style="page-break-after:always"></div>
</html>
