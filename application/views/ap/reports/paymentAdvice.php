<style type="text/css">

#content .wrap #grid_content_1 .row-fluid.scRow .row-fluid.scRow .span12.scCol #grid_block_5 .content.np #listDetails tbody #trInfos td .row-fluid .controls-row .span3 {
	font-size: 11px;
	color: #000;
	font-weight: bold;
}
.test {
	font-size: 10px;
}
.span3 {
	font-size: 10px;
}
tbody td { font-size:11px;}
#content .wrap #grid_content_1 .row-fluid.scRow .row-fluid.scRow .span12.scCol #grid_block_6 .content.np #listCharge tbody #trInfosCharge td .row-fluid .controls-row .span3 {
	font-weight: bold;
}
</style>


<div id="content"> 
<div class="wrap">
	<div class="head">
		<div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href='<?php echo base_url()."gl/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('titlePaymentAdvice') ?></li>
            </ul>
		</div>
                        
		<div class="search">
			<form action="<?php echo base_url() ?>admin/search" method="post">
				<input name="search_text" type="text" placeholder="search..."/>                                
            	<button type="submit"><span class="i-magnifier"></span></button>
			</form>
		</div>        
                                        
	</div><!-- head --> 
<div class="content" id="grid_content_1">
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_1">
          <div class="content">
          <div class="controls-row">
          <?php 
		  $currency = "";
		  if($rptData){
	 		foreach($rptData as $row){
				 $currency= $row->currencyCode
		     ?>
            <p style="text-align: right; font-size: 20px; font-weight: 500; line-height: 2;">
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
            <p>
          	 <div class="span12">
             	<div class="span6">
                <p style="padding-left:10px; "><strong><?php echo $row->supplierName; ?></strong><br/></p>
        	<p style="padding-left:10px; line-height:1.4;">
            
            <?php echo $row->line1; ?> <br/>
            <?php echo $row->line2; ?> <br/>
            <?php echo $row->line3; ?> <br/>
            <?php echo $row->supplierPostCode."  /  ".$row->city; ?> <br/>
            <?php echo $row->fldname."  /  ".$row->fldcountry; ?>
            
         </p>
                </div> 
                <div class="span6">
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
                 <?php echo $this->lang->line('AmountPaid') ?> : <?php echo  number_format($row->amountPaid,2)." ".$row->currencyCode; ?>
                 <br>
                 <?php echo $this->lang->line('RefNo') ?> : <?php echo $row->referenceNo; ?>
            </p>
                </div>
             </div>
			</p>
            
            <?php }}?>  
         </div> <!-- row -->
        </div><!-- content -->
       </div><!-- grid block 1-->
      </div><!-- scCol -->
	 
      
    </div><!-- row-fluid scRow-->
  
    
	<div class="row-fluid scRow"> 
        
        
        
        
        <div class="block" id="grid_block_4">
	       <div class="head">
           	<h2><?php echo $this->lang->line('paymentdetails') ?></h2>
           	<ul class="buttons">
            	<li><a class="block_toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                        	<span class="i-arrow-down-3"></span></a></li>
          	</ul>                                        
          </div><!-- head -->
          <div class="content np">
   				  <table class="table" cellpadding="0" cellspacing="0" width="100%">
            			<thead>
                			<tr>
                       	 	 <th>S.no</th>
                              <th><?php echo $this->lang->line('invoiceDate') ?></th>
                              <th><?php echo $this->lang->line('invoiceno') ?></th>
                              <th><?php echo $this->lang->line('amount'). " (".$currency.") " ?></th>
                    		</tr>
                		</thead>
                		<tbody>
                  <?php if($rptDataDetail){
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
                    
                   
              </tbody>
            </table>     
          </div><!-- content -->
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
		<div class="block" id="grid_block_4">
          <div class="content np span12">
                     
                  
                  <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
           				<a id="calcul" href="<?php echo base_url()?>ApTransactionReport/printPaymentAdviceRpt/<?php echo $id; ?>" class="btn btn-small btn-primary" type="button"> 
                         <i class="icon-white icon-print "></i> <?php echo $this->lang->line('print') ?></a>-->
       				</div><!-- btn group -->      
       			</div><!-- side fr -->      
       		</div><!-- footer -->   
              </div>    
        </div><!-- grid block 1-->
      </div><!-- scCol -->
    </div><!-- row-fluid scRow-->
</div><!-- grid 1 -->
</div><!-- wrap -->
</div><!-- content -->
                    
                    
   