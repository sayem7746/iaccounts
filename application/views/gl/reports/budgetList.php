<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
   $('select').select2();
}); 
function do_print(){
	var addyear = $('#add_year option:selected').val();
	window.open("<?php echo base_url() ?>glreports/budgetList_print/"+addyear);
}
 
function changeList(){
	var addyear = $('#add_year option:selected').val();
	var urls = "<?php echo base_url();?>glreports/budgetList/"+addyear;
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
                <li class="active"><?php echo $this->lang->line('titlelist') ?></li>
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
                    	<h2><?php echo $this->lang->line('titlelist') ?></h2>
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
						for($i=-15; $i<20; $i++){
							$options[date('Y', strtotime($i . "  year"))] = date('Y', strtotime($i . "  year"));
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
            			<th style="display:none"></th>
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
                        			<td class="tar"><?php echo number_format($datatbl_total) ?></td>
                        			</tr>
						<?php		$datatbl_total = $datatbl->amountcr; ?>			
						<?php } ?>
                        <?php 	$accountID = $datatbl->acctID; ?>
						<?php		$datatbl_total = $datatbl->amountcr; ?>			
                                <tr>
            						<td style="display:none"><?php echo $datatbl->ID ?></td>
                					<td><?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2).' [ '.$datatbl->acctName.' ]'?></td>
                        			<td class="tar"><?php echo number_format($datatbl->amountcr)?></td>
                        <?php }else{?>
						<?php		$datatbl_total = $datatbl_total + $datatbl->amountcr; ?>			
                        			<td class="tar"><?php echo number_format($datatbl->amountcr)?></td>
                        <?php } ?>
				<?php   endforeach; ?>
                        			<td class="tar"><?php echo number_format($datatbl_total) ?></td>
                        			</tr>
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
