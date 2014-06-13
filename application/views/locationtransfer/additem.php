<script>
/*
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
            $(this).html('Save');
            eState = 1;
        }
        if(eState == 1) 
            $(this).attr('data-state','2');
        else{
            $(this).removeAttr('data-state');
            $(this).html('Edit');
        }
    });
        
}); */
</script>
<div id="content">                        
<div class="wrap">
<div class="head">
	<div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url(); ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
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
                    	<h2><?php echo $this->lang->line('title') ?></h2>
                    </div><!-- head -->
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

