	<table border="1" cellpadding="1" cellspacing="0" width="100%">
                	<thead>
                    <tr>
                        <th><?php echo $this->lang->line('description') ?></th>
                        <th class="tac"><?php echo $this->lang->line('lastyear') ?></th>
                        <th class="tac"><?php echo $this->lang->line('thisyear') ?></th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($accountGroup){
				foreach($accountGroup as $datatbl):
							$total_thisyear = 0;
							$total_lastyear = 0;
                            $thisyear_amount = 0;
                            $lastyear_amount = 0;
				$bil++?>
  			<?php if ($datatbl->title == 1) {?>
           	<tr>
                	<td colspan="3"><h5><?php echo $this->lang->line($datatbl->acctGroupName)?></h5></td>
                </tr>
                <?php } ?>
                	<?php foreach($groupdetails as $rowdet):
									$rowdet_thisyeartotal = 0;
									$rowdet_lastyeartotal = 0;
							if($rowdet->parentID == $datatbl->ID){?>
  						<?php if ($rowdet->title == 1) {?>
            					<tr>
                					<td colspan="3"><strong><?php echo $this->lang->line($rowdet->acctGroupName)?></strong></td>
                				</tr>
                <?php } ?>
                				<?php foreach($groupdetails as $rowdet1):
									$rowdet1_thisyeartotal = 0;
									$rowdet1_lastyeartotal = 0;
										if($rowdet1->parentID == $rowdet->ID){?>
  											<?php if ($rowdet1->title == 1) {?>
            								<tr>
                								<td colspan="3"><strong><?php echo $this->lang->line($rowdet1->acctGroupName)?></strong></td>
                							</tr>
                <?php } ?>
                				<?php foreach($accountdetails as $row):
										if($row->acctGroupID == $rowdet1->ID){?>
                                       <?php	if($row->lastyeardebit == 0 && $row->lastyearcredit == 0 && $row->currentyeardebit == 0 && $row->currentyearcredit == 0){ }else{ ?>
            								<tr>
                								<td><?php echo $row->acctCode.' [ '.$row->acctName.' ]'?></td>
                								<td class="tar"><?php echo $row->lastyeardebit-$row->lastyearcredit ?></td>
                								<td class="tar"><?php echo ($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit) ?></td>
                							</tr>
                                            <?php $rowdet1_thisyeartotal = $rowdet1_thisyeartotal + 
												($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $rowdet1_lastyeartotal = $rowdet1_lastyeartotal + ($row->lastyeardebit-$row->lastyearcredit);?>
                                            <?php $rowdet_thisyeartotal = $rowdet_thisyeartotal + 
												($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $rowdet_lastyeartotal = $rowdet_lastyeartotal + ($row->lastyeardebit-$row->lastyearcredit);?>
                                            <?php $total_thisyear = $total_thisyear + ($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $total_lastyear = $total_lastyear + ($row->lastyeardebit-$row->lastyearcredit);?>
                                    <?php } ?>        
			            		<?php 	}
								endforeach;?>
            					<tr>
                					<td><?php echo $this->lang->line($rowdet1->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></td>
                					<td class="tar"><?php echo $rowdet1_lastyeartotal ?></td>
                					<td class="tar"><?php echo $rowdet1_thisyeartotal ?></td>
                				</tr>
			            		<?php 	}
								endforeach;?>
                				<?php foreach($accountdetails as $row):
										if($row->acctGroupID == $rowdet->ID){?>
                                       <?php	if($row->lastyeardebit == 0 && $row->lastyearcredit == 0 && $row->currentyeardebit == 0 && $row->currentyearcredit == 0){ }else{ ?>
            								<tr>
                								<td><?php echo $row->acctCode.' [ '.$row->acctName.' ]'?></td>
                								<td class="tar"><?php echo $row->lastyeardebit-$row->lastyearcredit ?></td>
                								<td class="tar"><?php echo ($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit) ?></td>
                							</tr>
                                            <?php $total_thisyear = $total_thisyear + ($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $total_lastyear = $total_lastyear + ($row->lastyeardebit-$row->lastyearcredit);?>
                                            <?php $rowdet_thisyeartotal = $rowdet_thisyeartotal + 
												($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit);?>
                                            <?php $rowdet_lastyeartotal = $rowdet_lastyeartotal + ($row->lastyeardebit-$row->lastyearcredit);?>
                                     <?php } ?>
			            		<?php 	}
								endforeach;?>
            					<tr>
                					<td><?php echo $this->lang->line($rowdet->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></td>
                					<td class="tar"><?php echo $rowdet_lastyeartotal ?></td>
                					<td class="tar"><?php echo $rowdet_thisyeartotal ?></td>
                				</tr>
            		<?php 	}
							endforeach;?>
                				<?php foreach($accountdetails as $row):
										if($row->acctGroupID == $datatbl->ID){?>
                                <?php        	if($row->acctCode == '130000000') { ?>
                                <?php 			$thisyear_amount = $currentretained * -1;?>
                                <?php 			$lastyear_amount = $row->lastyeardebit-$row->lastyearcredit?>
                                <?php 		}else{ ?>
                                <?php 			$thisyear_amount = ($row->lastyeardebit-$row->lastyearcredit)+($row->currentyeardebit - $row->currentyearcredit)?>
                                <?php 			$lastyear_amount = $row->lastyeardebit-$row->lastyearcredit?>
                                <?php 		} ?>
            								<tr>
                								<td><?php echo $row->acctCode.' [ '.$row->acctName.' ]'?></td>
                								<td class="tar"><?php echo $lastyear_amount ?></td>
                								<td class="tar"><?php echo $thisyear_amount ?></td>
                							</tr>
                                            <?php $total_thisyear = $total_thisyear + $thisyear_amount;?>
                                            <?php $total_lastyear = $total_lastyear + $lastyear_amount;?>
			            		<?php 	}
								endforeach;?>
            					<tr>
                					<td><h4><?php echo $this->lang->line($datatbl->acctGroupName)?> <?php echo $this->lang->line('total') ?></h4></td>
                					<td class="tar"><?php echo $total_lastyear ?></td>
                					<td class="tar"><?php echo $total_thisyear ?></td>
                				</tr>
            <?php endforeach; }?>
                     </tbody>
                     </table>
