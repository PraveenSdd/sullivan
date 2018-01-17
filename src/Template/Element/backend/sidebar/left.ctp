<?php ?>

<aside class="main-sidebar" >
    <section class="sidebar">
       <ul class="sidebar-menu" data-widget="tree">
 <li class=" <?php if($this->request->params['controller'] == 'Users' &&  ($this->request->params['action'] == 'dashboard' )){?> head-active active <?php }?>">
     <?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span>',['controller'=>'users','action'=>'dashboard'],array('escape' => false)); ?>
                            </li>
            <li class="treeview <?php if($this->request->params['controller'] == 'Users' && ($this->request->params['action'] == 'profile' || $this->request->params['action'] == 'profileEdit' || $this->request->params['action'] == 'changePassword')){ ?> active-parent <?php }?>">
                
<!--/* Manage Setting */-->            
                <a href="javascript:void(0)" class="head-title">
                    <i class="fa fa-cog"></i>
                    <span>Setting</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" <?php 
            if($this->request->params['controller'] == 'Users' && ($this->request->params['action'] == 'profile' || $this->request->params['action'] == 'profileEdit' || $this->request->params['action'] == 'changePassword') || $this->request->params['controller'] == 'Staffs' && ($this->request->params['action'] == 'add' || $this->request->params['action'] == 'index' || $this->request->params['action'] == 'view'|| $this->request->params['action'] == 'edit')){ ?>  style="display: block;" <?php } ?>>
  
<!--/* Profile */-->
                    <li class="<?php if($this->request->params['action'] == 'profile' || $this->request->params['action'] == 'profileEdit'){?> active<?php }?>">

                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-user')).'Profile', array('controller' => 'Users', 'action' => 'profile'), array('escape' => false)) ?>
                    </li>
<!--/* Change password */-->

                    <li class="<?php if($this->request->params['action'] == 'changePassword'){?> active<?php }?>">
                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-key')).'Change Password', array('controller' => 'Users', 'action' => 'changePassword'), array('escape' => false)) ?>
                    </li>
<!--/* Manage Staff */-->
                   
                    <li class=" <?php if($this->request->params['controller'] == 'Staffs' && ($this->request->params['action'] == 'add' || $this->request->params['action'] == 'index' || $this->request->params['action'] == 'view'|| $this->request->params['action'] == 'edit')){ ?> head-active active <?php }?>">
                         <?php echo $this->Html->link('<i class="fa fa-users"></i> <span>Manage Staff</span>',['controller'=>'staffs','action'=>'index'],array('escape' => false)); ?>
  
</li>
                </ul>
            </li>
<!--/* Manage Agencies */-->
            <li class=" <?php if($this->request->params['controller'] == 'Categories' &&  ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view')){?> head-active active <?php }?>">
                
                  <?php echo $this->Html->link('<i class="fa fa-pie-chart"></i> <span>Manage Agencies</span>',['controller'=>'categories','action'=>'index'],array('escape' => false)); ?>
               
            </li>
<!--/* Manage Operations */-->
            <li class=" <?php if($this->request->params['controller'] == 'Operations' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view')){ ?> head-active active <?php }?>">
                 <?php echo $this->Html->link('<i class="fa fa-folder"></i> <span>Manage Operations</span>',['controller'=>'operations','action'=>'index'],array('escape' => false)); ?>
              
            </li>
<!--/* Manage Permit */-->
            <li class=" <?php if($this->request->params['controller'] == 'Forms' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'permit' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view' || $this->request->params['action'] == 'upload')){ ?> head-active active <?php }?>">
                
                 <?php echo $this->Html->link('<i class="fa fa-file"></i> <span>Manage Permits</span>',['controller'=>'forms','action'=>'index'],array('escape' => false)); ?>
               
            </li>
<!--/* Manage Alerts */-->
            <li class=" <?php if($this->request->params['controller'] == 'Alerts' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'view' || $this->request->params['action'] == 'add' )){ ?> head-active active <?php }?>">
                
         <?php echo $this->Html->link('<i class="fa fa-bell"></i> <span>Manage Alerts</span>',['controller'=>'alerts','action'=>'index'],array('escape' => false)); ?>
              
            </li>
 <!--/* Manage Resources */-->                    
            <li>
                <a href="javascript:void(0)">
                    <i class="fa fa-dashboard"></i> <span>Manage Resources</span>
                </a>

            </li>
   <!--/* Manage Website */-->             
            <li class="treeview  <?php 
            if($this->request->params['controller'] == 'HomePages' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view' || $this->request->params['action'] == 'subscriptionPlans' || $this->request->params['action'] == 'editSubscriptionPlans'  || $this->request->params['action'] == 'viewSubscriptionPlans' )){ ?> active-parent <?php } ?>">
                <a href="javascript:void(0)" class="head-title">
                    <i class="fa fa-home"></i>
                    <span>Manage Website</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" <?php 
            if($this->request->params['controller'] == 'HomePages' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view' || $this->request->params['action'] == 'subscriptionPlans' || $this->request->params['action'] == 'editSubscriptionPlans'  || $this->request->params['action'] == 'viewSubscriptionPlans' )){ ?> style="display: block;" <?php } ?>>
   <!--/* Manage Home Title */-->   
                    <li class="<?php if($this->request->params['action'] == 'index' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view'){?> active<?php }?>">
                      <?php echo $this->Html->link('<i class="fa fa-circle-o"></i> <span>Home Title</span>',['controller'=>'homePages','action'=>'index'],array('escape' => false)); ?>
                  </li>

<!--/* Manage Subscription Plans */--> 
                    <li class="<?php if($this->request->params['action'] == 'subscriptionPlans' || $this->request->params['action'] == 'SubscriptionPlans' || $this->request->params['action'] == 'editSubscriptionPlans' || $this->request->params['action'] == 'viewSubscriptionPlans'){?> active<?php }?>">
                          <?php echo $this->Html->link('<i class="fa fa-circle-o"></i> <span> Subscription Plans</span>',['controller'=>'homePages','action'=>'subscriptionPlans'],array('escape' => false)); ?>
                        
                    </li>

                </ul>
            </li>
            <!--/* Manage Professional Assistances */--> 
            <li class="<?php if($this->request->params['controller'] == 'ProfessionalAssistances' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'view')){?> active<?php }?>">
                
                  <?php echo $this->Html->link('<i class="fa fa-phone"></i> <span> Professional Assistances</span>',['controller'=>'professionalAssistances','action'=>'index'],array('escape' => false)); ?>
                </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
