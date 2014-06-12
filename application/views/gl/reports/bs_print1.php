<?
if($prn=='EXCEL'){
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=Asset_Disposal_Summary.xls");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Assets - Depreciation Summary Report</title>
<link rel="stylesheet" href="../../css/stylesheets.css" type="text/css" />
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
	url = url + "assetreport/depr_summary_print/<?php echo $add_year;?>/";
	url = url + "EXCEL";
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
    			      	<th>#</th>
    			      	<th>Asset Type</th>
   				       	<th><?php echo date("M", strtotime("2014-01-01")); ?></th>
  			        	<th><?php echo date("M", strtotime("2014-02-01")); ?></th>
   			        	<th><?php echo date("M", strtotime("2014-03-01")); ?></th>
    			      	<th><?php echo date("M", strtotime("2014-04-01")); ?></th>
     			 		<th><?php echo date("M", strtotime("2014-05-01")); ?></th>
    			  		<th><?php echo date("M", strtotime("2014-06-01")); ?></th>
    			    	<th><?php echo date("M", strtotime("2014-07-01")); ?></th>
      				   	<th><?php echo date("M", strtotime("2014-08-01")); ?></th>
     			  		<th><?php echo date("M", strtotime("2014-09-01")); ?></th>
      				  	<th><?php echo date("M", strtotime("2014-10-01")); ?></th>
      				  	<th><?php echo date("M", strtotime("2014-11-01")); ?></th>
						<th><?php echo date("M", strtotime("2014-12-01")); ?></th>
						<th>Total Amount</th>
            		</tr>
        			</thead>
       				 <tbody><?php
					 	$bil = 1;
						$tjan = 0;
						$tfeb = 0;
						$tmac = 0;
						$tapr = 0;
						$tmay = 0;
						$tjun = 0;
						$tjul = 0;
						$taug = 0;
						$tsep = 0;
						$toct = 0;
						$tnov = 0;
						$tdec = 0;
						$ttotal = 0;
						$assettype = '';
						if($datatbls){
							foreach($datatbls as $datatbl):
								if($assettype == ''){ 
									$assettype = $datatbl->aset_type;
									$jan = 0;
									$feb = 0;
									$mac = 0;
									$apr = 0;
									$may = 0;
									$jun = 0;
									$jul = 0;
									$aug = 0;
									$sep = 0;
									$oct = 0;
									$nov = 0;
									$dec = 0;
									$total = 0;
								}else if($assettype <> $datatbl->aset_type){ ?>
            						<tr>
    	    	        			<td><?php echo $bil; ?></td>
    	    	        			<td><?php echo $assettype; ?></td>
                					<td align="right"><?php echo $jan; ?></td>
                					<td align="right"><?php echo $feb; ?></td>
		                			<td align="right"><?php echo $mac; ?></td>
        		        			<td align="right"><?php echo $apr; ?></td>
                					<td align="right"><?php echo $may; ?></td>
                					<td align="right"><?php echo $jun; ?></td>
		                			<td align="right"><?php echo $jul; ?></td>
        		        			<td align="right"><?php echo $aug; ?></td>
                					<td align="right"><?php echo $sep; ?></td>
                					<td align="right"><?php echo $oct; ?></td>
		                			<td align="right"><?php echo $nov; ?></td>
        		        			<td align="right"><?php echo $dec; ?></td>
                					<td align="right"><?php echo $total; ?></td>
                        			</tr>
                                    <?php
									$bil++;
									$tjan = $tjan + $jan;
									$tfeb = $tfeb + $feb;
									$tmac = $tmac + $mac;
									$tapr = $tapr + $apr;
									$tmay = $tmay + $may;
									$tjun = $tjun + $jun;
									$tjul = $tjul + $jul;
									$taug = $taug + $aug;
									$tsep = $tsep + $sep;
									$toct = $toct + $oct;
									$tnov = $tnov + $nov;
									$tdec = $tdec + $dec;
									$ttotal = $ttotal + $total;
									
									$jan = 0;
									$feb = 0;
									$mac = 0;
									$apr = 0;
									$may = 0;
									$jun = 0;
									$jul = 0;
									$aug = 0;
									$sep = 0;
									$oct = 0;
									$nov = 0;
									$dec = 0;
									$total = 0;
									$assettype = $datatbl->aset_type; 
								}
								switch ($datatbl->period){
								case '01':
									$jan = $jan + round($datatbl->amount);
									break;
								case '02':
									$feb = $feb + round($datatbl->amount);
									break;
								case '03':
									$mac = $mac + round($datatbl->amount);
									break;
								case '04':
									$apr = $apr + round($datatbl->amount);
									break;
								case '05':
									$may = $may + round($datatbl->amount);
									break;
								case '06':
									$jun = $jun + round($datatbl->amount);
									break;
								case '07':
									$jul = $jul + round($datatbl->amount);
									break;
								case '08':
									$aug = $aug + round($datatbl->amount);
									break;
								case '09':
									$sep = $sep + round($datatbl->amount);
									break;
								case '10':
									$oct = $oct + round($datatbl->amount);
									break;
								case '11':
									$nov = $nov + round($datatbl->amount);
									break;
								case '12':
									$dec = $dec + round($datatbl->amount);
									break;
								}
								$total = $total + round($datatbl->amount);
									?>
                                <?php
							?>
            			<?php endforeach; }
  									$tjan = $tjan + $jan;
									$tfeb = $tfeb + $feb;
									$tmac = $tmac + $mac;
									$tapr = $tapr + $apr;
									$tmay = $tmay + $may;
									$tjun = $tjun + $jun;
									$tjul = $tjul + $jul;
									$taug = $taug + $aug;
									$tsep = $tsep + $sep;
									$toct = $toct + $oct;
									$tnov = $tnov + $nov;
									$tdec = $tdec + $dec;
									$ttotal = $ttotal + $total;
?>
            						<tr>
    	    	        			<td><?php echo $bil; ?></td>
    	    	        			<td><?php echo $assettype; ?></td>
                					<td align="right"><?php echo $jan; ?></td>
                					<td align="right"><?php echo $feb; ?></td>
		                			<td align="right"><?php echo $mac; ?></td>
        		        			<td align="right"><?php echo $apr; ?></td>
                					<td align="right"><?php echo $may; ?></td>
                					<td align="right"><?php echo $jun; ?></td>
		                			<td align="right"><?php echo $jul; ?></td>
        		        			<td align="right"><?php echo $aug; ?></td>
                					<td align="right"><?php echo $sep; ?></td>
                					<td align="right"><?php echo $oct; ?></td>
		                			<td align="right"><?php echo $nov; ?></td>
        		        			<td align="right"><?php echo $dec; ?></td>
                					<td align="right"><?php echo $total; ?></td>
                        			</tr>
                                    <?php $bil++; ?>
            						<tr>
    	    	        			<td><?php echo $bil; ?></td>
    	    	        			<td>Total Amount</td>
                					<td align="right"><?php echo $tjan; ?></td>
                					<td align="right"><?php echo $tfeb; ?></td>
		                			<td align="right"><?php echo $tmac; ?></td>
        		        			<td align="right"><?php echo $tapr; ?></td>
                					<td align="right"><?php echo $tmay; ?></td>
                					<td align="right"><?php echo $tjun; ?></td>
		                			<td align="right"><?php echo $tjul; ?></td>
        		        			<td align="right"><?php echo $taug; ?></td>
                					<td align="right"><?php echo $tsep; ?></td>
                					<td align="right"><?php echo $toct; ?></td>
		                			<td align="right"><?php echo $tnov; ?></td>
        		        			<td align="right"><?php echo $tdec; ?></td>
                					<td align="right"><?php echo $ttotal; ?></td>
                        			</tr>
					</tbody>
			</table>                                         
</div>
<div style="page-break-after:always"></div>
</form>
</html>
