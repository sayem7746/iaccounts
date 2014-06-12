<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
   $('select').select2();
}); 
function do_print(){
	var addyear = $('#add_year option:selected').val();
	window.open("<?php echo base_url() ?>glreports/profitNloss_print/"+addyear);
}
 
function changeList(){
	var addyear = $('#add_year option:selected').val();
	var urls = "<?php echo base_url();?>glreports/profitNloss/"+addyear;
		window.location = urls;
}

</script>
<div id="content">                        
<div class="wrap">
	<div class="head">
		<div class="info">
			<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
			<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href="#"><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href="<?php echo base_url()?>generalLedger/home"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('title') ?></li>
            </ul>
		</div><!-- info -->
	<div class="search">
		<form action="<?php echo base_url() ?>admin/search" method="post">
			<input name="search_text" type="text" placeholder="search..."/>                                
            <button type="submit"><span class="i-magnifier"></span></button>
		</form>
	</div>                        
</div><!-- head --> 
<div class="content">
	<div class="wrap">    
		<div class="row-fluid">
			<div class="span12">
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title') ?></h2>
                    <div class="side fr">
                         <button class="btn btn-link" onClick="do_print()">Print</button>
                    </div>
                    </div><!-- head -->
				<div class="content np">    
                	<div class="controls-row"><!-- Row 4-->
						<div class="span5 tac">
                    	<div class="span2 tar"><?php echo form_label($this->lang->line('year'),'add_year');?></div>
						<?php
							$preselyear = $selyear;
							$options = '';
							foreach($yrs as $row){
								$options[$row] = $row;
							}
							$js='class="input-medium" id="add_year"';

							echo form_dropdown('add_year', $options, $preselyear, $js);
						?>       
                        </div>
						<div class="span2 tac">
                        <?php 
							$data = array(
									'name'=>'mysubmit', 
									'class'=>'btn btn-small btn-primary');
									$js="onClick='changeList()'";
							echo form_button($data,$this->lang->line('generatereport'),$js);
							?>
                        </div>
                 	</div><!-- End Row 4-->
				</div><!-- content -->
            	<div class="content np">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test">
                	<thead>
                    <tr>
                        <th align="left">&nbsp;&nbsp;<?php echo $this->lang->line('description') ?></th>
                        <th class="tar"><?php echo $this->lang->line('thisyear') ?>&nbsp;&nbsp;</th>
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
                		<td colspan="2">&nbsp;<strong><?php echo $this->lang->line($datatbl->acctGroupName)?></strong></td>
                	</tr>
            <?php }?>
      <?php foreach($accountdetails as $row):
				if($row->acctGroupID == $datatbl->ID){?>
      	<?php 
					if($row->currentyeardebit != '' && $row->currentyearcredit !=''){ ?>
                 <?php $totalamount = $row->currentyearcredit - $row->currentyeardebit ?>
            			<tr>
                			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                			<td class="tar"><?php echo ($totalamount == 0 )?'':number_format($totalamount,2)?>&nbsp;&nbsp;</td>
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
                				<td colspan="2">&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet->acctGroupName)?></strong></td>
                			</tr>
                	<?php } ?>
      				<?php foreach($accountdetails as $row):
							if($row->acctGroupID == $rowdet->ID){?>
      	<?php 
								if($row->currentyeardebit != '' && $row->currentyearcredit !=''){ ?>
                 			<?php   $totalamount = $row->currentyearcredit - $row->currentyeardebit ?>
            						<tr>
                						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row->acctCode,0, 4).'-'.substr($row->acctCode,4, 3).'-'.substr($row->acctCode,7, 2).' [ '.$row->acctName.' ]'?></td>
                						<td class="tar"><?php echo ($totalamount == 0 )?'':number_format($totalamount,2)?>&nbsp;&nbsp;</td>
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
                					<td colspan="2">&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet1->acctGroupName)?></strong></td>
                				</tr>
                	<?php 	} ?>
				<?php   foreach($groupdetails as $rowdet2): 
					$rowdet2_credit = 0; ?>
				<?php		if($rowdet2->parentID == $rowdet1->ID){
								if ($rowdet2->title == 1) {?>
            						<tr>
                						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet2->acctGroupName)?></strong></td>
                					</tr>
                	<?php 		} ?>
 				<?php   foreach($groupdetails as $rowdet3): 
					$rowdet3_credit = 0; ?>
				<?php		if($rowdet3->parentID == $rowdet2->ID){
								if ($rowdet3->title == 1) {?>
            						<tr>
                						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line($rowdet3->acctGroupName)?></strong></td>
                					</tr>
                	<?php 		} ?>
     				<?php 	  foreach($accountdetails as $row2):
									if($row2->acctGroupID == $rowdet3->ID){?>
      	<?php 
										if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php   		  $totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            								<tr>
                								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                								<td class="tar"><?php echo ($totalamount < 0 )?number_format($totalamount * -1,2):number_format($totalamount,2)?>&nbsp;&nbsp;</td>
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
                						<td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo $this->lang->line($rowdet3->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                						<td class="tar"><?php echo ($rowdet3_credit < 0 )?number_format($rowdet3_credit * -1,2):number_format($rowdet3_credit,2) ?>&nbsp;&nbsp;</td>
                					</tr>
                	<?php 		} ?>
				<?php   		  endforeach;?>
     				<?php 	  foreach($accountdetails as $row2):
									if($row2->acctGroupID == $rowdet2->ID){?>
      	<?php 
										if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php   		  $totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            								<tr>
                								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                								<td class="tar"><?php echo ($totalamount < 0 )?number_format($totalamount * -1,2):number_format($totalamount,2)?>&nbsp;&nbsp;</td>
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
                						<td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo $this->lang->line($rowdet2->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                						<td class="tar"><?php echo ($rowdet2_credit < 0 )?number_format($rowdet2_credit * -1,2):number_format($rowdet2_credit,2) ?>&nbsp;&nbsp;</td>
                					</tr>
                	<?php   } ?>
				<?php   endforeach;?>
      			<?php   foreach($accountdetails as $row2):
							if($row2->acctGroupID == $rowdet1->ID){?>
      	<?php 
								if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ ?>
                 			<?php 	$totalamount = $row2->currentyearcredit - $row2->currentyeardebit ?>
            							<tr>
                							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($row2->acctCode,0, 4).'-'.substr($row2->acctCode,4, 3).'-'.substr($row2->acctCode,7, 2).' [ '.$row2->acctName.' ]'?></td>
                							<td class="tar"><?php echo ($totalamount < 0 )?number_format($totalamount * -1,2):number_format($totalamount,2)?>&nbsp;&nbsp;</td>
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
                			<td><strong>&nbsp;&nbsp;&nbsp;&nbsp;
								<?php echo $this->lang->line($rowdet1->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                			<td class="tar"><?php echo number_format($rowdet1_credit,2) ?>&nbsp;&nbsp;</td>
                		  </tr>
                	<?php } ?>
				<?php endforeach;?>
            			  <tr>
                			<td><strong>
								<?php echo $this->lang->line($rowdet->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></strong></td>
                			<td class="tar"><?php echo number_format($rowdet_credit,2) ?>&nbsp;&nbsp;</td>
                		  </tr>
<!-- row det -->
                <?php } ?>
		<?php  endforeach; ?>
            			  <tr>
                			<td><h4><?php echo $this->lang->line($datatbl->acctGroupName)?> <?php echo $this->lang->line('subtotal') ?></h4></td>
                			<td class="tar"><?php echo number_format($datatbl_total,2) ?>&nbsp;&nbsp;</td>
                		  </tr>
        <?php } ?>
<?php  endforeach; ?>
		<!--tr>
			<td><h4><?php echo $this->lang->line('netincome') ?></h4></td>
        	<td class="tar"><?php echo number_format($datatbl_total,2) ?>&nbsp;&nbsp;</td>
  		</tr -->
	<?php }?>
                     </tbody>
                     </table>
				</div><!-- content -->
				</div><!-- block -->
			</div><!-- span12 -->
		</div><!-- row-fluid -->	
	</div><!-- wrap -->
</div><!-- content -->
<div class="dialog" id="row_edit" style="display: none;" title="<?php echo $this->lang->line('edit');?> ?">
    <p><?php echo $this->lang->line('message1');?></p>
</div>  
