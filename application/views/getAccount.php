<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $layout_title; ?></title>
    <?php echo put_headers();?>
	<?php echo $this->layouts->print_includes(); ?>
</head>
<script>
function returnParent(){
	return(this);
	window.close();
	}
</script>

<body>        
    <div id="wrapper" class="screen_wide sidebar_off">       
        <div id="layout">
            <div id="content">                        
                <div class="wrap nm">            
                    
                    <div class="signin_block">
                        <div class="row-fluid">
                            <div class="alert alert-info">
                                <strong>Howdy!</strong> Please, don't tell anyone your password
                                <?php echo validation_errors(); ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            <div class="block">
                                <div class="head">
                                    <h2></h2>                                    
                                    <ul class="buttons">                                        
                                        <li><a href="#" class="tip" title="Contact administrator"><i class="i-warning"></i></a></li>
                                        <li><a href="#" class="tip" title="Forget your password?"><i class="i-locked"></i></a></li>
                                    </ul>                                     
                                </div>
                                <div class="content np">
                                    <div class="controls-row">
                                        <div class="span3">Company:</div>
                                        <div class="span9">						
										<?php
											$preselcomp = '0';
											$optioncomp[NULL] = 'Please Select Account';
											foreach($accountList as $row){
												$optioncomp[$row->ID] = $row->acctCode . " [ " . $row->acctName . " ]";
											}
											$js = 'class="validate[required]"';
											echo form_dropdown('compID', $optioncomp, $preselcomp, $js);
											?>                       
										</div>
                                    </div>                                
                                </div>
                                <div class="footer">
                                    <div class="side fr">
                                        <button class="btn btn-primary" onClick="returnParent">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>               
        
    </div>
    
</body>
</html>
