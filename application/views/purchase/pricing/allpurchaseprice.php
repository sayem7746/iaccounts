<?php //print_r($supplier); exit(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		
		//Data table configurations
	   	var oTable = $("#test").dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [5,10,25,50,100],
			"sPaginationType": "full_numbers",
			"aoColumns": [{"bSortable": false},
							null,
							null,
							null,
							null,
							{"bSortable": false},
							{"bSortable": false},
						] 
		});
		oTable.fnSort( [ [1,'asc'] ] );
		//Data table configurations end	
		
		//Set purchse price for individual items
		$('#salespricing').submit(function () {
			addPrice();
			return false;
		});
		
		//Edit Item price
		$('.editPrice').click(function(){
			getData($(this).parents( "tr" ).find( ".itemIDs" ).text());
		});
		
		//Deleteing item price
		$('.delPrice').click(function(){
			var str = '';
			var i = 0;
			$('.itemPriceList').each(function(){
				if($(this).is(':checked')){
					if(!i)	str += $(this).val();
					else	str += ','+$(this).val();
					i++;
				}	
			});
			if(str != '' ){
				deletePrice(str);	
			}else{
				alert('Select item first');
			}
			
		});	
		
		//Presetup variables
		preSetup();
		
		//Onchange unit change
		$('.itemList').change(function(){
			$('.unit').val(unitOfMea[$(this).val()]);
		});
		
		//Onchange Supplier code change
		$('.suppSlct').change(function(){
			$('.suppCode').val(supCode[$(this).val()]);	
			$('.suppCur').text('( '+suppCurrency[$(this).val()]+' )');			
		});
	});
	
	//Editing price
	function getData(id){
		$.ajax({
			url: "<?php echo base_url(); ?>purchasepricing/get/",
			async: false,
			type: "POST",
			data: 'ID='+id,
			dataType: "html",
			success: function(data) {
				var obj = jQuery.parseJSON(data);
				$('#itemID').val(obj.itemID);
				$('.unit').val(unitOfMea[obj.itemID]);
				$('#supplierID').val(obj.supplierID);
				$('.suppCode').val(supCode[obj.supplierID]);	
				$('.suppCur').text('( '+suppCurrency[obj.supplierID]+' )');
				$('#itemPrice').val(obj.price);
				if(data == 'Successfully updated sales price'){
					//alert(data);
					//location.reload();
				}
			}
		});	
	}
	
	//Adding price for item	
	function addPrice(){
		//getting from data
		var data = $('#salespricing').serialize();	
		
		//Sending from data to save
		
		$.ajax({
			url: "<?php echo base_url(); ?>purchasepricing/add/",
			async: false,
			type: "POST",
			data: data,
			dataType: "html",
			success: function(data) {
				if(data == 'Updated'){
					location.reload();
				}
			}
		});
	}
	
	//Deleteing item price
	function deletePrice(str){
		var data = str; 
		$.ajax({
			url: "<?php echo base_url(); ?>purchasepricing/delete/",
			async: false,
			type: "POST",
			data: 'data='+data,
			dataType: "html",
			success: function(data) {
				if(data == 'Successfully Deleted'){
					location.reload();
				}
			}
		});
	}
	
	var unitOfMea = [];
	var supCode = [];
	var suppCurrency = [];
	
	function preSetup(){
		//item unit of measurement preSetup
		<?php foreach($item as $v): ?>
		unitOfMea[<?php echo $v->ID; ?>] = String('<?php echo $v->Unit; ?>');
		<?php endforeach; ?>
		
		//Supplier code preSetup
		<?php foreach($supplier as $v): ?>
		supCode[<?php echo $v->ID; ?>] = String('<?php echo $v->supplierCode; ?>');
		<?php endforeach; ?>
		
		//Supplier currency preSetup
		<?php foreach($supplier as $v): ?>
		suppCurrency[<?php echo $v->ID; ?>] = String('<?php echo $v->currencyCode; ?>');
		<?php endforeach; ?>
	}
</script>

<div id="content">                        
    <div class="wrap">
    	<!--Header start here-->
		<div class="head">
            <div class="info">
                <h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
                    <?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
                <ul class="breadcrumb">
                    <li><a href="#"><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                    <li><a href="#"><?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
                    <li class="active"><?php echo $this->lang->line('titlelist') ?></li>
                </ul>
            </div>
            <div class="search">
                <form action="<?php echo base_url() ?>admin/search" method="post">
                    <input name="search_text" type="text" placeholder="search..."/>                                
                    <button type="submit"><span class="i-magnifier"></span></button>
                </form>
            </div>                        
        </div>
        <!--Header end here-->
        
        <!--Alert Message start-->
        <?php 	
			$message = $this->session->flashdata('msg');
			$alert = $this->session->flashdata('danger-msg');
			if(isset($message) && $message != ''): ?>
            <div class="content alertbox">                                                
                <div class="row-fluid">
                    <div class="span12">        
                        <div class="alert alert-success">            
                            <strong>Success! </strong><?php echo $message;?>
                        </div>       
                    </div>
                </div>
            </div>
        <?php	
			elseif(isset($alert) && $alert != ''): ?>
            <div class="content alertbox">                                                
                <div class="row-fluid">
                    <div class="span12">        
                        <div class="alert alert-error">            
                            <strong>Deleted! </strong><?php echo $alert;?>
                        </div>       
                    </div>
                </div>
            </div>
		<?php endif; ?>
        <!--Alert Message end-->
        
        <!--Sales Pricing top form start-->
        <div class="content">      
            <div class="span6">
                <div class="block">
                	
                    <div class="head">
                        <h2><?php echo $this->lang->line('item_purchase_price') ?></h2>
                    </div>
                    
                    <?php echo form_open('salespricing/add',array("id"=>"salespricing")); ?>
                    <div class="content row-fluid scRow">                	
                        <div class="controls-row">
                            <div class="span4"><?php echo $this->lang->line('item') ?></div>
                            <div class="span8">
                                <?php
                                    $preselcat = '';
                                    $options[] = '--Please Select--';
                                    foreach($item as $row){
                                        $options[$row->ID] = $row->itemName.'('.$row->itemCode.')';
                                    }
                                    $js='class="input-medium itemList" id="itemID"';
                                    echo form_dropdown('itemID', $options, $preselcat, $js);
                                ?>
                            </div>                       
                        </div> 
                        <div class="controls-row">
                            <div class="span4"><?php echo $this->lang->line('supplier') ?></div>
                            <div class="span8">
                                <?php
                                    $preselcat = '';
									unset($options);
                                    $options[] = '--Please Select--';
                                    foreach($supplier as $row){
                                        $options[$row->ID] = $row->supplierName;
                                    }
                                    $js='class="suppSlct input-medium" id="supplierID"';
                                    echo form_dropdown('supplierID', $options, $preselcat, $js);
                                ?>
                            </div>                       
                        </div>
                        <div class="controls-row">
                            <div class="span4"><?php echo $this->lang->line('unit_of_measure') ?></div>
                            <div class="span4">
                                <?php
                                    $data = array(
                                        'value'=>"",
                                        'name'=>'unitOfMesure',
                                        'id'=>'unitOfMesure',
                                        'style'=>'',
                                        'type'=>'text',
                                        'placeholder'=>'Unit of measurement',
                                        'class'=>'unit input-medium validate[required,minSize[5],maxSize[10]]',); 
                                    echo form_input($data);
                                ?>
                            </div>                       
                        </div>  
                        <div class="controls-row">
                            <div class="span4"><?php echo $this->lang->line('suppliers_code') ?></div>
                            <div class="span8">
                                <?php
                                    $data = array(
                                        'value'=>"",
                                        'name'=>'supplierCode',
                                        'id'=>'supplierCode',
                                        'style'=>'',
                                        'type'=>'text',
                                        'placeholder'=>"Supplier's Code",
                                        'class'=>'suppCode input-medium validate[required,minSize[5],maxSize[10]]',); 
                                    echo form_input($data);
                                ?>
                            </div>                       
                        </div>
                        <div class="controls-row">
                            <div class="span4"><?php echo $this->lang->line('price').' ' ?><span class="suppCur">( <?php echo $this->lang->line('supplier_currency'); ?> )</span></div>
                            <div class="span8">
                                <?php
                                    $data = array(
                                        'value'=>"",
                                        'name'=>'itemPrice',
                                        'id'=>'itemPrice',
                                        'style'=>'',
                                        'type'=>'text',
                                        'placeholder'=>'Price',
                                        'class'=>'input-small validate[required,minSize[5],maxSize[10]]',); 
                                    echo form_input($data);
                                ?>
                            </div>                       
                        </div>                  
                    </div>
                    <div class="footer">
                        <div class="side fr">
                            <div class="btn-group">
                                <?php 
                                    $data = array(
												'name'=>'addprice', 
												'class'=>'btn btn-warning',
												'id'=>'adItmPrice'
											);
                                    echo form_submit($data,$this->lang->line('addPrice'));
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
        <!--Sales Pricing top form end-->
        
        <!--Main content start here-->
        <div class="content">
            <div class="wrap">                    
                <div class="row-fluid">
                    <div class="span12">
                        <div class="block">
                            <div class="head">
                                <h2><?php echo $this->lang->line('titlelist') ?></h2>
                                <div class="side fr">
                                	<a class="btn btn-danger delPrice">Delete</a>
                                </div>
                                <!--<ul class="buttons">
                                    <li><a href="" class="" title="New"><span class="i-plus-2"></span></a></li>
                                </ul>-->                                        
                            </div>
                            <div class="content np table-sorting">
                                <table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                                    <thead>
                                    <tr>
                                        <th style="display:none"></th>
                                        <th><?php echo $this->lang->line('item') ?></th>
                                        <th><?php echo $this->lang->line('supplier') ?></th>
                                        <th><?php echo $this->lang->line('supplier_unit_of_measurement') ?></th>
                                        <th><?php echo $this->lang->line('item_purchase_price') ?></th>
                                        <th><?php echo $this->lang->line('edit') ?></th>
                                        <th><?php echo $this->lang->line('select') ?></th>
                                    </tr>
                                    </thead>
                                     <tbody>
                                <?php $bil = 0; 
                                    if(isset($datatbls)):
                                    foreach($datatbls as $datatbl):
                                    $bil++?>
                                    <tr>
                                        <td style="display:none" class="itemIDs" ><?php echo $datatbl->ID; ?></td>
                                                              
                                        <td><?php echo $datatbl->name; ?></td>
                                        <td><?php echo $datatbl->supplierName; ?></td>
                                        <td><?php echo $datatbl->UOM; ?></td>
                                        <td><?php echo $datatbl->supplierPrice; ?></td>
                                        
                                        <td class="tac">
                                            <div class="btn-toolbar">
                                                <div class="btn-group">
                                                    <a href="javascript:" class="editPrice btn btn-mini btn-primary"><i class="icon-pencil"></i></a>
                                                </div>
                                            </div>
                                        </td> 
                                        <td align="center"><input class="itemPriceList" value="<?php echo $datatbl->ID; ?>" name="itemPriceList" type="checkbox" /></td>
                                    </tr>
                                <?php endforeach; 
                                else:						
                                ?>
                                    <tr>
                                        <td colspan="6"><?php echo $this->lang->line('no_entry_found'); ?></td>	
                                    </tr>
                                <?php endif;?>
                                        </tbody>
                                </table>                                         
                        	</div>
                            <div class="footer">
                                <div class="side fr">
                                    <div class="btn-group">
                                        &nbsp;
                                    </div>
                                </div>
                            </div> 
                        </div>                                
                    </div>
                </div>                                
            </div>
        </div>
        
	</div>
</div>
<div class="dialog" id="row_delete" style="display: none;" title="Are you sure to Delete?">
    <p><?php echo $this->lang->line('message1') ?></p>
</div>   
<div class="dialog" id="row_edit" style="display: none;" title="Are you sure to Edit ?">
    <p><?php echo $this->lang->line('message2') ?></p>
</div>

