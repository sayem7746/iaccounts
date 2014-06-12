<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $layout_title; ?></title>
    <?php echo put_headers();?>
	<?php echo $this->layouts->print_includes(); ?>
</head>
<body>        
    <div id="wrapper" class="screen_wide sidebar_off">       
        <div id="layout">
            <div id="content">                        
                <div class="wrap nm">            
                    
                    <div class="errorPage">        
                        <p class="name">403</p>
                        <p class="description">Forbidden</p>        
                        <p><button class="btn btn-primary" onClick="document.location.href = 'home';">Back to main</button> <button class="btn" onClick="history.back();">Previous page</button></p>
                    </div>                    
                    
                </div>
            </div>
        </div>               
        
    </div>
</body>
</html>
