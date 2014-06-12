	<table border="1" cellpadding="1" cellspacing="0" width="100%">
                	<thead>
                    <tr>
            			<th class="tac">#</th>
                        <th><?php echo $this->lang->line('acctNo') ?></th>
                        <th><?php echo $this->lang->line('description') ?></th>
                        <th class="tac"><?php echo $this->lang->line('lastyear') ?></th>
                        <th class="tac"><?php echo $this->lang->line('thisyear') ?></th>
            		</tr>
        			</thead>
       				 <tbody><?php
						$bil = 0; 
						if($datatbls){
							$total_thisyear = 0;
							$total_lastyear = 0;
							foreach($datatbls as $datatbl):
							if($datatbl->lastyeardebit == 0 && $datatbl->lastyearcredit == 0 && $datatbl->currentyeardebit == 0 && $datatbl->currentyearcredit == 0 ){
							}else{
 							$bil++?>
                            <tr>
                				<td class="tac"><?php echo $bil; ?></td>
                    			<td>
									<?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2) ?></td>
                    			<td><?php echo $datatbl->acctName ?></td>
                    			<td class="tar"><?php echo $datatbl->lastyeardebit - $datatbl->lastyearcredit ?></td>
                    			<td class="tar"><?php echo ($datatbl->lastyeardebit - $datatbl->lastyearcredit)+
									($datatbl->currentyeardebit - $datatbl->currentyearcredit) ?></td>
                            </tr>
								<?php $total_thisyear = $total_thisyear + ($datatbl->lastyeardebit - $datatbl->lastyearcredit)+
									($datatbl->currentyeardebit - $datatbl->currentyearcredit); ?>
								<?php $total_lastyear = $total_lastyear + ($datatbl->lastyeardebit - $datatbl->lastyearcredit); ?>
                                <?php }
            			 	endforeach; ?>
						<?php } ?>
					</tbody>
			</table>                                         
