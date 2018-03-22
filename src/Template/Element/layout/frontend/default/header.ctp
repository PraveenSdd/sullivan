
<header class="header-main clearfix">
    <a class="navbar-brand pull-left" href="/dashboard">
        <img src="<?php echo $this->Html->webroot; ?>/frontend/home/img/logo.png" alt="Sullivan PC"/></a>
    <ul class="nav navbar-nav navbar-right user-link-rgt-side">
        <li class="dropdown alert-notification-dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle alert-notification-dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" title="Alert Notifications"><i class="fa fa-bell-o"></i></a>
            <ul class="dropdown-menu">
                <?php if (!empty($headerAlertNotifications)) { ?>
                    <?php foreach ($headerAlertNotifications as $alertNotification) { ?>
                        <li>
                            <a class="padding-top-3 padding-bottom-3" href="/alerts/view/<?php echo $this->Encryption->encode($alertNotification['alert_id']) . '/' . $this->Encryption->encode($alertNotification['id']) ?>">
                                <p class="margin-0">
                                    <i class="fa fa-calendar-check-o"></i> 
                                    <?php echo date('M d, Y', strtotime($alertNotification['created'])); ?>
                                </p>
                                <p class="margin-0 padding-left-20">
                                <?php echo $alertNotification['alert']['title']; ?></p>
                            </a>
                        </li>
                    <?php } ?>
                    <li> 
                        <?php echo $this->Html->link('View All',['controller'=>'alerts','action'=>'notification'], array('escape' => false)); ?>
                    </li>    
                <?php } else { ?>
                    <li> 
                        <?php echo $this->Html->link('You have 0 notifications', 'javascript:void:(0);', array('escape' => false)); ?>
                    </li>
                <?php } ?>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo ($LoggedUserName) ? $LoggedUserName : 'Welcome'; ?></a>
            <ul class="dropdown-menu">
                <li>
                    <?php echo $this->Html->link('Profile', ['controller' => 'users', 'action' => 'profile', $this->Encryption->encode($LoggedUserId)], array('escape' => false)); ?>
                </li>

                <li>
                    <?php echo $this->Html->link('Logout', ['controller' => 'users', 'action' => 'logout'], array('escape' => false)); ?>
                </li>

            </ul>
        </li>

    </ul>
</header><!-- /header main end -->