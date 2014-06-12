<div>
	<table border="1" cellpadding="1" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th class="tac">#</th>
					<th><?php echo $this->lang->line('invoiceno');?></th>
					<th><?php echo $this->lang->line('supplierName');?></th>
            		<th><?php echo $this->lang->line('formNo');?></th>
                    <th><?php echo $this->lang->line('totalAmount');?></th>
                    <th class="tac"><?php echo $this->lang->line('date');?></th>          
		</tr>
		</thead>
		<tbody>
	<?php $bil = 0;
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td><?php echo $bil; ?></td>
                	<td><?php echo $datatbl->invoiceno ?></td>
                	<td><?php echo $datatbl->supplierName ?></td>
                	<td><?php echo $datatbl->formNo.'['.$this->FormSetup_model->getFormSerialNo_zeroLeading($datatbl->ID).']'; ?></td>
                    <td class="tac"><?php echo date('d-m-Y', strtotime($datatbl->invoiceDate)); ?></td>
                    <td class="tac"><?php echo $datatbl->totalAmount ?></td>
                    
                </tr>
            <?php endforeach; }?>
		</tbody>
	</table>                                         
</div>