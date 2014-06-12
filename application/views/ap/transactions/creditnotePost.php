<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
    var oTable = $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "asSorting": [ "asc"], "aTargets": [ 1 ],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null,
			null, 
			null, 
			null,
			null, { 
			"bSortable": false } ]});
    oTable.fnSort( [ [1,'asc'] ] );
    $("table .checkall1").live("click", "checkall1",function(){           
		$(oTable.fnGetNodes()).find(':checkbox').prop('checked', this.checked);
	});
}); 
 
function changeList(){
	var df = $('#selDateFrom').val();
	var dt = $('#selDateTo').val();
	var urls = "<?php echo base_url();?>aptransaction/creditnotePost/"+df+"/"+dt;
		window.location = urls;
} 


function postcrdtn(){
   var oTable = $("#test").dataTable( );
	$(oTable.fnGetNodes()).find(':checkbox').each(function () {
        if($(this).is(':checked')){
			var fldid = $('td:first', $(this).parents('tr')).text(); 
			var effdate = $('td:eq(6)', $(this).parents('tr')).text(); 
			var postData = {
				'fldid' : fldid,
				'effdate' : effdate,
			};
			
//			alert(effdate);
 			$.ajax({
  				type: "POST",
	  			dataType: "json",
				url: "<?php echo base_url()?>Aptransaction/creditNotePosting",
				data: postData ,
	  			async: false,
  				success: function(content){
				}
			}); 
		}
	});
	window.location.reload(true);
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
                <li><a href="ap/home"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $this->lang->line('title') ?></li>
            </ul>
		</div>
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
                    </div><!-- head -->
				<div class="content np">    
                	<div class="controls-row"><!-- Row 4-->
						<div class="span5 tac">
                    	<div class="span2 tar"><?php echo form_label($this->lang->line('dateFrom'));?></div>
                        <div class="input-prepend"> 
                        <span class="add-on"><i class="i-calendar"></i></span>
						<?php
										$data = array(
										'name' => 'selDateFrom',
										'id' => 'selDateFrom',
										'type' => 'text',
										'class' => 'input-small datepicker2');
										$js='onChange="changeList()"';
										echo form_input($data, date('d-m-Y', strtotime($dateFrom)), $js);
										
									?>     
                           </div>             
                        </div>
						<div class="span5 tac">
                    	<div class="span2 tar"><?php echo form_label($this->lang->line('dateTo'));?></div>
                        <div class="input-prepend">
                        <span class="add-on"><i class="i-calendar"></i></span>
						<?php
										$data = array(
										'name' => 'selDateTo',
										'id' => 'selDateTo',
										'type' => 'text',
										'class' => 'input-small datepicker2');
										$js='onChange="changeList()"';
										echo form_input($data, date('d-m-Y', strtotime($dateTo)), $js);
									?>  
                                    </div>     
                        </div>
                 	</div><!-- End Row 4-->
				</div><!-- content -->
            	<div class="head">
                	<h2><?php echo $this->lang->line('titlelist');?></h2>
                    	<ul class="buttons">
                    		<li><a href="<?php echo base_url(); ?>CompanySetup/chartAcct" title="Add New"><span class="i-plus-2"></span></a></li>
                        </ul>                                       
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th class="tac">#</th>
						<th><?php echo $this->lang->line('invoiceno');?></th>
						<th><?php echo $this->lang->line('supplierName');?></th>
            			<th><?php echo $this->lang->line('formNo');?></th>
                         <th><?php echo $this->lang->line('totalAmount');?></th>
                        <th class="tac"><?php echo $this->lang->line('date');?></th>
                        <th class="tac"><input type="checkbox" id="checkall1" class="checkall1"/></th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->ID; ?></td>	
             		<td><?php echo $bil; ?></td>
             		<td><?php echo $datatbl->supplierInvoiceNo ?></td>
            		<td><?php echo $datatbl->supplierName ?></td>
            		<td><?php echo $datatbl->formNo.'['.$this->FormSetup_model->getFormSerialNo_zeroLeading($datatbl->ID).']'; ?></td>
                    
                    <td class="tac"><?php echo number_format($datatbl->totalAmount,2) ?></td>
 
                    <td class="tac"><?php echo date('d-m-Y', strtotime($datatbl->invoiceDate)); ?></td>
                    
                    <td class="tac"><input type="checkbox" class="checkbox" id="checkbox"/></td>
                </tr>
            <?php endforeach; }?>
                     </tbody>
                     </table>
				</div><!-- content -->
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                        <?php 
							$data = array(
									'name'=>'postcrdtn', 
									'class'=>'btn btn-warning');
							$js='onclick="postcrdtn()"';
							echo form_submit($data,$this->lang->line('postcrdtn'),$js);
							?>
                    </div>
                </div>
            </div>                                    
				</div><!-- block -->
			</div><!-- span12 -->
		</div><!-- row-fluid -->	
	</div><!-- wrap -->
</div><!-- content -->
	</div><!-- wrap -->
</div><!-- content -->

