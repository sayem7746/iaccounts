<script>
$(document).ready(function(){
});
</script>
<div id="content">                        
<div class="wrap">
                  
<div class="head">
	<div class="info">
		<h1><?php echo $module ?></h1>
			<ul class="breadcrumb">
            	<li><a href='<?php echo base_url()."home" ?>'>Dashboard</a> <span class="divider">-</span></li>
                <li><a href="home"><?php echo $module ?></a> <span class="divider">-</span></li>
                <li class="active"><?php echo $title ?></li>
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
        	<div class="block">
            	<div class="head">
                	<h2>Mail Details Information</h2>
                    <ul class="buttons">
                    	<li><a href="#" class="block_loading"><span class="i-cycle"></span></a></li>
                    	<li><a href="#" class="block_toggle"><span class="i-arrow-down-3"></span></a></li>
                    	<li><a href="#" class="block_remove"><span class="i-cancel-2"></span></a></li>
                	</ul>                                        
                    <div class="side fr">
                    	<?php
                        switch ($mailmaster->mailt_type){
							case 'SECRET': ?>
                    	<span class="label label-warning"><?php echo $mailmaster->mailt_type; break; ?></span>
							<?php case 'IMPORTANT': ?>
                    	<span class="label label-important"><?php echo $mailmaster->mailt_type; break;?></span>
							<?php default: ?>
                    	<span class="label label-info"><?php echo $mailmaster->mailt_type; break;?></span>
                        <?php } ?>
                    </div>
            	</div>
                <div class="content np">
               		<table cellpadding="0" cellspacing="0" width="100%" border="0">
                    <tbody>
                    	<tr>
                        <td>Mail Ref. # :</td><td><?php echo $mailmaster->ref_no; ?></td>
                        <td>Mail Date :</td><td><?php echo date("d-m-Y", strtotime($mailmaster->mailt_dt)); ?></td>
                        </tr>
                    	<tr>
                        <td>Mail From :</td><td><?php echo $mailmaster->mailt_from; ?></td>
                        <td>Mail To :</td><td><?php echo $mailmaster->mailt_to; ?></td>
                        </tr>
                    	<tr>
                        <td>Mail Title :</td><td colspan="3"><?php echo $mailmaster->title; ?></td>
                        </tr>
                    	<tr>
                        <td>Description :</td><td colspan="3"><?php echo $mailmaster->desc; ?></td>
                        </tr>
                    	<tr>
                        <td>Mail Received Date :</td><td><?php echo date("d-m-Y", strtotime($mailmaster->mailt_rvcdate)); ?></td>
                        <td>Received By :</td><td><?php echo $mailmaster->mailt_rcv_by; ?></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
           </div>
		<div class="span12">
        	<div class="block">
		</div>
		</div>
		</div>
</div>
</div>                        
</div>
</div>
</div>
