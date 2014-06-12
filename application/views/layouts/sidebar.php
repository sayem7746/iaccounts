        <div id="layout">
        
            <div id="sidebar">

                <div class="user">
                    <div class="pic">
                        <img src="<?php echo base_url()?>img/examples/users/dmitry_m.jpg"/>
                    </div>
                    <div class="info">
                        <div class="name">
                            <a href="#"><?php echo element('username', $this->session->userdata('logged_in')); ?></a>
                        </div>
                        <div class="buttons">
                            <a href="#"><span class="i-cog"></span> <?php echo $this->lang->line('setting') ?></a>
                            <a href="#"><span class="i-chat"></span> <?php echo $this->lang->line('message') ?></a>
                            <a href=<?php echo base_url()."logout" ?> class="fr"><span class="i-forward"></span> <?php echo $this->lang->line('logout') ?></a>
                        </div>
                    </div>
                </div>

                <ul class="navigation">
					<?php echo $this->menus->print_includes(); ?>
                </ul>

            </div>
