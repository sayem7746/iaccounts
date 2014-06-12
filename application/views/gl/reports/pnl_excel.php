	<table border="1" cellpadding="1" cellspacing="0" width="100%">
                	<thead>
                    <tr>
                        <th align="left"><?php echo $this->lang->line('description') ?></th>
                        <th class="tar"><?php echo $this->lang->line('thisyear') ?></th>
            		</tr>
        			</thead>
       				 <tbody>
	<?php $bil = 0; 
	$datatbl_total = 0;
	if($accountGroup){
		foreach($accountGroup as $datatbl):
			$bil++?>
 			<?php if ($datatbl->title == 1) {?>
            		<tr>
                		<td colspan="2"><strong><?php echo $this->lang->line($datatbl->acctGroupName)?></strong></td>
                	</tr>
            <?php }?>
      <?php foreach($accountdetails as $row):
				if($row->acctGroupID == $datatbl->ID){?>
      	<?php 
					if($row->currentyeardebit != '' && $row->currentyearcredit !=''){ ?>
                 <?php $totalamount = $row->currentyearcredit - $row->currentyeardebit ?>
            			<tr>
                			<td><?php echo substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                			<td class="tar"><?php echo ($totalamount == 0 )?'':$totalamount?></td>
                		</tr>
             	<?php
						$datatbl_total = $datatbl_total + $totalamount;
							?>
			<?php   } ?>
			<?php } ?>
		<?php endforeach;?>
      	<?php if($groupdetails){ 
				foreach($groupdetails as $rowdet):
							$rowdet_credit = 0;
					if($rowdet->parentID == $datatbl->ID){
						if ($rowdet->title == 1) {?>
            				<tr>
                				<td colspan="2"><strong><?php echo $this->lang->line($rowdet->acctGroupName)?></strong></td>
                			</tr>
                	<?php } ?>
      				<?php foreach($accountdetails as $row):
							if($row->acctGroupID == $rowdet->ID){?>
      	<?php 
								if($row->currentyeardebit != '' && $row->currentyearcredit !=''){ ?>
                 			<?php   $totalamount = $row->currentyearcredit - $row->currentyeardebit ?>
            						<tr>
                						<td><?php echo substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                						<td class="tar"><?php echo ($totalamount == 0 )?'':$totalamount?></td>
                					</tr>
             	<?php
											$rowdet_credit = $rowdet_credit + $totalamount;
											$datatbl_total = $datatbl_total + $totalamount;
							?>
						<?php  } ?>
					<?php } ?>
				<?php endforeach;?>
				<?php foreach($groupdetails as $rowdet1): 
					$rowdet1_credit = 0; ?>
				<?php	if($rowdet1->parentID == $rowdet->ID){
							if ($rowdet1->title == 1) {?>
            					<tr>
                					<td colspan="2"><strong><?php echo $this->lang->line($rowdet1->acctGroupName)?></strong></td>
                				</tr>
                	<?php 	} ?>
				<?php   foreach($groupdetails as $rowdet2): 
					$rowdet2_credit = 0; ?>
				<?php		if($rowdet2->parentID == $rowdet1->ID){
								if ($rowdet2->title == 1) {?>
            						<tr>
                						<td colspan="2"><strong><?php echo $this->lang->line($rowdet2->acctGroupName)?></strong></td>
                					</tr>
                	<?php 		} ?>
 				<?php   foreach($groupdetails as $rowdet3): 
					$rowdet3_credit = 0; ?>
				<?php		if($rowdet3->parentID == $rowdet2->ID){
								if ($rowdet3->title == 1) {?>
            						<tr>
                						<td colspan="2"><strong><?php echo $this->lang->line($rowdet3->acctGroupName)?></strong></td>
                					</tr>
                	<?php 		} ?>
     				<?php 	  foreach($accountdetails as $row2):
									if($row2->acctGroupID == $rowdet3->ID){?>
      	<?php 

										if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php   		  $totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            								<tr>
                								<td><?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                								<td class="tar"><?php echo ($totalamount < 0 )?$totalamount * -1:$totalamount?></td>
                							</tr>
             	<?php
											$rowdet_credit = $rowdet_credit + $totalamount;
											$rowdet1_credit = $rowdet1_credit + $totalamount;
											$rowdet2_credit = $rowdet2_credit + $totalamount;
											$rowdet3_credit = $rowdet3_credit + $totalamount;
											$datatbl_total = $datatbl_total + $totalamount;
							?>
						<?php  		} ?>
                	<?php   		  }	 ?>
				<?php   		  endforeach;?>
            						<tr>
                						<td><strong>
											<?php echo $this->lang->line($rowdet3->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                						<td class="tar"><?php echo ($rowdet3_credit < 0 )?$rowdet3_credit * -1:$rowdet3_credit ?></td>
                					</tr>
                	<?php 		} ?>
				<?php   		  endforeach;?>
     				<?php 	  foreach($accountdetails as $row2):
									if($row2->acctGroupID == $rowdet2->ID){?>
      	<?php 
										if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php   		  $totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            								<tr>
                								<td><?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                								<td class="tar"><?php echo ($totalamount < 0 )?$totalamount * -1:$totalamount?></td>
                							</tr>
             	<?php
											$rowdet_credit = $rowdet_credit + $totalamount;
											$rowdet1_credit = $rowdet1_credit + $totalamount;
											$rowdet2_credit = $rowdet2_credit + $totalamount;
											$datatbl_total = $datatbl_total + $totalamount;
							?>
						<?php  		} ?>
                	<?php   		  }	 ?>
				<?php   		  endforeach;?>
            						<tr>
                						<td><strong>
											<?php echo $this->lang->line($rowdet2->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                						<td class="tar"><?php echo ($rowdet2_credit < 0 )?$rowdet2_credit * -1:$rowdet2_credit ?></td>
                					</tr>
                	<?php   } ?>
				<?php   endforeach;?>
      			<?php   foreach($accountdetails as $row2):
							if($row2->acctGroupID == $rowdet1->ID){?>
      	<?php 
								if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php 	$totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            							<tr>
                							<td><?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                							<td class="tar"><?php echo ($totalamount < 0 )?$totalamount * -1:$totalamount?></td>
                						</tr>
             	<?php
										$rowdet_credit = $rowdet_credit + $totalamount;
										$rowdet1_credit = $rowdet1_credit + $totalamount;
										$datatbl_total = $datatbl_total + $totalamount;
							?>
						<?php  	} ?>
                	<?php   	}	 ?>
				<?php 	endforeach;?>
            			  <tr>
                			<td><strong>
								<?php echo $this->lang->line($rowdet1->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                			<td class="tar"><?php echo $rowdet1_credit ?></td>
                		  </tr>
                	<?php } ?>
				<?php endforeach;?>
            			  <tr>
                			<td><strong>
								<?php echo $this->lang->line($rowdet->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                			<td class="tar"><?php echo $rowdet_credit ?></td>
                		  </tr>
<!-- row det -->
                <?php } ?>
		<?php  endforeach; ?>
            			  <tr>
                			<td><h4><?php echo $this->lang->line($datatbl->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></h4></td>
                			<td class="tar"><?php echo $datatbl_total ?></td>
                		  </tr>
        <?php } ?>
<?php  endforeach; ?>
		<!--tr>
			<td><h4><?php echo $this->lang->line('netincome') ?></h4></td>
        	<td class="tar"><?php echo $datatbl_total ?></td>
  		</tr -->
	<?php }?>
                     </tbody>
                     </table>
