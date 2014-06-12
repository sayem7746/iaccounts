            <div id="content">                        
                <div class="wrap">
                    <div class="head">
                        <div class="info">
							<h1><?php echo element('compName', $this->session->userdata('logged_in')) ?> [ 
								<?php echo element('compNo', $this->session->userdata('logged_in')) ?> ]</h1>
			<ul class="breadcrumb">
                <li class="active"><?php echo $title ?></li>
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
                             <div class="span6">
                                <div class="block">
                                    <div class="head">                                        
                                        <h2>Pie charts</h2>
                                    </div>
                                    <div class="content">
                                        <div id="chart-3" style="height: 300px; width: 300px; margin: 0px auto;"></div>
                                    </div>
                                </div>
                            </div>
                       
                            <div class="span6">
                                <div class="block">
                                    <div class="head">                                        
                                        <h2>Real-time update</h2>
                                    </div>
                                    <div class="content">
                                        <div id="chart-4" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                       </div>
					</div>
					</div>
                    <div class="content">
							<?= $latest; ?>
                    </div> <!-- content -->
               </div><!-- wrap -->
          </div><!-- content -->    
