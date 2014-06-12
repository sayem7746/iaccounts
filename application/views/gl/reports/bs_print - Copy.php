<div id="content">                        
<div class="wrap">
<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
 	$("#level2").hide();
}); 

function do_print(){
	window.open("<?php echo base_url() ?>" + 'assetreport/depr_summary_print/' + "j");
}
function closeopen(){
	$("#level2").hide();
}
</script>
<div class="head print">
	<div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'><?php echo $this->lang->line('dashboard') ?></a> <span class="divider">-</span></li>
                <li><a href='<?php echo base_url()."gl/home" ?>'> <?php echo $this->lang->line('module') ?></a> <span class="divider">-</span></li>
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
                	<h2><?php echo $this->lang->line('title1') . ' ' . date("d-M-Y") ?> </h2>
                    <div class="side fr">
                         <button class="btn btn-link" onClick="do_print()">Print</button>
                    </div>
                </div>
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
    			      	<th colspan="3"><?php echo $this->lang->line('description') ?></th>
    			      	<th class="tac" width="10%"><?php echo $this->lang->line('thisyear') ?></th>
    			      	<th class="tac" width="10%"><?php echo $this->lang->line('lastyear') ?></th>
            		</tr>
        			</thead>
       				 <tbody><?php
						$bil = 0; 
						if($accountGroup){
							foreach($accountGroup as $group):
 							$bil++?>
                           <tr>
                            	<td colspan="5"><strong><?php echo $group->acctGroupName ?></strong></td>
                            </tr>
                            <?php foreach($groupdetails as $details){
								if($details->parentID == $group->ID){ ?>
                            	<tr id="group"><td width="10">&nbsp;</td><td colspan="4">
                                	<a href="#level2" onclick="closeopen()">
                                    	<strong><?php echo $details->acctGroupName ?></strong>
                                        </a></td></tr>
                             	<?php foreach($groupdetails as $details2){ ?>
									<?php if($details2->parentID == $details->ID){ ?>
                            		<tr><td width="10">&nbsp;</td><td colspan="4"><strong><?php echo $details2->acctGroupName ?></strong></td></tr>
								<?php 	} 
								}?>
                               <!--call funtion utk loop-->
                                <?php 
                            		if($accountdetails){ 
									foreach($accountdetails as $acctdetails){ 
                                    	if($acctdetails->acctGroupID == $details->ID){ ?>
                            			<tr id="level2">
                                        <td>&nbsp;</td>
                                        <td width="10">&nbsp;</td>
                                        <td colspan="1"><?php echo $acctdetails->acctCode ?>[<?php echo $acctdetails->description ?>]</td>
                                        <td class="tar"><?php echo number_format($acctdetails->amount_cr + $acctdetails->amount_dr,2,".",",") ?></td>
                                        <td class="tar"><?php echo number_format($acctdetails->amount_cr + $acctdetails->amount_dr,2,".",",") ?></td>
                                        </tr>
									<?php }
									}?>
                            	<tr><td width="10">&nbsp;</td><td colspan="4"><strong><?php echo $details->acctGroupName ?>&nbsp;&nbsp;<?php echo $this->lang->line('subtotal') ?></strong></td></tr>
								<?php }
								}
								?>
                            	
                            <?php }?>
                                <?php 
                            		if($accountdetails){ 
                            		foreach($accountdetails as $acctdetails){ 
                                    	if($acctdetails->acctGroupID == $group->ID){ ?>
                            			<tr><td>&nbsp;</td><td colspan="4"><?php echo $acctdetails->acctCode ?>[<?php echo $acctdetails->description ?>]</td></tr>
									<?php }
									}?>
                            	<tr><td colspan="5"><strong><?php echo $group->acctGroupName ?>&nbsp;&nbsp;<?php echo $this->lang->line('total') ?></strong></td></tr>					
                                <?php if($group->ID == 30){ ?>
                            	<tr><td colspan="5"><strong>Assets & Liabilities &nbsp;&nbsp;<?php echo $this->lang->line('total') ?></strong></td></tr><tr><td colspan="5">&nbsp;</td></tr>

                                <?php }
									}
            			 endforeach; } ?>
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
<div class="dialog" id="asset_details" style="display: none;" title="Asset Details Page ...">
    <p>Click Ok to continue .....</p>
</div>   
