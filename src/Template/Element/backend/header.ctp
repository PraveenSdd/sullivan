<?php ?>

<header class="main-header">
    <!-- Logo -->
    <a href="/admin/dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Sulivan PC</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Sulivan PC</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 messages</li>
              <li>
              </li>
              <li class="footer"><a href="javascript:void(0);">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 notifications</li>
              <li>
               
              </li>
              <li class="footer"><a href="javascript:void(0);">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 tasks</li>
              <li>
               
              </li>
              <li class="footer">
                <a href="javascript:void(0);">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
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
