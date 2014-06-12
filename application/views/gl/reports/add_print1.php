<?
if($prn=='EXCEL'){
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=Asset_Addition_Report.xls");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Assets - Additional Summary Report</title>
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
	var url = "<?php echo base_url()?>";
	url = url + "assetreport/add_print/<?php echo $add_year;?>/";
	url = url + "<?php echo $add_month?>/EXCEL";
		window.location.href = url;
}
</script>
</head>
<form name="frm" method="post" action="">
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
            	<table border="1" cellpadding="1" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th align="center">#</th>
            			<th>Asset Number</th>
                		<th>Description</th>
                		<th>Type</th>
                		<th>Custodian</th>                
                		<th>Parents</th>                
                		<th>Purchase Date</th>                
                		<th>Book Value</th>               
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td align="center"><?php echo $bil; ?></td>
                    <td><?php echo $datatbl->aset_number;?></td>
                	<td><?php echo $datatbl->aset_desc; ?></td>
                	<td><?php echo $datatbl->aset_type; ?></td>
                	<td><?php echo $datatbl->aset_custodian; ?></td>
                	<td><?php echo $datatbl->aset_parent; ?></td>
                	<td align="center"><?php echo date("d-m-Y", strtotime($datatbl->aset_pur_dt)); ?></td>
                	<td class="tar"><?php echo number_format($datatbl->aset_book_value, 2, '.', ','); ?></td>
                </tr>
            <?php endforeach; }?>
					</tbody>
			</table>                                         
</div>
<div style="page-break-after:always"></div>
</form>
</html>
