<?php $ecodeUserId = $this->Encryption->encode($Authuser['id']); ?>
	<header class="header-main clearfix">
    	<a class="navbar-brand pull-left" href="/dashboard">
            <img src="<?php echo $this->Html->webroot;?>/frontend/home/img/logo.png" alt="Sullivan PC"/></a>
        <ul class="nav navbar-nav navbar-right user-link-rgt-side">
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo $Authuser['first_name'];?></a>
                <ul class="dropdown-menu">
                   <li>
                    <?php echo $this->Html->link('Profile',['controller'=>'users','action'=>'profile',$ecodeUserId],array('escape' => false)); ?>
                   </li>
                    
                   <li>
                <?php echo $this->Html->link('Logout',['controller'=>'users','action'=>'logout'],array('escape' => false)); ?>
                                    </li>
                   
                </ul>
            </li>
        </ul>
    </header><!-- /header main end -->