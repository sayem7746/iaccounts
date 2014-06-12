<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
   $('select').select2();
    $("table.editable td").live('dblclick',function () {        
		var addyear = $('#add_year option:selected').val();
		var fldid = $('td:first', $(this).parents('tr')).text(); 
		var fieldname = $(this).attr('id');
        var eContent = $(this).html();
        var eCell = $(this);
            
        if(eContent.indexOf('<') >= 0 || eCell.parents('table').hasClass('oc_disable')) return false;        
        
		if(fieldname <=12 ){    
        eCell.addClass("editing");        
        eCell.html('<input type="text" value="' + eContent + '"/>');
        
        var eInput = eCell.find("input");
        eInput.focus();
 
        eInput.keypress(function(e){
            if (e.which == 13) {
                var newContent = $(this).val();
                eCell.html(newContent).removeClass("editing");
				var dataToSend= {fldid: fldid, fieldname: fieldname, content: newContent, budgetYear: addyear};
			 $.ajax({
  				type: "POST",
  				url: "<?php echo base_url() ?>glsetting/budget_save",
				data:dataToSend,
  				success: function(){
					alert('<?php echo $this->lang->line('message7')?>');
					window.location.reload(true);
				}, 
			 });       
                // Here your ajax actions after pressed Enter button
            }
        });
 
        eInput.focusout(function(){
            eCell.text(eContent).removeClass("editing");            
            // Here your ajax action after focus out from input
			alert('<?php echo $this->lang->line('message8')?>');
        });        
		}
    });
}); 
function do_print(){
	var addyear = $('#add_year option:selected').val();
	window.open("<?php echo base_url() ?>glreports/budgetList_print/"+addyear);
}
 
function changeList(){
	var addyear = $('#add_year option:selected').val();
	var urls = "<?php echo base_url();?>glsetting/budgetEdit/"+addyear;
		window.location = urls;
}
function calculate(obj){
	var total_amount = 0;
	var total = Math.round(obj.value / 12);
    var eRow   = $(this).parents('tr');
	var acctID = $('td:first', $(obj).parents('tr')).html();
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(2)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(3)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(4)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(5)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(6)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(7)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(8)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(9)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(10)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(11)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(total_amount) + parseInt(total);
	$('td:eq(12)', $(obj).parents('tr')).find("input").val(total);
	total_amount = parseInt(obj.value) - parseInt(total_amount);
	$('td:eq(13)', $(obj).parents('tr')).find("input").val(total_amount);
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
						$js='class="input-medium" id="add_year" onChange="changeList()"';
						echo form_dropdown('add_year', $options, $preselyear, $js); 
						?>       
                        </div>
                 	</div><!-- End Row 4-->
				</div><!-- content -->
            	<div class="content np">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
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
                        			<td class="tar" id="13"><?php echo $datatbl_total ?></td>
                        			</tr>
						<?php } ?>
                        <?php 	$accountID = $datatbl->acctID; ?>
						<?php		$datatbl_total = $datatbl->amountcr; ?>			
                                <tr>
            						<td style="display:none"><?php echo $datatbl->acctID ?></td>
                					<td><?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2).' [ '.$datatbl->acctName.' ]'?></td>
                        			<td class="tar" id="<?php echo $datatbl->period?>"><?php echo $datatbl->amountcr?></td>
                        <?php }else{?>
						<?php		$datatbl_total = $datatbl_total + $datatbl->amountcr; ?>			
                        			<td class="tar" id="<?php echo $datatbl->period?>"><?php echo $datatbl->amountcr?></td>
                        <?php } ?>
				<?php   endforeach; ?>
                        			<td class="tar" id="13"><?php echo $datatbl_total ?></td>
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
