<script>
$(document).ready(function(){
	$('select').select2();
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	
    $("table.editable").on("click",".edit",function(){
        var eRow   = $(this).parents('tr');
        var eState = $(this).attr('data-state');
        
        if(eState == null){
            //$(this).html('Save');
            eState = 1;
        }
        if(eState == 1) 
            $(this).attr('data-state','2');
        else{
            $(this).removeAttr('data-state');
            $(this).html('Edit');
        }
    });
        
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
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
			null, 
			null, { 
			"bSortable": false } ]});
     oTable.fnSort( [ [1,'asc'] ] );
	 $("table .checkall1").live("click", "checkall1",function(){           
		$(oTable.fnGetNodes()).find(':checkbox').prop('checked', this.checked);
	});
    $("table.editable").on("click",".edit",function(){
        rRow = $(this).parents("tr");
        ID = $('td:first', $(this).parents('tr')).text(); 
        $("#row_edit").dialog("open");
    });
    $("#row_edit").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
				window.location.href = "<?php echo base_url() ?>purchaseInvoice/edit/" + ID;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
});

function changeList(obj){
	var df = $('#selDateFrom').val();
	var dt = $('#selDateTo').val();
	var urls = "<?php echo base_url();?>SupplierPayment/supplierpaymentlist/"+df+"/"+dt;
		window.location = urls;
}

function updatePosting(){
   var oTable = $("#test").dataTable( );
	$(oTable.fnGetNodes()).find(':checkbox').each(function () {
        if($(this).is(':checked')){
			var ID = $('td:first', $(this).parents('tr')).text(); 
			var updateAble = $('td:eq(2)', $(this).parents('tr')).text(); 
			var postData = {
				'ID' : ID,
				'updateAble' : updateAble,
			};
 			$.ajax({
  				type: "POST",
	  			dataType: "json",
				url: "<?php echo base_url()?>supplierpayment/supplierPaymentList",
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
                <li><a href="#"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
										'class' => 'input-small datepicker2',);
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
										'class' => 'input-small datepicker2',);
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
						<th class="tac"><?php echo $this->lang->line('amountPaid');?></th>
						<th class="tac"><?php echo $this->lang->line('supplierName');?></th>
            			<th class="tac"><?php echo $this->lang->line('formNo');?></th>
                        <th class="tac"><?php echo $this->lang->line('paymentDate');?></th>
                		<th width="55" class="tac"><?php echo $this->lang->line('action');?></th>
                        <th width="55" class="tac"><?php echo $this->lang->line('status');?></th>
                        <th class="tac"><input type="checkbox" id="checkall1" class="checkall1"/></th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0;
			//echo var_dump($datatbls); 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->ID; ?></td>	
                	<td><?php echo $bil; ?></td>
                	<td><?php echo $datatbl->amountPaid ?></td>
                	<td><?php echo $datatbl->supplierName ?></td>
                	<td><?php echo $datatbl->formNo.'['.$this->FormSetup_model->getFormSerialNo_zeroLeading($datatbl->ID).']'; ?></td>
                    
                    <td class="tac"><?php echo date('d-m-Y', strtotime($datatbl->paymentDate)); ?></td>
						<td class="tac"><?php
							$js = 'class="btn btn-mini btn-primary edit" title="'.$this->lang->line("edit").'"';
							echo form_button('edit','<span class="i-pen">',$js); ?>
                        </td>
                        <td class="tac"><?php echo 'No';  ?></td>
                        <td class="tac"><input type="checkbox" class="checkbox" name="updateAble" id="updateAble" checked="checked" value="1"/>
                    </td>
                </tr>
            <?php endforeach; }?>
					</tbody>
			</table>
            <div class="footer">
            	<div class="side fr">
                	<div class="btn-group">
                        <?php 
							$data = array(
									'name'=>'updatePosting', 
									'class'=>'btn btn-warning');
							$js='onclick="updatePosting()"';
							echo form_submit($data,$this->lang->line('updatePosting'),$js);
							?>
                    </div>
                </div>
            </div>                                         
			</div>
<div class="dialog" id="row_edit" style="display: none;" title="Edit ?">
    <p><?php echo $this->lang->line('message2');?></p>
</div>  

