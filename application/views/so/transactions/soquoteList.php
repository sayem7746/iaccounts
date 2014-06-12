<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
   $('select').select2();
   var oTable = $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null, 
			null, 
			null, 
			null,
			null,{ 
		 	"bSortable": false } ]});
     oTable.fnSort( [ [1,'asc'] ] );
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
				window.location.href = "<?php echo base_url(); ?>glreports/journalDetails/" + ID;		
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
}); 
 
function changeList(){
	var addyear = $('#add_year option:selected').val();
	var addper = $('#add_period option:selected').val();
	var urls = "<?php echo base_url();?>glreports/unpostedjournal/"+addyear+"/"+addper;
		window.location = urls;
}

function selectYearPeriod(obj){
		var year = obj.value;
//		alert(year);
			
			$.ajax({
  				type: "POST",
	  			dataType: "json",
				url: "<?php echo base_url()?>glreports/get_TrialBalance_year/"+year,
				data: year,
	  			async: false,
  				success: function(content){
					if(content.status == "success") {
					var items = [];
					//items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].ID+'">'
						+ content.message[i].period + '</option>');
					}  //end for
					jQuery("#add_period").empty();
					jQuery("#add_period").append(items.join('</br>'));
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				} //end if
			} //end success
				
			}); //end ajax
//	window.location.reload(true); 
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
                    	<ul class="buttons">
                    		<li><a href="<?php echo base_url()?>sotransaction/SalesQuotation" title="Add New"><span class="i-plus-2"></span></a></li>
                        </ul>                                        
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
							$js='onchange="selectYearPeriod(this)" class="input-medium" id="add_year"';

							echo form_dropdown('add_year', $options, $preselyear, $js);
						?>       
                        </div>
						<div class="span5 tac">
                    	<div class="span2 tar"><?php echo form_label($this->lang->line('period'),'add_period');?></div>
						<?php
							$preselperiod = $selper;
							$options = '';
							$options[] = $this->lang->line('period');
							if($period){
								foreach($period as $row){
									$options[$row->period] = $row->period;
								}
							}
							$js='class="input-medium" id="add_period"';

							echo form_dropdown('add_period', $options, $preselperiod, $js);
						?>       
                        </div>
						<div class="span2 tac">
                        <?php 
							$data = array(
									'name'=>'mysubmit', 
									'class'=>'btn btn-small btn-primary');
									$js="onClick='changeList()'";
							echo form_button($data,$this->lang->line('submit'),$js);
							?>
                        </div>
                 	</div><!-- End Row 4-->
				</div><!-- content -->
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th class="tac">#</th>
                        <th><?php echo $this->lang->line('quoteNo') ?></th>
                        <th class="tac"><?php echo $this->lang->line('quoteDate') ?></th>
                        <th class="tac"><?php echo $this->lang->line('expiredDate') ?></th>
                        <th class="tac"><?php echo $this->lang->line('amount') ?></th>
                        <th><?php echo $this->lang->line('customer') ?></th>
                        <th class="tac"><?php echo $this->lang->line('action') ?></th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->ID; ?></td>
                	<td class="tac"><?php echo $bil; ?></td>
                    <td><a title="<?php echo $this->lang->line('details');?>" class="btn btn-mini btn-link edit"><?php echo $datatbl->ID ?></a></td>
                	<td class="tac"><?php echo $datatbl->quotationDate?></td>
                	<td><?php echo $datatbl->salesAgentID?></td>
                	<td class="tar"><?php echo number_format($datatbl->totalTaxAmount,2); ?></td>
                	<td><?php echo $datatbl->customerName; ?></td>
 					<td class="tac"><?php
							$js = 'class="btn btn-mini btn-danger remove" title="'.$this->lang->line('delete').'"';
							echo form_button('remove','<span class="i-trashcan">',$js);
						?></td>
               </tr>
            <?php endforeach; }?>
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
