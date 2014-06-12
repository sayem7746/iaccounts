
	<table border="0" cellpadding="1" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th width="20%"></th>
			<th width="20%"></th>
			<th width="20%"></th>
			<th width="20%"></th>
			<th width="30%">Purchase Debit Note</th>               
		</tr>
        <tr>
			<th></th>
			<th></th>
			<th>DEMO6161</th>
			<th></th>
			<th></th>               
		</tr>
        <tr>
			<th></th>
			<th></th>
			<th>GST Reg No : <?php echo $companyInfo->gstRegisteredNo; ?></th>
			<th></th>
			<th></th>               
		</tr>
		</thead>
		<tbody>
        <tr>
        	<td class="tac"><?php echo $pInvoice->supplierName; ?></td>
            <td></td>
            <td></td>
            <td colspan="2">Form No : <?php echo $pInvoice->formNo; ?></td>
        </tr>
        <tr>
        	<td width="20%" class="tac"><?php echo $pInvoice->line1; ?></td>
            <td width="20%"></td>
            <td width="20%"></td>
            <td>Invoice No : <?php echo $pInvoice->supplierInvoiceNo; ?></td>
        </tr>
        <tr>
        	<td class="tac"><?php echo $pInvoice->line2; ?></td>
            <td></td>
            <td></td>
            <td>Pur Invoice Date : <?php echo $pInvoice->invoiceDate; ?></td>
        </tr>
        <tr>
        	<td class="tac"><?php echo $pInvoice->line3; ?></td>
            <td></td>
            <td></td>
            <td>Pur Debit Note Date :</td>
        </tr>
        <tr>
        	<td><?php echo $pInvoice->city; ?>,<?php echo $pInvoice->supplierPostCode; ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
        </table>
        <table border="0" cellpadding="1" cellspacing="0" width="100%">
		<thead>
        <tr>
        	<th>S.No</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Item Desc</th>
            <th>Unit Price</th>
            <th>Qty</th>
            <th>Amt(Ex GST)</th>
            <th>GST %</th>
            <th>GST Amt</th>
            <th>Amt(In GST)</th>
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
                	<td  class="tac"><?php echo $bil; ?></td>
                	
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
                <td colspan="3" class="tar">Net Total :<?php 
				$net = 0;
				foreach($pdetails as $datatbl):
					$net = $net + $datatbl->amountExcludedTax;
				endforeach; ?>
 				<?php echo $net ?></td>
       	</tr>
            <tr>
        		<td></td>
            	<td></td>
            	<td></td>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="tar">GST Payable Total :<?php
				$pay = 0;
				foreach($pdetails as $datatbl): 
					$pay = $pay + $datatbl->taxAmount;
                endforeach; ?>
                <?php echo $pay ?></td>
        	</tr>
            <tr>
        		<td></td>
            	<td></td>
            	<td></td>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Prepared By</td>
                <td>Approved By</td>
        	</tr>
		</tbody>
	</table>