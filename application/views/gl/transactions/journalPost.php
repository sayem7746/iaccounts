<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
   $('select').select2();
	$("table.editable").die();
   var oTable = $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false }, 
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
	var addyear = $('#add_year option:selected').val();
	var addper = $('#add_period option:selected').val();
	var urls = "<?php echo base_url();?>Gltransaction/posting/"+addyear+"/"+addper;
		window.location = urls;
}

function postJournal(){
   var oTable = $("#test").dataTable( );
	$(oTable.fnGetNodes()).find(':checkbox').each(function () {
        if($(this).is(':checked')){
			var fldid = $('td:first', $(this).parents('tr')).text(); 
			var journalNo = $('td:eq(2)', $(this).parents('tr')).text(); 
			var postData = {
				'fldid' : fldid,
				'journalNo' : journalNo
			};
 			$.ajax({
  				type: "POST",
	  			dataType: "json",
				url: "<?php echo base_url()?>Gltransaction/journalPosting",
				data: postData ,
	  			async: false,
  				success: function(content){
				}
			}); 
		}
	});
	window.location.reload(true);
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
                <li><a href="#"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
                        <th><?php echo $this->lang->line('jlnumber') ?></th>
                        <th class="tac"><?php echo $this->lang->line('year') ?></th>
                        <th class="tac"><?php echo $this->lang->line('period') ?></th>
                        <th><?php echo $this->lang->line('description') ?></th>
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
                	<td class="tac"><?php echo $bil; ?></td>
                    <td><?php echo $datatbl->journalID ?></td>
                	<td class="tac"><?php echo $datatbl->year?></td>
                	<td class="tac"><?php echo $datatbl->period; ?></td>
                	<td><?php echo $datatbl->description; ?></td>
                    <td class="tac"><?php if($datatbl->total_amount == 0 ) {?><input type="checkbox" class="checkbox" id="checkbox"/> 
						<?php }else{ echo $this->lang->line('balance');?> : <?php echo $datatbl->total_amount;  } ?> 
                    </td>
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
									'name'=>'postjournal', 
									'class'=>'btn btn-warning');
							$js='onclick="postJournal()"';
							echo form_submit($data,$this->lang->line('postjournal'),$js);
							?>
                    </div>
                </div>
            </div>                                    
				</div><!-- block -->
			</div><!-- span12 -->
		</div><!-- row-fluid -->	
	</div><!-- wrap -->
</div><!-- content -->
