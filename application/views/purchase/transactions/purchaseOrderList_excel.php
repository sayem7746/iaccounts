<div>
	<table border="1" cellpadding="1" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th class="tac">#</th>
			<th><?php echo $this->lang->line('supplierName') ?></th>
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
                	<td><?php echo $bil; ?></td>
                	<td><?php echo $datatbl->supplierName ?></td>
                    <td><?php echo $datatbl->purchaseOrderNo ?></td>
                    <td><?php echo $datatbl->salesAgentName ?></td>
                	<td><?php echo $datatbl->formNo.'['.$this->FormSetup_model->getFormSerialNo_zeroLeading($datatbl->ID).']'; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($datatbl->poDate)); ?></td>
                </tr>
            <?php endforeach; }?>
		</tbody>
	</table>                                         
</div>