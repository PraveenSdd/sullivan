    <div class="container-fluid">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><?php echo $this->Html->link('Dashboard',['controller'=>'users','action'=>'dashboard'],array('escape' => false)); ?></li>
                <li class="<?php if($this->request->params['controller'] == 'Projects' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'create' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view')) { echo 'active';} ?>">
                    <?php echo $this->Html->link('Projects',['controller'=>'projects','action'=>'index'],array('escape' => false)); ?>
                </li>
                <li class="<?php if($this->request->params['controller'] == 'Staffs' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view')) { echo 'active';} ?>">
                    <?php echo $this->Html->link('Staffs',['controller'=>'staffs','action'=>'index'],array('escape' => false)); ?>
                </li>

                <li  class="<?php if($this->request->params['controller'] == 'Forms' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'upload' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'view')) { echo 'active';} ?>"> <?php echo $this->Html->link('Forms',['controller'=>'forms','action'=>'index'],array('escape' => false)); ?></li>
                <li class="<?php if($this->request->params['controller'] == 'Forms' && ($this->request->params['action'] == 'uploadFormsList')) { echo 'active';} ?>">
                    <?php echo $this->Html->link('Upload Form   ',['controller'=>'forms','action'=>'uploadFormsList'],array('escape' => false)); ?>
                </li>

                <li class="<?php if($this->request->params['controller'] == 'Locations' && ($this->request->params['action'] == 'index')) { echo 'active';} ?>">
                    <?php echo $this->Html->link('Location',['controller'=>'locations','action'=>'index'],array('escape' => false)); ?>
                </li>
                
                
                 <li class="<?php if($this->request->params['controller'] == 'Permissions' && ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'edit')) { echo 'active';} ?>">
                    <?php echo $this->Html->link('Permissions',['controller'=>'Permissions','action'=>'index'],array('escape' => false)); ?>
                </li>
                
                
                
                
                
                
            </ul>   

        </div>  
