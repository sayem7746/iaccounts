<script type="text/javascript">
$(document).ready(function() {
   $('select').select2();
}); 
 
function changeList(){
	var addyear = $('#add_year option:selected').val();
	var addper = $('#add_period option:selected').val();
	var acctNo = $('#acctNo option:selected').val();
	var urls = "<?php echo base_url();?>glreports/accountBalanceSummary/"+addyear+"/"+addper+"/"+acctNo;
		window.location = urls;
}

function do_print(){
	var addyear = $('#add_year option:selected').val();
	var addper = $('#add_period option:selected').val();
	var acctNo = $('#acctNo option:selected').val();
	window.open("<?php echo base_url() ?>glreports/accountBalanceSummary_print/"+addyear+"/"+addper+"/"+acctNo);
}

function selectYearPeriod(obj){
		var year = obj.value;
//		alert(year);
			
			$.ajax({
  				type: "POST",
	  			dataType: "json",
				url: "<?php echo base_url()?>glreports/get_TrialBalance_year/"+year,
				data: year,
	  			async: false,
  				success: function(content){
					if(content.status == "success") {
					var items = [];
					//items.push('<option>-Please Select-</option>');
					for ( var i = 0; i < content.message.length; i++) {
					items.push('<option value="'+content.message[i].ID+'">'
						+ content.message[i].period + '</option>');
					}  //end for
					jQuery("#add_period").empty();
					jQuery("#add_period").append(items.join('</br>'));
				} else {
					$("#error").html('<p>'+content.message+'</p>');
				} //end if
			} //end success
				
			}); //end ajax
//	window.location.reload(true); 
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
                <li class="active"><?php echo $this->lang->line('title') ?></li>
            </ul>
		</div><!-- info -->
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
                                        <div class="side fr">
                        <?php 
							$data = array(
									'name'=>'generatereport', 
									'class'=>'btn btn-small btn-primary');
									$js="onClick='changeList()'";
							echo form_button($data,$this->lang->line('generatereport'),$js);
							?>
                                        </div>
                    </div><!-- head -->
				<div class="content np">    
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo form_label($this->lang->line('year'),'add_year');?></div>
						<div class="span4">
						<?php
							$preselyear = $selyear;
							$options = '';
							foreach($yrs as $row){
								$options[$row] = $row;
							}
							$js='onchange="selectYearPeriod(this)"class="span4 input-medium" id="add_year"';

							echo form_dropdown('add_year', $options, $preselyear, $js);
						?>       
                        </div>
                    	<div class="span2 tar"><?php echo form_label($this->lang->line('period'),'add_period');?></div>
						<div class="span4">
						<?php
							$preselperiod = $selper;
							$options = '';
							$options[] = $this->lang->line('period');
							if($period){
								foreach($period as $row){
									$options[$row->period] = $row->period;
								}
							}
							$js='class="span4 input-medium" id="add_period"';

							echo form_dropdown('add_period', $options, $preselperiod, $js);
						?>       
                        </div>
                 	</div><!-- End Row 4-->
                	<div class="controls-row"><!-- Row 4-->
                    	<div class="span2"><?php echo $this->lang->line('acctNo') ?></div>
                   		<div class="span4">
						<?php
							$preselacct = $acctNo;
							$options = '';
							$options[] = $this->lang->line('pleaseselect');
							foreach($chartAccounts as $row){
							$options[$row->ID] = $row->acctCode . " [" . $row->acctName . "]";
							}
							$js='id="acctNo" style="width: 300px;"';
							echo form_dropdown('acctNo', $options, $preselacct , $js);
						?>       
                     	</div> 
                 	</div><!-- End Row 4-->
				</div><!-- content -->
		<div class="row-fluid">
			<div class="span12">
            	<div class="block">
                	<div class="head">
                    	<h2><?php echo $this->lang->line('title') ?></h2>
                    <div class="side fr">
                         <button class="btn btn-link" onClick="do_print()">Print</button>
                    </div>
                    </div><!-- head -->
                     <div class="content accordion">
       				 <?php
						$bil = 0; 
						if($datatbls){
							foreach($datatbls as $datatbl):
							if($datatbl->yeardebit == 0 && $datatbl->yearcredit == 0 && $datatbl->thismonthdr == 0 && $datatbl->thismonthcr == 0 ){
							}else{
 							$bil++?>
                    		<h3>
                            <?php echo substr($datatbl->acctCode,0, 4).'-'.substr($datatbl->acctCode,4, 3).'-'.substr($datatbl->acctCode,7, 2) ?>
                            <?php echo $datatbl->acctName ?>
                            <!--div style="float:right"><?php echo number_format(($datatbl->yeardebit - $datatbl->yearcredit),2);?>
                            </div--></h3><div>
                           <?php 
						   			$openbal = $datatbl->yeardebit - $datatbl->yearcredit;
									if($datatbls1){ ?>
										<?php
										$controlHead = 0; 
										foreach($datatbls1 as $row):
											if($row->acctCode == $datatbl->ID){
												if($controlHead == 0){ ?>
                            	<div class="span2"><strong><u><?php echo $this->lang->line('journalno') ?></u></strong></div>
                            	<div class="span4"><strong><u><?php echo $this->lang->line('description') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('monthdebit') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('monthcredit') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('balance') ?></u></strong></div>
                            	<div class="span2 tar">&nbsp;</div>
                             	<div class="span3"><?php echo $this->lang->line('openbalance') ?></div>
                            	<div class="span2 tar">&nbsp;</div>
                            	<div class="span2 tar">&nbsp;</div>
                            	<div class="span2 tar"><?php echo number_format($openbal,2) ?></div>
												<?php 
												$controlHead = 1;
												} 
												$openbal = $openbal + $row->amount_dr;
												$openbal = $openbal - $row->amount_cr;
												?>
                             	<div class="span2"><a href="<?php echo base_url()?>glreports/journalDetails1/<?php echo $row->journalID ?>" title="<?php echo $this->lang->line('details');?>" class="btn btn-mini btn-link edit"><?php echo $row->journalID ?></a></div>
                            	<div class="span3"><?php echo $row->description ?></div>
                            	<div class="span2 tar"><?php echo number_format($row->amount_dr,2) ?></div>
                            	<div class="span2 tar"><?php echo number_format($row->amount_cr,2) ?></div>
                            	<div class="span2 tar">&nbsp;</div>
                                <br />
                               <?php		}
										endforeach; 
								if($controlHead == 0){ ?>
                            	<div class="span2"><strong><u><?php echo $this->lang->line('journalno') ?></u></strong></div>
                            	<div class="span4"><strong><u><?php echo $this->lang->line('description') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('monthdebit') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('monthcredit') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('balance') ?></u></strong></div>
                            	<div class="span2 tar">&nbsp;</div>
                             	<div class="span3"><?php echo $this->lang->line('closing') ?></div>
                            	<div class="span2 tar">&nbsp;</div>
                            	<div class="span2 tar">&nbsp;</div>
                            	<div class="span2 tar"><?php echo number_format($openbal,2) ?></div>
                                </div>
                                <?php }else{?>
                            	<div class="span2 tar">&nbsp;</div>
                             	<div class="span3"><?php echo $this->lang->line('closing') ?></div>
                            	<div class="span2 tar">&nbsp;</div>
                            	<div class="span2 tar">&nbsp;</div>
                            	<div class="span2 tar"><?php echo number_format($openbal,2) ?></div>
                                </div>
									<?php } 
									}else{ ?> 
                            	<div class="span2"><strong><u><?php echo $this->lang->line('journalno') ?></u></strong></div>
                            	<div class="span4"><strong><u><?php echo $this->lang->line('description') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('monthdebit') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('monthcredit') ?></u></strong></div>
                            	<div class="span2 tac"><strong><u><?php echo $this->lang->line('balance') ?></u></strong></div>
                            	<div class="span2 tar">&nbsp;</div>
                             	<div class="span3"><?php echo $this->lang->line('closing') ?></div>
                            	<div class="span2 tar">&nbsp;</div>
                            	<div class="span2 tar">&nbsp;</div>
                            	<div class="span2 tar"><?php echo number_format($openbal,2) ?></div>
                                </div>
                            <?php }
							}
            			 	endforeach; 
						}
							?>
					</div><!-- content -->
				</div><!-- block -->
			</div><!-- span12 -->
		</div><!-- row-fluid -->	
	</div><!-- wrap -->
</div><!-- content -->
<div class="dialog" id="row_edit" style="display: none;">
    <p><?php echo $this->lang->line('message6');?></p>
</div>  
