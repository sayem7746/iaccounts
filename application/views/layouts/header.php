<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />    
<title>
	<?php echo $layout_title; ?></title>
    <?php echo put_headers();
			   ?>
	<?php echo $this->layouts->print_includes(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#en').click(function(){
  		var urls =  "<?php echo base_url(); ?>admin/session/en";
 		$.ajax({
  			type: "POST",
  			url: urls,
  			success: function(){
				location.reload();
			},
		});       // Here your ajax action after delete confirmed
		});
	$('#ms').click(function(){
  		var urls =  "<?php echo base_url(); ?>admin/session/ms";
 		$.ajax({
  			type: "POST",
  			url: urls,
  			success: function(){
				location.reload();
			},
		});       // Here your ajax action after delete confirmed
	});
});
</script>
</head>
<body>

<!--Ajax layer start-->
<!--<style>
	.ajaxLayer{
		width:100%;
		height:100%;
		background:#000;
		position:fixed;
		display:none;
		z-index:1000;
	}
	.ajaxLayer img{
		position:absolute;
		left:50%;	top:50%;
	}
</style>
<div class="ajaxLayer">
	<img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
</div>-->

<!--Ajax layer end-->  
<!-- Modals -->
  <div id="popupModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div id="popuHeader" class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           <h3 id="_popupTitle">Modal header</h3>
       </div>
       <div id="_popupContent" class="modal-body">
            <p>no Content</p>
       </div>
       <div id="_popupFooter" class="modal-footer">
         <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
         <button class="btn btn-primary">Save changes</button>
       </div>
  </div>
<!--end modals -->
        
        
        
        
<div id="wrapper">
        <div id="header">
            
            <div class="wrap">
                
                <a href="" class="logo"></a>
              <div class="buttons fl">
                    <div class="item">
                        <a href="#" class="btn btn-primary btn-small c_layout">
                            <span class="i-layout-8"></span>                            
                        </a>
                    </div>
                    <div class="item">
                        <div align="center"><a href="#" class="btn btn-primary btn-small c_screen">
                          <span class="i-stretch"></span>                            
                        </a>
                          </div>
                    </div>                    
              </div> <!-- button fl -->
			    <div class="buttons fr">
                    <div class="item">                        
                        <div class="btn-group">                        
                            <a href="#" class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown">
                                <span class="i-forward"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><span class="i-profile"></span> Profile</a></li>
                                <li><a href="#"><span class="i-tools"></span> Controls</a></li>                                
                                <li><a href="#"><span class="i-locked"></span> Lock</a></li>
                                <li><a href='<?php echo base_url()."logout" ?>'><span class="i-forward"></span> Logout</a></li>
                            </ul> 
                        </div>
                    </div>   <!-- item -->  
                               
                    <div class="item">                        
                        <div class="btn-group">                        
                            <a href="#" class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown">
                                <?php if ($this->session->userdata('language') == 'en'){?>
                       		<img src="<?php echo base_url() ?>img/english.png" title="English"/>
                                    <?php }else{ ?>
                                		<img src="<?php echo base_url() ?>img/malay.png" title="Bahasa Melayu"/>
                                    <?php } ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li id="en" title="English"><a href="#" ><img src="<?php echo base_url() ?>img/english.png"/> English</a></li>
                                <li id="ms" title="Bahasa Melayu"><a href="#" ><img src="<?php echo base_url() ?>img/malay.png"/> Bahasa Melayu</a></li>
                            </ul> 
                        </div>
                    </div>   <!-- item -->             
            	</div> <!-- button -->
            </div> <!-- Wrap -->           
        </div> <!-- header -->
