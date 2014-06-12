<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Debit Note</title>
<link rel="stylesheet" href="<?php echo base_url()?>css/stylesheets.css" type="text/css" />
<style media="print" type="text/css">
	/*body{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}*/
	.printButton { display: none; }
</style>
<script language="javascript" type="text/javascript">	
function do_print(){
	window.print();
}
/*function do_printexcel(){
	var url = "<?php //echo base_url()?>aptransaction/printDebitNote_excel/<?php //echo $dateFrom?>/<?php //echo $dateTo?>";
	window.location.href = url;
}*/
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
	<table border="0" cellpadding="1" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th width="20%"></th>
			<th width="20%"></th>
			<th width="20%"></th>
			<th width="20%"></th>
			<th width="30%"><?php echo $this->lang->line('purchaseDebitNote') ?></th>               
		</tr>
        <tr>
			<th></th>
			<th></th>
			<th>DEMO6161</th>
			<th></th>
			<th></th>               
		</tr>
        <tr style="border-bottom:1px solid black">
			<th></th>
			<th></th>
			<td class="tac">GST Reg No : <?php echo $companyInfo->gstRegisteredNo; ?></td>
			<th></th>
			<th></th>               
		</tr>
		</thead>
		<tbody>
        <tr>
        	<td class="tac"><?php echo $debitNote->supplierName; ?></td>
            <td></td>
            <td></td>
            <td colspan="2"><?php echo $this->lang->line('debitNoteNo') ?> : <?php echo $debitNote->formNo.'['.$this->FormSetup_model->getFormSerialNo_zeroLeading($debitNote->ID).']'; ?></td>
        </tr>
        <tr>
        	<td width="20%" class="tac"><?php echo $debitNote->line1; ?></td>
            <td width="20%"></td>
            <td width="20%"></td>
            <td><?php echo $this->lang->line('invoiceNo') ?> : <?php echo $pInvoice->supplierInvoiceNo; ?></td>
        </tr>
        <tr>
        	<td class="tac"><?php echo $debitNote->line2; ?></td>
            <td></td>
            <td></td>
            <td><?php echo $this->lang->line('purInvoiceDate') ?> : <?php echo date("d-m-Y", strtotime($pInvoice->invoiceDate)); ?></td>
        </tr>
        <tr>
        	<td class="tac"><?php echo $debitNote->line3; ?></td>
            <td></td>
            <td></td>
            <td><?php echo $this->lang->line('purDebitNoteDate') ?> : <?php echo date("d-m-Y", strtotime($debitNote->debitNoteDate)); ?></td>
        </tr>
        <tr>
        	<td><?php echo $debitNote->city; ?>,<?php echo $debitNote->supplierPostCode; ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
        </table>
        <table border="0" cellpadding="1" cellspacing="0" width="100%">
		<thead>
        <tr bgcolor="#FFFF00">
        	<th><?php echo $this->lang->line('sNo') ?></th>
            <th><?php echo $this->lang->line('itemCode') ?></th>
            <th><?php echo $this->lang->line('itemName') ?></th>
            <th><?php echo $this->lang->line('itemDesc') ?></th>
            <th><?php echo $this->lang->line('unitPrice') ?></th>
            <th><?php echo $this->lang->line('qty') ?></th>
            <th><?php echo $this->lang->line('amtExGst') ?></th>
            <th><?php echo $this->lang->line('gst') ?></th>
            <th><?php echo $this->lang->line('gstAmt') ?></th>
            <th><?php echo $this->lang->line('amtInGst') ?></th>
        </tr>
        </thead>
        <tbody>
	<?php $bil = 0;
			//echo var_dump($datatbls); 
				if($pdetails){
				foreach($pdetails as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->ID; ?></td>	
                	<td class="tac"><?php echo $bil; ?></td>
                	
                	<td class="tac"><?php echo $datatbl->itemCode ?></td>
                    <td class="tac"><?php echo $datatbl->itemname ?></td>
                    <td class="tac"><?php echo $datatbl->itemdescription ?></td>
                	<td class="tac"><?php echo $datatbl->unitPrice ?></td>
                    <td class="tac"><?php echo $datatbl->quantity ?></td>
                    <td class="tac"><?php echo $datatbl->amountExcludedTax ?></td>
                    <td class="tac"><?php echo $datatbl->taxPercentage?></td>
                    <td class="tac"><?php echo $datatbl->taxAmount?></td>
                    <td class="tac"><?php echo $datatbl->amountIncludedTax?></td>
                </tr>
            <?php endforeach; }?>
            <tr>
        		<td></td>
            	<td></td>
            	<td></td>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        	</tr>
            <tr>
        		<td></td>
            	<td></td>
            	<td></td>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="tar"><?php echo $this->lang->line('netTotal') ?> : <?php 
				$net = 0;
				foreach($pdetails as $datatbl):
					$net = $net + $datatbl->amountExcludedTax;
				endforeach; ?>
 				<?php echo number_format($net, 2); ?></td>
       	</tr>
            <tr>
        		<td></td>
            	<td></td>
            	<td></td>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="tar"><?php echo $this->lang->line('gstPayableTotal') ?> : <?php
				$pay = 0;
				foreach($pdetails as $datatbl): 
					$pay = $pay + $datatbl->taxAmount;
                endforeach; ?>
                <?php echo number_format($pay, 2); ?></td>
        	</tr>
            <tr>
        		<td class="tac"><br><br><br><br>Memo:</td>
            	<td></td>
            	<td></td>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="tar"><br><br><br><br><br><br><?php echo $this->lang->line('preparedBy') ?><br><br><br><br></td>
                <td class="tar"><br><br><br><br><br><br><?php echo $this->lang->line('approvedBy') ?><br><br><br><br></td>
        	</tr>
            <tr>
                <td colspan="10" class="tar"><?php echo $this->lang->line('sys') ?></td>
        	</tr>
            <tr style="border-bottom:1px solid black">
        		<td></td>
            	<td></td>
            	<td></td>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        	</tr>
              <tr>
        		<td colspan="3"><?php 
				echo date("d-m-Y H:i:s A")
				?></td>
                <td colspan="3" class="tac"><?php echo $this->lang->line('private') ?></td>
                <td colspan="4" class="tar">1</td>
        	</tr>
		</tbody>
	</table>                                         
</div>
<div style="page-break-after:always"></div>
</html>
