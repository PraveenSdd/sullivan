<?php ?>
<div class="left-sidebar clearfix">
    <a href="javascript:void();" class="lft-sidebar-control"><i class="fa fa-bars"></i></a>
    <ul class="ul-drop-parent clearfix">
        <li class="dropdown  <?php if($this->request->params['controller'] == 'Staffs' || $this->request->params['controller'] == 'Users' || $this->request->params['controller'] == 'Locations' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add' || $this->request->params['action'] != 'dashboard'|| $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view')) { echo 'open open-side-menu';} ?>">

            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:vopid(0);">Account <i class="fa fa-caret-right pull-right"></i><i class="fa fa-caret-down pull-right"></i></a>
            <ul class="dropdown-menu">
                <li class="<?php if($this->request->params['controller'] == 'Users' && ($this->request->params['action'] == 'profile' || $this->request->params['action'] == 'editProfile')) { echo 'active';} ?>">

 <?php echo $this->Html->link('Profile',['controller'=>'users','action'=>'profile',$this->Encryption->encode($LoggedUserId)],array('escape' => false)); ?>                </li>
                <li class="<?php if($this->request->params['controller'] == 'Staffs' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view')) { echo 'active';} ?>">
                    <?php echo $this->Html->link('Staffs',['controller'=>'staffs','action'=>'index'],array('escape' => false)); ?>
                </li>
                <li class="<?php if($this->request->params['controller'] == 'Locations' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view')) { echo 'active';} ?>">
                    <?php echo $this->Html->link('Location',['controller'=>'locations','action'=>'index'],array('escape' => false)); ?>
                </li>
            </ul>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'Alerts' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'edit')) { echo 'active';} ?>">
    <?php echo $this->Html->link('Alerts',['controller'=>'alerts','action'=>'index'],array('escape' => false)); ?>
        </li>  
        <li class="dropdown <?php if(($this->request->params['controller'] == 'Permits' && (in_array($this->request->params['action'], ['current','view','details']))) || ($this->request->params['controller'] == 'PreviousPermits' && (in_array($this->request->params['action'], ['index','add','edit','view'])))) { echo 'open  open-side-menu';} ?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:vopid(0);">Permit <i class="fa fa-caret-right pull-right"></i><i class="fa fa-caret-down pull-right"></i></a>
            
            <ul class="dropdown-menu">
                <li  class="<?php if($this->request->params['controller'] == 'Permits' && (in_array($this->request->params['action'], ['current','view','details']))) { echo 'active';} ?>"> 
    <?php echo $this->Html->link('Current Permit',['controller'=>'permits','action'=>'current'],array('escape' => false)); ?>
                </li>
                <li class="<?php if($this->request->params['controller'] == 'PreviousPermits' && (in_array($this->request->params['action'], ['index','add','edit','view']))) { echo 'active';} ?>">
                    <?php echo $this->Html->link('Previous Permit',['controller'=>'previousPermits','action'=>'index'],array('escape' => false)); ?>
                </li>
                
            </ul>
        </li>
        
        <li class="<?php if($this->request->params['controller'] == 'ProfessionalAssistances' && ($this->request->params['action'] == 'index')) { echo 'active';} ?>">
    <?php echo $this->Html->link('Professional Assistance',['controller'=>'professionalAssistances','action'=>'index'],array('escape' => false)); ?>
        </li>
        <li class="<?php if($this->request->params['controller'] == 'ProfessionalAssistances' && ($this->request->params['action'] == 'index1')) { echo 'active';} ?>">
    <?php echo $this->Html->link('Help','javascript:void(0)',array('escape' => false)); ?>
        </li>
        <li class="<?php if($this->request->params['controller'] == 'ProfessionalAssistances' && ($this->request->params['action'] == 'index2')) { echo 'active';} ?>">
    <?php echo $this->Html->link('Forum','javascript:void(0)',array('escape' => false)); ?>
        </li>
        
    </ul>
</div><!-- /left sidebar end -->