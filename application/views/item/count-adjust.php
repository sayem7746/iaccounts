<?php //print_r($supplier); exit(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		
		//Data table configurations
	   	var oTable = $("#test").dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [5,10,25,50,100],
			"sPaginationType": "full_numbers",
			"aoColumns": [	null,
							null,
							null,
							null,
							null,
							null,
							null,
							null,
							null
						] 
		});
		oTable.fnSort( [ [1,'asc'] ] );
		//Data table configurations end
		
		var changeRow = new Array();
		/*Table editing start*/
		$("table.editable td").dblclick(function () {        
        
			var eContent = $(this).text();
			var eCell = $(this);
				
			if(eContent.indexOf('<') >= 0 || eCell.parents('table').hasClass('oc_disable')) return false;        
			
			if(eCell.hasClass('no-edit')){return false;}	
			eCell.addClass("editing");        
			eCell.html('<input type="text" value="' + eContent + '"/>');
			
			var eInput = eCell.find("input");
			eInput.focus();
	 
			eInput.keypress(function(e){
				if (e.which == 13) {
					var newContent = $(this).val();
					changeRow[eCell.parents('tr').find('#ID').text()] = newContent;
					calVariance(eCell.parents('tr'),newContent);
					eCell.html(newContent).removeClass("editing").animate({backgroundColor:'#f89406',color:'#fff'});
					// Here your ajax actions after pressed Enter button
				}
			});
	 		
			eInput.focusout(function(){
				var newContent = $(this).val();
				changeRow[eCell.parents('tr').find('#ID').text()] = newContent;
				calVariance(eCell.parents('tr'),newContent);
				eCell.text($(this).val()).removeClass("editing").animate({backgroundColor:'#f89406',color:'#fff'});            
				// Here your ajax action after focus out from input
			});
		});
		
		/*Table editing end*/
		$('.adjust').live('click',function(){
			var newArr = new Array();
			var i = 0;
			changeRow.forEach(function(val,key){
				newArr[i] = new Array(2);
				newArr[i][0] = key;
				newArr[i][1] = val;
				i++;
			});
			
			var data = JSON.stringify(newArr);
			$.ajax({
				url: "<?php echo base_url(); ?>itemcountadjust/adjust/",
				async: false,
				type: "POST",
				data: 'data='+data,
				dataType: "html",
				success: function(data) {
					location.reload();
				}
			});
		});
	});
	
	function  calVariance(obj,nCont){
		var qty = parseInt(obj.find('#quantity').text());
		var perItemPrice = parseFloat(obj.find('#costQty').text().replace(',',''))/qty;
		var countPrice = perItemPrice*nCont;
		var costVariance = (qty*perItemPrice)-countPrice;
		var itemId = obj.find('#ID').text();
		
		//Changeing HTML DOM values
		obj.find('#variance').text(qty - nCont).animate({backgroundColor:'#f89406',color:'#fff'});
		obj.find('#varCost').text(parseFloat(countPrice, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")).animate({backgroundColor:'#f89406',color:'#fff'});
		obj.find('#costVar').text(parseFloat(costVariance, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()).animate({backgroundColor:'#f89406',color:'#fff'});
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
        
        <!--Main content start here-->
        <div class="content">
            <div class="wrap">                    
                <div class="row-fluid">
                    <div class="span12">
                        <div class="block">
                            <div class="head">
                                <h2><?php echo $this->lang->line('titlelist'); ?></h2>
                                <div class="side fr">
                                    <div class="btn-group">
                                        <a href="javascript:" class="btn btn-primary adjust" title="Add Location Transfer">Adjust</a>                                               
                                    </div>
                                </div>
                                <!--<ul class="buttons">
                                    <li><a href="" class="" title="New"><span class="i-plus-2"></span></a></li>
                                </ul>-->                                        
                            </div>
                            <div class="content np table-sorting">
                                <table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                                    <thead>
                                    <tr>
                                        <th style="display:none"><?php echo $this->lang->line('itemId') ?></th>
                                        <th><?php echo $this->lang->line('itemCode') ?></th>
                                        <th><?php echo $this->lang->line('itemName') ?></th>
                                        <th><?php echo $this->lang->line('quantityOnHand') ?></th>
                                        <th><?php echo $this->lang->line('costQtyOnHand') ?></th>
                                        <th><?php echo $this->lang->line('counted') ?></th>
                                        <th><?php echo $this->lang->line('variance') ?></th>
                                        <th><?php echo $this->lang->line('cost') ?></th>
                                        <th><?php echo $this->lang->line('costVariance') ?></th>
                                    </tr>
                                    </thead>
                                     <tbody>
										<?php $bil = 0; 
                                        if(isset($datatbls)):
                                        foreach($datatbls as $datatbl):
                                        $bil++?>
                                        <tr>
                                            <td id="ID" style="display:none"><?php echo $datatbl->ID; ?></td>                                                                      
                                            <td id="itemCode" class="no-edit"><?php echo $datatbl->itemCode; ?></td>
                                            <td id="name" class="no-edit"><?php echo $datatbl->name; ?></td>
                                            <td id="quantity" class="no-edit" style="text-align:right"><?php echo $datatbl->quantity; ?></td>
                                            <td id="costQty" class="no-edit" style="text-align:right"><?php echo number_format($datatbl->costQty,2,'.',','); ?></td>
                                            <td id="counted" style="text-align:right"><?php echo $datatbl->quantity; ?></td>
                                            <td id="variance" class="no-edit" style="text-align:right">0.0</td>
                                            <td id="varCost" class="no-edit" style="text-align:right"><?php echo number_format($datatbl->costQty,2,'.',','); ?></td>
                                            <td id="costVar" class="no-edit" style="text-align:right">0.0</td>
                                        </tr>
                                        <?php endforeach; 
                                        endif;?>
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

