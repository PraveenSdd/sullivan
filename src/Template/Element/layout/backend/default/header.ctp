<?php ?>

<header class="main-header">
    <!-- Logo -->
    <a href="/admin/dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>PermitAdmin</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PermitAdmin</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Alert-Notifications: style can be found in dropdown.less -->
          <li class="dropdown alert-notifications-menu">
              <a title="Alert Notification" href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $headerAlertNotificationCount ?></span>
            </a>
            <ul class="dropdown-menu">
              <?php if (!empty($headerAlertNotifications)) { ?>
                    <?php foreach ($headerAlertNotifications as $alertNotification) { ?>
                        <li>
                            <a style="padding-top:5px; padding-bottom:5px;"  href="/admin/alerts/view/<?php echo $this->Encryption->encode($alertNotification['alert_id']) . '/' . $this->Encryption->encode($alertNotification['id']) ?>">
                                <p style="margin:0;">
                                    <i class="fa fa-calendar-check-o"></i> 
                                    <?php echo date('M d, Y', strtotime($alertNotification['created'])); ?>
                                    </p>
                                <p style="margin:0;padding-left:15px;"><?php echo $alertNotification['alert']['title']; ?></p>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="text-center"> 
                        <?php echo $this->Html->link('View All',['controller'=>'alerts','action'=>'notification','prefix'=>'admin'], array('escape' => false, 'class'=>'header', 'style'=>'font-weight:600')); ?>
                    </li>    
                <?php } else { ?>
                    <li class="text-center"> 
                        <?php echo $this->Html->link('You have 0 notifications', 'javascript:void:(0);', array('escape' => false, 'class'=>'footer')); ?>
                    </li>
                <?php } ?>  
            </ul>
          </li>
          
          <!-- Activity Logs: style can be found in dropdown.less -->
          <li class="dropdown activity-log-menu">
              <a title="Activity Logs" href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-globe"></i>
            </a>
            <ul class="dropdown-menu">
              <?php if (!empty($headerActivityLogs)) { ?>
                    <?php foreach ($headerActivityLogs as $activityLog) { ?>
                        <li>
                            <a style="padding-top:5px; padding-bottom:5px;" href="javascript:void(0)">
                                <p style="margin:0;">
                                    <i class="fa fa-chain"></i>
                                    <?php echo date('M d, Y', strtotime($activityLog['created'])); ?>
                                </p>
                                <p style="margin:0;padding-left:15px;"><?php echo $activityLog['message']; ?></p>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="text-center"> 
                        <?php echo $this->Html->link('View All',['controller'=>'activityLogs','action'=>'index','prefix'=>'admin'], array('escape' => false, 'class'=>'header', 'style'=>'font-weight:600')); ?>
                    </li>    
                <?php } else { ?>
                    <li class="text-center"> 
                        <?php echo $this->Html->link('You have 0 activity', 'javascript:void:(0);', array('escape' => false, 'class'=>'footer')); ?>
                    </li>
                <?php } ?>  
            </ul>
          </li>
          
          <li class="dropdown user user-menu">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i>
              <span class="hidden-xs"><?= $Authuser['first_name'];?></span>
            </a>
       
            <ul class="dropdown-menu">
                <li>
                   <?php echo $this->Html->link('Sign Out',['controller'=>'users','action'=>'logout'],array('escape' => false)); ?>
                </li>
           </ul>
             
          </li>

        </ul>
      </div>
    </nav>
  </header>
