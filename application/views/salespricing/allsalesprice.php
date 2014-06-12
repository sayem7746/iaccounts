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
							{"bSortable": false},
							{"bSortable": false},
						] 
		});
		oTable.fnSort( [ [1,'asc'] ] );
		//Data table configurations end		
		
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
			deletePrice(str);
		});	
	});
	
	//Editing price
	function getData(id){
		$.ajax({
			url: "<?php echo base_url(); ?>salespricing/get/",
			async: false,
			type: "POST",
			data: 'ID='+id,
			dataType: "html",
			success: function(data) {
				var obj = jQuery.parseJSON(data);
				$('#itemPrice').val(obj.price);
				$('#itemID').val(obj.ID);
				$('#currencyID').val(obj.currencyID);
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
			url: "<?php echo base_url(); ?>salespricing/add/",
			async: false,
			type: "POST",
			data: data,
			dataType: "html",
			success: function(data) {
				if(data == 'Success'){
					location.reload();
				}
			}
		});
	}
	
	//Deleteing item price
	function deletePrice(str){
		var data = str; 
		$.ajax({
			url: "<?php echo base_url(); ?>salespricing/delete/",
			async: false,
			type: "POST",
			data: 'data='+data,
			dataType: "html",
			success: function(data) {
				if(data == 'Successfully Deleted'){
					alert(data);
					//location.reload();
				}
			}
		});
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
        <?php 	$message = $this->session->flashdata('msg');
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
		<?php endif; ?>
        <!--Alert Message end-->
        
        <!--Sales Pricing top form start-->
        <div class="content">      
            <div class="span6">
                <div class="block">
                    <div class="head">
                        <h2><?php echo $this->lang->line('item-price') ?></h2>
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
                                        $options[$row->ID] = $row->name.'('.$row->itemCode.')';
                                    }
                                    $js='class="input-medium" id="itemID"';
                                    echo form_dropdown('itemID', $options, $preselcat, $js);
                                ?>
                            </div>                       
                        </div> 
                        <div class="controls-row">
                            <div class="span4"><?php echo $this->lang->line('currency') ?></div>
                            <div class="span8">
                                <?php
                                    $preselcat = '';
									unset($options);
                                    $options[] = '--Please Select--';
                                    foreach($currency as $row){
                                        $options[$row->ID] = $row->currencyWord.'('.$row->currencyCode.')';
                                    }
                                    $js='class="input-medium" id="currencyID"';
                                    echo form_dropdown('currencyID', $options, $preselcat, $js);
                                ?>
                            </div>                       
                        </div>
                        <div class="controls-row">
                            <div class="span4"><?php echo $this->lang->line('price') ?></div>
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
                                    <button class="btn btn-danger delPrice">Delete</button>
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
                                        <th><?php echo $this->lang->line('currency') ?></th>
                                        <th><?php echo $this->lang->line('price') ?></th>
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
                                                                  
                                            <td><?php echo $datatbl->name."(".$datatbl->name.")"; ?></td>
                                            <td><?php echo $datatbl->currencyWord?$datatbl->currencyWord.'('.$datatbl->currencyCode.')':'---'; ?></td>
                                            <td><?php echo $datatbl->price; ?></td>
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

