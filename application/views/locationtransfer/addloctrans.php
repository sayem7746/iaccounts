<script>

$(document).ready(function(){
	//$('select').select2();
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	
	//Validate form data
	$('.submit').click(function(){
		if($("#loctransfer").validationEngine('validate')){
			return true;
		}else{
			return false;
		}
	});
	
	
	// function to add new item to the list
	$('#addRow').click(function(){
		if (!$("#itemcode").length) {
			 $('<tr>'+
				'<td class="span2" ><input type="text" id="itemCode" name="itemcode" onkeyup="getitem(this);" onchange="getitem(this);" data-source="<?php echo $itemCodes; ?>" data-items="4" data-provide="typeahead" class="span12"></td>'
				+'<td class="span2"><input id="description" name="description"  type="text" class="span12 validate[required,maxSize[64]]" placeholder="Item Description"></td>'
				+'<td class="span2"><input id="quantity" name="quantity" class="span12 validate[required]" type="text" placeholder="Quantity"></td>'
				+'<td class="span1"><input id="stock" name="stock" class="span12 validate[required,custom[number]]" type="text" placeholder="Stock"></td>'
				+'<td class="span1">'
					+'<button class="btn btn-mini btn-primary saveItm" type="button">Save</button>'
					+'<button id="btnCancel" class="btn btn-mini" type="button">Cancel</button>'
				+'</td>'
			+'</tr>'
			  ).insertBefore( "#trInfos" );
		}else{
			msg (1,"alert","Please, do save the current details before addind new one");
		}
	});
	
	
	//Item save
	$('.saveItm').live('click',function(){
		var me = $(this).parents('tr');
		if($("#loctransfer").validationEngine('validate')){
			jQuery.ajax({
				url: "<?php echo base_url(); ?>locationtransfer/ajax_save_item/",
				async: false,
				type: "POST",
				data: 	{
							itemCode:$(me).find('#itemCode').val(),
							description:$(me).find('#description').val(),
							quantity:$(me).find('#quantity').val(),
							stock:$(me).find('#stock').val(),
						},
				dataType: "html",
				success: function(data) {
					console.log(data);
				}
			});
		}
		return false;	
	});
	
});
//Alert messages
function msg(n,type, message){
	$("#msg_div"+n +" p").html(message);
	$("#msg_div"+n).attr("class","alert " + type);
}

//Ajax item list gathering 
function getitem(me){
	var str = $(me).val();
	if(str.match(/-/g)){
		// Ajax call to get item details
		jQuery.ajax({
			url: "<?php echo base_url(); ?>locationtransfer/ajax_get_items/",
			async: false,
			type: "POST",
			data: "itemCode="+$(me).val(),
			dataType: "html",
			success: function(data) {
				var obj = jQuery.parseJSON(data);
				//jQuery('.itemTbl .noItem,.itemTbl .itemList').remove();
				if(obj[0].ID){
					$('#itemCode').val(obj[0].itemCode);
					$('#description').val(obj[0].description);
					msg (1,"alert","Please, do save the current details before addind new one");
				}
			}
		});
	}
}
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
                                <div class="span4"><?php echo $this->lang->line('fromLocation') ?>*</div>
                                <div class="span8">
                                    <?php
                                        $preselcat = '458';
                                        foreach($fromLocation as $row){
                                            $options[$row->fldid] = $row->code;
                                        }
                                        $js=' class="validate[required] input-large"';
                                        echo form_dropdown('fromLocationID', $options, $preselcat, $js);
                                    ?>
                                </div>                       
                            </div> 
                            <div class="controls-row">
                                <div class="span4"><?php echo $this->lang->line('toLocation') ?>*</div>
                                <div class="span8">
                                    <?php
                                        $js='class="validate[required] input-large"';
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
                                        'class'=>'input-small',); 
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
                                        'class'=>'input-small validate[required]',); 
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
                                <div class="span4"><?php echo $this->lang->line('movementType') ?>*</div>
                                <div class="span8">
                                    <?php 
                                        $preselcat = '458';
                                        $options = array();
                                        foreach($itemCategory as $row){
                                            $options[$row->ID] = $row->name;
                                        }
                                        $js='class="validate[required] input-large"';
                                        echo form_dropdown('movementTypeID', $options,$preselcat,$js);
                                    
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
                                        'class' => 'validate[required] input-small datepicker2',);
                                        $js='';
                                        echo form_input($data, date('d-m-Y'), $js);                                        
                                    ?>       
                                </div>
                            </div>
                            <div class="controls-row">
                                <div class="span4"><?php echo $this->lang->line('locTransMemo') ?>*</div>
                                <div class="input-prepend span8">
                                    <?php
                                        $data = array(
                                        'name' 	=> 'memo',
                                        'id' 	=> 'memo',
										'cols' 	=> 18,
										'rows' 	=> 5,
										'class'	=> 'validate[required]'	
										);
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
        
        <div class="row-fluid scRow">                            
          <div class="span12 scCol">
            <div class="block" id="grid_block_4">
               <div class="head">
                <h2><?php echo $this->lang->line('items')?></h2>
                <ul class="buttons">
                    <li><a class="block_toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                <span class="i-arrow-down-3"></span></a></li>
                </ul>                                        
              </div><!-- head -->
              <div class="content np">
                      <table id="listDetails" cellpadding="0" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="display:none"></th>
                                    <th class="tac"><?php echo $this->lang->line('itemCode')?></th>
                                    <th class="tac"><?php echo $this->lang->line('itemDescription')?></th>
                                    <th class="tac"><?php echo $this->lang->line('quantity')?></th>
                                    <th class="tac"><?php echo $this->lang->line('stock')?></th>
                                	<th class="tac"><?php echo $this->lang->line('action')?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="trInfos">
                                    <td colspan="11">
                                        <div id="msg_div1" class="alert alert-info">
                                          <h4><?php echo $this->lang->line('lastMessage')?></h4>
                                          <p style="padding-top:10px;"><?php echo $this->lang->line('noMessage')?></p>
                                      </div>
                                  </td>
                              </tr>
                        </tbody>
                      </table>
                <div class="footer">
                    <div class="side fr">
                        <div class="btn-group">
                        <button style="margin-right:6px;" onclick="$('#parchaseDetailForm').validationEngine('hide');" class="btn btn-mini" type="button" name="validat">Hide prompts</button>
                        <button id="addRow" class="btn btn-mini btn-primary" type="button">
                            <i class="icon-plus-sign"></i><?php echo $this->lang->line('addNewItem')?></button>
                        </div><!-- btn group -->      
                    </div><!-- side fr -->      
                </div><!-- footer -->      
              </div><!-- content -->
            </div><!-- grid block 1-->
          </div><!-- scCol -->
        </div><!-- row-fluid scRow-->
        
        <div class="content">
            <div class="wrap">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="block">
                            <div class="footer">
                                <div class="side fr">
                                    <div class="btn-group">
                                        <?php 
                                            $data = array(
                                                    'name'=>'postloctrans', 
                                                    'class'=>'btn btn-warning submit');
                                            echo form_submit($data,$this->lang->line('processTransfer'));
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