<script>
$(document).ready(function(){
	jQuery('.datepicker2').datepicker({
			dateFormat : 'dd-mm-yy',
			changeMonth : true,
			changeYear : true
			});
	jQuery("#supplierCode").keyup(function() {
		jQuery(this).val(jQuery(this).val().toUpperCase());
	});
});
	function changeList(obj){
		var id = obj.value;
		$.ajax({
			type: "POST",
			url: "<?php base_url()?>../setting/getState/",
			data: "region="+id,
			dataType:"json",
			success: function(content){
				if(content.status == "success") {
					var items = [];
					items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].fldid+'">'
						+ content.message[i].fldname + '</option>');
					}
					jQuery("#state").empty();
					jQuery("#state").append(items.join('</br>'));
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				}
			}
		});
		return false;
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
                <li class="active"><?php echo $this->lang->line('titlelist') ?></li>
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
		<div class="span12">
			<?php 
				$hidden = array('order_time' => date('Y-m-d H-i-s'));
				$attrib = array('id'=>'validate'); 
				echo form_open('', $attrib, $hidden);?>
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $title ?></h2>
                        <div class="side fr">
                        <button class="btn" onClick="clear_form('#validate');" type="button"><?php echo $this->lang->line('clear'); ?></button>
                    </div>
				</div>
				<div class="content np"> <!-- Content 1 -->   
                <table border="0" width="100%"><tr><td width="49%">
                <?php
                     echo $companyInfo->companyName;?>
                  <?php
                     echo $companyInfo->companyNo;?> <br/>
                  <?php
                     echo $companyInfo->phoneNo;?> <br/>
                  <?php
                     echo $companyInfo->faxNo;?>
     
                  
                </td><td width="51%">
                  <?php
					 echo $supplierDetails->supplierName;?><br/>
                  <?php
					 echo $supplierDetails->phoneNumber1;?><br/>
                  <?php
					 echo $supplierDetails->fax;?><br/>
                      
               </td></tr><tr><td colspan="2"></td></tr></table>     
                  </div>
                  <div>
                <div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable" border="0">
                	<thead>
                    <tr>
              			<th style="display:none"></th>
            			<th><?php echo form_label($this->lang->line('ID'),'ID');?></th>
            			<th><?php echo form_label($this->lang->line('transDate'),'transDate');?></th>
                        <th><?php echo form_label($this->lang->line('refNo'),'refNo');?></th>
                        <th><?php echo form_label($this->lang->line('formNo'),'formNo');?></th>   
                        <th><?php echo form_label($this->lang->line('description'),'description');?></th>
                		<th><?php echo form_label($this->lang->line('debit'),'debit');?></th>    
                        <th><?php echo form_label($this->lang->line('credit'),'credit');?></th>   
                        <th><?php echo form_label($this->lang->line('balance'),'balance');?></th>   
            		</tr>
        			</thead>
       				 <tbody>
                     <?php
					 $balance = 0 ; //need to get balance b/f
					   // var_dump($supplierStatement);
						foreach($supplierStatement as $row){
							  echo '<tr><td>'.$row->ID;
					  ?>	
                     </td>  
                     <?php
                     echo '<td>'.$row->transDate.'</td>';?>
                     
                     <?php
                     echo '<td>'.$row->refNo.'</td>';?>
                     
                     <?php
                     echo '<td>'.$row->formNo.'</td>';?>
                     
                     <?php
                     echo '<td>description lah</td>';
                    
					$balance += $row->dr;
					$balance -= $row->cr;
                     echo '<td>'.number_format($row->dr,2,'.',',').'</td>'; //dr
					 echo '<td>'.number_format($row->cr,2,'.',',').'</td>'; //cr
					 echo '<td>'.number_format($balance,2,'.',',').'</td>'; //balance
	
                      } ?> 
                    
                     </div><div> 
                     <tr>
                     <td colspan="8" class="tar"><h8><?php echo $this->lang->line('total').' '.number_format ($balance,2,'.',','); echo num_to_word($balance,$dictionary)." only"; ?></h8></td>
                     </tbody>
			</table>                           
			</div>
                  </div>
                </div>
        </div>             
	  </div>

    </div>
              <table border="1" width="100%">
                <tr>
                  <td width="17%"><?php echo $this->lang->line('current'); ?></td>
                  <td width="17%"><?php echo $this->lang->line('OneMonth'); ?></td>
                  <td width="17%"><?php echo $this->lang->line('TwoMonth'); ?></td>
                  <td width="17%"><?php echo $this->lang->line('ThreeMonth'); ?></td>
                  <td width="18%"><?php echo $this->lang->line('FourthMonth'); ?></td>
                  <td width="14%"><?php echo $this->lang->line('FifthMonth'); ?></td>
                </tr>
                   </tr>
                <tr> 
                  <td>2,000.00</td>
                  <td>2,200.00</td>
                  <td>0.00</td>
                  <td>0.00</td>
                  <td>0.00</td>
                  <td>0.00</td>
                </tr>
              </table>
          
</div>
</div>
</div>                                   
</div>
	</form>
</div>
</div>                        
</div>
</div>

