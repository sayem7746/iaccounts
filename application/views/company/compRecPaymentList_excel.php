<table border="1" cellpadding="1" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th><?php echo $this->lang->line('customerName');?></th>
			<th class="tac"><?php echo $this->lang->line('amountReceived');?></th>
            <th class="tac"><?php echo $this->lang->line('referenceNo');?></th>
            <th><?php echo $this->lang->line('formNo');?></th>
            <th class="tac"><?php echo $this->lang->line('receivePaymentDate');?></th>               
		</tr>
		</thead>
		<tbody>
	<?php $bil = 0;
			//echo var_dump($datatbls); 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->ID; ?></td>	
                	<td  class="tac"><?php echo $bil; ?></td>
                	
                	<td><?php echo $datatbl->customerName ?></td>
                    <td class="tar"><?php echo $datatbl->amountReceived ?></td>
                    <td class="tar"><?php echo $datatbl->referenceNo ?></td>
                	<td class="tac"><?php echo $datatbl->formNo.'['.$this->FormSetup_model->getFormSerialNo_zeroLeading($datatbl->ID).']'; ?></td>
                    <td class="tac"><?php echo date('d-m-Y', strtotime($datatbl->paymentDate)); ?></td>
                </tr>
            <?php endforeach; }?>
		</tbody>
	</table>