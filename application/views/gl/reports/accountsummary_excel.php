	<table border="1" cellpadding="1" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th class="tac">#</th>
			<th><?php echo $this->lang->line('journalno') ?></th>
			<th><?php echo $this->lang->line('description') ?></th>
			<th><?php echo $this->lang->line('monthdebit') ?></th>
			<th><?php echo $this->lang->line('monthcredit') ?></th>                
			<th><?php echo $this->lang->line('balance') ?></th>                
		</tr>
		</thead>
		<tbody>
	<?php $bil = 0; 
		if($datatbls){
			foreach($datatbls as $datatbl):
				if($datatbl->yeardebit == 0 && $datatbl->yearcredit == 0 && $datatbl->thismonthdr == 0 && $datatbl->thismonthcr == 0 ){
				}else{
					$bil++?>
            		<tr>
                		<td align="center"><?php echo $bil; ?></td>
                    	<td colspan="5">&nbsp;&nbsp;<?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2) ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $datatbl->acctName ?></td>
                		<!-- td class="tar"><?php echo number_format($datatbl->aset_book_value, 2, '.', ','); ?></td -->
                	</tr>
                 	<?php 
						$openbal = $datatbl->yeardebit - $datatbl->yearcredit;
						if($datatbls1){ ?>
						<?php
							$controlHead = 0; 
							foreach($datatbls1 as $row):
								if($row->acctCode == $datatbl->ID){
									if($controlHead == 0){ ?>
                                    	<tr>
                                        	<td></td>
                                        	<td></td>
                                        	<td>&nbsp;&nbsp;<?php echo $this->lang->line('openbalance') ?></td>
                                        	<td></td>
                                        	<td></td>
                                        	<td class="tar"><?php echo number_format($openbal,2) ?>&nbsp;&nbsp;</td>
                                        </tr>
										<?php 
										$controlHead = 1;
									} 
									$openbal = $openbal + $row->amount_dr;
									$openbal = $openbal - $row->amount_cr;
									?>
                                    <tr>
                                       	<td></td>
                                       	<td class="tac" width="10%"><?php echo $row->journalID ?></td>
                                       	<td>&nbsp;&nbsp;<?php echo $row->description ?></td>
                                       	<td class="tar" width="10%"><?php echo number_format($row->amount_dr,2) ?>&nbsp;&nbsp;</td>
                                       	<td class="tar" width="10%"><?php echo number_format($row->amount_cr,2) ?>&nbsp;&nbsp;</td>
                                       	<td class="tar" width="10%"></td>
                                    </tr>
                               <?php		}
							endforeach; ?>
                            	<tr>
                                   	<td></td>
                                   	<td></td>
                                	<td>&nbsp;&nbsp;<?php echo $this->lang->line('closing') ?></td>
                                   	<td></td>
                                   	<td></td>
                                   	<td class="tar"><?php echo number_format($openbal,2) ?>&nbsp;&nbsp;</td>
                                 </tr>
					  <?php  
						}else{ ?> 
                        	<tr>
                            	<td></td>
                                <td></td>
                                <td>&nbsp;&nbsp;<?php echo $this->lang->line('closing') ?></td>
                                <td></td>
                                <td></td>
                                <td class="tar"><?php echo number_format($openbal,2) ?>&nbsp;&nbsp;</td>
                            s</tr>
                  <?php }
					}
            	endforeach; 
			}
	?>
		</tbody>
	</table>                                         
