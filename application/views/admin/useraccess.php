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
    $("#test input.transaction[type=checkbox]").each(function () {
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
    $("table.editable").on("click",".Submit",function(){
        rRow = $(this).parents("tr");
        fldid = $('td:first', $(this).parents('tr')).text(); 
		if($(rRow.find('input[id="transaction"]')).is(':checked')){ transaction = 1 ;}else{ transaction = 0;};
		if($(rRow.find('input[id="reports"]')).is(':checked')){ reports = 1 ;}else{ reports = 0;};
		if($(rRow.find('input[id="set_up"]')).is(':checked')){ set_up = 1 ;}else{ set_up = 0;};
        $("#row_submit").dialog("open");
    });
    function row_submit(row){
		var postData = {
			'fldid' : fldid,
			'transaction' : transaction,
			'reports' : reports,
			'setup' : set_up,
		};
 		$.ajax({
  			type: "POST",
  			dataType: "json",
			url: "../useraccess_update",
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
    $("#row_submit").dialog({
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
            	<li><a href='<?php echo base_url()."home" ?>'><?php echo $this->lang->line('dash') ?></a> <span class="divider">-</span></li>
                <li><a href="home"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
                	<h2><?php echo $this->lang->line('title1'); echo $umaster->username ; ?> [ <?php echo $umaster->userid ; ?> ]</h2>
                </div>
            	<div class="content np">
                    <table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable oc_disable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th class="tac">#</th>
                		<th><?php echo $this->lang->line('moduleID')?></th>
                		<th class="tac"><?php echo $this->lang->line('All')?></th>
                		<th class="tac"><?php echo $this->lang->line('transaction')?></th>
                		<th class="tac"><?php echo $this->lang->line('reports')?></th>                
                		<th class="tac"><?php echo $this->lang->line('setup')?></th>                
                		<th class="tac"><?php echo $this->lang->line('Action')?></th>
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
                	<td id="moduleID"><?php echo $datatbl->description; ?></td>
                	<td id="alls" class="tac"><?php 
						$data = array(
    						'name'        => 'alls',
    						'id'          => 'alls',
    						'value'       => 'accept',
    						'style'       => 'margin:10px',
							'class'	   => 'alls',
 							'title'	   => $this->lang->line('All')
    					);
						if($datatbl->setup == 1 && $datatbl->transaction == 1 && $datatbl->reports == 1 ){ $data['checked'] = TRUE; }else{ $data['checked'] = FALSE; };
						echo form_checkbox($data); ?></td>
                	<td id="transaction" class="tac"><?php 
						$data = array(
    						'name'        => 'transaction',
    						'id'          => 'transaction',
    						'value'       => 'accept',
    						'style'       => 'margin:10px',
							'class'	   => 'transaction',
 							'title'	   => $this->lang->line('transaction')
   					);
						if($datatbl->transaction == 1){ $data['checked'] = TRUE; }else{ $data['checked'] = FALSE; };
						echo form_checkbox($data); ?></td>
                	<td id="reports" class="tac"><?php 
						$data = array(
    						'name'        => 'reports',
    						'id'          => 'reports',
    						'value'       => 'accept',
    						'style'       => 'margin:10px',
							'class'	   => 'reports',
 							'title'	   => $this->lang->line('reports')
    					);
						if($datatbl->reports == 1){ $data['checked'] = TRUE; }else{ $data['checked'] = FALSE; };
						echo form_checkbox($data); ?></td>
                	<td id="set_up" class="tac"><?php 
						$data = array(
    						'name'        => 'set_up',
    						'id'          => 'set_up',
    						'value'       => 'accept',
    						'style'       => 'margin:10px',
							'class'	   => 'set_up',
 							'title'	   => $this->lang->line('setup')
    					);
						if($datatbl->setup == 1){ $data['checked'] = TRUE; }else{ $data['checked'] = FALSE; };
						echo form_checkbox($data); ?></td>
                    <td class="tac"><?php
							$js = 'class="btn btn-mini btn-primary Submit" id="Submit" title="Submit" disabled="disabled"';
							echo form_button($this->lang->line('Submit'),$this->lang->line('Submit'),$js);
							?>
                    </td>
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
<div class="dialog" id="row_submit" style="display: none;" title="Update User Access?">
    <p>Row will be updated</p>
</div>   
