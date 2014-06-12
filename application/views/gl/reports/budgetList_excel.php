	<table border="1" cellpadding="1" cellspacing="0" width="100%">
                	<thead>
                    <tr>
            			<th><?php echo $this->lang->line('acctCode')?></th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 1</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 2</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 3</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 4</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 5</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 6</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 7</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 8</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 9</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 10</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 11</th>
            			<th class="tac"><?php echo $this->lang->line('period')?> 12</th>
            			<th class="tac"><?php echo $this->lang->line('total')?></th>
            		</tr>
        			</thead>
       				 <tbody>
					<?php $bil = 0; 
					$datatbl_total = 0;
					$accountID = '';
					if($budgetdetails){
						foreach($budgetdetails as $datatbl): ?>
                        <?php if($datatbl->acctID != $accountID){ ?>
                        <?php 	if($accountID != '') {?>
                        			<td class="tar"><?php echo $datatbl_total ?></td>
                        			</tr>
						<?php } ?>
						<?php		$datatbl_total = $datatbl->amountcr; ?>			
                        <?php 	$accountID = $datatbl->acctID; ?>
                                <tr>
                					<td><?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2).' [ '.$datatbl->acctName.' ]'?></td>
                        			<td class="tar"><?php echo $datatbl->amountcr?></td>
                        <?php }else{?>
						<?php		$datatbl_total = $datatbl_total + $datatbl->amountcr; ?>			
                        			<td class="tar"><?php echo $datatbl->amountcr?></td>
                        <?php } ?>
				<?php   endforeach; ?>
                        			<td class="tar"><?php echo $datatbl_total ?></td>
                        			</tr>
			<?php }?>
                     </tbody>
                     </table>
