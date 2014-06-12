	<table border="1" cellpadding="1" cellspacing="0" width="100%">
                	<thead>
                    <tr>
            			<th class="tac">#</th>
                        <th><?php echo $this->lang->line('acctNo') ?></th>
                        <th><?php echo $this->lang->line('description') ?></th>
    			      	<th class="tac"><?php echo $this->lang->line('yeardebit') ?></th>
    			      	<th class="tac"><?php echo $this->lang->line('yearcredit') ?></th>
                        <th class="tac"><?php echo $this->lang->line('monthdebit') ?></th>
                        <th class="tac"><?php echo $this->lang->line('monthcredit') ?></th>
            		</tr>
        			</thead>
       				 <tbody><?php
						$bil = 0; 
						$YTDtotal_credit = 0;
						$YTDtotal_debit = 0;
						$total_credit = 0;
						$total_debit = 0;
						if($datatbls){
							foreach($datatbls as $datatbl):
							if($datatbl->yeardebit == 0 && $datatbl->yearcredit == 0 && $datatbl->thismonthdr == 0 && $datatbl->thismonthcr == 0 ){
							}else{
 							$bil++?>
                            <tr>
                				<td class="tac"><?php echo $bil; ?></td>
                    			<td><?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2) ?></td>
                    			<td><?php echo $datatbl->acctName ?></td>
                    			<td class="tar"><?php echo $datatbl->yeardebit ?></td>
                    			<td class="tar"><?php echo $datatbl->yearcredit ?></td>
                    			<td class="tar"><?php echo $datatbl->thismonthdr ?></td>
                    			<td class="tar"><?php echo $datatbl->thismonthcr ?></td>
                            </tr>
                                <?php }
  								$YTDtotal_debit = $YTDtotal_debit + $datatbl->yeardebit;
  								$YTDtotal_credit = $YTDtotal_credit + $datatbl->yearcredit;
  								$total_debit = $total_debit + $datatbl->thismonthdr;
  								$total_credit = $total_credit + $datatbl->thismonthcr;
            			 	endforeach; ?>
                            <tr>
                				<td class="tac"></td>
                    			<td colspan="2" class="tac"><h4><?php echo $this->lang->line('total') ?></h4></td>
                    			<td class="tar"><?php echo $YTDtotal_debit ?></td>
                    			<td class="tar"><?php echo $YTDtotal_credit ?></td>
                    			<td class="tar"><?php echo $total_debit ?></td>
                    			<td class="tar"><?php echo $total_credit ?></td>
                            </tr>
					<?php	} ?>
					</tbody>
			</table>                                         
