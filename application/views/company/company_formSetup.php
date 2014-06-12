<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
	$("#Submit").attr("disabled", "disabled");
    $("#test input.alls[type=checkbox]").each(function () {
        $(this).change(function () {
             var $tr =  $(this).closest('tr');
             $tr.find('.Submit').removeAttr("disabled");
            if ($(this).is(":checked")) {
                $tr.find('.transaction').attr('checked', true);
                $tr.find('.reports').attr('checked', true);
                $tr.find('.set_up').attr('checked', true);
            } else {
                $tr.find('.transaction').attr('checked', false);
                $tr.find('.reports').attr('checked', false);
                $tr.find('.set_up').attr('checked', false);
            }
        });
    });
    $("#test input.formYear[type=checkbox]").each(function () {
        $(this).change(function () {
             var $tr =  $(this).closest('tr');
             $tr.find('.Submit').removeAttr("disabled");
            if ($(this).is(":checked")) {
            } else {
                $tr.find('.alls').attr('checked', false);
            }
        });
    });
    $("#test input.reports[type=checkbox]").each(function () {
        $(this).change(function () {
             var $tr =  $(this).closest('tr');
             $tr.find('.Submit').removeAttr("disabled");
            if ($(this).is(":checked")) {
            } else {
                $tr.find('.alls').attr('checked', false);
            }
        });
    });
    $("#test input.set_up[type=checkbox]").each(function () {
        $(this).change(function () {
             var $tr =  $(this).closest('tr');
             $tr.find('.Submit').removeAttr("disabled");
            if ($(this).is(":checked")) {
            } else {
                $tr.find('.alls').attr('checked', false);
            }
        });
    });
	 $("table.editable td").live('dblclick',function () {        
       
		var fldid = $('td:first', $(this).parents('tr')).text(); 
		var fieldname = $(this).attr('id');
        var eContent = $(this).text();
        var eCell = $(this);

        var $tr =  $(this).closest('tr');
        $tr.find('.Submit').removeAttr("disabled");
            
        if(eContent.indexOf('<') >= 0 || eCell.parents('table').hasClass('oc_disable')) return false;        
            
        eCell.addClass("editing");        
        eCell.html('<input type="text" value="' + eContent + '"/>');
        
        var eInput = eCell.find("input");
        eInput.focus();
 
        eInput.keypress(function(e){
            if (e.which == 13) {
                var newContent = $(this).val();
                eCell.html(newContent).removeClass("editing");
				var dataToSend= {fldid: fldid, fieldname: fieldname, content: newContent};
			 $.ajax({
  				type: "POST",
  				url: "formSetup_update",
				data:dataToSend,
  				success: function(){
				//alert('Data has been saved...');
				}, 
			 });       
                // Here your ajax actions after pressed Enter button
            }
        });
 
        eInput.focusout(function(){
            eCell.text(eContent).removeClass("editing");            
            // Here your ajax action after focus out from input
			alert('Data not saved...');
        });        
    });

    $("table.editable").on("click",".Submit",function(){
		
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
		if($(rRow.find('input[id="formYear"]')).is(':checked')){ transaction = 1 ;}else{ transaction = 0;};
		if($(rRow.find('input[id="formMonth"]')).is(':checked')){ reports = 1 ;}else{ reports = 0;};
		if($(rRow.find('input[id="formDay"]')).is(':checked')){ set_up = 1 ;}else{ set_up = 0;};
       // $("#row_submit_btnsave").dialog("open");
	   row_submit(rRow);
    });
    function row_submit(row){
		var postData = {
			'id' : fldid,
			'formYear' : transaction,
			'formMonth' : reports,
			'formDay' : set_up,
		};
 		$.ajax({
  			type: "POST",
  			dataType: "json",
			url: "formSetup_save",
			data: postData ,
  			success: function(content){
				alert(content.message);
setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 0001);			},
		});        // Here your ajax action after delete confirmed
//		location.reload();
    }
    $("#row_submit_btnsavet").dialog({
        autoOpen: false,
        resizable: false,        
        modal: true,
        buttons: {
            "Continue...": function() {
                row_submit(rRow);
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });    
}); 
</script>

<div class="head">
	<div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'>Dashboard</a> <span class="divider">-</span></li>
                <li><a href="home"><?php echo $module ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $title ?></li>
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
                	<h2><?php echo $title ?></h2>
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th>#</th>
                		<th><?php echo $this->lang->line('formID')?></th>
                        
                		<th class="tac"><?php echo $this->lang->line('formCode')?></th>
                		<th class="tac"><?php echo $this->lang->line('formYear')?></th>
                		<th class="tac"><?php echo $this->lang->line('formMonth')?></th>                
                		<th class="tac"><?php echo $this->lang->line('formDay')?></th>                
                		<th class="tac"><?php echo $this->lang->line('formInitial')?></th>                
                		<th width="55" class="tac">Action</th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
// echo var_dump($datatbls); 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->ID; ?></td>
                	<td><?php echo $bil; ?></td>
                	<td><button class="btn btn-link access" title="<?php echo $this->lang->line('title')?>"><?php echo $datatbl->name; ?></button></td>


                	<td id="formCode"><?php echo $datatbl->formCode; ?></td>
                   	<td id="formYear" class="tac"><?php 
						$data = array(
    						'name'        => 'formYear',
    						'id'          => 'formYear',
    						'value'       => 'accept',
    						'style'       => 'margin:10px',
							'class'	   => 'formYear',
 							'title'	   => $this->lang->line('formYear')
   					);
						if($datatbl->formYear == 1){ $data['checked'] = TRUE; }else{ $data['checked'] = FALSE; };
						echo form_checkbox($data); ?></td>
    
                	<td id="reports" class="tac"><?php 
						$data = array(
    						'name'        => 'formMonth',
    						'id'          => 'formMonth',
    						'value'       => 'accept',
    						'style'       => 'margin:10px',
							'class'	   => 'reports',
 							'title'	   => $this->lang->line('formMonth')
    					);
						if($datatbl->formMonth == 1){ $data['checked'] = TRUE; }else{ $data['checked'] = FALSE; };
						echo form_checkbox($data); ?></td>
                	<td id="set_up" class="tac"><?php 
						$data = array(
    						'name'        => 'formDay',
    						'id'          => 'formDay',
    						'value'       => 'accept',
    						'style'       => 'margin:10px',
							'class'	   => 'set_up',
 							'title'	   => $this->lang->line('formDay')
    					);
						if($datatbl->formDay == 1){ $data['checked'] = TRUE; }else{ $data['checked'] = FALSE; };
						echo form_checkbox($data); ?></td>
                	<td id="formInitial"><?php echo $datatbl->formInitial; ?></td>
                    <td><?php 
							$js = 'class="btn btn-mini btn-primary Submit" id="Submit" title="Save" disabled="disabled"';
							echo form_button($this->lang->line('save'),$this->lang->line('save'),$js);
                    ?></td>
                </tr>
            <?php endforeach; }?>
					</tbody>
			</table>                                         
			</div>
</div>                                
</div>
</div>                                
</div>
</div>                                
</div>
</div>
<div class="dialog" id="row_delete" style="display: none;" title="Delete?">
    <p>Row will be deleted</p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Edit ?">
    <p>To editing page.....</p>
</div>   
<div class="dialog" id="row_submit_btnsave" style="display: none;" title="Setting User Access ?">
    <p>Click OK to continue.....</p>
</div>   
