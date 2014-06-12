<script>
$(document).ready(function(){
	$('select').select2();
//	$('#acctCodel').select2();savedetails
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
   var oTable = $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", 
		 "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null, 
			null, 
			null,
			null ]});
//     oTable.fnSort( [ [1,'asc'] ] );
});
</script>
<div id="content">                        
<div class="wrap">
                  
<div class="head">
	<div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href='<?php echo base_url()."gl/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('title') ?></li>
            </ul>
	</div>
                        
	<div class="search">
		<form action="<?php echo base_url() ?>admin/search" method="post">
			<input name="search_text" type="text" placeholder="search..."/>                                
            <button type="submit"><span class="i-magnifier"></span></button>
		</form>
	</div>                        
</div>  <!-- Head -->                                                                  
                    
<div class="content" id="grid_content_1">
	<div class="row-fluid">
		<div class="alert alert-info">
			<strong><?php echo $this->lang->line('title') ?></strong>
		</div>
	</div>
	<div class="row-fluid scRow">                            
	  <div class="span8 scCol">
		<div class="block" id="grid_block_1">
          <div class="content">
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label($this->lang->line('jlnumber'),'journal_number');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'journal_number', 
									'id'=>'journal_number', 
									'disabled'=>'disabled', 
									'class'=>'input-medium',); 
								echo form_input($data, $journalHead->journalID); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label('Description:','description');?></div>
                   		<div class="span10">
                            	<?php 								
								$data = array(
									'name'=>'description', 
									'id'=>'description', 
									'disabled'=>'disabled', 
									'class'=>'span12',); 
								echo form_input($data, $journalHead->description); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                  <div class="controls-row"><!-- Row 3 -->
                    	<div class="span2"><?php echo form_label($this->lang->line('effective_date'),'effdate');?></div>
                    <div class="span9">
                    	<div class="input-prepend">
                        	<span class="add-on"><i class="i-calendar"></i></span>
                            	<?php 								
								$data = array(
									'type'=>'text',
									'name'=>'effdate', 
									'id'=>'effdate', 
									'disabled'=>'disabled', 
									'class'=>'input-small datepicker2 tac',); 
								echo form_input($data, date('d-m-Y', strtotime($journalHead->effective_date))); ?>
                        </div>                                                                                                
                     </div>
                    </div><!-- End Row 3 -->
          </div><!-- End Content-->
        </div>  <!-- Block grid-->                                  
      </div>     <!-- span8 -->                               
	  <div class="span4 scCol">
		<div class="block" id="grid_block_2">
          <div class="content">
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span5"></div>
                   		<div class="span7">
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span5"><?php echo $this->lang->line('amount_cr_ttl');?></div>
                   		<div class="span7">
                            	<?php 								
								$data = array(
									'name'=>'amountcredit', 
									'id'=>'amountcredit', 
									'disabled'=>'disabled',
									'class'=>'input-small tar',); 
								echo form_input($data, number_format($journalHead->total_amount_dr,2)); ?>
                  		</div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span5"><?php echo $this->lang->line('amount_dr_ttl');?></div>
                   		<div class="span7">
                            	<?php 								
								$data = array(
									'name'=>'amountdebit', 
									'id'=>'amountdebit', 
									'disabled'=>'disabled',
									'class'=>'input-small tar',); 
								echo form_input($data, number_format($journalHead->total_amount_cr,2)); ?>
                  		</div>
                 	</div><!-- End Row 4-->
          </div><!-- End Content-->
         </div> <!-- Block grid-->                                   
      </div> <!-- scCol-->                                   
     </div> <!-- row-fluid scRow-->                                   
	<div class="row-fluid scRow">                            
	  <div class="span12 scCol">
	 	<div class="block" id="journalTable">
        	<div class="head">
            	<h2><?php echo $this->lang->line('details') ?></h2>
        	</div>
          	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="oTable" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th width="5">#</th>
            			<th><?php echo $this->lang->line('acctCode')?></th>
            			<th><?php echo $this->lang->line('description')?></th>
            			<th class="tar"><?php echo $this->lang->line('amount_dr')?></th>
            			<th class="tar"><?php echo $this->lang->line('amount_cr')?></th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($datatbls){
					foreach($datatbls as $datatbl):
					$bil++?>
            		<tr>
                		<td style="display:none" ><?php echo $datatbl->ID; ?></td>
                		<td class="tac"><?php echo $datatbl->sequence; ?></td>
                    	<td><?php echo substr($datatbl->acctcode,0, 4).'-'.substr($datatbl->acctcode,4, 3).'-'.substr($datatbl->acctcode,7, 2) . "  [" . $datatbl->acctname. "]"?></td>
                		<td><?php echo $datatbl->description?></td>
                		<td class="tar"><?php echo number_format($datatbl->amount_dr,2); ?></td>
                		<td class="tar"><?php echo number_format($datatbl->amount_cr,2); ?></td>
                	</tr>
            <?php endforeach; 
				}?>
					</tbody>
			</table>                                         
			</div>
		</div><!-- Block grid-->
</div>
</div>                        
</div>                        
</div>
