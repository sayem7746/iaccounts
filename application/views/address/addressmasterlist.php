<script type="text/javascript">
$(document).ready(function() {
    /* Build the DataTable with third column using our custom sort functions */
   $('select').select2();
   var oTable = $("#test").dataTable( {
        "iDisplayLength": 10,
		 "aLengthMenu": [5,10,25,50,100],
		 "sPaginationType": "full_numbers", "aoColumns": [ { 
		 	"bSortable": false }, 
			null, 
			null, 
			null, 
			null,
			null,
			null,
			null, { 
			"bSortable": false } ]});
     oTable.fnSort( [ [1,'asc'] ] );
}); 
 
function changeList(obj){
	var id = obj.value;
	var urls = "<?php echo base_url();?>Address/addressmasterlist/"+id;
		window.location = urls;
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
                    	<h2>Supplier Address Maintenance</h2>
                    </div><!-- head -->
				<div class="content np">    
                	<div class="controls-row">
                        <div class="span2"><?php echo form_label('addressCategory:','addressCategory');?></div>
                   		<div class="span4">
						<?php
							$preselcat = $addressCategory;
							$options[1] = 'company';
							$options[2] = 'customer';
							$options[3] = 'supplier';
							$js='onChange="changeList(this)" class="input-medium"';
							echo form_dropdown($this->lang->line('addressCategory'), $options, $preselcat, $js);
						?>       
                     </div>  <!-- span4 -->              
                  </div><!-- control row -->
				</div><!-- content -->
				</div><!-- block -->
			</div><!-- span12 -->
		</div><!-- row-fluid -->	
		<div class="row-fluid">
			<div class="span12">
            	<div class="block">
                	<div class="head">
                    	<h2>Supplier Address Maintenance</h2>
                    </div><!-- head -->
            	<div class="content np table-sorting">
            	<table cellpadding="0" cellspacing="0" width="100%" id="test" class="editable">
                	<thead>
                    <tr>
            			<th style="display:none"></th>
            			<th>ID</th>
                        <th>customer/supplier/company</th>
                        <th>Address Name</th>   
                        <th>City</th>                         
                		<th>Post Code</th>    
                        <th>State</th> 
                        <th>Country</th>
                      	<th>Action</th>
            		</tr>
        			</thead>
       				 <tbody>
			<?php $bil = 0; 
				if($datatbls){
				foreach($datatbls as $datatbl):
				$bil++?>
            	<tr>
                	<td style="display:none" ><?php echo $datatbl->ID; ?></td>
                	<td><?php echo $bil; ?></td>
                    <td><?php echo $datatbl->name ?><br><?php echo $datatbl->addressName; ?></td>
                	<td><?php echo $datatbl->line1?><br><?php echo $datatbl->line2?><br><?php echo $datatbl->line3; ?></td>
                	<td><?php echo $datatbl->city; ?></td>
                	<td><?php echo $datatbl->postCode; ?></td>
                    <td><?php echo $datatbl->state; ?></td>
                    <td><?php echo $datatbl->country; ?></td>
                    <td><?php 
							$js = 'class="btn btn-mini btn-primary edit" title="Edit"';
							echo form_button('edit','<span class="i-pen">',$js); ?>&nbsp;<?php
							$js = 'class="btn btn-mini btn-danger remove" title="Delete"';
							echo form_button('remove','<span class="i-trashcan">',$js);
						?>
                    </td>
                </tr>
            <?php endforeach; }?>
                     </tbody>
                     </table>
				</div><!-- content -->
				</div><!-- block -->
			</div><!-- span12 -->
		</div><!-- row-fluid -->	
	</div><!-- wrap -->
</div><!-- content -->