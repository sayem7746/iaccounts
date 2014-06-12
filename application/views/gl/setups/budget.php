<script>
$(document).ready(function(){
	$('select').select2();
});
function saveBudget(){
	var fcy = $("#financialYear").val();
		var tablerows = $("table > tbody >tr").length;
//		var startrows = parseInt($("#oTable > tbody >tr").length) - numrows;
		var rows = $("table").dataTable().fnGetNodes();
//	var accountno =$("#acctCode option:selected").val();
		for (var i = 0; i < tablerows ; i++){
			var postData = {
				'fcy' :  fcy,
				'acctID' : $(rows[i]).find("td:eq(0)").html(),
				'1' : $(rows[i]).find("td:eq(2) input").val(),
				'2' : $(rows[i]).find("td:eq(3) input").val(),
				'3' : $(rows[i]).find("td:eq(4) input").val(),
				'4' : $(rows[i]).find("td:eq(5) input").val(),
				'5' : $(rows[i]).find("td:eq(6) input").val(),
				'6' : $(rows[i]).find("td:eq(7) input").val(),
				'7' : $(rows[i]).find("td:eq(8) input").val(),
				'8' : $(rows[i]).find("td:eq(9) input").val(),
				'9' : $(rows[i]).find("td:eq(10) input").val(),
				'10' : $(rows[i]).find("td:eq(11) input").val(),
				'11' : $(rows[i]).find("td:eq(12) input").val(),
				'12' : $(rows[i]).find("td:eq(13) input").val(),
			}
//			alert($(rows[i]).find("td:eq(0)").html());
 				$.ajax({
  					type: "POST",
  					dataType: "json",
					url: "<?php echo base_url()?>glsetting/budget_insert",
					data: postData ,
	  				async: false,
					success: function(content){
						if(content.status == "success") {
//							var urls = "<?php echo base_url();?>glsetting/budgetEdit/"+fcy;
//							window.location = urls;
						}
					}
				});  
		}
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

function total(obj){
    var eRow   = $(this).parents('tr');
	var total_amount = 0;
	total_amount = parseInt(total_amount) + parseInt($('td:eq(2)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(3)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(4)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(5)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(6)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(7)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(8)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(9)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(10)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(11)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(12)', $(obj).parents('tr')).find("input").val());
	total_amount = parseInt(total_amount) + parseInt($('td:eq(13)', $(obj).parents('tr')).find("input").val());
	$('td:eq(14)', $(obj).parents('tr')).find("input").val(total_amount);
}
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
<div class="content">
	<div class="row-fluid">
		<div class="alert alert-info">
			<strong><?php echo $this->lang->line('title') ?></strong>
		</div>
	</div>
	<div class="row-fluid scRow">                            
		<div class="span12">
			<div class="block">
         	<div class="head">
            	<h2><?php echo $this->lang->line('details') ?></h2>
                	<ul class="buttons">
                 		<li><?php 
						$preselyear = date('Y');
						$options = '';
						for($i=-1; $i<10; $i++){
							$options[date('Y', strtotime($i . "  year"))] = date('Y', strtotime($i . "  year"));
						}
						$js='class="input-medium" id="financialYear"';
						echo form_dropdown('financialYear', $options, $preselyear, $js); ?></li>
                	</ul>                                        
        	</div>
         	<div class="content np">
            	<table cellpadding="0" cellspacing="0" width="100%">
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
						if($chartofaccount){
							foreach($chartofaccount as $datatbl):
								$bil++?>
                                <tr>
            						<td style="display:none"><?php echo $datatbl->ID ?></td>
                					<td><?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2).' [ '.$datatbl->acctName.' ]'?></td>
                                    <td class="span1"><input type='text' name='period01' onchange="total(this)" class='span12 tar' value="0" align="right"/></td>
                                    <td class="span1"><input type='text' name='period02' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period03' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period04' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period05' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period06' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period07' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period08' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period09' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period10' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period11' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='period12' onchange="total(this)" class='span12 tar' value="0"/></td>
                                    <td class="span1"><input type='text' name='total' id="total" onchange="calculate(this)" class='span12 tar' value="0"/></td>
                                </tr>
							<?php endforeach;?>
                    <?php } ?>
					</tbody>
			</table>                                         
			</div>
            <div class="footer">
            	<div class="side">
                	<div class="btn-group">
                        <?php 
							$data = array(
									'name'=>'mysubmit', 
									'class'=>'btn btn-primary',
									'onClick'=>"saveBudget()"); 
							echo form_button($data,$this->lang->line('submit'));
							?>
                    </div>
                </div>
            </div>                                    
        	</div>
        </div>    
    </div>
</div> <!-- content -->
</div>
</div>