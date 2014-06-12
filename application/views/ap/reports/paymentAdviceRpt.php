<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link  rel="stylesheet" type="text/css"  href="<?php echo base_url()?>css/bootstrap/bootstrap.min.css" />
<style>
@media print {
  .tdPrint{
	  display:none;}
}
</style>

<script>
function do_print(){
	window.print();
}

function getExcelFile(){
	var url = "<?php echo base_url()?>ApTransactionReport/printPaymentAdviceRptExel/<?php echo $id?>";
	window.location.href = url;
	}
</script>

</head>

<body>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<table  style="width:80%; margin-top:100px; margin:auto;">
<tbody >
<?php 
  $currency = "";
  if($rptData){
    foreach($rptData as $row){
         $currency= $row->currencyCode
     ?>
	<tr>
    	<td colspan="2" >
           <p style="text-align: right;padding-right:10px; font-size: 20px; font-weight: 500; line-height: 2;">
      		  <?php echo $this->lang->line('titlePaymentAdvice') ?>
     	  </p>
          <?php 
		  	if($company){
   			 foreach($company as $rowC){
     ?>
          <p style="text-align:center; font-size:16px;"> 
            <span style=" font-weight:800;"><?php echo $rowC->companyName; ?></span> <br />
            <span><?php echo $rowC->companyNo; ?></span><br />
            </p>
            <p style="text-align:center; line-height:1.4;">
            
            <span><?php echo $rowC->line1; ?></span><br />
            <span><?php echo $rowC->line2; ?></span><br />
            <span><?php echo $rowC->line3; ?></span><br />
            <span><?php echo $rowC->companyPostCode.'  '. $rowC->city; ?> </span><br />
            <span><?php echo 'Phone : '.$rowC->phoneNo.'  Fax : '. $rowC->faxNo; ?> </span>
            <span><?php echo $rowC->fldname.'  '. $rowC->fldcountry; ?> </span>
            </p>
            <?php }} ?>
            <hr/>
        </td>
    </tr>
    <tr>
    	<td>
        	<p style="padding-left:10px; "><strong><?php echo $row->supplierName; ?></strong><br/></p>
        	<p style="padding-left:10px; line-height:1.4;">
            
            <?php echo $row->line1; ?> <br/>
            <?php echo $row->line2; ?> <br/>
            <?php echo $row->line3; ?> <br/>
            <?php echo $row->supplierPostCode."  /  ".$row->city; ?> <br/>
            <?php echo $row->fldname."  /  ".$row->fldcountry; ?>
            
         </p>
        </td>
       	<td style="float:right;" valign="top">
        	<p style="line-height:1.4; text-align:left;">
                 <?php echo $this->lang->line('Date') ?> :  <?php echo date("d /M / Y", strtotime($row->paymentDate)); ?>
                 <br>
                 <?php echo $this->lang->line('Form') ?> : <?php echo $row->formNo."(".$row->ID.")"; ?>
                 <br />
                 <?php echo $this->lang->line('PaymentMethod') ?> : <?php echo $row->pMethod; ?>
                 <br />
                 <?php echo $this->lang->line('Currency') ?> : <?php echo $row->currencyCode; ?>
                 <br />
                 <?php echo $this->lang->line('PaytExRate') ?> : <?php echo $row->exchangeRate; ?>
                 <br/>
                 <?php echo $this->lang->line('AmountPaid') ?> : <?php echo number_format($row->amountPaid,2)." ".$row->currencyCode; ?>
                 <br>
                 <?php echo $this->lang->line('RefNo') ?> : <?php echo $row->referenceNo; ?>
            </p>
        </td>
    </tr>
     <?php }}?>  
     <tr><td colspan="2">
      <?php if($rptDataDetail){ ?>
		  <table class="table" cellpadding="0" cellspacing="0" width="80%">
          
                <thead>
                    <tr style="background:url(<?php echo base_url()?>img/rptPaymentAdvice.png)">
                    <th><?php echo $this->lang->line('Sno') ?></th>
                    <th><?php echo $this->lang->line('invoiceDate') ?></th>
                    <th><?php echo $this->lang->line('invoiceno') ?></th>
                    <th><?php echo $this->lang->line('amount'). " (".$currency.") " ?></th>
                    
                    </tr>
                </thead>
                <tbody>
             <?php
              $i=1;
              $total=0;
            foreach($rptDataDetail as $row1){
                $total = $total + $row1->amountApplied;
             ?>
             <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row1->invoiceDate; ?></td>
                <td><?php echo $row1->supplierInvoiceNo; ?></td>
                <td style=" text-align:right;"><?php echo number_format($row1->amountApplied,2) ; ?></td>
            </tr>
            <?php } 
             echo "<tr><td style='text-align:right;' colspan='4'>Total Amount :  ".number_format($total,2)."</td></tr>";
            } ?>
            	<tr>
                	<td colspan="4">
                     <br /> <br /> <br /> <br />
                    	 <p style="text-align: right; font-size:8px; font-weight:500;"> Prepared by &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        Aprproved By&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       Receive By</p>
                         <br />
                          <br />
                    	<p>
                        
                            <p style="text-align: right; font-weight: 600; font-size: 8px;">SYSTEM GENERATED NO SIGNATURE REQUIRRED</p>
                            <hr style="margin-top:-10px; font-size:20px; font-weight:800;" />
                        	    <div class="row-fluid">
                          <div class="span4"><?php echo date("m/d/Y G:i:s"); ?></div>
                          <div class="span4">Private and Confidential</div>
                          <div class="span4"></div>
    </div>
                        </p>
                    </td>
                </tr>
                <tr class="tdPrint">
                <td align="center" colspan="4">
        	<button title="Print" class="btn btn-primary Print" onclick="do_print()" type="button" name="Print"><i class="icon-print"></i></button> <button title="Download" class="btn btn-primary EXCEL" onclick="getExcelFile()" type="button" name="EXCEL"><i class="icon-download"></i></button>&nbsp;&nbsp; <button title="Close" class="btn btn-warning Close" onclick="javascript:window.close();" type="button" name="Close"><i class="icon-off"></i></button>        </td>
                </tr>
             </tbody>
    		</table>    
     </td></tr>
   
</tbody>
</table>
  


</body>
</html>