<script>

$(document).ready(function(){
	$('select').select2();
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});

	
	//Add items to location transfer
	var str;
		//remove items from the table.
		//jQuery()
		//Add items to the table.
		jQuery('body').on('click','.removeItm',function(){
			jQuery('.itemTbl .itemList input:checked').parent().parent().remove();
		}).on('click','#popupModal .addItems',function(){
			var i = 0;
			var str = '';
			jQuery("#popupModal .itemCheck input").each(function(){
				if(jQuery(this).attr('checked') == 'checked'){
					if(!i)	str += jQuery(this).val(); 
					else	  str += '-'+jQuery(this).val(); 
					i++;	
				}
			});

			// Ajax call to get item details
			jQuery.ajax({
				url: "<?php echo base_url(); ?>locationtransfer/get_items/item_ids/"+str,
				async: false,
				type: "GET",
				data: "",
				dataType: "html",
				success: function(data) {
					var obj = jQuery.parseJSON(data);
					jQuery('.itemTbl .noItem,.itemTbl .itemList').remove();
					if(obj[0].ID){
						jQuery.each(obj,function(i,v){
							var tempStr = '<tr class="itemList itemList'+v.ID+'">\
							<td style="display:none" >'+v.ID+'</td>\
							<td valign="middle"><input type="checkbox" checked="checked" name="itemList[]" value="'+v.ID+'" id="'+v.ID+'" /></td>\
							<td class="tac">'+v.itemCode+'</td>\
							<td>'+v.description+'</td>\
							<td class="tac"><input class="input-small" type="text" value="" name="quantity[]" /></td>\
							<td class="tac"><input class="input-small" type="text" value="" name="stock[]" /></td>\
							</tr>';
							jQuery('#loctransfer .itemTbl').append(tempStr);
						});
					}else{
						var tempStr = '<tr class="itemList noItem">\
										<td colspan="6">No Content available</td>\
										</tr>';
						jQuery('.itemTbl').append(tempStr);
					}
				}
			});
		});	        
});
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
	<?php echo form_open('locationtransfer/add',array("id"=>"loctransfer")); ?>        
        <div class="content">      
            <div class="row-fluid">
                <div class="alert alert-info">
                    <strong><?php echo $this->lang->line('loctransform') ?></strong>
                </div>
            </div> 
            <!--Location transfer top form-->  
            <div class="row-fluid scRow">
                <div class="span6 scCol">        	
                    <div class="block" id="grid_block_1">
                        <div class="content">                 	
                            <div class="controls-row">
                                <div class="span4"><?php echo $this->lang->line('fromLocation') ?></div>
                                <div class="span8">
                                    <?php
                                        $preselcat = '458';
                                        $options[] = '--Please Select--';
                                        foreach($fromLocation as $row){
                                            $options[$row->fldid] = $row->code;
                                        }
                                        $js='onChange="changeList(this)" class="input-large"';
                                        echo form_dropdown('fromLocationID', $options, $preselcat, $js);
                                    ?>
                                </div>                       
                            </div> 
                            <div class="controls-row">
                                <div class="span4"><?php echo $this->lang->line('toLocation') ?></div>
                                <div class="span8">
                                    <?php
                                        $js='onChange="changeList(this)" class="input-large"';
                                        echo form_dropdown('toLocationID', $options, $preselcat, $js);
                                    ?>
                                </div>                       
                            </div>  
                            <div class="controls-row">
                                <div class="span4"><?php echo $this->lang->line('reference') ?></div>
                                <div class="span8">
                                    <?php
                                    $data = array(
                                        'value'=>$formNo,
                                        'name'=>'formNo',
                                        'id'=>'formNo',
                                        'style'=>'color: red;',
                                        'class'=>'input-small validate[required,minSize[5],maxSize[10]]',); 
                                    echo form_input($data, set_value($formNo));
                                    ?>
                                    <?php
                                    $data = array(
                                        'value'=>"0000",
                                        'name'=>'formNo',
                                        'id'=>'formNo',
                                        'style'=>'',
                                        'disabled'=>'disabled',
                                        'placeholder'=>'0000',
                                        'class'=>'input-small validate[required,minSize[5],maxSize[10]]',); 
                                    echo form_input($data);
                                    ?>
                                </div>                       
                            </div>                            
                        </div> 
                    </div> <!-- Block -->
                </div>
                <div class="span6 scCol">
                    <div class="block" id="grid_block_1">	
                        <div class="content"> 
                            <div class="controls-row">
                                <div class="span4"><?php echo $this->lang->line('movementType') ?></div>
                                <div class="span8">
                                    <?php
                                        $preselcat = '458';
                                        $options = array();
                                        $options[] = '--Please Select--';
                                        foreach($itemCategory as $row){
                                            $options[$row->ID] = $row->name;
                                        }
                                        $js='onChange="changeList(this)" class="input-large"';
                                        echo form_dropdown('movementTypeID', $options, $preselcat, $js);
                                    ?>
                                </div>                       
                            </div> 
                            <div class="controls-row">
                                <div class="span4"><?php echo $this->lang->line('transferDate') ?></div>
                                <div class="input-prepend span8">
                                    <span class="add-on"><i class="i-calendar"></i></span>
                                    <?php
                                        $data = array(
                                        'name' => 'selDateFrom',
                                        'id' => 'selDateFrom',
                                        'type' => 'text',
                                        'class' => 'input-small datepicker2',);
                                        $js='onChange="changeList()"';
                                        echo form_input($data, date('d-m-Y'), $js);                                        
                                    ?>       
                                </div>
                            </div>
                            <div class="controls-row">
                                <div class="span4"><?php echo $this->lang->line('locTransMemo') ?></div>
                                <div class="input-prepend span8">
                                    <?php
                                        $data = array(
                                        'name' => 'memo',
                                        'id' => 'memo',
										'cols' => 18,
										'rows' => 5);
                                        echo form_textarea($data);                                        
                                    ?>       
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
            <!--Location transfer top form-->  
        </div>
        
        <div class="content">
            <div class="wrap">   
                
                <div class="row-fluid">
                    <div class="span12">
                        <div class="block">
                            <div class="head">
                                <h2>
                                    <a href="#popupModal" role="button" class="btn btn-primary" data-toggle="modal">Add Item</a>
                                    <a href="javascript:" role="button" class="btn btn-danger removeItm" data-toggle="modal">Remove Item</a>
                                </h2>
                                <script>
                                    jQuery(document).ready(function(){
                                        jQuery('#popupModal').html(jQuery('#popupItemAdder').html());	
                                    });
                                </script>
                            </div><!-- head -->
                        <div class="content np table-sorting">
                            <table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable itemTbl">
                                <tr>
                                    <th style="display:none"></th>
                                    <th class="tac">Select</th>
                                    <th class="tac">Item Code</th>
                                    <th class="tac">Item Description</th>
                                    <th class="tac">Quantity</th>
                                    <th class="tac">Stock</th>
                                </tr>
                                <?php $bil = 0; 
                                if(isset($locItems)):
                                    foreach($items as $item):
                                    $bil++?>
                                    <tr class="itemList itemList<?php $item->ID; ?>">
                                        <td style="display:none" ><?php echo $item->ID; ?></td>
                                        <td><input type="checkbox" name="itemList" value="<?php echo $item->ID; ?>" /></td>
                                        <td class="tac"><?php echo $item->itemCode; ?></td>
                                        <td><?php echo $item->description; ?></td>
                                        <td class="tac"></td>
                                        <td class="tac"></td>
                                    </tr>
                                    <?php 
                                    endforeach;
                                else:
                                ?>
                                <tr class="itemList noItem">
                                    <td colspan="6">No Content available</td>
                                </tr>	                         
                                <?php
                                endif;?>
                                     
                            </table>
                        </div><!-- content -->
                        <div class="footer">
                            <div class="side fr">
                                <div class="btn-group">
                                    <?php 
                                        $data = array(
                                                'name'=>'postloctrans', 
                                                'class'=>'btn btn-warning');
                                        $js='onclick="postJournal()"';
                                        echo form_submit($data,$this->lang->line('processTransfer'),$js);
                                        ?>
                                </div>
                            </div>
                        </div>                                    
                        </div><!-- block -->
                    </div><!-- span12 -->
                </div><!-- row-fluid -->	
            </div><!-- wrap -->
        </div><!-- content -->
    <?php echo form_close(); ?>
	</div>
</div>

<!-- Bootrstrap modal form -->
<div id="popupItemAdder" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Modal form</h3>
    </div>        
    <div class="row-fluid">
        <div class="block np">
        	<div class="content np">
            	<div class="controls-row">
                    <div class="span3">Select Items:</div>
                    <div class="span9">
                    	<?php
						$i = 0;
                        foreach($items as $item):
						?>
                        <label class="checkbox inline itemCheck"><input type="checkbox" name="items" value="<?php echo $item->ID; ?>" /><?php echo $item->name; ?></label>
                        <?php 
						endforeach;
						?>
                    </div>
                </div> 
            </div>              
        </div>
    </div>                   
    <div class="modal-footer">
        <button class="btn btn-primary addItems" data-dismiss="modal" aria-hidden="true">Add Items</button> 
        <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Close</button>            
    </div>
</div>
<!-- EOF Bootrstrap modal form -->